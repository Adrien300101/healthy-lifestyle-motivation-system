<?php
include_once("header-main.php");

$goal_details = DB::query("SELECT d.reps_limit, d.daily_goal_id, d.date_created, e.exercise_id, e.exercise_name, e.exercise_description, e.exercise_image, e.embedded_video FROM daily_exercise_goal d LEFT JOIN exercise_list e ON e.exercise_id = d.exercise_id WHERE d.user_id = %i AND d.exercise_status = %i AND e.status = %i", $user_id, 0, 0);

if (isset($_GET['complete']) && isset($_GET['goal_id']) && isset($_GET['reps_done']) && isset($_GET['first_time']) && isset($_GET['exercise_id'])) {
    $complete = $_GET['complete'];
    $goal_id = $_GET['goal_id'];
    $reps_done = $_GET['reps_done'];
    $first_time = $_GET['first_time'];
    $exercise_id = $_GET['exercise_id'];

    $rate_per_rep = DB::queryFirstField("SELECT value FROM value_config WHERE value_id = %i AND value_name = %s", 1, "rate_per_reps");

    $stc_amount = $rate_per_rep * $reps_done;

    if ($complete == 1) {
        if ($first_time == 1) {//first time user to set max he can do
            DB::update('daily_exercise_goal', ["exercise_status" => 1, "date_completed" => date("Y-m-d H:i:s"), "reps_limit" => $reps_done], "user_id=%i AND daily_goal_id = %i", $user_id, $goal_id);
        } else {
            DB::update('daily_exercise_goal', ["exercise_status" => 1, "date_completed" => date("Y-m-d H:i:s")], "user_id=%i AND daily_goal_id = %i", $user_id, $goal_id);
        }

        $date_created = date("Y-m-d H:i:s");

        //create next exercise goal for tomorrow
        DB::insert('daily_exercise_goal', [
            'exercise_id' => $exercise_id,
            'user_id' => $user_id,
            'reps_limit' => $reps_done + 1,
            'exercise_status' => 0,
            'date_created' => $date_created
        ]);

        //insert record for this transaction to database
        DB::insert('wallet_transactions', [
            'transaction_type' => 2,
            'receiver_id' => $user_id,
            'stc_amount' => $stc_amount,
            'date_created' => $date_created,
            'status' => 1
        ]);
    }
} else {
    $complete = -1;
}
?>
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php include_once("nk-sidebar.php") ?>
            <!-- sidebar @e -->
                <!-- main header @s -->
                <?php include_once("nk-header.php"); ?>
                <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Exercise Now!</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>Choose your exercise type</p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <?php 
                                            foreach ($goal_details as $goal) {  
                                        ?>
                                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                                            <div class="card card-bordered border-primary">
                                                <div class="card-inner">
                                                    <div class="team">
                                                        <div class="user-card user-card-s2">
                                                            <div class="user-avatar md bg-purple w-50 h-75">
                                                                <img src="../images/exercise/<?php echo $goal['exercise_image'] ?>" alt="Exercise Image" style="width: 100%; height: 100%;">
                                                            </div>
                                                            <div class="user-info">
                                                                <h6><?php echo $goal['exercise_name'] ?></h6>
                                                            </div>
                                                        </div>
                                                        <div class="team-details">
                                                            <p><?php echo $goal['exercise_description'] ?></p>
                                                            <p class="text-primary">Target: <?php echo $goal['reps_limit'] ?> repetitions</p>
                                                        </div>

                                                        <br><br>
                                                        <?php 
                                                            $current_date = date("Y-m-d"); // First date
                                                            $date2 = date("Y-m-d", strtotime($goal['date_created'])); // Second date
            
                                                            // Convert dates to timestamp
                                                            $date1_timestamp = strtotime($current_date);
                                                            $date2_timestamp = strtotime($date2);
            
                                                            // Check if date2 is less than current_date
                                                            if (($date2_timestamp < $date1_timestamp) || $goal['reps_limit'] == 0) {
                                                        ?>
                                                        <div class="team-view">
                                                                <button class="btn btn-lg btn-mw btn-success" onclick='playNowInit(<?php echo json_encode($goal["reps_limit"]) ?>, <?php echo json_encode($goal["daily_goal_id"]) ?>, <?php echo json_encode($goal["exercise_id"]) ?>);'>Start</button>

                                                                <button class="btn btn-lg btn-mw btn-info" onclick='showVid(<?php echo json_encode($goal["embedded_video"]) ?>, <?php echo json_encode($goal["exercise_name"]) ?>);' style="margin-left: 10px;">How to?</button>
                                                        </div>

                                                        <?php 
                                                            } else if (isset($complete) && $complete == 1) {
                                                        ?>
                                                        <div class="team-view">
                                                            <span class="badge badge-dim rounded-pill bg-warning  badge-md">Completed</span>
                                                        </div>
                                                        <?php 
                                                            } else {
                                                        ?>
                                                        <div class="team-view">
                                                            <span class="badge badge-dim rounded-pill bg-warning  badge-md">Completed</span>
                                                        </div>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </div><!-- .team -->
                                                </div><!-- .card-inner -->
                                            </div><!-- .card -->
                                        </div>
                                        <?php 
                                            }
                                        ?>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <?php include_once("nk-footer.php"); ?>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->

<div class="modal fade" tabindex="-1" id="daily_complete_modal" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button onclick="reloadPage();" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross"></em></button>
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check"></em>
                    <h4 class="nk-modal-title">Congratulations!</h4>
                    <div class="nk-modal-text">
                        <div class="caption-text">You’ve successfully received <strong><span id="amount_container"></span></strong> STC</div>
                        <span class="sub-text-sm">Check your wallet now.<a href="../user/wallet.php"> Click here</a></span>
                    </div>
                    <div class="nk-modal-action">
                        <button onclick="reloadPage();" class="btn btn-lg btn-mw btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer bg-lighter">
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="exercise_overview" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <button onclick="closeVid()" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross"></em></button>
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    
                    <h4 class="nk-modal-title" id="exercise_title">How to do </h4>
                    <div class="nk-modal-text">
                        <div class="caption-text" id="exercise_video">
                            <iframe src="https://www.youtube.com/embed/k4s7oCaFURs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="nk-modal-action">
                        <button onclick="closeVid();" class="btn btn-lg btn-mw btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="group_play_guide" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm_header">GROUP PLAY</h5>
                <a class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body" id="confirm_body">
                Enjoy home training <span class="text-info">with your friends online!</span><br>
                And get the rewards given out as <span class="text-success">extra EXP and NFT fratures!</span><br>
                You can open a workout room or join a room created by others.
            </div>
            <div class="modal-footer bg-light d-flex justify-content-center">
                <button id="confirm_btn" class="btn btn-info" style="width:100px;" data-dismiss="modal">Create</button>
                <button id="confirm_btn" class="btn btn-success" style="width:100px;" data-dismiss="modal">Join in</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once("footer-main.php");
?>

<script>
    var complete = <?php echo json_encode($complete); ?>;
    const PRIVATE_KEY = <?php echo json_encode(PRIVATE_KEY); ?>;
    const TRON_API_KEY = <?php echo json_encode(TRON_API_KEY); ?>;
    const CONTRACT_ADD = <?php echo json_encode(CONTRACT_ADDRESS); ?>;
    const USER_WALLET_ADD = <?php echo json_encode($wallet_add); ?>;

    $(document).ready(function() {
    if (complete == 1) {
        console.log("here");
        const amount_stc = `<?php if (isset($stc_amount)) {echo $stc_amount;} ?>`;

        if (amount_stc != "0") {
            performTransaction(amount_stc);
        }
        document.getElementById("amount_container").innerHTML = `<?php if (isset($stc_amount)) {echo $stc_amount;} ?>`;
        $("#daily_complete_modal").modal("show");

        // Add event listener to modal backdrop element
        $("#daily_complete_modal").on("click", function(e) {
            if (e.target === this) { // Only reload if the click was on the backdrop element
                reloadPage();
            }
        });
    }
    });

    function playNowInit(rep_limit, goal_id, exercise_id) {
        HealthyVerse.playNow(rep_limit, goal_id, exercise_id);
    }

    function groupPlayGuide() {
        $("#group_play_guide").modal("show");
    }

    function reloadPage() {
        // Get the current URL without parameters
        var baseUrl = window.location.href.split('?')[0];

        // Set the new URL without parameters
        window.location.href = baseUrl;
    }

    function performTransaction(amount){
        let stc_amount = new BigNumber(amount);
        stc_amount = stc_amount.times(new BigNumber(10).pow(18)).toFixed();
        
        var privateKey = PRIVATE_KEY; //PRIVATE KEY OF SENDER
        const HttpProvider = TronWeb.providers.HttpProvider;
        const fullNode = new HttpProvider("https://nile.trongrid.io");
        const solidityNode = new HttpProvider("https://nile.trongrid.io");
        const eventServer = new HttpProvider("https://nile.trongrid.io");
        const tronWeb = new TronWeb(fullNode,solidityNode,eventServer,privateKey);
        tronWeb.setHeader({"TRON-PRO-API-KEY": TRON_API_KEY});

        const CONTRACT = CONTRACT_ADD; //CONTRACT ADDRESS

        const app = async() => {
        const {
                abi
            } = await tronWeb.trx.getContract(CONTRACT);
            
            const contract = tronWeb.contract(abi.entrys, CONTRACT);
                try{
                    const resp = await contract.methods.transfer(USER_WALLET_ADD, stc_amount).send();
                    const signedtxn = await tronWeb.trx.sign(resp, privateKey);
                    
                    console.log(resp);
                    console.log(signedtxn);
                    
                }catch(error){
                    if(error.message){
                        console.log(error.message);
                    }else{
                        console.log("Transaction Failed. Please try again later");
                    }
                }
        }

        app();
    }

    function showVid(embedded_html, exercise_name) {
        // Parse the HTML using DOMParser
        const parser = new DOMParser();
        const doc = parser.parseFromString(embedded_html, 'text/html');

        // Remove width and height attributes from the iframe element
        const iframe = doc.querySelector('iframe');
        iframe.removeAttribute('width');
        iframe.removeAttribute('height');

        // Serialize the modified DOM back to a string
        const modified_embedded_html = doc.body.innerHTML;

        document.getElementById("exercise_title").innerHTML += exercise_name;
        document.getElementById("exercise_video").innerHTML = modified_embedded_html;

        $("#exercise_overview").modal("show");
    }

    function closeVid() {
        $("#exercise_overview").modal("hide");
        const videoIframeContainer = document.getElementById('exercise_video');
        videoIframeContainer.innerHTML = "";
    }

</script>