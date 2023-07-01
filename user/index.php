<?php 
    include_once("header-main.php");

    $exercise_history = DB::query("SELECT exercise_id, reps_limit, exercise_status, date_completed 
    FROM daily_exercise_goal 
    WHERE user_id = %i 
        AND date_completed >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
        AND exercise_status = %i AND exercise_id = %i
    ORDER BY date_created ASC;
    ", $user_id, 1, 1);

    $exercise_detail = DB::queryFirstRow("SELECT d.date_created, d.reps_limit, e.exercise_image FROM daily_exercise_goal d LEFT JOIN exercise_list e ON e.exercise_id = d.exercise_id WHERE d.user_id = %i AND d.exercise_status = %i AND e.status = %i", $user_id, 0, 0);

    $ranking_details = DB::query("SELECT 
                                        u.first_name,
                                        u.last_name,
                                        u.email,
                                        u.initial,
                                        COALESCE(SUM(w.stc_amount), 0) AS total_stc_amount,
                                        RANK() OVER (ORDER BY COALESCE(SUM(w.stc_amount), 0) DESC) AS rank
                                    FROM
                                        users u
                                    LEFT JOIN
                                        wallet_transactions w ON u.user_id = w.receiver_id AND w.transaction_type = %i AND w.status = %i
                                    GROUP BY
                                        u.user_id
                                    ORDER BY
                                        total_stc_amount DESC LIMIT 3;
                                        ", 2, 1);

    $coupon_details = DB::query("SELECT product_img_url FROM product WHERE product_status = %i AND product_category_id = %i", 0, 0);
    
?>
        <!-- main @s -->
        <div class="nk-main ">
            <?php include_once("nk-sidebar.php"); ?>
            <!-- wrap @s -->
            <?php include_once("nk-header.php"); ?>
                <!-- main header @e -->
                
                <!-- content @s -->
                <div class="nk-content nk-content-fluid">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Dashboard</h3>
                                            <div class="nk-block-des text-soft">
                                                <p></p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col-lg-8">
                                            <div class="card card-bordered h-100 border-primary">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">Exercise Overview</h6>
                                                            <p>In last 7 days exercise overview.</p>
                                                        </div>
                                                        <div class="card-tools mt-n1 me-n1">
                                                            
                                                        </div>
                                                    </div><!-- .card-title-group -->
                                                    <div class="nk-order-ovwg">
                                                        <div class="row g-4 align-end">
                                                            <div class="col-xxl-8">
                                                                <div class="nk-order-ovwg-ck">
                                                                    <!-- <canvas class="order-overview-chart" id="exerciseOverview"></canvas> -->
                                                                    <ul id="spinner_chart" class="preview-list g-1" style="display:block;">
                                                                        <li class="preview-item" style="width: 100%;">
                                                                            <div class="d-flex justify-content-center">
                                                                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                                                                    <span class="visually-hidden">Loading...</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                    <canvas class="order-overview-chart chartjs-render-monitor" id="exerciseOverview" style="display:none;"></canvas>
                                                                </div>
                                                            </div><!-- .col -->
                                                            <div class="col-xxl-4">
                                                                <div class="row g-4">
                                                                    <div class="col-sm-6 col-xxl-12">
                                                                        <div class="card card-bordered border-primary">
                                                                            <div class="card-inner">
                                                                                <div class="team">
                                                                                    <div class="user-card user-card-s2">
                                                                                        <div class="user-avatar md bg-purple w-50 h-75">
                                                                                            <img src="../images/exercise/<?php echo $exercise_detail['exercise_image'] ?>" alt="Exercise Image" style="width: 100%; height: 100%;">
                                                                                        </div>
                                                                                    </div>
                                                                                
                                                                                    <?php 
                                                                                        $current_date = date("Y-m-d"); // First date
                                                                                        $date2 = date("Y-m-d", strtotime($exercise_detail['date_created'])); // Second date
                                        
                                                                                        // Convert dates to timestamp
                                                                                        $date1_timestamp = strtotime($current_date);
                                                                                        $date2_timestamp = strtotime($date2);
                                        
                                                                                        // Check if date2 is less than current_date
                                                                                        if (($date2_timestamp < $date1_timestamp) || $exercise_detail['reps_limit'] == 0) {
                                                                                    ?>
                                                                                    <div class="team-details">
                                                                                        <p class="text-primary">Complete Today's Goal Now</p>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="team-view">
                                                                                            <a href="../user/exercise-list.php" class="btn btn-lg btn-mw btn-success">Play Now</a>
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
                                                                </div>
                                                            </div><!-- .col -->
                                                        </div>
                                                    </div><!-- .nk-order-ovwg -->
                                                </div><!-- .card-inner -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-lg-4">
                                            <div class="card card-bordered h-100 border-primary">
                                                <div class="card-inner-group">
                                                    <div class="card-inner card-inner-md">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Today's Top 3 Rankers:</h6>
                                                            </div>
                                                            
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                    <div class="card-inner">
                                                        <table id="transaction-table" class="datatable-init table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Rank</th>
                                                                    <th>Name</th>
                                                                    <th>STC Collected</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                if (isset($ranking_details)) {
                                                                    foreach ($ranking_details as $detail) {
                                                                        if ($detail['rank'] == 1) {
                                                                            $text_color = "text-warning";
                                                                            $bg_color = "bg-warning";
                                                                        } else if ($detail['rank'] == 2) {
                                                                            $text_color = "text-success";
                                                                            $bg_color = "bg-success";
                                                                        } else if ($detail['rank'] == 3) {
                                                                            $text_color = "text-danger";
                                                                            $bg_color = "bg-danger";
                                                                        } else {
                                                                            $text_color = "text-info";
                                                                            $bg_color = "bg-info";
                                                                        }
                                                                ?>
                                                                <tr>
                                                                    <td class="<?php echo $text_color ?>">
                                                                        <?php 
                                                                            echo $detail['rank'];
                                                                        ?>
                                                                    </td>
                                                                    <td class="<?php echo $text_color ?>">
                                                                        <a href="#" class="project-title">
                                                                            <div class="user-avatar sq <?php echo $bg_color ?>"><span><?php echo $detail['initial'] ?></span></div>
                                                                            <div class="project-info">
                                                                                <h6 class="title <?php echo $text_color ?>"><?php echo $detail['first_name']." ".$detail['last_name'] ?></h6>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <td class="<?php echo $text_color ?>"><?php echo number_format($detail['total_stc_amount'], 2) ?></td>
                                                                </tr>
                                                                <?php
                                                                    }
                                                                } 
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div><!-- .card-inner -->
                                                    
                                                    <div class="card-inner-sm border-top text-center">
                                                        <a href="../user/leaderboard.php" class="btn btn-link btn-block">See Full Leaderboard</a>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .card-inner-group -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-lg-8">
                                            <div class="card card-bordered card-full border-primary">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title"><span class="me-2">Latest Coupons</span></h6>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner p-0 border-top">
                                                    <div id="carouselExFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            <?php 
                                                            if (count($coupon_details) > 0) {
                                                                for ($i = 0; $i < count($coupon_details); $i++) {
                                                                    if ($i == 0) {
                                                            ?>
                                                            
                                                            <div class="carousel-item active">
                                                                <img src="../images/products/<?php echo $coupon_details[$i]['product_img_url'] ?>" class="d-block w-100" style="height: 200px;" alt="carousel">
                                                            </div>
                                                            <?php 
                                                                    } else {
                                                            ?>
                                                            <div class="carousel-item">
                                                                <img src="../images/products/<?php echo $coupon_details[$i]['product_img_url'] ?>" class="d-block w-100" style="height: 200px;" alt="carousel">
                                                            </div>
                                                            <?php 
                                                                    }
                                                                }
                                                            } else {
                                                                echo "No coupons available!";
                                                            }
                                                            ?>
                                                        </div>
                                                        <a class="carousel-control-prev" href="#carouselExFade" role="button" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#carouselExFade" role="button" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </a>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner-sm border-top text-center">
                                                    <a href="../user/marketplace.php" class="btn btn-link btn-block">See Market Place</a>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                    </div><!-- .row -->
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
    <!-- select region modal -->
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
                                    <img src="./images/flags/arg.png" alt="" class="country-flag">
                                    <span class="country-name">Argentina</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/aus.png" alt="" class="country-flag">
                                    <span class="country-name">Australia</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/bangladesh.png" alt="" class="country-flag">
                                    <span class="country-name">Bangladesh</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/canada.png" alt="" class="country-flag">
                                    <span class="country-name">Canada <small>(English)</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">Centrafricaine</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">China</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/french.png" alt="" class="country-flag">
                                    <span class="country-name">France</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/germany.png" alt="" class="country-flag">
                                    <span class="country-name">Germany</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/iran.png" alt="" class="country-flag">
                                    <span class="country-name">Iran</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/italy.png" alt="" class="country-flag">
                                    <span class="country-name">Italy</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/mexico.png" alt="" class="country-flag">
                                    <span class="country-name">México</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/philipine.png" alt="" class="country-flag">
                                    <span class="country-name">Philippines</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/portugal.png" alt="" class="country-flag">
                                    <span class="country-name">Portugal</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/s-africa.png" alt="" class="country-flag">
                                    <span class="country-name">South Africa</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/spanish.png" alt="" class="country-flag">
                                    <span class="country-name">Spain</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/switzerland.png" alt="" class="country-flag">
                                    <span class="country-name">Switzerland</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/uk.png" alt="" class="country-flag">
                                    <span class="country-name">United Kingdom</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/english.png" alt="" class="country-flag">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the canvas element
    const ctx = document.getElementById('exerciseOverview').getContext('2d');

    // Initialize the chart
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [], // Array to store the labels
            datasets: [{
            label: 'Repetitions completed',
            data: [], // Array to store the data
            backgroundColor: '#3498db',
            borderColor: '#3498db',
            borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function addData(label, value) {
        chart.data.labels.push(label);
        chart.data.datasets[0].data.push(value);
        chart.update(); // Update the chart to reflect the changes
    }

    var jsArrayExercise = <?php echo json_encode($exercise_history); ?>;
    var options = { day: 'numeric', month: 'long' };

    // Create an array to store completed dates
    var completedDates = jsArrayExercise.map(function(element) {
        if (element && element.date_completed) { // Check if the element and 'date_completed' property exist
            return new Date(element.date_completed).toLocaleDateString('en-US', options);
        }
    });

    // Get the last date and today's date
    var lastDate = null;
    if (jsArrayExercise.length > 0 && jsArrayExercise[jsArrayExercise.length - 1].date_completed) {
        lastDate = new Date(jsArrayExercise[jsArrayExercise.length - 1].date_completed);
    }

    var today = new Date();
    today.setHours(0, 0, 0, 0); // Set time to 00:00:00 to compare dates

    // Iterate over the last 7 days
    for (var i = 6; i >= 0; i--) {
        var currentDate = new Date(today);
        currentDate.setDate(currentDate.getDate() - i);
        var formattedDate = currentDate.toLocaleDateString('en-US', options);

        if (completedDates.includes(formattedDate)) {
            // Add data for completed days
            var index = completedDates.indexOf(formattedDate);
            var repsLimit = jsArrayExercise[index] && jsArrayExercise[index].reps_limit; // Check if the element and 'reps_limit' property exist
            addData(formattedDate, repsLimit);
        } else {
            // Add data for missed days
            addData(formattedDate, 0);
        }

        if (i == 0) {
            document.getElementById("spinner_chart").style.display = "none";
            document.getElementById("exerciseOverview").style.display = "block";
        }
    }



</script>
