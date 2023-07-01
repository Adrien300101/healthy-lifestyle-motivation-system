<?php 
    include_once("../config.php");
    include_once("../user/check-user-function.php");

    if (isset($_POST['amount_transfer']) && isset($_POST['sender_id']) && isset($_POST['transaction_status']) && isset($_POST['coupon_id'])) {
        $sender_id = $_POST['sender_id'];

        if (check_user($sender_id)) {
            $stc_transfer_amount = $_POST['amount_transfer'];
            $transaction_status = $_POST['transaction_status'];

            $validation = 0;

            if ($transaction_status === "SUCCESS") {
                $status = 1;
            } else if ($transaction_status === "FAILED") {
                $status = 2;
            } else {
                $validation = 1;
            }

            if($stc_transfer_amount != 0 && $stc_transfer_amount >= 1){
                if(!is_numeric($stc_transfer_amount) || strpos($stc_transfer_amount, 'e')){
                    $validation = 1;
                    $data['amount'] = "not numeric";
                }else if(strpos($stc_transfer_amount, '.') && strlen(substr(strrchr($stc_transfer_amount, "."), 1)) > 2){
                    $validation = 1;
                    $data['amount'] = "too many decimal points";
                }
            }else{
                $validation = 1;
            }

            if ($validation == 0) {
                $coupon_id = $_POST['coupon_id'];
                $coupon_details = DB::queryFirstField("SELECT product_id FROM product WHERE product_id = %i", $coupon_id);

                if ($coupon_details != NULL) {
                    DB::insert('product_user_bridge', [
                        'product_id' => $coupon_id,
                        'user_id' => $sender_id,
                        'date_purchased' => date("Y-m-d H:i:s"),
                        'status' => 0
                    ]);

                    DB::insert('wallet_transactions', [
                        'transaction_type' => 3,
                        'sender_id' => $sender_id,
                        'receiver_id' => NULL,
                        'stc_amount' => $stc_transfer_amount,
                        'date_created' => date("Y-m-d H:i:s"),
                        'status' => $status
                    ]);

                    if ($status == 1) {
                        $data['error'] = 0;
                        $data['error_msg'] = $stc_transfer_amount . " STC has been deducted from your wallet address";
                    } else {
                        $data['error'] = 1;
                        $data['error_msg'] = "Something went wrong during saving the record of the transaction! Please contact our admin!";
                    }
                } else {
                    $data['error'] = 1;
                    $data['error_msg'] = "Oops, something went wrong. Please try again later!fa";
                }
            } else {
                $data['error'] = 1;
                $data['error_msg'] = "Oops, something went wrong. Please try again later!na";
            }
        } else {
            //wrong user
            $data['error'] = 1;
            $data['error_msg'] = "Oops, something went wrong. Please try again later!ba";
        }
    } else {
        //incomplete parameters
        $data['error'] = 1;
        $data['error_msg'] = "Oops, something went wrong. Please try again later!la";
    }

    echo json_encode($data);
?>