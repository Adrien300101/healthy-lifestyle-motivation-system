
    
    <script src="../assets/js/bundle.js?ver=3.1.1"></script>
    <script src="../assets/js/scripts.js?ver=3.1.1"></script>
    <script src="../assets/js/charts/chart-crypto.js?ver=3.1.1"></script>
    <script src="../assets/js/charts/gd-analytics.js?ver=3.1.1"></script>
    <script src="../assets/js/charts/gd-default.js?ver=3.1.1"></script>
    <script src="../assets/js/libs/jqvmap.js?ver=3.1.1"></script>
    <script src="../js/TronWeb.js"></script>
    <script src="../js/bignumber.js-master/bignumber.js"></script>
    
    <script>
        const privateKey = <?php echo json_encode($private_key) ?>;
        const address = <?php echo json_encode($wallet_add) ?>;
        const stcContractAddress = <?php echo json_encode(CONTRACT_ADDRESS) ?>;

        $(document).ready(function() {
            //below code to get the balance of STC for the wallet address of the user:
            // Set up the TronWeb instance
            const fullNode = 'https://api.nileex.io';
            const solidityNode = 'https://api.nileex.io';
            const eventServer = 'https://api.nileex.io';
            const tronWeb = new TronWeb(fullNode, solidityNode, eventServer, privateKey);

            // Get the STC balance for the address
            const app = async() => {
            const {
                abi
            } = await tronWeb.trx.getContract(stcContractAddress);

                const stcContract = tronWeb.contract(abi.entrys, stcContractAddress);
                stcContract.balanceOf(address).call().then((balance) => {

                    var editProfileBalanceElement = document.getElementById("stc_balance");
                    var balanceLargeScreen = document.getElementById("balance_large_screen");
                    var balanceSmallScreen = document.getElementById("balance_small_screen");
                    var walletBalance = document.getElementById("wallet_balance");

                    if (balanceLargeScreen) {
                        $("#balance_large_screen").html(`${(balance * Math.pow(10, -18)).toFixed(2)} <small class="currency currency-btc">STC</small>`);
                        document.getElementById("balance_large_screen").style.display = "block";
                        document.getElementById("spinner_stc_wallet_large").style.display = "none";
                    }

                    if (balanceSmallScreen) {
                        $("#balance_small_screen").html(`${(balance * Math.pow(10, -18)).toFixed(2)} <small class="currency currency-btc">STC</small>`);
                        document.getElementById("balance_small_screen").style.display = "block";
                        document.getElementById("spinner_stc_wallet_small").style.display = "none";
                    }

                    if (editProfileBalanceElement) {
                        $("#stc_balance").html(`${(balance * Math.pow(10, -18)).toFixed(2)} <small class="currency currency-btc">STC</small>`);
                        document.getElementById("stc_balance").style.display = "block";
                        document.getElementById("spinner_stc_profile_balance").style.display = "none";
                    }

                    if (walletBalance) {
                        $("#wallet_balance").html(`${(balance * Math.pow(10, -18)).toFixed(2)}`);
                        document.getElementById("button_container").style.display = "block";
                        document.getElementById("buy_button").style.display = "block";
                        document.getElementById("spinner_wait_button").style.display = "none";
                        document.getElementById("spinner_container").style.display = "none";
                    }
                    
                }).catch((error) => {
                    console.log(`Error getting balance: ${error}`);
                });
            
            }

            app();
        });
    </script>
</body>

</html>