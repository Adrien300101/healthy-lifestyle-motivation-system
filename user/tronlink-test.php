<?php 
    include_once("header-main.php");
?>
        <button id="sendTransactionBtn">Send Transaction</button>

    </div>
    <?php include_once("footer-main.php") ?>
    <script src="../assets/js/qr_packed.js" type="text/javascript"></script>
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <script>
        // Wait for TronLink to be injected
        window.addEventListener("load", function() {
            if (typeof tronWeb !== "undefined") {
                // TronLink is available, you can use it here
                console.log("TronLink is connected");

                // Example transaction function
                function sendTransaction() {
                    tronWeb.trx.sendTransaction({
                        to: "TVrcfoJFMhAif32ywcmtcU3huMCYvoXgj3",
                        amount: 1000000 // Amount in SUN (1 TRX = 1,000,000 SUN)
                    })
                    .then(result => {
                        console.log(result);
                        alert("Transaction successful!");
                    })
                    .catch(error => {
                        console.log(error);
                        alert("Transaction failed!");
                    });
                }

                // Attach the function to the button click event
                var sendTransactionBtn = document.getElementById("sendTransactionBtn");
                sendTransactionBtn.addEventListener("click", sendTransaction);
            } else {
                // TronLink is not available
                console.log("TronLink not detected");
                alert("Please install TronLink to use this application.");
            }
        });
    </script>
