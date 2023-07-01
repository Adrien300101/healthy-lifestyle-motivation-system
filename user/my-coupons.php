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
                                        <h3 class="nk-block-title page-title">My Coupons</h3>
                                        <div class="nk-block-des text-soft">
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <?php 
                                        $product_details = DB::query("SELECT p.product_id, p.product_img_url, p.product_name, p.product_description, p.coupon_code FROM product p LEFT JOIN product_user_bridge pu ON p.product_id = pu.product_id WHERE p.product_status = %i AND pu.status = %i AND pu.user_id = %i", 0, 0, $user_id);

                                        if (count($product_details) > 0) {
                                            foreach ($product_details as $product) {
                                    ?>
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <div class="card card-bordered product-card border-primary">
                                            <div class="product-thumb">
                                                <a href="#">
                                                    <img class="card-img-top" src="../images/products/<?php echo $product['product_img_url'] ?>" alt="" style="width: 100%; height: 314.52px;">
                                                </a>
                                            </div>
                                            <div class="card-inner text-center">
                                                <h5 class="product-title"><a href="#"><?php echo $product['product_name']; ?></a></h5>
                                            </div>
                                            <div class="card-inner text-center">
                                                <p><?php echo $product['product_description'] ?></p>
                                            </div>
                                            <div class="card-inner text-center">
                                                <div class="nk-refwg-url">
                                                    <div class="form-control-wrap">
                                                        <div class="form-clip clipboard-init" data-clipboard-target="#coupon_code<?php echo $product['product_id'] ?>" data-success="Copied" data-text="Copy Code"><em class="clipboard-icon icon ni ni-copy"></em> <span class="clipboard-text">Copy Code</span></div>
                                                        <div class="form-icon">
                                                            <em class="icon ni ni-link-alt"></em>
                                                        </div>
                                                        <input type="text" readonly class="form-control copy-text" id="coupon_code<?php echo $product['product_id'] ?>" value="<?php echo $product["coupon_code"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <?php 
                                            }
                                        } else {
                                            echo ' <div class="col-xxl-3 col-lg-4 col-sm-6">
                                                        <div class="card card-bordered product-card">
                                                            <div class="empty-state text-center">
                                                                <div class="empty-state-icon"><em class="icon ni ni-info"></em></div>
                                                                <h5 class="empty-state-title">You don’t have any coupons.</h5>
                                                                <p class="empty-state-text">Get started by <a href="marketplace.php" class="text-blue">buying now</a>.</p>
                                                            </div>
                                                        </div>
                                                    </div>';
                                        }
                                    ?>
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

<?php
include_once("footer-main.php");
?>