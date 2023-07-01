<?php 
    include_once("../config.php");
    require '../vendor/autoload.php';
    include_once("../user/check-user-function.php");

    use IEXBase\TronAPI\Tron;
    use IEXBase\TronAPI\Exception\TronException;

    $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');

    // Set up the Tron object
    $tron = new \IEXBase\TronAPI\Tron($fullNode);

    if (isset($_POST['coupon_id']) && isset($_POST['user_id']) && isset($_POST['user_balance'])) {
        $user_id = $_POST['user_id'];

        if (check_user($user_id)) {
            $coupon_id = $_POST['coupon_id'];
            $coupon_price = DB::queryFirstField("SELECT product_price FROM product WHERE product_id = %i", $coupon_id);
            $user_balance = $_POST['user_balance'];
            $validation = 0;

            if($user_balance != 0 && $user_balance >= 1){
                if(!is_numeric($user_balance) || strpos($user_balance, 'e')){
                    $validation = 1;
                }else if(strpos($user_balance, '.') && strlen(substr(strrchr($user_balance, "."), 1)) > 2){
                    $validation = 1;
                }else{
                    if($user_balance < $coupon_price){
                        $validation = 2;
                    }
                }
            }else{
                $validation = 1;
            }

            if ($validation == 0) {
                $sender_details = DB::queryFirstRow("SELECT w.private_key, u.email FROM users u LEFT JOIN wallet_info w ON w.user_id = u.user_id WHERE u.user_id = %i", $user_id);

                $otp = rand(100000, 999999);

                include_once("./email/send-email-otp-payment.php");
                $check_email = send_email_otp($sender_details['email'], $otp, $coupon_price);
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

                $data['error'] = 0;
                $data['error_msg'] = "You are about to purchase this coupon for ".$coupon_price." STC. An OTP has been sent to your email please copy it and paste in the field below!";

                $data['coupon_price'] = $coupon_price;
                $data['sender_private_key'] = $sender_details['private_key'];
                $data['current_balance'] = $user_balance;
                $data['balance_after'] = $user_balance - $coupon_price;
            } else if ($validation == 1) {
                $data['error'] = 1;
                $data['error_msg'] = "Oops, something went wrong, Please try again later! Params";
            } else {
                $data['error'] = 1;
                $data['error_msg'] = "Oops, you do not have enough balance!";
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