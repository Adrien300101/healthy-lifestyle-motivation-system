<?php 
    include_once("../config.php");
    include_once("../admin/check-admin-function.php");

    if (isset($_POST["admin_id"]) && isset($_POST['coupon_name']) && isset($_POST['coupon_description']) && isset($_POST['coupon_price']) && isset($_POST['coupon_code'])) {
        $admin_id = $_POST['admin_id'];
        if (check_admin($admin_id)) {
            $coupon_name = $_POST['coupon_name'];
            $coupon_description = $_POST['coupon_description'];
            $coupon_price = $_POST['coupon_price'];
            $coupon_code = $_POST['coupon_code'];
            $validation = 0;

            //validation for image
            if (!isset($_FILES['coupon_image'])) {
                $data['error_file_msg'] = "Please upload a picture of the coupon!";
                $validation = 1;
            } else {
                $coupon_image = $_FILES['coupon_image'];
                $file_ext_index = strrpos($coupon_image["name"], '.') + 1;
                $file_ext = substr($coupon_image["name"], $file_ext_index, (strlen($coupon_image["name"])-1));
                $array_supported_exts = array("apng", "png", "jpg", "jpeg", "jfif", "pjpeg");
                $match = 0;
                foreach($array_supported_exts as $ext){
                    if($ext == $file_ext){
                        $match += 1;
                    }
                }

                if ($match == 0 ) {
                    $data['error_file_msg'] = "The file extension is not supported. You can only upload an image!";
                    $validation = 1;
                } else {
                    $data['error_file_msg'] = "";
                }
            }

            if (empty($coupon_name)) {
                $validation = 1;
                $data['coupon_name_error'] = "This field cannot be left empty!";
            } else {
                $data['coupon_name_error'] = "";
            }
        
            if (empty($coupon_description)) {
                $validation = 1;
                $data['coupon_description_error'] = "This field cannot be left empty!";
            } else {
                $data['coupon_description_error'] = "";
            }

            if ($coupon_price != 0) {
                if (!is_numeric($coupon_price) || strpos($coupon_price, 'e')) {
                    $data['coupon_price_error'] = "Coupon price can only be in numbers";
                    $validation = 1;
                } else {
                    $data['coupon_price_error'] = "";
                }
            } else if ($coupon_price <= 0) {
                $data['coupon_price_error'] = "Coupon price cannot be zero or negative";
                $validation = 1;
            } else {
                $data['coupon_price_error'] = "";
            }

            if (empty($coupon_code)) {
                $validation = 1;
                $data['coupon_code_error'] = "This field cannot be left empty!";
            } else {
                $data['coupon_code_error'] = "";
            }

            if ($validation == 0) {
                if ($coupon_image["size"] > 0) {
                    $coupon_image_name = $coupon_image["name"];
                    $tmp_name = $coupon_image["tmp_name"];
    
                    $coupon_image_ex = pathinfo($coupon_image_name, PATHINFO_EXTENSION);//obtaining the extension of the image
                    $coupon_image_ex_lc = strtolower($coupon_image_ex);//converting the extension to lower case
    
                    $new_coupon_image = date("YmdHisu").'.'.$coupon_image_ex_lc;
                    $coupon_image_upload_path = "../images/products/".$new_coupon_image;
                    if (move_uploaded_file($tmp_name, $coupon_image_upload_path)) {//uploading to the uploaded_icon folder
                        DB::insert('product', ['product_name' => $coupon_name, 'product_description' => $coupon_description, 'product_price' => $coupon_price, 'product_status' => 0, 'product_img_url' => $new_coupon_image, 'product_category_id' => 0, 'coupon_code' => $coupon_code]);

                        $data['error'] = 0;
                        $data['error_msg'] ="Coupon was successfully added!";
                    } else {
                        $data['error'] = 1;
                        $data['error_msg'] = "Image was not uploaded!";
                    }
                   
                } else {
                    $data['error'] = 1;
                    $data['error_msg'] ="Oops, seems like there is something wrong with the image you are trying to upload!";
                }
            } else {
                $data['error'] = 1;
                $data['error_msg'] ="Please ensure all fields are correct!";
            }
        } else {
            //wrong user
            $data['error'] = 2;
            $data['error_msg'] = "Oops, something went wrong. Please try again later!";
        }
    } else {
        //incomplete parameters
        $data['error'] = 2;
        $data['error_msg'] = "Oops, something went wrong. Please try again later!";
    }

    echo json_encode($data);
?>