<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");

    if (isset($_POST['edited_admin_id']) && isset($_POST['admin_id']) ) {
        $admin_id = $_POST['admin_id'];
        if (check_admin($admin_id)) {
            $admin_detail = DB::queryFirstField("SELECT a.admin_id FROM admin a LEFT JOIN admin_role ar ON ar.admin_role_id = a.admin_role_id WHERE ar.admin_role_id = %i AND ar.admin_role_name = %s AND a.admin_id = %i", 1, "Super Admin", $admin_id);
            if ($admin_detail != NULL) {
                $edited_admin_id = $_POST['edited_admin_id'];
                $edited_admin_detail = DB::queryFirstField("SELECT admin_id FROM admin WHERE admin_id = %i", $edited_admin_id);
                if ($edited_admin_detail != NULL) {
                    //deactivate account of user
                    DB::update("admin", ['admin_status' => 1], "admin_id = %i", $edited_admin_id);
                    $data['error'] = 0;
                    $data['error_msg'] = "Admin was successfully deactivated!";
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