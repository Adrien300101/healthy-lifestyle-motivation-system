<?php 
    include_once("header-main.php");
    require_once '../vendor/autoload.php';

    // // require_once('../tron-api-5.0.0/src/Tron.php');
    // use IEXBase\TronAPI\Provider\HttpProvider;


    // $httpProvider = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nile.trongrid.io');
    // $tron = new \IEXBase\TronAPI\Tron($httpProvider);


    // // $tron = new \IEXBase\TronAPI\Tron('https://api.nile.trongrid.io');

    // //$privateKey = '944a9be77c7cfd93d6829b61d1f78a5ff4b51b76529bb2502f0bf342e2b98e02';
    // // $wallet = $tron->loadAccount(PRIVATE_KEY);

    // // $balance = $tron->getBalance($wallet['address']);

    // $balance = $tron->getBalance(null, true);
    // echo 'Balance: ' . $balance . ' TRX';

use IEXBase\TronAPI\Tron;

$fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');
$solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');
$eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');

try {
    $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
} catch (\IEXBase\TronAPI\Exception\TronException $e) {
    exit($e->getMessage());
}


// $this->setAddress(OWNER_WALLET_ADDRESS);
//Balance
$tron->setAddress(OWNER_WALLET_ADDRESS);
$tron->setPrivateKey(PRIVATE_KEY);
$balance = $tron->getBalance(null, true);
echo $balance;

// // Transfer Trx
// var_dump($tron->send('to', 1.5));

// //Generate Address
// var_dump($tron->createAccount());

// //Get Last Blocks
// var_dump($tron->getLatestBlocks(2));

// //Change account name (only once)
// var_dump($tron->changeAccountName('address', 'NewName'));


// // Contract
// $tron->contract('Contract Address');


?>


