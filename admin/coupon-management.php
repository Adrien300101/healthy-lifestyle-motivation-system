
<?php
	include_once("header-main.php");
?>
<style>
    .description-cell {
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<body class="nk-body bg-white npc-general pg-auth dark-mode">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php
                include_once("nk-sidebar.php");
            ?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php 
                    include_once("nk-header.php");
                ?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Coupon List</h3>
                                            <div class="nk-block-des text-soft">
                                                <p></p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li><button onclick="showAddModal()" class="btn btn-primary"><span>Add Coupon</span></button></li>
                                                    </ul>
                                                </div>
                                            </div><!-- .toggle-wrap -->
                                        </div>
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner">
                                            <table class="datatable-init nowrap table">
                                                <thead>
                                                    <tr>
                                                        <th>Coupon Image</th>
                                                        <th>Coupon Name</th>
                                                        <th>Coupon Code</th>
                                                        <th>Coupon Price (STC)</th>
                                                        <th>Coupon Category</th>
                                                        <th>Coupon Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $coupon_details = DB::query("SELECT * FROM product p LEFT JOIN product_category pc ON p.product_category_id = pc.product_category_id");

                                                    foreach ($coupon_details as $detail) {
                                                        if ($detail['product_status'] == 0) {
                                                            $txt_color = "text-success";
                                                            $status = "Active";
                                                        } else {
                                                            $txt_color = "text-danger";
                                                            $status = "Deactivated";
                                                        }

                                                        if ($detail['product_category_name'] == "NEW") {
                                                            $category_txt_color = "text-success";
                                                        } else if ($detail['product_category_name'] == "HOT") {
                                                            $category_txt_color = "text-danger";
                                                        } else {
                                                            $category_txt_color = "text-info";
                                                        }
                                                ?>
                                                    <tr>
                                                        <td class="w-25">
                                                            <img style="width: 25%; height: 25%;" src="./images/products/<?php echo $detail['product_img_url'] ?>" class="img-fluid img-thumbnail" alt="Product image">
                                                        </td>
                                                        <td>
                                                            <span class="tb-status"><?php echo $detail['product_name']; ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="tb-status text-info"><?php echo $detail['coupon_code'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="tb-amount"><?php echo $detail['product_price'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="tb-status <?php echo $category_txt_color ?>"><?php echo $detail['product_category_name']; ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="tb-status <?php echo $txt_color; ?>"><?php echo $status; ?></span>
                                                        </td>
                                                        <td>
                                                            <ul class="nk-tb-actions gx-1">
                                                                <li>
                                                                    <div class="drodown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li><a data-bs-toggle="modal" onclick='showEditCouponModal(<?php echo $detail["product_id"] ?>, "<?php echo $detail["product_img_url"] ?>", "<?php echo $detail["product_name"] ?>", <?php echo json_encode($detail["product_description"]) ?>, <?php echo $detail["product_price"] ?>, "<?php echo $detail["coupon_code"] ?>", <?php echo $detail["product_category_id"] ?>)'><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                                                <!-- <li><a onclick="deleteCoupon(<?php //echo $detail['product_id'] ?>)"><em class="icon ni ni-delete"></em><span>Delete</span></a></li> -->
                                                                                <?php 
                                                                                    if ($detail['product_status'] != 0) {
                                                                                ?>
                                                                                <li><a onclick="activateCoupon(<?php echo $detail['product_id'] ?>);"><em class="icon ni ni-check"></em><span>Activate</span></a></li>
                                                                                <?php 
                                                                                    } else {
                                                                                ?>
                                                                                <li><a onclick="deactivateCoupon(<?php echo $detail['product_id'] ?>)"><em class="icon ni ni-cross"></em><span>Deactivate</span></a></li>
                                                                                <?php 
                                                                                    }
                                                                                ?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <?php 
                    include_once("nk-footer.php");
                ?>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    
    <div class="modal fade" id="editCoupon">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a onclick="closeModal();" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Edit Coupon</h5>
                    <form action="#" class="mt-2">
                        <div class="row g-gs">
                            <div class="col-md-12 d-flex justify-content-center align-items-center">
                                <div class="form-group">
                                    <label class="form-label">Image Preview</label>
                                    <div class="w-50 h-75">
                                        <img id="coupon-img-show" style="display: none;" class="w-100 h-100" alt="Coupon Image">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="edit-image">Coupon New Image</label>
                                    <div class="form-control-wrap">
                                        <div class="form-file">
                                            <input type="file" multiple="" class="form-control" id="edit-image">
                                            <!-- <label class="form-file-label" for="edit-image"></label> -->
                                            <span id="edit-image-error" class="invalid"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="edit-coupon-name">Coupon Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="edit-coupon-name">
                                        <span id="edit-coupon-name-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="edit-description">Coupon Description</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control no-resize" id="edit-description"></textarea>
                                        <span id="edit-description-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-price">Coupon Price</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="edit-price" oninput="restrictInputToNumbers(this)">
                                        <span id="edit-price-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-coupon-code">Coupon Code</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="edit-coupon-code">
                                        <span id="edit-coupon-code-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="">Coupon Category</label>
                                <div class="form-group">
                                    <!-- <div class="row"> -->
                                        
                                        <?php 
                                            $category_details = DB::query("SELECT * FROM product_category");
                                            foreach ($category_details as $detail) {
                                        ?>
                                        <!-- <div class="col-md-12"> -->
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="<?php echo $detail['product_category_name'] ?>" value="<?php echo $detail['product_category_id'] ?>" name="categoryRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="<?php echo $detail['product_category_name'] ?>"><?php echo $detail['product_category_name'] ?></label>
                                            </div>
                                        <!-- </div> -->
                                        <?php 
                                            }
                                        ?>
                                        <span id="edit-category-error" class="invalid"></span>
                                    <!-- </div> -->
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button onclick="updateCoupon()" id="update-button" type="button" class="btn btn-lg btn-primary btn-block"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="update-loading" style="display:none;"></span><span>Update Coupon</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .Edit Modal-Content -->

    <div class="modal fade" id="addCoupon">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a onclick="closeAddModal();" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Add Coupon</h5>
                    <form action="#" class="mt-2">
                        <div class="row g-gs">
                            <div class="col-md-12 d-flex justify-content-center align-items-center">
                                <div class="form-group">
                                    <label class="form-label">Image Preview</label>
                                    <div class="w-50 h-75">
                                        <img id="add-coupon-img-show" style="display: none;" class="w-100 h-100" alt="Coupon Image">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="add-image">Coupon Image</label>
                                    <div class="form-control-wrap">
                                        <div class="form-file">
                                            <input type="file" multiple="" class="form-control" id="add-image">
                                            <!-- <label class="form-file-label" for="add-image"></label> -->
                                            <span id="add-image-error" class="invalid"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="add-coupon-name">Coupon Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="add-coupon-name">
                                        <span id="add-coupon-name-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="add-description">Coupon Description</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control no-resize" id="add-description"></textarea>
                                        <span id="add-description-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="add-price">Coupon Price</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="add-price" oninput="restrictInputToNumbers(this)">
                                        <span id="add-price-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="add-coupon-code">Coupon Code</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="add-coupon-code">
                                        <span id="add-coupon-code-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button onclick="addCoupon()" id="add-button" type="button" class="btn btn-lg btn-primary btn-block"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="add-loading" style="display:none;"></span><span>Add Coupon</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .Add Modal-Content -->
    
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.1"></script>
    <script src="./assets/js/scripts.js?ver=3.1.1"></script>
    <script src="./assets/js/libs/datatable-btns.js"></script>
    <script>
        // Get references to the file input and the img tag
        const addImageInput = document.getElementById('add-image');
        const addImgTag = document.getElementById('add-coupon-img-show');

        // Add event listener to the file input
        addImageInput.addEventListener('change', function() {
            // Check if any file is selected
            if (addImageInput.files && addImageInput.files[0]) {
                const file = addImageInput.files[0];

                // Check if the file type is an image
                if (file.type.startsWith('image/')) {
                    document.getElementById("add-coupon-img-show").style.display = "block";
                    const reader = new FileReader();

                    // Read the selected file as a data URL
                    reader.readAsDataURL(file);

                    // Set the source of the img tag to the data URL
                    reader.onload = function(e) {
                        addImgTag.src = e.target.result;
                    }
                } else {
                    // Execute code for handling non-image files
                    Swal.fire({
                        html: "Wrong file type. Please select an image!",
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    });

                    addImageInput.value = ''; // Clear the selected file
                }
            }
        });

        // Get references to the file input and the img tag
        const editImageInput = document.getElementById('edit-image');
        const editImgTag = document.getElementById('coupon-img-show');

        // Add event listener to the file input
        editImageInput.addEventListener('change', function() {
            // Check if any file is selected
            if (editImageInput.files && editImageInput.files[0]) {
                const file = editImageInput.files[0];

                // Check if the file type is an image
                if (file.type.startsWith('image/')) {
                    document.getElementById("coupon-img-show").style.display = "block";
                    const reader = new FileReader();

                    // Read the selected file as a data URL
                    reader.readAsDataURL(file);

                    // Set the source of the img tag to the data URL
                    reader.onload = function(e) {
                        editImgTag.src = e.target.result;
                    }
                } else {
                    // Execute code for handling non-image files
                    Swal.fire({
                        html: "Wrong file type. Please select an image!",
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    });

                    editImageInput.value = ''; // Clear the selected file
                }
            }
        });


        function restrictInputToNumbers(inputElement) {
            inputElement.value = inputElement.value.replace(/[^0-9.]/g, ''); // Allow digits and decimal point
            inputElement.value = inputElement.value.replace(/^\./, ''); // Remove leading decimal point
            inputElement.value = inputElement.value.replace(/\.(?=.*\.)/g, ''); // Allow only one decimal point
            inputElement.value = inputElement.value.replace(/(\.\d{2}).*/g, '$1'); // Allow no more than two decimal places
            inputElement.value = inputElement.value.replace(/^0+(\d+)/, '$1'); // Remove leading zeros
        }


        function showEditCouponModal(coupon_id, img_url, coupon_name, coupon_description, price, code, category) {
            document.getElementById("coupon-img-show").src = "./images/products/" + img_url;
            document.getElementById("edit-coupon-name").value = coupon_name;
            document.getElementById("edit-description").value = coupon_description;
            document.getElementById("edit-price").value = price;
            document.getElementById("edit-coupon-code").value = code;
            document.getElementById(category === 0 ? "NEW" : (category === 1 ? "HOT" : "NORMAL")).checked = true;
            document.getElementById("update-button").setAttribute("onclick", "updateCoupon("+coupon_id+")");
            $("#editCoupon").modal("show");
        }

        function updateCoupon(coupon_id) {
            document.getElementById("update-button").disabled = true;
            document.getElementById("update-loading").style.display = "block";

            let coupon_name = document.getElementById("edit-coupon-name").value;
            let description = document.getElementById("edit-description").value;
            let price = document.getElementById("edit-price").value;
            let code = document.getElementById("edit-coupon-code").value;

            let file = document.querySelector("#edit-image").files[0];
            let form_data = new FormData();
            if (typeof file !== 'undefined') {
                form_data.append("coupon_image", file);
            }

            let radioButtons = document.getElementsByName("categoryRadio");
            for (var i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    let selectedValue = radioButtons[i].value;
                    form_data.append("coupon_category_id", selectedValue);
                    break; // Exit the loop after finding the selected radio button
                }
            }

            form_data.append("coupon_name", coupon_name);
            form_data.append("coupon_description", description);
            form_data.append("coupon_price", price);
            form_data.append("coupon_code", code);
            form_data.append("coupon_id", coupon_id);
            form_data.append("admin_id", <?php echo $admin_id ?>);

            $.ajax({
                url: "admin/coupon-edit-operations.php",
                type: "POST",
                data: form_data,
                contentType: false,
                processData:false,
                dataType: "json",
                success: function(data) {
                    document.getElementById("update-button").disabled = false;
                    document.getElementById("update-loading").style.display = "none";
                    console.log(data);
                    if (data.error == 0) {
                        Swal.fire({
                            html: data.error_msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ffcf40'
                        }).then(function() {
                            window.location.reload();
                        });

                    } else if (data.error == 1) {
                        document.getElementById("edit-image-error").innerHTML = data.error_file_msg;
                        document.getElementById("edit-coupon-name-error").innerHTML = data.coupon_name_error;
                        document.getElementById("edit-description-error").innerHTML = data.coupon_description_error;
                        document.getElementById("edit-price-error").innerHTML = data.coupon_price_error;
                        document.getElementById("edit-coupon-code-error").innerHTML = data.coupon_code_error;
                        document.getElementById("edit-category-error").innerHTML = data.category_error;
                        Swal.fire({
                            html: data.error_msg,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ffcf40'
                        });
                    } else {
                        Swal.fire({
                            html: data.error_msg,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ffcf40'
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                    document.getElementById("update-button").disabled = false;
                    document.getElementById("update-loading").style.display = "none";
                    Swal.fire({
                        html: 'Oops, something went wrong, please try again later',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'

                    }).then(function() {
                        location.reload();
                    });
                }
            });
        }

        function closeModal() {
            document.getElementById("add-image-error").value = "";
            document.getElementById("add-coupon-name-error").value = "";
            document.getElementById("add-description-error").innerHTML = "";
            document.getElementById("add-price-error").innerHTML = "";
            document.getElementById("add-coupon-code-error").innerHTML = "";
            $("#editCoupon").modal("hide");
        }

        // Function to handle the click event outside of the modal
        function handleClickOutside(event) {
            // Get the modal element
            let modalEdit = document.getElementById("editCoupon");
            let modalAdd = document.getElementById("addCoupon");

            if (event.target === modalEdit) {
                // User clicked outside the modal
                document.getElementById("add-image-error").value = "";
                document.getElementById("add-coupon-name-error").value = "";
                document.getElementById("add-description-error").innerHTML = "";
                document.getElementById("add-price-error").innerHTML = "";
                document.getElementById("add-coupon-code-error").innerHTML = "";

            } else if (event.target === modalAdd) {
                // User clicked outside the modal
                document.getElementById("add-image-error").value = "";
                document.getElementById("add-coupon-name-error").value = "";
                document.getElementById("add-description-error").innerHTML = "";
                document.getElementById("add-price-error").innerHTML = "";
                document.getElementById("add-coupon-code-error").innerHTML = "";
            }
        }

        // Event listener to detect clicks outside the modal
        document.addEventListener("click", handleClickOutside);

        function showAddModal() {
            $("#addCoupon").modal("show");
        }

        function addCoupon() {
            document.getElementById("add-button").disabled = true;
            document.getElementById("add-loading").style.display = "block";

            let coupon_name = document.getElementById("add-coupon-name").value;
            let coupon_description = document.getElementById("add-description").value;
            let coupon_price = document.getElementById("add-price").value;
            let coupon_code = document.getElementById("add-coupon-code").value;
            
            var file = document.querySelector("#add-image").files[0];
            var form_data = new FormData();
            if (typeof file !== 'undefined') {
                form_data.append("coupon_image", file);
            }
            form_data.append("coupon_name", coupon_name);
            form_data.append("coupon_description", coupon_description);
            form_data.append("coupon_price", coupon_price);
            form_data.append("coupon_code", coupon_code);
            form_data.append("admin_id", `<?php echo $admin_id ?>`);

            Swal.fire({
                title: "Confirmation",
                html: "Are you sure you want to proceed?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#ffcf40',
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "admin/coupon-add-operations.php",
                        type: "POST",
                        data: form_data,
                        contentType: false,
                        processData:false,
                        dataType: "json",
                        success: function(data) {
                            document.getElementById("add-button").disabled = false;
                            document.getElementById("add-loading").style.display = "none";
                            //console.log(data);
                            if (data.error == 0) {
                                Swal.fire({
                                    html: data.error_msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffcf40'
                                }).then(function() {
                                    window.location.reload();
                                });

                            } else if (data.error == 1) {
                                document.getElementById("add-coupon-name-error").innerHTML = data.coupon_name_error;
                                document.getElementById("add-image-error").innerHTML = data.error_file_msg;
                                document.getElementById("add-description-error").innerHTML = data.coupon_description_error;
                                document.getElementById("add-price-error").innerHTML = data.coupon_price_error;
                                document.getElementById("add-coupon-code-error").innerHTML = data.coupon_code_error;
                                Swal.fire({
                                    html: data.error_msg,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffcf40'
                                });
                            } else {
                                Swal.fire({
                                    html: data.error_msg,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffcf40'
                                });
                            }
                        },
                        error: function(data) {
                            console.log(data);
                            document.getElementById("add-button").disabled = false;
                            document.getElementById("add-loading").style.display = "none";
                            Swal.fire({
                                html: 'Oops, something went wrong, please try again later',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#ffcf40'

                            }).then(function() {
                                location.reload();
                            });
                        }
                    });
                } else {
                    document.getElementById("add-button").disabled = false;
                    document.getElementById("add-loading").style.display = "none";
                }
            });
        }

        function closeAddModal() {
            document.getElementById("add-image-error").value = "";
            document.getElementById("add-coupon-name-error").value = "";
            document.getElementById("add-description-error").innerHTML = "";
            document.getElementById("add-price-error").innerHTML = "";
            document.getElementById("add-coupon-code-error").innerHTML = "";
            $("#addCoupon").modal("hide");
        }

        function deactivateCoupon(coupon_id) {
            Swal.fire({
                title: "Confirmation",
                html: "Are you sure you want to proceed?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "OK",
                confirmButtonColor: '#ffcf40',
                cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Code to run when the "OK" button is clicked
                        $.ajax({
                            url: "admin/deactivate-coupon.php",
                            method: "POST",
                            data: {
                                admin_id: `<?php echo $admin_id ?>`,
                                product_id: coupon_id
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if (data.error == 0) {
                                    Swal.fire({
                                        html: data.error_msg,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#ffcf40'
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        html: data.error_msg,
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#ffcf40'
                                    });
                                }
                            },
                            error: function(data) {
                                console.log(data);
                                Swal.fire({
                                    html: 'Oops, something went wrong, please try again later',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffcf40'

                                }).then(function() {
                                    location.reload();
                                });
                            }
                        });
                    }
            });
        }

        function activateCoupon(product_id) {
            Swal.fire({
                title: "Confirmation",
                html: "Are you sure you want to proceed?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "OK",
                confirmButtonColor: '#ffcf40',
                cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Code to run when the "OK" button is clicked
                        $.ajax({
                            url: "admin/activate-coupon.php",
                            method: "POST",
                            data: {
                                admin_id: `<?php echo $admin_id ?>`,
                                product_id: product_id
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if (data.error == 0) {
                                    Swal.fire({
                                        html: data.error_msg,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#ffcf40'
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        html: data.error_msg,
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#ffcf40'
                                    });
                                }
                            },
                            error: function(data) {
                                console.log(data);
                                Swal.fire({
                                    html: 'Oops, something went wrong, please try again later',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffcf40'

                                }).then(function() {
                                    location.reload();
                                });
                            }
                        });
                    }
            });
        }
        
        // function deleteCoupon(coupon_id) {
        //     Swal.fire({
        //         title: "Confirmation",
        //         html: "Are you sure you want to proceed?",
        //         icon: "question",
        //         showCancelButton: true,
        //         confirmButtonText: "OK",
        //         confirmButtonColor: '#ffcf40',
        //         cancelButtonText: "Cancel",
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 // Code to run when the "OK" button is clicked
        //                 $.ajax({
        //                     url: "admin/delete-coupon.php",
        //                     method: "POST",
        //                     data: {
        //                         admin_id: `<?php echo $admin_id ?>`,
        //                         coupon_id: coupon_id
        //                     },
        //                     dataType: "json",
        //                     success: function(data) {
        //                         console.log(data);
        //                         if (data.error == 0) {
        //                             Swal.fire({
        //                                 html: data.error_msg,
        //                                 icon: 'success',
        //                                 confirmButtonText: 'OK',
        //                                 confirmButtonColor: '#ffcf40'
        //                             }).then(function() {
        //                                 window.location.reload();
        //                             });
        //                         } else {
        //                             Swal.fire({
        //                                 html: data.error_msg,
        //                                 icon: 'error',
        //                                 confirmButtonText: 'OK',
        //                                 confirmButtonColor: '#ffcf40'
        //                             });
        //                         }
        //                     },
        //                     error: function(data) {
        //                         console.log(data);
        //                         Swal.fire({
        //                             html: 'Oops, something went wrong, please try again later',
        //                             icon: 'error',
        //                             confirmButtonText: 'OK',
        //                             confirmButtonColor: '#ffcf40'

        //                         }).then(function() {
        //                             location.reload();
        //                         });
        //                     }
        //                 });
        //             }
        //     });
        // }
    </script>
</body>

</html>