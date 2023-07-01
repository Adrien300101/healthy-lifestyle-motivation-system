<?php
include_once("../config.php");

if(isset($_POST['email'])){
	$email 	= $_POST['email'];
	
	if($email != ""){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$data['error'] = 1;
            $data['email_error'] = "Please enter a valid email!";
			$data['error_msg'] = "Please ensure all fields are correct!";
		}else{
			$check_details = DB::queryFirstRow("SELECT user_id, first_name, last_name FROM users WHERE email = %s", $email);
			
			if($check_details != NULL){
				include_once("email/forget-password-send-email.php");
				
                $name = $check_details['first_name']." ".$check_details['last_name'];
				$hash_key = bin2hex(random_bytes(5));
				$check_email = send_forgot_password_email($email, $name, $hash_key);
				if($check_email == false){
					$email_status = 1;
				}else{
					$email_status = 0;
				}	
				
				$email_fields = [
					'user_id' => $check_details['user_id'],
					'type' => 2,
                    'date_sent' => date("Y-m-d H:i:s"),
					'status' => $email_status
				];
				
				try {
					DB::insert("email_logs", $email_fields);
					$email_id = DB::insertId();
					
					$password_requests_fields = [
						'email_log_id' => $email_id,
						'hash_key' => $hash_key,
					];
					
					DB::insert("user_reset_password_requests", $password_requests_fields);
			
					$data['error'] = 0;
					$data['error_msg'] = "An email has been sent to you. Please follow the instructions stated in the email!";
				
				}catch(MeekroDBException $e){
					$data['error'] = 1;
					$data['error_msg'] = "Oops something went wrong. Please try again later!";
				}
			}else{
				//email not in database
				$data['error'] = 1;
                $data['email_error'] = "This email is not in our system!";
				$data['error_msg'] = "Please ensure all fields are correct!";
			}
		}
	}else{
		//email empty field
		$data['error'] = 1;
        $data['email_error'] = "This field cannot be left empty!";
		$data['error_msg'] = "Please ensure all fields are correct!";
	}
}else{
	//incomplete parameter(s)
	$data['error'] = 1;
	$data['error_msg'] = "Oops something went wrong. Please try again later!";
}

echo json_encode($data);
?>
