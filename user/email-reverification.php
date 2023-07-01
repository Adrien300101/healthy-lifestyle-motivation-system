
<?php
	if(isset($_GET['email'])){
		include_once("../config.php");
		
		$email = $_GET['email'];
		$details = DB::queryFirstRow("SELECT u.user_id, u.user_status, el.date_sent FROM users u INNER JOIN email_logs el ON el.user_id = u.user_id WHERE u.email = %s AND el.type = %i ORDER BY date_sent DESC", $email, 0);
		if($details != NULL){
			$user_id   = $details['user_id'];
			$status    = $details['user_status'];
			$date_sent = date_create($details['date_sent']);
			$date_now  = date_create(date("Y-m-d H:i:s"));
			
			$diff=date_diff($date_sent,$date_now);
			if($status == 1){
				$title = "Email : [".$email."] has already been verified. ";
				$text  = "This email has already been verified previously. Please proceed to Sign In with the email.";
				
				$signin_display = "";
				$resend_display = "style='display:none;'";
			}elseif($diff->d >= 1){
				$title = "Email : [".$email."] verification has already expired. ";
				$text  = "This email verification has already past 24 hours, thus expired. Please request for another email verification request.";
				
				$signin_display = "style='display:none;'";
				$resend_display = "";
			}else{
				DB::update("users", ['user_status' => 1], "user_id = %i", $user_id);
				
				$title = "Email : [".$email."] Successfully Verified! ";
				$text  = "Thank you for verifying your email address. You can now proceed to Sign In with your account.";
				
				$signin_display = "";
				$resend_display = "style='display:none;'";
			}
		}else{
			$title = "Technical Error [User Details Error]";
			$text  = "User details not found, please contact an adminstrator for any enquiries.";
			
			$signin_display = "";
			$resend_display = "style='display:none;'";
		}
	}else{
		$title = "Oops, did you came to the wrong page?";
		$text  = "";
		
		$signin_display = "";
		$resend_display = "style='display:none;'";
	}
	
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
                    <div class="nk-block nk-block-middle nk-auth-body">
                        <div class="brand-logo pb-5">
                            <a href="html/index.html" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h4 class="nk-block-title"><?php echo $title; ?></h4>
                                <div class="nk-block-des text-success">
                                    <p><?php echo $text; ?></p>
									<button <?php echo $resend_display; ?> id="resend_button" type="button" class="btn btn-lg btn-primary btn-block" onclick="resend()"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="resend_loading" style="display:none;"></span><span>Resend Email Verification</span></button>
									<button onclick='go_to_app();' <?php echo $signin_display; ?> id="resend_button" type="button" class="btn btn-lg btn-primary btn-block"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="resend_loading" style="display:none;"></span><span>Sign In</span></button>
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
                                            <a class="nav-link">Help</a>
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
    <script src="../assets/js/bundle.js?ver=3.1.1"></script>
    <script src="../assets/js/scripts.js?ver=3.1.1"></script>
	<?php 
		if(isset($_GET['email'])){
	?>

	<script>

		function resend(){
			document.getElementById("resend_button").disabled = true;
			document.getElementById("resend_loading").style.display = "block";
		
			const email = "<?php echo $_GET['email']; ?>";
			$.ajax({
				url: "../user/email/resend-email-reverification.php",
				method: "POST",
				data: {
					email: email
				},
				dataType: "json",
				success: function(data){
					document.getElementById("resend_button").disabled = false;
					document.getElementById("resend_loading").style.display = "none";
			
					if(data.error == 0){
						Swal.fire({
							html: data.error_msg,
							icon: 'success',
							confirmButtonText: 'OK',
							confirmButtonColor: '#ffcf40'
						})
					}else{					
						Swal.fire({
							html: data.error_msg,
							icon: 'error',
							confirmButtonText: 'OK',
							confirmButtonColor: '#ffcf40'
						})
					}
				}, error: function(data){
					document.getElementById("resend_button").disabled = false;
					document.getElementById("resend_loading").style.display = "none";
					console.log(data);
					Swal.fire({
						text: 'Unable to resend verification email. Please try again later',
						icon: 'error',
						confirmButtonText: 'OK',
						confirmButtonColor: '#ffcf40'
					})
				}
			});
		}

		function go_to_app() {
			var customUrlScheme = "hlms://healthy-lifestyle-motivation-system";
            window.location = customUrlScheme;
		}


	</script>

	<?php
		}
	?>
</html>