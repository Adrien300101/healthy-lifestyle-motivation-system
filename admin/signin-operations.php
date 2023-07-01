<?php
include_once("../config.php");

if(isset($_POST['email']) && isset($_POST['password'])){
	$email 	  = $_POST['email'];
	$password = $_POST['password'];
	
	if($email != "" || $password != ""){
		
		$admin_details = DB::queryFirstRow("SELECT admin_id, admin_session_id, admin_email, admin_password, admin_status FROM admin WHERE admin_email = %s", $email);
		if($admin_details != NULL){
			if($admin_details['admin_status'] == 0){	
				if(password_verify($password, $admin_details['admin_password'])){
				
					$token = bin2hex(random_bytes(3)); //bin2hex doubles the byte size
					try{
						session_start();
						$_SESSION['session_id'] = $admin_details['admin_session_id'];

						$data['error'] = 0;
						$data['redirect_url'] = "admin/user-management.php";
						$data['error_msg'] = "Login Successfully";
					}catch(MeekroDBException $e){
						$data['error'] = 1;
						$data['error_msg'] = "[Error-801] Oops, something went wrong, please try again later";
					}
				}else{
					//wrong password
					$data['error'] = 1;
					$data['error_msg'] = "Incorrect email or password. Please try again";
				}
			}elseif($admin_details['admin_status'] == 1){	
					//Inactivated account
					$data['error'] = 1;
					$data['error_msg'] = "Your account has been deactivated. ";
			}else{
				//status not found
				$data['error'] = 1;
				$data['error_msg'] = "Oops, something went wrong, please try again later";
			}
		}else{
			//no user found
			$data['error'] = 1;
			$data['error_msg'] = "Incorrect email or password. Please try again";
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