<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");
    include_once("./email/resend-email-verification.php");

    if (isset($_POST['user_id']) && isset($_POST['admin_id']) ) {
        $admin_id = $_POST['admin_id'];
        if (check_admin($admin_id)) {
            $user_id = $_POST['user_id'];
            $user_detail = DB::queryFirstRow("SELECT email, first_name, last_name FROM users WHERE user_id = %i", $user_id);
            if ($user_detail != NULL) {
                //send email verification to user
                $check_email = send_verification_email($user_detail['email'], $user_detail['first_name']." ".$user_detail['last_name']);
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

                $data['error'] = 0;
                $data['error_msg'] = "Activation email was sent to the user again!";
            } else {
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