<?php 
    include_once("../config.php");
    require_once '../vendor/autoload.php';

    if (isset($_POST['wallet_id']) && isset($_POST['user_id'])) {
        $wallet_id = $_POST['wallet_id'];
        $user_id = $_POST['user_id'];

        $check = DB::queryFirstField("SELECT w.wallet_id FROM users u LEFT JOIN wallet_info w ON w.user_id = u.user_id WHERE u.user_id = %i AND w.wallet_id = %i", $user_id, $wallet_id);

        if ($check !== null) {
            DB::update('wallet_info', ['wallet_status' => 1], "wallet_id=%i", $wallet_id);

            $data['error'] = 0;
            $data['error_msg'] = "Wallet Address Activated Successfully!";
        } else {
            $data['error'] = 1;
            $data['error_msg'] = "Failed to activate wallet address. Please try again later!";
        }

    } else {
        $data['error'] = 1;
        $data['error_msg'] = "Oops, something went wrong!";
    }

    echo json_encode($data);
?>