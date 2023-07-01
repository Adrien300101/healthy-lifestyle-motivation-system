<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");

    if (isset($_POST['user_id']) && isset($_POST['admin_id']) ) {
        $admin_id = $_POST['admin_id'];
        if (check_admin($admin_id)) {
            $user_id = $_POST['user_id'];
            $user_detail = DB::queryFirstField("SELECT user_id FROM users WHERE user_id = %i", $user_id);
            if ($user_detail != NULL) {
                //deactivate account of user
                DB::update("users", ['user_status' => 2], "user_id = %i", $user_id);
                $data['error'] = 0;
                $data['error_msg'] = "User was successfully deactivated!";
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