<?php
include_once("../config.php");

if(isset($_POST['email']) && isset($_POST['hash_key']) && isset($_POST['password']) && isset($_POST['confirm_password'])){
	$email 			  = $_POST['email'];
	$hash_key 		  = $_POST['hash_key'];
	$password		  = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	
	if($password != "" && $confirm_password != ""){
		if(strlen($password) < 8 || strlen($password) > 32){
			$data['error'] = 1;
			$data['error_msg'] = "The number of characters in the password should be between 8 and 32!";
			
		}elseif(strlen($confirm_password) < 8 || strlen($confirm_password) > 32){
			$data['error'] = 1;
			$data['error_msg'] = "The number of characters in the confirm password should be between 8 and 32!";
			
		}elseif($password != $confirm_password){
			$data['error'] = 1;
			$data['error_msg'] = "Passwords do not match!";
			
		}else{
			$check_request = DB::queryFirstRow("SELECT u.user_id, pr.email_log_id FROM email_logs el 
												INNER JOIN user_reset_password_requests pr ON pr.email_log_id = el.email_log_id 
												INNER JOIN users u ON u.user_id = el.user_id 
												WHERE u.email = %s AND pr.hash_key = %s AND pr.status = %i", $email, $hash_key, 0);
			
			if($check_request != NULL){
				try{
					DB::update("users", ["password" => password_hash($password, PASSWORD_DEFAULT)], "user_id = %i", $check_request["user_id"]);
					DB::update("user_reset_password_requests",  ["status" => 1], "email_log_id = %i",  $check_request["email_log_id"]);
					
					$data['error'] = 0;
					$data['error_msg'] = "Password was reset successfully!";
				}catch(MeekroDBException $e){
					$data['error'] = 1;
					$data['error_msg'] = "Oops, something went wrong. Please try again later!";
				}
			}else{
				$data['error'] = 1;
				$data['error_msg'] = "Oops, looks like this is an invalid request. Please try again later!";
			}
		}
	}else{
		$data['error'] = 1;
		$data['error_msg'] = "Please do not leave any fields empty!";
	}	
}else{
	//incomplete parameter(s)
	$data['error'] = 1;
	$data['error_msg'] = "Oops, something went wrong. Please try again later!";
}

echo json_encode($data);
?>