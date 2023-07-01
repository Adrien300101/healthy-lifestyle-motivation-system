<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");

    if (isset($_POST['product_id']) && isset($_POST['admin_id']) ) {
        $admin_id = $_POST['admin_id'];
        if (check_admin($admin_id)) {
            $product_id = $_POST['product_id'];
            $product_detail = DB::queryFirstField("SELECT product_id FROM product WHERE product_id = %i", $product_id);
            if ($product_detail != NULL) {
                //deactivate coupon
                DB::update("product", ['product_status' => 1], "product_id = %i", $product_id);
                $data['error'] = 0;
                $data['error_msg'] = "Coupon was successfully deactivated!";
            } else {
                //wrong coupon
                $data['error'] = 1;
                $data['error_msg'] = "Oops, something went wrong. Please try again later!";
            }
        } else {
            //wrong user
            $data['error'] = 1;
            $data['error_msg'] = "Oops, something went wrong. Please try again later!";
        }
    } else {
        //incomplete parameters
        $data['error'] = 1;
        $data['error_msg'] = "Oops, something went wrong. Please try again later!";
    }

    echo json_encode($data);
?>