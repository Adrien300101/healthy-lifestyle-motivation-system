<?php 
    include_once("../config.php");
    require '../vendor/autoload.php';
    include_once("../user/check-user-function.php");

    use IEXBase\TronAPI\Tron;
    use IEXBase\TronAPI\Exception\TronException;

    $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');

    // Set up the Tron object
    $tron = new \IEXBase\TronAPI\Tron($fullNode);

    if (isset($_POST['wallet_add']) && isset($_POST['stc_transfer_amount']) && isset($_POST['user_id']) && isset($_POST['user_balance'])) {
        $user_id = $_POST['user_id'];

        if (check_user($user_id)) {

            $receiver_wallet_add = $_POST['wallet_add'];
            $stc_transfer_amount = $_POST['stc_transfer_amount'];
            $user_balance = $_POST['user_balance'];
            $validation = 0;
            
            $is_valid_add = $tron->validateAddress($receiver_wallet_add);

            if ($is_valid_add['result'] == false) {
                $validation = 1;
                $data['wallet_add_msg'] = "This wallet address is invalid!";
            } else {
                if (empty($receiver_wallet_add)) {
                    $validation = 1;
                    $data['wallet_add_msg'] = "This field cannot be left empty!";
                } else {
                    $sender_wallet_address = DB::queryFirstField("SELECT tron_wallet_address FROM wallet_info WHERE user_id = %i", $user_id);
                    if ($receiver_wallet_add == $sender_wallet_address) {
                        $validation = 1;
                        $data['wallet_add_msg'] = "You are not allowed to transfer to your own wallet address!";
                    } else {
                        $data['wallet_add_msg'] = "";
                    }
                }
            }

            if($stc_transfer_amount != 0 && $stc_transfer_amount >= 1){
                if(!is_numeric($stc_transfer_amount) || strpos($stc_transfer_amount, 'e')){
                    $data['transfer_amount_error'] = "Only numbers should be entered";
                    $validation = 1;
                }elseif(strpos($stc_transfer_amount, '.') && strlen(substr(strrchr($stc_transfer_amount, "."), 1)) > 2){
                    $data['transfer_amount_error'] = "You cannot enter more than two digits after the decimal point!";
                    $validation = 1;
                }else{
                    if($user_balance < $stc_transfer_amount){
                        $data['transfer_amount_error'] = "You do not have enough balance";
                        $validation = 1;
                    }else{
                        $data['transfer_amount_error'] = "";
                    }
                }
            }else{
                $data['transfer_amount_error'] = "Please enter valid number!";
                $validation = 1;
            }

            if ($validation == 0) {
                $data['amount_to_transfer'] = $stc_transfer_amount;
                $data['current_balance'] = $user_balance;
                $data['balance_after'] = $user_balance - $stc_transfer_amount;
                $data['error'] = 0;
                $data['error_msg'] = "An otp was sent to your email!";
                $data['wallet_add_receiver'] = $receiver_wallet_add;

                $otp = rand(100000, 999999);

                $sender_details = DB::queryFirstRow("SELECT email FROM users WHERE user_id = %i", $user_id);

                include_once("./email/send-email-otp.php");
                $check_email = send_email_otp($sender_details['email'], $otp, $stc_transfer_amount, $receiver_wallet_add);
                if ($check_email == false) {
                    $email_status = 1;
                } else {
                    $email_status = 0;
                }

                $email_fields = [
                    'user_id' => $user_id,
                    'date_sent' => date("Y-m-d H:i:s"),
                    'type' => 1,
                    'status' => $email_status
                ];
        
                DB::insert("email_logs", $email_fields);

                DB::update('users', ['otp' => $otp, 'otp_date_created' => date("Y-m-d H:i:s")], "user_id=%i", $user_id);

            } else {
                $data['error'] = 1;
                $data['error_msg'] = "Please ensure all fields are correct!";
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