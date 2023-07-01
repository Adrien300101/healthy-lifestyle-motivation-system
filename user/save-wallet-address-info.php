<?php 
    include_once("../config.php");
    require_once '../vendor/autoload.php';

    if (isset($_POST['address']) && isset($_POST['privateKey']) && isset($_POST['publicKey']) && isset($_POST['userId'])) {

        $user_id = $_POST['userId'];
        $address = $_POST['address'];
        $private_key = $_POST['privateKey'];
        $public_key = $_POST['publicKey'];
        $validation = 0;

        $check_user_id = DB::queryFirstField("SELECT user_id FROM users WHERE user_id = %i", $user_id);
        if ($check_user_id === null) {
            //user does not exist
            $validation = 1;
        }

        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');

        // Set up the Tron object
        $tron = new \IEXBase\TronAPI\Tron($fullNode);

        $is_valid_add = $tron->validateAddress($address);

        if (!$is_valid_add) {
            $validation = 1;
        }

        $public_key_regex = "#^04[0-9a-fA-F]{128}$#";

        if (!preg_match($public_key_regex, $public_key)) {
            $validation = 1;
        }

        $private_key_regex = '#^[0-9a-fA-F]{64}$#';

        if (!preg_match($private_key_regex, $private_key)) {
            $validation = 1;
        }

        if ($validation == 0) {

            $check = DB::insert('wallet_info', [
                'user_id' => $user_id,
                'tron_wallet_address' => $address,
                'private_key' => $private_key,
                'public_key' => $public_key
            ]);

            if ($check) {
                $data['error'] = 0;
                $data['error_msg'] = "Wallet Address Information Successfully Saved!";
            } else {
                $data['error'] = 1;
                $data['error_msg'] = "Oops, something went wrong. Please try again later!";
            }

        } else {
            $data['error'] = 1;
            $data['error_msg'] = "Oops, something went wrong. Please try again later!";
        }

    } else {
        //incomplete parameters
        $data['error'] = 1;
	    $data['error_msg'] = "Oops, something went wrong, please try again later";
    }

    echo json_encode($data);
?>