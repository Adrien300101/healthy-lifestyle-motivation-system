<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");

    if (isset($_POST['product_id']) && isset($_POST['admin_id']) ) {
        $admin_id = $_POST['admin_id'];
        if (check_admin($admin_id)) {

            $product_detail = DB::queryFirstField("SELECT product_id FROM product WHERE product_id = %i", $_POST['product_id']);

            if ($product_detail != NULL) {
                $product_id = $_POST['product_id'];
                //activate coupon
                DB::update("product", ['product_status' => 0], "product_id = %i", $product_id);
                $data['error'] = 0;
                $data['error_msg'] = "Coupon was successfully activated!";
            }else {
                //wrong product
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