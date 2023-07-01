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
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Leaderboard</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>Today's Ranking:</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row">
                                    <?php 
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
                                        total_stc_amount DESC;
                                        ", 2, 1);

                                        $leaderboard_img = DB::query("SELECT img_url FROM leaderboard_images WHERE img_status = %i ORDER BY img_id ASC", 0);

                                        if (count($leaderboard_img) > 0) {
                                            for ($i = 0; $i < count($leaderboard_img); $i++) {
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="card card-bordered card-preview border-warning">
                                            <div class="card-inner">
                                                <div class="leaderboard-card">
                                                    <div class="leaderboard-card__top">
                                                        <h3 class="text-center"><?php echo $ranking_details[$i]["first_name"]." ".$ranking_details[$i]["last_name"] ?></h3>
                                                    </div>
                                                    <div class="leaderboard-card__body">
                                                        <div class="text-center">
                                                            <img src="../images/leaderboard-images/<?php echo $leaderboard_img[$i]['img_url'] ?>" style="width: 30%; height: 30%;" class="circle-img mb-2" alt="User Img">
                                                            <h5 class="mb-0"><?php echo number_format($ranking_details[$i]["total_stc_amount"], 2)." STC"; ?></h5>
                                                            <p class="text-muted mb-0"><?php echo $ranking_details[$i]["email"] ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                            }
                                        } else {
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="card card-bordered card-preview border-warning">
                                            <div class="card-inner">
                                                <div class="leaderboard-card">
                                                    <div class="leaderboard-card__top">
                                                        <h3 class="text-center">No Top 3 Ranking Details Available Yet!</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="nk-block">
                                <div class="card card-bordered card-preview border-warning">
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
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- .card-preview -->
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

<?php
include_once("footer-main.php");
?>