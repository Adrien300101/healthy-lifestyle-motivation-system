<?php 

    include_once("../config.php");
    function check_admin($admin_id) {
        session_start();
        $session_id = $_SESSION['session_id'];

        $check = DB::queryFirstField("SELECT admin_session_id FROM admin WHERE admin_id = %i AND admin_session_id = %s", $admin_id, $session_id);

        if ($check == null) {
            return false;
        } else {
            return true;
        }
    }
?>