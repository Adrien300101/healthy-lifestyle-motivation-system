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
                                        <h3 class="nk-block-title page-title">Market Place</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>Today's Offers:</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <?php 
                                        $product_details = DB::query("
                                        SELECT p.product_id, p.product_img_url, p.product_name, p.product_category_id, p.product_price
                                        FROM product p
                                        WHERE product_status = %i
                                        AND NOT EXISTS (
                                            SELECT 1
                                            FROM product_user_bridge pu
                                            WHERE pu.product_id = p.product_id
                                            AND pu.user_id = %i
                                        )
                                    ", 0, $user_id);
                                    
                                        if (count($product_details) > 0) {
                                            foreach ($product_details as $product) {
                                    ?>
                                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                                        <div class="card card-bordered product-card border-primary">
                                            <div class="product-thumb">
                                                <a href="#">
                                                    <img class="card-img-top" src="../images/products/<?php echo $product['product_img_url'] ?>" alt="" style="width: 100%; height: 314.52px;">
                                                </a>
                                                <ul class="product-badges">
                                                    <li>
                                                        <?php 
                                                            if ($product['product_category_id'] == 0) {
                                                                echo '<span class="badge bg-success">NEW</span>';
                                                            } else if ($product['product_category_id'] == 1) {
                                                                echo '<span class="badge bg-danger">HOT</span>';
                                                            }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-inner text-center">
                                                <h5 class="product-title"><a href="#"><?php echo $product['product_name']; ?></a></h5>
                                                <div class="product-price text-primary h5"><?php echo number_format($product['product_price'], 2)." STC"; ?></div>
                                            </div>
                                            <div class="card-inner text-center">
                                                <a href="product-checkout.php?product_id=<?php echo $product['product_id'] ?>" class="btn btn-primary">
                                                    <em class="icon ni ni-coins"></em>
                                                    <span>Buy Now</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <?php 
                                            }
                                        } else {
                                            echo '<div class="col-xxl-3 col-lg-4 col-sm-6">
                                            <div class="card card-bordered product-card">No Coupons Available Now. Please come back later!</div></div>';
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