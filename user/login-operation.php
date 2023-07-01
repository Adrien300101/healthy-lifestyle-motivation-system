<?php
include_once("../config.php");

if(isset($_POST['email']) && isset($_POST['password'])){
	$email 	  = $_POST['email'];
	$password = $_POST['password'];
	
	if($email != "" || $password != ""){
		
		$user_details = DB::queryFirstRow("SELECT user_id, session_id, email, password, user_status FROM users WHERE email = %s", $email);
		if($user_details != NULL){
			if($user_details['user_status'] == 1){	
				if(password_verify($password, $user_details['password'])){
				
					$token = bin2hex(random_bytes(3)); //bin2hex doubles the byte size
					try{
						DB::insert("user_signin_sessions", ['user_id' => $user_details['user_id'], 'token' => $token, 'ip_address' => $_SERVER['REMOTE_ADDR'], 'signin_date' => date("Y-m-d H:i:s")]);

						session_start();
						$_SESSION['session_id'] = $user_details['session_id'];
						$_SESSION['token'] = $token;

						$data['error'] = 0;
						$data['redirect_url'] = "../user/index.php";
						$data['error_msg'] = "Login Successfully";
					}catch(MeekroDBException $e){
						$data['error'] = 1;
						$data['error_msg'] = "[Error-801] Oops, something went wrong, please try again later";
					}
				}else{
					//wrong password
					$data['error'] = 1;
					$data['error_msg'] = "Incorrect email or password. Please try again";
                    $data['password_error'] = "Incorrect password";
				}
			}elseif($user_details['user_status'] == 2){	
					//Inactivated account
					$data['error'] = 1;
					$data['error_msg'] = "Your account has been deactivated.";
			}else if ($user_details['user_status'] == 0){
                $data['error'] = 1;
				$data['error_msg'] = "Your account has not been activated yet. Please activate your account by clicking on the link sent to your email.";
            }else{
				//status not found
				$data['error'] = 1;
				$data['error_msg'] = "Oops, something went wrong, please try again later";
			}
		}else{
			//no user found
			$data['error'] = 1;
			$data['error_msg'] = "Incorrect email or password. Please try again";
            $data['email_error'] = "Incorrect email";
            $data['password_error'] = "Incorrect password";
		}
	}else{
		//empty input
		$data['error'] = 1;
		$data['error_msg'] = "Both email and password fields are required";
		if($email == ""){
			$data['email_error'] = "Email cannot be empty";
		}
		
		if($password == ""){
			$data['password_error'] = "Password cannot be empty";
		}
	}
}else{
	//incomplete parameter(s)
	$data['error'] = 1;
	$data['error_msg'] = "Oops, something went wrong, please try again later";
}

echo json_encode($data);
?>