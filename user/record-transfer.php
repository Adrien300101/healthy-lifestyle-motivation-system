<?php 
    include_once("../config.php");
    require '../vendor/autoload.php';
    include_once("../user/check-user-function.php");

    use IEXBase\TronAPI\Tron;
    use IEXBase\TronAPI\Exception\TronException;

    $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');

    // Set up the Tron object
    $tron = new \IEXBase\TronAPI\Tron($fullNode);

    if (isset($_POST['receiver_wallet_add']) && isset($_POST['amount_transfer']) && isset($_POST['sender_id']) && isset($_POST['user_balance']) && isset($_POST['transaction_status'])) {
        $sender_id = $_POST['sender_id'];

        if (check_user($sender_id)) {
            $receiver_wallet_add = $_POST['receiver_wallet_add'];
            $stc_transfer_amount = $_POST['amount_transfer'];
            $user_balance = $_POST['user_balance'];
            $transaction_status = $_POST['transaction_status'];

            $validation = 0;

            if ($transaction_status === "SUCCESS") {
                $status = 1;
            } else if ($transaction_status === "FAILED") {
                $status = 2;
            } else {
                $validation = 1;
            }
            
            $is_valid_add = $tron->validateAddress($receiver_wallet_add);

            if ($is_valid_add['result'] == false) {
                $validation = 1;
                $data['wallet_add'] = "Wrong wallet address";
            } else {
                if (empty($receiver_wallet_add)) {
                    $validation = 1;
                    $data['wallet_add'] = "wallet address empty";
                }
            }

            if($stc_transfer_amount != 0 && $stc_transfer_amount >= 1){
                if(!is_numeric($stc_transfer_amount) || strpos($stc_transfer_amount, 'e')){
                    $validation = 1;
                    $data['amount'] = "not numeric";
                }else if(strpos($stc_transfer_amount, '.') && strlen(substr(strrchr($stc_transfer_amount, "."), 1)) > 2){
                    $validation = 1;
                    $data['amount'] = "too many decimal points";
                }else{
                    if(floatval($user_balance) < floatval($stc_transfer_amount)){
                        $validation = 1;
                        $data['user_balance'] = $user_balance;
                        $data['stc_amount'] = $stc_transfer_amount;
                        $data['amount'] = "not enough balance";
                    }
                }
            }else{
                $validation = 1;
            }

            if ($validation == 0) {
                $receiver_id = DB::queryFirstField("SELECT user_id FROM wallet_info WHERE tron_wallet_address = %s", $receiver_wallet_add);

                DB::insert('wallet_transactions', [
                    'transaction_type' => 1,
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'stc_amount' => $stc_transfer_amount,
                    'date_created' => date("Y-m-d H:i:s"),
                    'status' => $status
                ]);

                if ($status == 1) {
                    $data['error'] = 0;
                    $data['error_msg'] = $stc_transfer_amount . " STC has been successfully transferred to this wallet address: " . $receiver_wallet_add;
                } else {
                    $data['error'] = 1;
                    $data['error_msg'] = "The transfer to the wallet address " . $receiver_wallet_add . " has failed! Please contact our admin!";
                }
            } else {
                $data['error'] = 1;
                $data['error_msg'] = "Oops, something went wrong. Please try again later! Wa";
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