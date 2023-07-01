<?php
	include_once("header-main.php");
?>

<!-- main @s -->
        <div class="nk-main ">
            <?php include_once("nk-sidebar.php"); ?>
            <!-- wrap @s -->
            <?php include_once("nk-header.php"); ?>
                <!-- content @s -->
                <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="nk-block">
                                <div class="card card-bordered border-primary">
                                    <div class="card-aside-wrap">
                                      <div class="card-inner card-inner-lg">
                                            <div class="nk-block-head nk-block-head-lg">
                                                <div class="nk-block-between">
                                                    <div class="nk-block-head-content">
                                                        <h4 class="nk-block-title">Personal Information</h4>
                                                        <div class="nk-block-des">
                                                            <p></p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                                        <a href="#" class="toggle btn btn-dim btn-outline-light btn-icon" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                            <div class="nk-block">
                                                <div class="nk-data data-list">
                                                    <div class="data-head">
                                                        <h6 class="overline-title">BASICS</h6>
                                                    </div>
                                                    <div class="data-item" data-toggle="modal" onclick="showUpdateModal();">
                                                        <div class="data-col">
                                                            <span class="data-label">Full Name</span>
                                                            <span class="data-value"><?php echo $name; ?></span>
                                                        </div>
                                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                                    </div><!-- data-item -->
                                                    <div class="data-item">
                                                        <div class="data-col">
                                                            <span class="data-label">Email</span>
                                                            <span class="data-value"><?php echo $email; ?></span>
                                                        </div>
                                                        <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                                    </div><!-- data-item -->
                                                </div><!-- data-list -->
                                                
                                            </div><!-- .nk-block -->
                                        </div>
										<?php
											include_once("edit-account-sidebar.php");
										?>
                                    </div><!-- card-aside-wrap -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
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
    

    <div class="modal fade" tabindex="-1" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" onclick="closeUpdateModal();"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Update Profile</h5>
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="fname">First Name</label>
                                <input type="text" class="form-control form-control-md" id="fname" value="<?php echo $first_name; ?>" placeholder="Enter your first name">
                                <span id="name_error" class="invalid"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="lname">Last Name</label>
                                <input type="text" class="form-control form-control-md" id="lname" value="<?php echo $last_name; ?>" placeholder="Enter your last name">
                                <span id="name_error" class="invalid"></span>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <a id="update_button" onclick="updateProfile()" class="btn btn-lg btn-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="update_loading" style="display:none;"></span><span style="color:#fff">Update Profile</span></a>
                                </li>
                                <li>
                                    <a href="#" onclick="closeUpdateModal();" class="link link-light">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
    <!-- JavaScript -->
<?php include_once("footer-main.php") ?>
<script>
    function showUpdateModal() {
        $("#profile-edit").modal("show");
    }

    function closeUpdateModal() {
        $("#profile-edit").modal("hide");
    }

    function updateProfile() {
        document.getElementById("update_button").disabled = true;
        document.getElementById("update_loading").style.display = "block";

        let fname = document.getElementById("fname").value;
        let lname = document.getElementById("lname").value;

        $.ajax({
            url: "edit-personal-info-operations.php",
            method: "POST",
            data: {
                fname: fname,
                lname: lname,
                user_id: <?php echo json_encode($user_id); ?>
            },
            dataType: "json",
            success: function(data){
                console.log(data);
                document.getElementById("update_button").disabled = false;
                document.getElementById("update_loading").style.display = "none";
                if(data.error == 0){
                    Swal.fire({
                        html: data.error_msg,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    }).then(function(){
                        location.reload();
                    });
                } else {					
                    Swal.fire({
                        html: data.error_msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    });
                }
            }, error: function(data){
                console.log(data);
                document.getElementById("update_button").disabled = false;
                document.getElementById("update_loading").style.display = "none";
                
                Swal.fire({
                    text: 'Oops, something went wrong, please try again later',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffcf40'
                    
                }).then(function(){										 
                    location.reload();
                });	
            }
        });
    }

</script>