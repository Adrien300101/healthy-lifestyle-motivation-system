<?php
	include_once("../config.php");
	include_once("head-main-no-login.php");
?>
<body class="nk-body bg-white npc-general pg-auth dark-mode">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="../images/healthyvere-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Reset Password</h4>
                                    </div>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label class="form-label" for="password">New Password</label>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" placeholder="Enter your new password">
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="form-label" for="confirm_password">Confirm New Password</label>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="confirm_password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="confirm_password" placeholder="Confirm your new password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button id="reset_button" type="button" class="btn btn-lg btn-primary btn-block" onclick='resetPassword();'><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="reset_loading" style="display:none;"></span><span>Reset Password</span></button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4"> Decided otherwise? <a href="user/login.php"><strong>Sign in instead</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6 order-lg-last">
                                    <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                        <li class="nav-item">
                                            <a class="nav-link">Terms & Condition</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link">Privacy Policy</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" >Help</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">&copy; <?php echo date("Y"); ?> HealthyVerse. All Rights Reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="../assets/js/bundle.js?ver=2.4.0"></script>
    <script src="../assets/js/scripts.js?ver=2.4.0"></script>
	<?php
	if(isset($_GET['email']) && isset($_GET['hash_key'])){
		$email 	  = $_GET['email'];
		$hash_key = $_GET['hash_key'];
		$check_request = DB::queryFirstField("SELECT u.user_id FROM email_logs el 
												INNER JOIN user_reset_password_requests pr ON pr.email_log_id = el.email_log_id 
												INNER JOIN users u ON u.user_id = el.user_id 
												WHERE u.email = %s AND pr.hash_key = %s AND pr.status = %i", $email, $hash_key, 0);
												
		if($check_request == NULL){
			echo "
			<script>
				Swal.fire({
					text: 'Invalid reset password request. Please contact our adminstrator for any enquiries.',
					icon: 'error',
					confirmButtonText: 'OK',
					confirmButtonColor: '#ffcf40'
					
				}).then(function(){										 
                    var customUrlScheme = 'hlms://healthy-lifestyle-motivation-system';
                    window.location = customUrlScheme;
				});	
			</script>";
		}else{
		?>
			<script>
			function resetPassword(){
				document.getElementById("reset_button").disabled = true;
				document.getElementById("reset_loading").style.display = "block";
				
				let password 		 = document.getElementById("password").value;
				let confirm_password = document.getElementById("confirm_password").value;
				
				
				$.ajax({
					url: "reset-password-operations.php",
					method: "POST",
					data: {
						email: "<?php echo $email; ?>",
						hash_key: "<?php echo $hash_key; ?>",
						password: password,
						confirm_password: confirm_password,
					},
					dataType: "json",
					success: function(data){
						document.getElementById("reset_button").disabled = false;
						document.getElementById("reset_loading").style.display = "none";
				
						if(data.error == 0){
							Swal.fire({
								html: data.error_msg,
								icon: 'success',
								confirmButtonText: 'OK',
								confirmButtonColor: '#ffcf40'
							}).then(function(){
								var customUrlScheme = "hlms://healthy-lifestyle-motivation-system";
            				    window.location = customUrlScheme;
							});
							
						}else{					
							Swal.fire({
								html: data.error_msg,
								icon: 'error',
								confirmButtonText: 'OK',
								confirmButtonColor: '#ffcf40'
							});
						}
					}, error: function(data){
						document.getElementById("reset_button").disabled = false;
						document.getElementById("reset_loading").style.display = "none";
						
						Swal.fire({
							text: 'Oops, something went wrong, please try again later',
							icon: 'error',
							confirmButtonText: 'OK',
							confirmButtonColor: '#ffcf40'
							
						}).then(function(){										 
                            var customUrlScheme = "hlms://healthy-lifestyle-motivation-system";
            				window.location = customUrlScheme;
						});	
					}
				});
			}
			</script>
		<?php
		}
	}else{
		echo "
			<script>
				Swal.fire({
					text: 'Invalid reset password request. Please contact our adminstrator for any enquiries.',
					icon: 'error',
					confirmButtonText: 'OK',
					confirmButtonColor: '#ffcf40'
					
				}).then(function(){										 
                    var customUrlScheme = 'hlms://healthy-lifestyle-motivation-system';
                    window.location = customUrlScheme;
				});	
			</script>";
	}
	?>
</html>