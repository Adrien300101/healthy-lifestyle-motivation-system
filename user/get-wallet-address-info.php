<?php 
    include_once("../config.php");

?>

<html>
    <p id="wallet_info"></p>
    <button onclick="getWalletInfo()">Show Results</button>


<script>
    const PRIVATE_KEY = "6e6fbe3db645141c9f5f330c9df07bc60f1d6f4e8a1f5a750722a9b5b5e073f5";
    const TRON_API_KEY = <?php echo json_encode(TRON_API_KEY); ?>;
    const CONTRACT_ADD = <?php echo json_encode(CONTRACT_ADDRESS); ?>;

    function getWalletInfo() {

        const privateKey = PRIVATE_KEY;
        const HttpProvider = TronWeb.providers.HttpProvider;
        const fullNode = new HttpProvider("https://nile.trongrid.io");
        const solidityNode = new HttpProvider("https://nile.trongrid.io");
        const eventServer = new HttpProvider("https://nile.trongrid.io");
        const tronWeb = new TronWeb(fullNode,solidityNode,eventServer,privateKey);
        tronWeb.setHeader({"TRON-PRO-API-KEY": TRON_API_KEY});

        const address = 'TWadmBLdDwcmQqeh2XHK8a8GRqae52RY9z'; // Replace with the Tron wallet address you want to retrieve the public key for

        tronWeb.trx.getAccount(address)
        .then(account => {
            console.log(account);
        })
        .catch(err => {
            console.error(err);
        });

    }
</script>

<script src="../js/TronWeb.js"></script>

</html>