<?php 
include_once("../config.php");
require_once '../vendor/autoload.php';

use IEXBase\TronAPI\Tron;

$fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
$solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
$eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');

try {
    $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
} catch (\IEXBase\TronAPI\Exception\TronException $e) {
    exit($e->getMessage());
}

// Replace with your token name
$tokenName = 'Tether USD (USDT)';

$tokenId = 'your token id here';

// Search for the token by name
$tokenList = $tron->getTokensIssuedByAddress("THPvaUhoh2Qn2y9THCZML3H815hhFhn5YC");//takes the wallet address of the owner as argument

var_dump($tokenList);

foreach ($tokenList as $token) {
    echo "here";
    if ($token['name'] == $tokenName) {
        // Token found, get the ID
        $tokenId = $token['id'];
        break;
    }
}

echo "Token ID for $tokenName: $tokenId";

?>