<?php 

    include_once("../config.php");
    function check_user($user_id) {
        session_start();
        $session_id = $_SESSION['session_id'];

        $check = DB::queryFirstField("SELECT session_id FROM users WHERE user_id = %i AND session_id = %s", $user_id, $session_id);

        if ($check == null) {
            return false;
        } else {
            return true;
        }
    }
?>