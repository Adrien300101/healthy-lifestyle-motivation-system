<?php 
    include_once("header-main.php");
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
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-head-sub"><span>Account Wallet</span> </div><!-- .nk-block-head-sub -->
                                <div class="nk-block-between-md g-4">
                                    <div class="nk-block-head-content">
                                        <h2 class="nk-block-title fw-normal">Wallet</h2>
                                        <div class="nk-block-des">
                                            <!-- <p>Here is the list of your assets / wallets!</p> -->
                                        </div>
                                    </div>
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-block-head-sm">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title title">STC Crypto Account</h5>
                                    </div>
                                </div>
                                
                                <div class="row g-gs">
                                    <div class="col-sm-6 col-lg-4 col-xl-6 col-xxl-4">
                                        <div class="card card-bordered is-dark border-warning">
                                            <div class="nk-wgw">
                                                <div class="nk-wgw-inner">
                                                    <a class="nk-wgw-name" href="#">
                                                        <div class="nk-wgw-icon">
                                                            <em class="icon ni"><img src="../images/coins/stc_icon.png" class="img-fluid"></em>
                                                        </div>
                                                        <h5 class="nk-wgw-title title">STC Wallet</h5>
                                                    </a>
                                                    <div class="nk-wgw-balance">
                                                        <ul id="spinner_stc_wallet" class="preview-list g-1" style="display:none;">
                                                            <li class="preview-item" style="width: 100%;">
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div id="stc_amount_div" class="amount" style="display: none;"><span class="currency currency-nio" id="stc_amount"></span></div>
                                                        <!-- <div class="amount-sm">8,924.63<span class="currency currency-usd">USD</span></div> -->
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="nk-wgw-actions">
                                                    <ul>
                                                        <li><a onclick="show_pre_transfer_modal()"><em class="icon ni ni-arrow-up-right"></em> <span>Send</span></a></li>
                                                        <li><a onclick="share_wallet_add()"><em class="icon ni ni-arrow-down-left"></em><span>Receive</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    
                                </div><!-- .row -->
                            </div>
                            <br><br>
                            <div class="nk-block">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Transaction History</h4>
                                    </div>
                                </div>

                                <div class="card card-bordered card-preview border-warning">
                                    <div class="card-inner">
                                        <table id="transaction-table" class="datatable-init table">
                                            <thead>
                                                <tr>
                                                    <th>Transaction Type</th>
                                                    <th>Amount (STC)</th>
                                                    <th>Status</th>
                                                    <th>Sender</th>
                                                    <th>Receiver</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $transaction_details = DB::query("SELECT
                                                    t.transaction_type,
                                                    t.sender_id,
                                                    t.receiver_id,
                                                    sender.first_name AS sender_first_name,
                                                    sender.last_name AS sender_last_name,
                                                    receiver.first_name AS receiver_first_name,
                                                    receiver.last_name AS receiver_last_name,
                                                    t.stc_amount,
                                                    t.date_created,
                                                    t.status
                                                FROM
                                                    wallet_transactions t
                                                LEFT JOIN
                                                    users sender
                                                ON
                                                    t.sender_id = sender.user_id
                                                LEFT JOIN
                                                    users receiver
                                                ON
                                                    t.receiver_id = receiver.user_id
                                                WHERE
                                                    (t.sender_id = %i OR t.receiver_id = %i)
                                                ORDER BY
                                                    t.date_created DESC;", $user_id, $user_id);
                

                                                    foreach ($transaction_details as $transaction) {
                                                        if ($transaction['transaction_type'] == 1 && $transaction['sender_id'] == $user_id) {
                                                            $tran_text_color = "text-warning";
                                                            $tran_text = "TRANSFER";
                                                        } else if ($transaction['transaction_type'] == 1 && $transaction['receiver_id'] == $user_id) {
                                                            $tran_text_color = "text-info";
                                                            $tran_text = "RECEIVE";
                                                        } else if ($transaction['transaction_type'] == 3 && $transaction['sender_id'] == $user_id) {
                                                            $tran_text_color = "text-purple";
                                                            $tran_text = "COUPON PURCHASE";
                                                        } else {
                                                            $tran_text_color = "text-success";
                                                            $tran_text = "EXERCISE SUCCESS";
                                                        }

                                                        if ($transaction['status'] == 0) {
                                                            $stat_text_color = "text-warning";
                                                            $stat_text = "PENDING";
                                                        } else if ($transaction['status'] == 1) {
                                                            $stat_text_color = "text-success";
                                                            $stat_text = "SUCCESS";
                                                        } else {
                                                            $stat_text_color = "text-danger";
                                                            $stat_text = "FAILED";
                                                        }
                                                ?>
                                                <tr>
                                                    <td class="<?php echo $tran_text_color ?>">
                                                        <?php 
                                                            echo $tran_text;
                                                        ?>
                                                    </td>
                                                    <td class="<?php echo $tran_text_color ?>"><?php echo $transaction['stc_amount'] ?></td>
                                                    <td class="<?php echo $stat_text_color ?>"><?php echo $stat_text ?></td>
                                                    <td>
                                                        <?php 
                                                            if ($transaction['sender_first_name'] != null) {
                                                                echo $transaction['sender_first_name'] . " " . $transaction['sender_last_name'];
                                                            } else {
                                                                echo "N/A";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            if ($transaction['receiver_first_name'] != null) {
                                                                echo $transaction['receiver_first_name'] . " " . $transaction['receiver_last_name'];
                                                            } else {
                                                                echo "N/A";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $transaction['date_created'] ?></td>
                                                </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- .card-preview -->
                                
                            </div><!-- .nk-block -->
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
    <div class="modal fade" tabindex="-1" id="activateWalletModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-info bg-info"></em>
                        <h4 class="nk-modal-title">Please activate your wallet address!</h4>
                        <div class="nk-modal-text">
                            <p class="lead">Your wallet address is still inactive. Click on the button below to activate it.</p>
                            <!-- <p class="text-soft">If you need help please contact us at (855) 485-7373.</p> -->
                        </div>
                        <div class="nk-modal-action mt-5">
                            <button class="btn btn-lg btn-mw btn-primary" id="activate_btn" onclick="activateWallet()">Activate</button>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div>
        </div>
    </div>

    <div class="modal fade show" tabindex="-1" id="share_wallet_add" aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a onclick="close_share_wallet_add()" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-telegram bg-success"></em>
                        <h4 class="nk-modal-title">Receive Student Coins</h4>
                        <div class="nk-modal-text">
                            <ul class="team-info">
                                <!-- <div id="reader" width="600px"></div> -->
                                <!-- <div class="user-card user-card-s2">
                                    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php //echo $user_id; ?>" title="mycoin.bz" style=" width: 100px; height: 100px; margin:-15px 0 0 -30px;">

                                </div> -->
                                <div class="card card-bordered is-dark">
                                    <div class="nk-refwg-invite card-inner">
                                        <div class="nk-refwg-head g-3">
                                            <div class="nk-refwg-title">
                                                <h5 class="title">Your Tron Wallet Address</h5>
                                                <div class="title-sub">Copy your tron wallet address below and share it for transfer operation.</div>
                                            </div>
                                        </div>
                                        <div class="nk-refwg-url">
                                            <div class="form-control-wrap">
                                                <div class="form-clip clipboard-init" data-clipboard-target="#referral_code" data-success="Copied" data-text="Copy Code"><em class="clipboard-icon icon ni ni-copy"></em> <span class="clipboard-text">Copy Address</span></div>
                                                <div class="form-icon">
                                                    <em class="icon ni ni-link-alt"></em>
                                                </div>
                                                <input type="text" readonly class="form-control copy-text" id="referral_code" value="<?php echo $wallet_add; ?>">
                                            </div>
                                        </div><br>
                                    </div><!-- .nk-refwg-invite -->
                                </div>
                            </ul>
                            
                        </div>
                        <div class="nk-modal-action">
       
                        </div>
                    </div>
                </div> <!--.modal-body -->
            </div>
        </div>
    </div> 

    <div class="modal fade show" tabindex="-1" id="pre_transfer_modal" aria-modal="true" role="dialog" backdrop='static' keyboard='false'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a onclick="close_pre_transfer_modal()" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-telegram bg-success"></em>
                        <h4 class="nk-modal-title">Transfer Student Coins</h4>
                        <div class="nk-modal-text">
                            <!-- <ul class="team-info">
                                <div id="reader" width="600px"></div>

                            </ul> -->

                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <div class="preview-block">
                                        <div class="row gy-4">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="wallet_add">Enter a valid TRC20 Wallet Address</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="wallet_add" placeholder="e.g. TVrcfoJFMhAif32ywcmtcU3huMCYvoXgj3">
                                                        <span id="wallet_add_error" class="invalid" style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="stc_transfer">Enter amount (STC)</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-text-hint">
                                                            <span class="overline-title">STC</span>
                                                        </div>
                                                        <input oninput="restrictInputToNumbers(this)" type="text" class="form-control" id="stc_transfer" placeholder="">
                                                        <span id="transfer_amount_error" class="invalid" style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-modal-action">
                            <button onclick="transfer_pre_validate()" id="pre_transfer_button" type="button" class="btn btn-lg btn-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="pre_transfer_loading" style="display:none;"></span><span>Proceed</span></button>
                        </div>
                    </div>
                </div> <!--.modal-body -->
            </div>
        </div>
    </div> 

    <div class="modal fade show" tabindex="-1" id="transfer_modal" aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a onclick="close_transfer_modal()" id="transfer_cross_button" class="close"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-telegram bg-success"></em>
                        <h4 class="nk-modal-title">Transfer Student Coins</h4>
                        <div class="nk-modal-text">
                            <!-- <ul class="team-info">
                                <div id="reader" width="600px"></div>

                            </ul> -->
                            <ul class="team-info">
                                <li><span>Transfer Amount (STC)</span><span id="amount_to_transfer"></span></li>
                                <li><span>Current Balance (STC)</span><span id="current_balance"></span></li>
                                <li><span>Balance After Transfer (STC)</span><span id="balance_after"></span></li>
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
                            <button onclick="transfer()" id="transfer_button" type="button" class="btn btn-lg btn-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="transfer_loading" style="display:none;"></span><span>Transfer</span></button>
                        </div>
                    </div>
                </div> <!--.modal-body -->
            </div>
        </div>
    </div> 
    
    <div class="modal fade" tabindex="-1" role="dialog" id="region">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="title mb-4">Select Your Country</h5>
                    <div class="nk-country-region">
                        <ul class="country-list text-center gy-2">
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/arg.png" alt="" class="country-flag">
                                    <span class="country-name">Argentina</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/aus.png" alt="" class="country-flag">
                                    <span class="country-name">Australia</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/bangladesh.png" alt="" class="country-flag">
                                    <span class="country-name">Bangladesh</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/canada.png" alt="" class="country-flag">
                                    <span class="country-name">Canada <small>(English)</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">Centrafricaine</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">China</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/french.png" alt="" class="country-flag">
                                    <span class="country-name">France</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/germany.png" alt="" class="country-flag">
                                    <span class="country-name">Germany</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/iran.png" alt="" class="country-flag">
                                    <span class="country-name">Iran</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/italy.png" alt="" class="country-flag">
                                    <span class="country-name">Italy</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/mexico.png" alt="" class="country-flag">
                                    <span class="country-name">México</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/philipine.png" alt="" class="country-flag">
                                    <span class="country-name">Philippines</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/portugal.png" alt="" class="country-flag">
                                    <span class="country-name">Portugal</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/s-africa.png" alt="" class="country-flag">
                                    <span class="country-name">South Africa</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/spanish.png" alt="" class="country-flag">
                                    <span class="country-name">Spain</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/switzerland.png" alt="" class="country-flag">
                                    <span class="country-name">Switzerland</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/uk.png" alt="" class="country-flag">
                                    <span class="country-name">United Kingdom</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="../images/flags/english.png" alt="" class="country-flag">
                                    <span class="country-name">United State</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->
    <!-- JavaScript -->
    
<?php include_once("footer-main.php") ?>
<script src="../assets/js/qr_packed.js" type="text/javascript"></script>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<script>

    window.onload = function() {
        document.getElementById("spinner_stc_wallet").style.display = "block";
        var wallet_status = <?php echo json_encode($wallet_status); ?>;
        if (wallet_status == 0) {
            $("#activateWalletModal").modal("show");
        }
    };

    // function onScanSuccess(decodedText, decodedResult) {
    //     // Handle on success condition with the decoded text or result.
    //     console.log(`Scan result: ${decodedText}`, decodedResult);
    // }

    // var html5QrcodeScanner = new Html5QrcodeScanner(
    //     "reader", { fps: 10, qrbox: 250 });
    // html5QrcodeScanner.render(onScanSuccess);

    function show_pre_transfer_modal() {
        $("#pre_transfer_modal").modal("show");
    }

    function close_pre_transfer_modal() {
        $("#pre_transfer_modal").modal("hide");
    }

    function close_transfer_modal() {
        $("#transfer_modal").modal("hide");
    }

    function share_wallet_add() {
        $("#share_wallet_add").modal("show");
    }

    function close_share_wallet_add() {
        $("#share_wallet_add").modal("hide");
    }

    $(document).ready(function() {
        var table = $('#transaction-table').DataTable();

        table.order([5, 'desc']).draw(); // Column index 5 represents the Date column, sort in descending order

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
                document.getElementById("pre_transfer_button").setAttribute("onclick", `transfer_pre_validate(${balance * Math.pow(10, -18)})`);
                document.getElementById("spinner_stc_wallet").style.display = "none";
                document.getElementById("stc_amount_div").style.display = "block";
                $("#stc_amount").html(`Balance: ${(balance * Math.pow(10, -18)).toFixed(2)} STC`);
                
            }).catch((error) => {
                document.getElementById("spinner_stc_wallet").style.display = "none";
                document.getElementById("stc_amount_div").style.display = "block";
                Swal.fire({
                    text: 'Oops, something went wrong. Please try again later!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'
                }).then(() => {
                    window.location.href = 'index.php';
                });
                console.error(`Error getting balance: ${error}`);
            });
        
        }

        app();

        $('#transfer_modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    //below function sends 1 TRX from the wallet of the admin to the wallet address of the user to activate it
    function activateWallet() {
        $("#activateWalletModal").modal("hide");
        
        const fullNode = 'https://api.nileex.io';
        const solidityNode = 'https://api.nileex.io';
        const eventServer = 'https://api.nileex.io';
        const tronWeb = new TronWeb(fullNode, solidityNode, eventServer, privateKey);

        // Send a transaction to activate the account
        const amount = 100000000; // 100 TRX
        tronWeb.trx.sendTransaction(address, amount, <?php echo json_encode(PRIVATE_KEY) ?>)
        .then((result) => {
            console.log('Account activated:', result);

            $.ajax({
                url: "../user/activate-wallet-address.php",
                method: "POST",
                data: {
                    wallet_id: <?php echo json_encode($wallet_id) ?>,
                    user_id: <?php echo json_encode($user_id) ?>
                },
                dataType: "json",
                success: function(data){

                    if(data.error == 0){
                        Swal.fire({
                            html: data.error_msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ffcf40'
                        })
                    }else{					
                        Swal.fire({
                            html: data.error_msg,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ffcf40'
                        })
                    }
                }, error: function(data){	
                    console.log(data);					
                    Swal.fire({
                        text: 'Something went wrong. Unable to activate wallet address. Please try again later',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    })
                }
            });

        }).catch((error) => {
            console.error('Error activating account:', error);
        });
    }

    function restrictInputToNumbers(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9.]/g, ''); // Allow digits and decimal point
        inputElement.value = inputElement.value.replace(/(\..*)\./g, '$1'); // Allow only one decimal point
        inputElement.value = inputElement.value.replace(/(\.\d{2}).*/g, '$1'); // Allow no more than two decimal places
    }


    function transfer_pre_validate(user_balance) {
        document.getElementById("pre_transfer_loading").style.display = "block";
        document.getElementById("pre_transfer_button").disabled = true;
        document.getElementById("wallet_add").disabled = true;
        document.getElementById("stc_transfer").disabled = true;
        var wallet_add = document.getElementById("wallet_add").value;
        var stc_transfer_amount = document.getElementById("stc_transfer").value;

        $.ajax({
            url: "../user/stc-transfer-pre-operations.php",
            method: "POST",
            data: {
                wallet_add: wallet_add,
                stc_transfer_amount : stc_transfer_amount,
                user_balance: user_balance,
                user_id: <?php echo json_encode($user_id) ?>
            },
            dataType: "json",
            success: function(data){

                document.getElementById("pre_transfer_loading").style.display = "none";
                document.getElementById("pre_transfer_button").disabled = false;
                document.getElementById("wallet_add").disabled = false;
                document.getElementById("stc_transfer").disabled = false;
                document.getElementById("wallet_add").value = "";
                document.getElementById("stc_transfer").value = "";

                if(data.error == 0){
                    Swal.fire({
                        html: data.error_msg,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    })

                    close_pre_transfer_modal();

                    document.getElementById("amount_to_transfer").innerHTML = data.amount_to_transfer;
                    document.getElementById("current_balance").innerHTML = data.current_balance;
                    document.getElementById("balance_after").innerHTML = data.balance_after;
                    var wallet_add = data.wallet_add_receiver;
                    var amount = data.amount_to_transfer;
                    var current_balance = data.current_balance;
                    document.getElementById("transfer_button").setAttribute("onclick", 'transfer('+amount+', "' +wallet_add+'", '+ current_balance+')');

                    $("#transfer_modal").modal("show");
                    
                }else{	
                    console.log(data);
                    document.getElementById("wallet_add_error").innerHTML = data.wallet_add_msg;
                    document.getElementById("wallet_add_error").style.display = "block";
                    document.getElementById("transfer_amount_error").innerHTML = data.transfer_amount_error;
                    document.getElementById("transfer_amount_error").style.display = "block";				
                    Swal.fire({
                        html: data.error_msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    })
                }
            }, error: function(data){
                
                document.getElementById("pre_transfer_loading").style.display = "none";
                document.getElementById("pre_transfer_button").disabled = false;
                document.getElementById("wallet_add").disabled = false;
                document.getElementById("stc_transfer").disabled = false;
                document.getElementById("wallet_add").value = "";
                document.getElementById("stc_transfer").value = "";
				
                Swal.fire({
                    text: 'Oops, something went wrong. Please try again later',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'
                })
            }
        });
    }

    function transfer(stc_transfer_amount, wallet_add, current_balance) {
        document.getElementById("transfer_loading").style.display = "block";
        document.getElementById("transfer_button").disabled = true;
        document.getElementById("transfer_cross_button").setAttribute("onclick", "");

        document.getElementById("otp").disabled = true;
        var otp = document.getElementById("otp").value;

        $.ajax({
            url: "../user/stc-transfer-operations.php",
            method: "POST",
            data: {
                wallet_add: wallet_add,
                stc_transfer_amount : stc_transfer_amount,
                user_balance: current_balance,
                otp: otp,
                user_id: <?php echo json_encode($user_id) ?>
            },
            dataType: "json",
            success: function(data){
                if(data.error == 0){

                    sendStc(data.stc_transfer_amount, data.receiver_wallet_add, data.sender_private_key, data.current_balance);
                    
                }else{	
                    document.getElementById("transfer_loading").style.display = "none";
                    document.getElementById("transfer_button").disabled = false;
                    document.getElementById("transfer_cross_button").setAttribute("onclick", "close_transfer_modal()");
                    document.getElementById("otp").disabled = false;
                    console.log(data);
                    document.getElementById("otp_error").innerHTML = data.otp_msg;
                    document.getElementById("otp_error").style.display = "block";

                    Swal.fire({
                        html: data.error_msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    })
                }
            }, error: function(data){
                
                document.getElementById("transfer_loading").style.display = "none";
                document.getElementById("transfer_button").disabled = false;
                document.getElementById("otp").disabled = false;
                document.getElementById("transfer_cross_button").setAttribute("onclick", "close_transfer_modal()");
				
                Swal.fire({
                    text: 'Something went wrong. Unable to activate wallet address. Please try again later',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'
                })
            }
        });

    }

    function sendStc(amount, receiver_wallet_add, sender_private_key, user_balance) {
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
                const resp = await contract.methods.transfer(receiver_wallet_add, stc_amount).send();
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
                                url: "../user/record-transfer.php",
                                data: {
                                    amount_transfer : amount,
                                    receiver_wallet_add : receiver_wallet_add,
                                    user_balance: user_balance,
                                    transaction_status : transactionInfo.receipt.result,
                                    sender_id : <?php echo json_encode($user_id) ?>
                                },
                                dataType: "json",
                                success: function(data){
                                    document.getElementById("transfer_loading").style.display = "none";
                                    document.getElementById("transfer_button").disabled = false;
                                    document.getElementById("transfer_cross_button").setAttribute("onclick", "close_transfer_modal()");
                                    document.getElementById("otp").disabled = false;
                                    close_transfer_modal();
                                    console.log(data);

                                    if(data.error == 0){
                                        Swal.fire({
                                            html: data.error_msg,
                                            icon: 'success',
                                            confirmButtonText: 'OK',
                                            confirmButtonColor: '#ffcf40'
                                        }).then(() => {
                                            location.reload();
                                        });
                                        
                                    }else{	
                                        console.log(data);

                                        Swal.fire({
                                            html: data.error_msg,
                                            icon: 'error',
                                            confirmButtonText: 'OK',
                                            confirmButtonColor: '#ffcf40'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    }
                                }, error: function(data){
                                    console.log(data);
                                    document.getElementById("transfer_loading").style.display = "none";
                                    document.getElementById("transfer_button").disabled = false;
                                    document.getElementById("transfer_cross_button").setAttribute("onclick", "close_transfer_modal()");
                                    document.getElementById("otp").disabled = false;
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