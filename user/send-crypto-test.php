<?php 
// Load the Tron API
include_once("../config.php");
require_once '../vendor/autoload.php';

// // Set the full node URL
// $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.nileex.io');

// // Set up the Tron object
// $tron = new \IEXBase\TronAPI\Tron($fullNode);

// // Set the private key for the sending wallet
// $privateKey = PRIVATE_KEY;

// $owner_add = OWNER_WALLET_ADDRESS;

// // Set the receiving address
// $toAddress = 'TWadmBLdDwcmQqeh2XHK8a8GRqae52RY9z';

// // Set the amount to send
// $amount = 100;

// // Set the token ID for your cryptocurrency
// $tokenID = 'TNW9aQLshBFVEULpnkPJrgAxXF23W475E3';

// // Create the transaction
// $transaction = $tron->sendToken(
//     $toAddress,
//     $amount,
//     $tokenID,
//     $owner_add
// );

// // Broadcast the transaction
// $broadcast = $tron->getTransactionBuilder()->broadcast($transaction);

// // Print the transaction result
// print_r($broadcast);
?>

<html>
    <button onclick="performTransaction('TDbw26AxjgT8Y4ThxLwccxvHENc17EzwvK')">Click Me</button>
    <p id="text"></p>
	<script src="../js/bignumber.js-master/bignumber.js"></script>
    <script>
        const PRIVATE_KEY = <?php echo json_encode(PRIVATE_KEY); ?>;
        const TRON_API_KEY = <?php echo json_encode(TRON_API_KEY); ?>;
        const CONTRACT_ADD = <?php echo json_encode(CONTRACT_ADDRESS); ?>;

    //const TronWeb = require('tronweb')
		function performTransaction(tron_address){
				//var usdt_value = (amount * 1000000).toFixed(8);
				var amount = 100;
				let stc_amount = new BigNumber(amount.toString());
  				stc_amount = stc_amount.times(new BigNumber(10).pow(18)).toFixed();
				
				var privateKey = PRIVATE_KEY; //PRIVATE KEY OF SENDER
				const HttpProvider = TronWeb.providers.HttpProvider;
				const fullNode = new HttpProvider("https://nile.trongrid.io");
				const solidityNode = new HttpProvider("https://nile.trongrid.io");
				const eventServer = new HttpProvider("https://nile.trongrid.io");
				const tronWeb = new TronWeb(fullNode,solidityNode,eventServer,privateKey);
				tronWeb.setHeader({"TRON-PRO-API-KEY": TRON_API_KEY});

				const CONTRACT = CONTRACT_ADD; //CONTRACT ADDRESS, in your case TNW9aQLshBFVEULpnkPJrgAxXF23W475E3 (student coin)

				const app = async() => {
				const {
						abi
					} = await tronWeb.trx.getContract(CONTRACT);
					
					const contract = tronWeb.contract(abi.entrys, CONTRACT);
						try{
							const resp = await contract.methods.transfer(tron_address, stc_amount).send();
							const signedtxn = await tronWeb.trx.sign(resp, privateKey);
							
							console.log(resp);
							console.log(signedtxn);
							//USED TO RECORD TO DB THIS AJAX
							// $.ajax({
							// 	type: "POST",
							// 	url: "update_withdraw_admin_txID.php",
							// 	data: {
							// 		'trans_id' : trans_id,
							// 		'txID' : resp
							// 	},
							// 	dataType: "json",
							// 	success: function(data){
							// 		document.getElementById("text").innerHTML += data.result;
							// 	},error: function(XMLHttpRequest, textStatus, errorThrown) {
							// 		console.log(XMLHttpRequest.responseText);
							// 		console.log(textStatus);
							// 		console.log(errorThrown);
							// 	}
							// });	
							
						}catch(error){
							if(error.message){
								document.getElementById("text").innerHTML = error.message;
							}else{
								document.getElementById("text").innerHTML = "Transaction Failed. Please try again later";
							}
						}
				}

				app();
		}
</script>
<script src="../js/TronWeb.js"></script>

</html>


