<?php 
    include_once("../config.php");
    include_once("../user/check-user-function.php");

    if (isset($_POST['user_id']) && isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {

        $user_id = $_POST['user_id'];

        if (check_user($user_id)) {
            $current_password = $_POST['current_password'];
            $new_password     = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            if($current_password != ""){
                $db_password = DB::queryFirstField("SELECT password FROM users WHERE user_id = %i", $user_id);
                if(password_verify($current_password, $db_password)){
                    $validation = 0;
                    if($new_password != ""){
                        if(strlen($new_password) < 8 || strlen($new_password) > 32){
                            $data['new_password_error'] = "The length of the password should only be between 8 and 32 characters!";
                            $validation = 1;
                        }else{
                            $data['new_password_error'] = "";
                        }
                    }else{
                        $data['new_password_error'] = "This field cannot be left empty!";
                        $validation = 1;
                    }
                    
                    if($confirm_password != ""){
                        if(strlen($confirm_password) < 8 || strlen($confirm_password) > 32){
                            $data['confirm_password_error'] = "The length of the password should only be between 8 and 32 characters!";
                            $validation = 1;
                        }else{
                            $data['confirm_password_error'] = "";
                        }
                    }else{
                        $data['confirm_password_error'] = "This field cannot be left empty!";
                        $validation = 1;
                    }
                    
                    if($new_password != "" && $confirm_password != ""){
                        if($new_password != $confirm_password){
                            $data['confirm_password_error'] = "Passwords do not match!";
                            $validation = 1;
                        }else{
                            $data['confirm_password_error'] = "";
                        }
                    }
                    
                    if($validation == 1){
                        $data['error'] = 1;
                        $data['error_msg'] = "Please ensure all the fields are correct!";
                    }else{
                        $user_fields = [
                            'password' => password_hash($new_password, PASSWORD_DEFAULT),
                        ];
                        
                        try{
                            DB::update("users", $user_fields, "user_id = %i", $user_id);
                            
                            $data['error'] = 0;
                            $data['error_msg'] = "Your password has been changed successfully!";

                        }catch(MeekroDBException $e){
                            $data['error'] = 1;
                            $data['error_msg'] = "Oops, something went wrong. Please try again later!";
                        }
                    }
                }else{
                    $data['error'] = 1;
                    $data['error_msg'] = "Current password is incorrect. Please try again!";
                }
            }else{
                $data['error'] = 1;
                $data['error_msg'] = "Current password field cannot be left empty!";
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