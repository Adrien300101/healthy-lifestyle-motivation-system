<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");
    include_once("./email/resend-email-verification.php");

    if (isset($_POST['user_id']) && isset($_POST['admin_id']) && isset($_POST["first_name"]) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['con_password'])) {
        $admin_id = $_POST['admin_id'];

        if (check_admin($admin_id)) {
            $user_id = $_POST['user_id'];
            $user_details = DB::queryFirstRow("SELECT first_name, last_name, email FROM users WHERE user_id = %i", $user_id);
            if ($user_details != NULL) {
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $con_password = $_POST['con_password'];
                $validation = 0;

                if (empty($first_name)) {
                    $validation = 1;
                    $data['fname_error'] = "This field cannot be left empty!";
                } else {
                    $data['fname_error'] = "";
                }
            
                if (empty($last_name)) {
                    $validation = 1;
                    $data['lname_error'] = "This field cannot be left empty!";
                } else {
                    $data['lname_error'] = "";
                }
            
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validation = 1;
                    $data['email_error'] = "Email is invalid!";
                } else {
                    $check_email = DB::queryFirstField("SELECT user_id FROM users WHERE email = %s AND NOT user_id = %i", $email, $user_id);
                    if ($check_email != null) {
                        $data['email_error'] = "This email is already in use. Please choose another email";
                        $validation = 1;
                    } else {
                        if ($email == $user_details['email']) {
                            $user_status = 1;
                        } else {
                            $user_status = 0;
                        }

                        $data['email_error'] = "";
                    }
                }

                if (empty($password)) {
                    $validation = 1;
                    $data['password_error'] = "This field cannot be left empty!";
                } else {
                    $data['password_error'] = "";
                }
            
                if (empty($con_password)) {
                    $validation = 1;
                    $data['con_password_error'] = "This field cannot be left empty!";
                } else {
                    $data['con_password_error'] = "";
                }
            
                if ($password != $con_password) {
                    $validation = 1;
                    $data['con_password_error'] = "Passwords do not match!";
                } else {
                    $data['con_password_error'] = "";
                }

                if ($validation == 0) {
                    $initial = substr($first_name, 0, 1).substr($last_name, 0, 1);

                    DB::update("users", ['first_name' => $first_name, 'last_name' => $last_name, 'initial' => $initial, 'password' => password_hash($password, PASSWORD_DEFAULT), 'email' => $email, 'user_status' => $user_status], "user_id = %i", $user_id);

                    if ($user_status == 0) {
                        $check_email = send_verification_email($email, $first_name." ".$last_name);
                        if ($check_email == false) {
                            $email_status = 1;
                        } else {
                            $email_status = 0;
                        }

                        $email_fields = [
                            'user_id' => $user_id,
                            'date_sent' => date("Y-m-d H:i:s"),
                            'type' => 0,
                            'status' => $email_status
                        ];

                        DB::insert("email_logs", $email_fields);
                    }

                    $data['error'] = 0;
                    $data['error_msg'] ="Update was successful!";
                } else {
                    $data['error'] = 1;
                    $data['error_msg'] ="Please ensure all fields are correct!";
                }
            } else {
                //wrong user
                $data['error'] = 2;
                $data['error_msg'] = "Oops, something went wrong. Please try again later!";
            }
        } else {
            //wrong user
            $data['error'] = 2;
            $data['error_msg'] = "Oops, something went wrong. Please try again later!";
        }
    } else {
        //incomplete parameters
        $data['error'] = 2;
        $data['error_msg'] = "Oops, something went wrong. Please try again later!";
    }

    echo json_encode($data);
?>