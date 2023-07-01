<?php 
    include_once("../config.php");
    require '../vendor/autoload.php';
    include_once("../user/check-user-function.php");

    use IEXBase\TronAPI\Tron;
    use IEXBase\TronAPI\Exception\TronException;

    $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');

    // Set up the Tron object
    $tron = new \IEXBase\TronAPI\Tron($fullNode);

    if (isset($_POST['wallet_add']) && isset($_POST['stc_transfer_amount']) && isset($_POST['user_id']) && isset($_POST['user_balance']) && isset($_POST['otp'])) {
        $user_id = $_POST['user_id'];

        if (check_user($user_id)) {
            $otp = $_POST['otp'];

            $otp_details = DB::queryFirstRow("SELECT otp, DATE_ADD(otp_date_created, INTERVAL 5 MINUTE) as otp_expire FROM users WHERE user_id = %i", $user_id);

            if($otp_details['otp'] != $otp){
                $data['error'] = 1;
                $data['error_msg'] = "The OTP provided is incorrect!";
                $data['otp_error'] = "Incorrect OTP";
                $validation = 1;
            }elseif($otp_details['otp_expire'] < date("Y-m-d H:i:s")){
                $data['error'] = 1;
                $data['error_msg'] = "OTP has expired. Please request <br><a onclick='transfer_pre_validate(".$user_balance.")'>new OTP</a>";
                $data['otp_error'] = "OTP has expired. Please request <br><a onclick='transfer_pre_validate(".$user_balance.")'>new OTP</a>";
            }else{
                $receiver_wallet_add = $_POST['wallet_add'];
                $stc_transfer_amount = $_POST['stc_transfer_amount'];
                $user_balance = $_POST['user_balance'];
                $validation = 0;
            
                $is_valid_add = $tron->validateAddress($receiver_wallet_add);

                if ($is_valid_add['result'] == false) {
                    $validation = 1;
                } else {
                    if (empty($receiver_wallet_add)) {
                        $validation = 1;
                    } else {
                        $sender_wallet_address = DB::queryFirstField("SELECT tron_wallet_address FROM wallet_info WHERE user_id = %i", $user_id);
                        if ($receiver_wallet_add == $sender_wallet_address) {
                            $validation = 1;
                        }
                    }
                }

                if($stc_transfer_amount != 0 && $stc_transfer_amount >= 1){
                    if(!is_numeric($stc_transfer_amount) || strpos($stc_transfer_amount, 'e')){
                        $validation = 1;
                    }else if(strpos($stc_transfer_amount, '.') && strlen(substr(strrchr($stc_transfer_amount, "."), 1)) > 2){
                        $validation = 1;
                    }else{
                        if($user_balance < $stc_transfer_amount){
                            $validation = 1;
                        }
                    }
                }else{
                    $validation = 1;
                }



                if ($validation == 0) {
                    $sender_private_key = DB::queryFirstField("SELECT private_key FROM wallet_info WHERE user_id = %i", $user_id);

                    $data['error'] = 0;
                    $data['error_msg'] = $stc_transfer_amount . " STC will be transferred now to this wallet address: " . $receiver_wallet_add;

                    $data['receiver_wallet_add'] = $receiver_wallet_add;
                    $data['stc_transfer_amount'] = $stc_transfer_amount;
                    $data['sender_private_key'] = $sender_private_key;
                    $data['current_balance'] = $user_balance;
                } else {
                    $data['error'] = 1;
                    $data['error_msg'] = "Please ensure all fields are correct!";
                }
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