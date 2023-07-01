<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");
    include_once("./email/send-admin-email-verification.php");

    if (isset($_POST['admin_id']) && isset($_POST["first_name"]) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['admin_role']) && isset($_POST['password']) && isset($_POST['con_password'])) {
        $admin_id = $_POST['admin_id'];
        $admin_role_id = DB::queryFirstField("SELECT admin_role_id FROM admin_role WHERE admin_role_id = %i", $_POST['admin_role']);
        if (check_admin($admin_id) && $admin_role_id != NULL) {
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
                $check_email = DB::queryFirstField("SELECT admin_id FROM admin WHERE admin_email = %s", $email);
                if ($check_email != null) {
                    $data['email_error'] = "This email is already in use. Please choose another email";
                    $validation = 1;
                } else {
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

                DB::insert('admin', ['admin_first_name' => $first_name, 'admin_last_name' => $last_name, 'admin_initial' => $initial, 'admin_password' => password_hash($password, PASSWORD_DEFAULT), 'admin_email' => $email, 'admin_status' => 2, "admin_session_id" => bin2hex(random_bytes(5)), 'admin_role_id' => $admin_role_id]);

                $admin_id = DB::insertId();

                $check_email = send_admin_verification_email($email, $first_name." ".$last_name);
                if ($check_email == false) {
                    $email_status = 1;
                } else {
                    $email_status = 0;
                }

                $email_fields = [
                    'admin_id' => $admin_id,
                    'date_sent' => date("Y-m-d H:i:s"),
                    'email_type' => 0,
                    'email_status' => $email_status
                ];

                DB::insert("admin_email_log", $email_fields);

                $data['error'] = 0;
                $data['error_msg'] ="Admin was successfully added!";
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
        //incomplete parameters
        $data['error'] = 2;
        $data['error_msg'] = "Oops, something went wrong. Please try again later!";
    }

    echo json_encode($data);
?>