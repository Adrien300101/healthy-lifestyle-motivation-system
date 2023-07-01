<?php 
    include_once("header-main.php");

    if (isset($_GET['product_id'])) {
        $product_details = DB::queryFirstRow("
                SELECT p.product_id, p.product_img_url, p.product_name, pc.product_category_name, p.product_price, p.product_description
                FROM product p LEFT JOIN product_category pc ON pc.product_category_id = p.product_category_id  
                WHERE p.product_status = %i AND p.product_id = %i
            ", 0, $_GET['product_id']);
        if ($product_details == NULL) {
            echo "
                Swal.fire({
                    html: 'Oops, something went wrong, please try again later',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'

                }).then(function() {
                    window.location.href = '../user/marketplace.php';
                });
            ";
        }
    } else {
        echo "
                Swal.fire({
                    html: 'Oops, something went wrong, please try again later',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'

                }).then(function() {
                    window.location.href = '../user/marketplace.php';
                });
            ";
    }
?>
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php include_once("nk-sidebar.php") ?>
            <!-- sidebar @e -->
                <!-- main header @s -->
                <?php include_once("nk-header.php"); ?>
                
                <!-- main header @e -->
                <!-- content @s -->

            <div class="nk-content nk-content-fluid">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Coupon Details</h3>
                                        <div class="nk-block-des text-soft">
                                            
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="../user/marketplace.php" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                        <a href="../user/marketplace.php" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered border-warning">
                                    <div class="card-inner">
                                        <div class="row pb-5">
                                            <div class="col-lg-6">
                                                <div class="product-gallery me-xl-1 me-xxl-5">
                                                    <div style="width: 100%; height: 100%;">
                                                        <img class="card-img" src="../images/products/<?php echo $product_details['product_img_url'] ?>" alt="" style="width: 100%; height: 100%;">
                                                    </div>
                                                </div><!-- .product-gallery -->
                                            </div><!-- .col -->
                                            <div class="col-lg-6">
                                                <div class="product-info mt-5 me-xxl-5">
                                                    <h4 class="product-price text-primary" id="price-display"><?php echo $product_details['product_price']." STC"; ?></h4>
                                                    <h2 class="product-title"><?php echo $product_details['product_name'] ?></h2>
                                                    <div class="product-excrept text-soft">
                                                        <p class="lead"><?php echo $product_details['product_description'] ?></p>
                                                    </div>
                                                    <div class="card-inner text-center" id="spinner_container">
                                                        <ul id="spinner_wait_button" class="preview-list g-1" style="display: block;">
                                                            <li class="preview-item" style="width: 100%;">
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-inner text-center" id="button_container" style="display: none;">
                                                        <button onclick="showOTPModal()" id="buy_button" style="display:none;margin:auto;" class="btn btn-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="buy_loading" style="display:none;"></span><span>Buy</span></button>
                                                    </div>
                                                </div><!-- .product-info -->
                                            </div><!-- .col -->
                                        </div><!-- .row -->
                                    </div>
                                </div>
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once("nk-footer.php"); ?>
            <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <div class="modal fade show" tabindex="-1" id="otp-modal" aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a onclick="close_transfer_modal()" id="otp_cross_button" class="close"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl bg-primnary"><i class="fa-solid fa-credit-card"></i></em>
                        <h4 class="nk-modal-title">Checkout</h4>
                        <div class="nk-modal-text">
                            <ul class="team-info">
                                <li><span>Coupon Price (STC)</span><span id="coupon_price"><?php echo $product_details['product_price'] ?></span></li>
                                <li><span>Your Wallet Balance (STC)</span><span id="wallet_balance"></span></li>
                                <li><span>Balance After Payment (STC)</span><span id="balance_after"></span></li>
                                <br><br>
                                <div class="form-group">
                                    <label class="form-label" for="otp">Enter OTP</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="otp" placeholder="">
                                        <span id="otp_error" class="invalid" style="display: none;"></span>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="nk-modal-action">
                            <button onclick="makePayment()" id="proceed_button" type="button" class="btn btn-lg btn-primary" ><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="proceed_loading" style="display:none;"></span><span>Proceed</span></button>
                        </div>
                    </div>
                </div> <!--.modal-body -->
            </div>
        </div>
    </div> 
<?php
include_once("footer-main.php");
?>

<script src="https://kit.fontawesome.com/e0f3ebe6da.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#otp-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    function showOTPModal() {
        document.getElementById("buy_loading").style.display = "block";
        document.getElementById("buy_button").disabled = true;

        let coupon_price = parseFloat(document.getElementById("coupon_price").innerText);
        let wallet_balance = parseFloat(document.getElementById("wallet_balance").innerText);

        console.log(wallet_balance);

        //ajax call to first send email and then open the modal
        $.ajax({
            url: "../user/stc-pre-payment-operations.php",
            method: "POST",
            data: {
                coupon_id : `<?php echo $product_details['product_id'] ?>`,
                user_balance: wallet_balance,
                user_id: `<?php echo $user_id ?>`
            },
            dataType: "json",
            success: function(data){
                document.getElementById("buy_loading").style.display = "none";
                document.getElementById("buy_button").disabled = false;

                if(data.error == 0){
                    document.getElementById("balance_after").innerText = data.balance_after;
                    document.getElementById("proceed_button").setAttribute("onclick", "makePayment("+ data.coupon_price + ", " + data.current_balance + ")");
                    $("#otp-modal").modal("show");
                    //makePayment(data.stc_transfer_amount, data.sender_private_key, data.current_balance);
                    
                }else{	
                    document.getElementById("buy_loading").style.display = "none";
                    document.getElementById("buy_button").disabled = false;
                    // document.getElementById("transfer_cross_button").setAttribute("onclick", "close_transfer_modal()");
                    // document.getElementById("otp").disabled = false;
                    // console.log(data);
                    // document.getElementById("otp_error").innerHTML = data.otp_msg;
                    // document.getElementById("otp_error").style.display = "block";

                    Swal.fire({
                        html: data.error_msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    })
                }
            }, error: function(data){
                console.log(data);
                document.getElementById("buy_loading").style.display = "none";
                document.getElementById("buy_button").disabled = false;
				
                Swal.fire({
                    text: 'Something went wrong. Please try again later!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'
                })
            }
        });
    }

    function close_transfer_modal() {
        $("#otp-modal").modal("hide");
    }

    function makePayment(stc_transfer_amount, current_balance) {
        document.getElementById("proceed_loading").style.display = "block";
        document.getElementById("proceed_button").disabled = true;
        document.getElementById("otp_cross_button").setAttribute("onclick", "");
        let otp = document.getElementById("otp").value;

        $.ajax({
            url: "../user/stc-payment-operations.php",
            method: "POST",
            data: {
                stc_transfer_amount : stc_transfer_amount,
                user_balance: current_balance,
                otp: otp,
                user_id: <?php echo json_encode($user_id) ?>
            },
            dataType: "json",
            success: function(data){
                if(data.error == 0){

                    sendStc(data.stc_transfer_amount, data.sender_private_key);
                    
                }else{	
                    document.getElementById("proceed_loading").style.display = "none";
                    document.getElementById("proceed_button").disabled = false;
                    document.getElementById("otp_cross_button").setAttribute("onclick", "close_transfer_modal()");
                    console.log(data);
                    document.getElementById("otp_error").innerHTML = data.otp_error;
                    document.getElementById("otp_error").style.display = "block";

                    Swal.fire({
                        html: data.error_msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    })
                }
            }, error: function(data){
                
                document.getElementById("proceed_loading").style.display = "none";
                document.getElementById("proceed_button").disabled = false;
                document.getElementById("otp_cross_button").setAttribute("onclick", "close_transfer_modal()");
				
                Swal.fire({
                    text: 'Something went wrong. Unable to activate wallet address. Please try again later',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'
                })
            }
        });
    }

    function sendStc(amount, sender_private_key) {
        const TRON_API_KEY = <?php echo json_encode(TRON_API_KEY); ?>;
        const CONTRACT_ADD = <?php echo json_encode(CONTRACT_ADDRESS); ?>;

        let stc_amount = new BigNumber(amount);
        stc_amount = stc_amount.times(new BigNumber(10).pow(18)).toFixed();

        console.log(stc_amount);
        
        var privateKey = sender_private_key; //PRIVATE KEY OF SENDER
        const HttpProvider = TronWeb.providers.HttpProvider;
        const fullNode = new HttpProvider("https://nile.trongrid.io");
        const solidityNode = new HttpProvider("https://nile.trongrid.io");
        const eventServer = new HttpProvider("https://nile.trongrid.io");
        const tronWeb = new TronWeb(fullNode,solidityNode,eventServer,privateKey);
        tronWeb.setHeader({"TRON-PRO-API-KEY": TRON_API_KEY});

        const app = async() => {
        const {
                abi
            } = await tronWeb.trx.getContract(CONTRACT_ADD);
            
            const contract = tronWeb.contract(abi.entrys, CONTRACT_ADD);
            try{
                const resp = await contract.methods.transfer(`<?php echo OWNER_WALLET_ADDRESS; ?>`, stc_amount).send();
                const signedtxn = await tronWeb.trx.sign(resp, privateKey);

                console.log("Here: " + resp);
                console.log(signedtxn);

                const checkStatus = async () => {
                    try {
                    // Retrieve the transaction information
                        const transactionInfo = await tronWeb.trx.getTransactionInfo(resp);
                        if (
                            (transactionInfo &&
                            transactionInfo.receipt &&
                            transactionInfo.receipt.result === "SUCCESS") || (transactionInfo &&
                            transactionInfo.receipt &&
                            transactionInfo.receipt.result === "FAILED")
                        ) {
                            console.log("Transaction successful!");

                            //USED TO RECORD TO DB THIS AJAX
                            $.ajax({
                                type: "POST",
                                url: "../user/record-payment.php",
                                data: {
                                    coupon_id : `<?php echo $product_details['product_id'] ?>`,
                                    amount_transfer : amount,
                                    transaction_status : transactionInfo.receipt.result,
                                    sender_id : <?php echo json_encode($user_id) ?>
                                },
                                dataType: "json",
                                success: function(data){
                                    document.getElementById("proceed_loading").style.display = "none";
                                    document.getElementById("proceed_button").disabled = false;
                                    document.getElementById("otp_cross_button").setAttribute("onclick", "close_transfer_modal()");
                                    close_transfer_modal();
                                    console.log(data);

                                    if(data.error == 0){
                                        Swal.fire({
                                            html: data.error_msg,
                                            icon: 'success',
                                            confirmButtonText: 'OK',
                                            confirmButtonColor: '#ffcf40'
                                        }).then(() => {
                                            window.location.href = "marketplace.php";
                                        });
                                        
                                    }else{	
                                        console.log(data);

                                        Swal.fire({
                                            html: data.error_msg,
                                            icon: 'error',
                                            confirmButtonText: 'OK',
                                            confirmButtonColor: '#ffcf40'
                                        }).then(() => {
                                            window.location.href = "marketplace.php";
                                        });
                                    }
                                }, error: function(data){
                                    console.log(data);
                                    document.getElementById("proceed_loading").style.display = "none";
                                    document.getElementById("proceed_button").disabled = false;
                                    document.getElementById("otp_cross_button").setAttribute("onclick", "close_transfer_modal()");
                                    close_transfer_modal();
                                    Swal.fire({
                                        html: "Oops, something went wrong. Please try again later!",
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#ffcf40'
                                    })
                                }
                            });
                        } else {
                            console.log("Transaction not yet confirmed.");
                            // Retry after a delay
                            setTimeout(checkStatus, 5000); // 5 seconds delay 
                        }
                    } catch (error) {
                        console.error("Error retrieving transaction info:", error);
                        // Retry after a delay
                        setTimeout(checkStatus, 5000); // 5 seconds delay
                    }
                };

                checkStatus();
                
            }catch(error){
                console.log(error);
                document.getElementById("proceed_loading").style.display = "none";
                document.getElementById("proceed_button").disabled = false;
                document.getElementById("otp_cross_button").setAttribute("onclick", "close_transfer_modal()");
                close_transfer_modal();
                Swal.fire({
                    html: "You do not have enough TRX to perform this transaction. Please try again later!",
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'
                })
            }
        }

        app();
    }
</script>
