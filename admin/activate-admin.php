<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");
    include_once("./email/send-admin-email-verification.php");

    if (isset($_POST['edited_admin_id']) && isset($_POST['admin_id']) ) {
        $admin_id = $_POST['admin_id'];
        if (check_admin($admin_id)) {
            $admin_detail = DB::queryFirstField("SELECT a.admin_id FROM admin a LEFT JOIN admin_role ar ON ar.admin_role_id = a.admin_role_id WHERE ar.admin_role_id = %i AND ar.admin_role_name = %s AND a.admin_id = %i", 1, "Super Admin", $admin_id);
            if ($admin_detail != NULL) {
                $edited_admin_id = $_POST['edited_admin_id'];
                $edited_admin_detail = DB::queryFirstRow("SELECT admin_email, admin_first_name, admin_last_name FROM admin WHERE admin_id = %i", $edited_admin_id);
                if ($edited_admin_detail != NULL) {
                    //send email verification to user
                    $check_email = send_admin_verification_email($edited_admin_detail['admin_email'], $edited_admin_detail['admin_first_name']." ".$edited_admin_detail['admin_last_name']);
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

                    $data['error'] = 0;
                    $data['error_msg'] = "Activation email was sent to the admin again!";
                } else {
                    //wrong user
                    $data['error'] = 1;
                    $data['error_msg'] = "Oops, something went wrong. Please try again later!";
                }
            }else {
                //wrong user
                $data['error'] = 1;
                $data['error_msg'] = "Oops, something went wrong. Please try again later!";
            }
        } else {
            //wrong user
            $data['error'] = 1;
            $data['error_msg'] = "Oops, something went wrong. Please try again later!";
        }
    } else {
        //incomplete parameters
        $data['error'] = 1;
        $data['error_msg'] = "Oops, something went wrong. Please try again later!";
    }

    echo json_encode($data);
?>