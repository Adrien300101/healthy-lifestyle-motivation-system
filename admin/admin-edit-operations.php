<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");
    include_once("./email/send-admin-email-verification.php");

    if (isset($_POST['edited_admin_id']) && isset($_POST['admin_id']) && isset($_POST["first_name"]) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['admin_role']) && isset($_POST['password']) && isset($_POST['con_password'])) {
        $admin_id = $_POST['admin_id'];

        if (check_admin($admin_id)) {
            $edited_admin_id = $_POST['edited_admin_id'];
            $admin_details = DB::queryFirstRow("SELECT admin_first_name, admin_last_name, admin_email FROM admin WHERE admin_id = %i", $edited_admin_id);
            $admin_role_id = DB::queryFirstField("SELECT admin_role_id FROM admin_role WHERE admin_role_id = %i", $_POST['admin_role']);
            if ($admin_details != NULL && $admin_role_id != NULL) {
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
                    $check_email = DB::queryFirstField("SELECT admin_id FROM admin WHERE admin_email = %s AND NOT admin_id = %i", $email, $edited_admin_id);
                    if ($check_email != null) {
                        $data['email_error'] = "This email is already in use. Please choose another email";
                        $validation = 1;
                    } else {
                        if ($email == $admin_details['admin_email']) {
                            $admin_status = 0;
                        } else {
                            $admin_status = 1;
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

                    DB::update("admin", ['admin_first_name' => $first_name, 'admin_last_name' => $last_name, 'admin_initial' => $initial, 'admin_password' => password_hash($password, PASSWORD_DEFAULT), 'admin_email' => $email, 'admin_status' => $admin_status, 'admin_role_id' => $admin_role_id], "admin_id = %i", $edited_admin_id);

                    if ($admin_status == 1) {
                        $check_email = send_admin_verification_email($email, $first_name." ".$last_name);
                        if ($check_email == false) {
                            $email_status = 1;
                        } else {
                            $email_status = 0;
                        }

                        $email_fields = [
                            'admin_id' => $edited_admin_id,
                            'date_sent' => date("Y-m-d H:i:s"),
                            'email_type' => 0,
                            'email_status' => $email_status
                        ];

                        DB::insert("admin_email_log", $email_fields);
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