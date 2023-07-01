<?php
function check_token(){
	$status = session_status();
	if($status == PHP_SESSION_NONE){
		//There is no active session
		session_start();
	}
	if(isset($_SESSION['session_id']) && isset($_SESSION['token'])){
		include_once("../config.php");
		$session_id = $_SESSION['session_id'];
		$token 		= $_SESSION['token'];
		
		$current_token = DB::queryFirstRow("SELECT s.token, u.user_id, u.user_status FROM user_signin_sessions s INNER JOIN users u ON u.user_id = s.user_id WHERE u.session_id = %s ORDER BY signin_date DESC", $session_id);
		if($token != $current_token['token']){
			session_destroy();
			$data['error'] = 1;
			$data['error_msg'] = "Another device has signed in to this account! You will be redirected to the login page!";
		}elseif($current_token['user_status'] != 1){
			session_destroy();
			if($current_token['user_status'] == 0){
				$data['error'] = 1;
				$data['error_msg'] = "Your account is inactive! You will be redirected to the login page!";
			}elseif($current_token['user_status'] == 2){
				$data['error'] = 1;
				$data['error_msg'] = "Your account has been deactivated! You will be redirected to the login page!";
			}else{
				$data['error'] = 1;
				$data['error_msg'] = "Oops something went wrong. You will be redirected to the login page!";
			}
		}else{
			$data['error'] = 0;
			$data['error_msg'] = "";
			$data['session_id'] = $session_id;
			$data['token'] = $token;
			$data['user_id'] = $current_token['user_id'];
		}
	}else{
		session_destroy();
		$data['error'] = 1;
		$data['error_msg'] = "Your session has ended. Please login again!";
	}

	return ($data);
}

echo json_encode(check_token());
?>