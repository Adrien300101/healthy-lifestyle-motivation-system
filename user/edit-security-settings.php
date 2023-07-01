<?php
include_once("header-main.php");
?>
		<!-- main @s -->
		<div class="nk-main ">
			<?php
			include_once("nk-sidebar.php");
			?>
			<!-- wrap @s -->
				<?php
				include_once("nk-header.php");
				?>
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
														<h4 class="nk-block-title">Security Settings</h4>
														<div class="nk-block-des">
															<p>These settings helps you keep your account secure.</p>
														</div>
													</div>
													<div class="nk-block-head-content align-self-start d-lg-none">
														<a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
													</div>
												</div>
											</div><!-- .nk-block-head -->
											<div class="nk-block">
												<div class="card card-bordered border-primary">
													<div class="card-inner">
														<div class="between-center flex-wrap g-3">
															<div class="nk-block-text">
																<h6>Change Password</h6>
																<p>Change your password from time to time to protect your account.</p>
															</div>
															<div class="nk-block-actions flex-shrink-sm-0">
																<ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
																	<li class="order-md-last">
																		<a href="#" onclick="showPasswordModal();" class="btn btn-primary">Change Password</a>
																	</li>
																</ul>
															</div>
														</div>
													</div><!-- .card-inner -->
													<div class="card-inner">
														<div class="nk-block-text">
															<h6>Login Activity</h6>
															<p>Here are your last 10 login activities log.</p>
														</div>
														<table class="table table-ulogs">
															<thead class="thead-light">
																<tr>
																	<th class="text-center"><span class="overline-title">IP</span></th>
																	<th class="text-center"><span class="overline-title">TIME</span></th>
																</tr>
															</thead>
															<tbody>
																<?php
																$activity_logs = DB::query("SELECT s.ip_address, s.signin_date FROM user_signin_sessions s INNER JOIN users u ON u.user_id = s.user_id WHERE u.session_id = %s ORDER BY s.signin_date DESC LIMIT 10", $session_id);
																if ($activity_logs != NULL) {
																	for ($i = 0; $i < count($activity_logs); $i++) {
																		echo '<tr>
																				<td><span class="sub-text text-center">' . $activity_logs[$i]["ip_address"] . '</span></td>
																				<td ><span class="sub-text text-center">' . date_format(date_create($activity_logs[$i]["signin_date"]), "d M Y - H:i A") . '</span></td>
																			</tr>';
																	}
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div><!-- .nk-block -->
										</div><!-- .card-inner -->
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
				<div class="modal fade" tabindex="-1" role="dialog" id="change-password">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<a href="#" class="close" onclick="closePasswordModal();"><em class="icon ni ni-cross-sm"></em></a>
							<div class="modal-body modal-body-lg">
								<h5 class="title">Change Password</h5>
								<div class="row gy-4">
									<div class="col-md-12">
										<div class="form-group">
											<label class="form-label" for="current_password">Current Password</label>
											<div class="form-control-wrap">
												<a href="#" class="form-icon form-icon-right passcode-switch" data-target="current_password">
													<em class="passcode-icon icon-show icon ni ni-eye"></em>
													<em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
												</a>
												<input type="password" class="form-control form-control-lg" id="current_password" placeholder="Enter current password">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label" for="display-name">New Password</label>
											<div class="form-control-wrap">
												<a href="#" class="form-icon form-icon-right passcode-switch" data-target="new_password">
													<em class="passcode-icon icon-show icon ni ni-eye"></em>
													<em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
												</a>
												<input type="password" class="form-control form-control-lg" id="new_password" placeholder="Enter new password">
												<span id="new_password_error" class="invalid"></span>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label" for="phone-no">Confirm Password</label>
											<div class="form-control-wrap">
												<a href="#" class="form-icon form-icon-right passcode-switch" data-target="confirm_password">
													<em class="passcode-icon icon-show icon ni ni-eye"></em>
													<em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
												</a>
												<input type="password" class="form-control form-control-lg" id="confirm_password" placeholder="Enter password again">
												<span id="confirm_password_error" class="invalid"></span>
											</div>
										</div>
									</div>
									<div class="col-12">
										<ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
											<li>
												<a id="change_button" onclick="change_password()" class="btn btn-lg btn-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="change_loading" style="display:none;"></span><span style="color:#fff">Change Password</span></a>
											</li>
											<li>
												<a href="#" onclick="closePasswordModal();" class="link link-light">Cancel</a>
											</li>
										</ul>
									</div>
								</div>
							</div><!-- .modal-body -->
						</div><!-- .modal-content -->
					</div><!-- .modal-dialog -->
				</div><!-- .modal -->
				<?php include_once("nk-footer.php"); ?>
                <!-- footer @e -->
			</div>
			<!-- wrap @e -->
		</div>
		<!-- main @e -->
	</div>
	<!-- app-root @e -->
<?php include_once("footer-main.php") ?>
<script>
	$(".modal").on("hidden.bs.modal", function() {
		document.getElementById("current_password").value = "";
		document.getElementById("new_password").value = "";
		document.getElementById("confirm_password").value = "";

		document.getElementById("new_password_error").innerHTML = "";
		document.getElementById("confirm_password_error").innerHTML = "";
	});

    function showPasswordModal() {
        $("#change-password").modal("show");
    }

    function closePasswordModal() {
        $("#change-password").modal("hide");
    }

	function change_password() {
		document.getElementById("change_button").disabled = true;
		document.getElementById("change_loading").style.display = "block";

		document.getElementById("new_password_error").innerHTML = "";
		document.getElementById("confirm_password_error").innerHTML = "";

		let current_password = document.getElementById("current_password").value;
		let new_password = document.getElementById("new_password").value;
		let confirm_password = document.getElementById("confirm_password").value;


		$.ajax({
			url: "change-password-operations.php",
			method: "POST",
			data: {
				current_password: current_password,
				new_password: new_password,
				confirm_password: confirm_password,
                user_id : <?php echo json_encode($user_id); ?>
			},
			dataType: "json",
			success: function(data) {
                console.log(data);
				document.getElementById("change_button").disabled = false;
				document.getElementById("change_loading").style.display = "none";

				if (data.error == 0) {
					Swal.fire({
						html: data.error_msg,
						icon: 'success',
						confirmButtonText: 'OK',
						confirmButtonColor: '#ffcf40'
					}).then(function() {
						window.location.href = "signout.php";
					});

				} else {
					if (data.new_password_error || data.confirm_password_error) {
						document.getElementById("new_password_error").innerHTML = data.new_password_error;
						document.getElementById("confirm_password_error").innerHTML = data.confirm_password_error;
					} else {
						var error_msg;
						if (!data.error_msg) {
							error_msg = "Oops, something went wrong, please try again later";
						} else {
							error_msg = data.error_msg;
						}
						Swal.fire({
							html: error_msg,
							icon: 'error',
							confirmButtonText: 'OK',
							confirmButtonColor: '#ffcf40'
						});
					}
				}
			},
			error: function(data) {
                console.log(data);
				document.getElementById("change_button").disabled = false;
				document.getElementById("change_loading").style.display = "none";

				Swal.fire({
					text: 'Oops, something went wrong, please try again later',
					icon: 'error',
					confirmButtonText: 'OK',
					confirmButtonColor: '#ffcf40'

				}).then(function() {
					location.reload();
				});
			}
		});
	}

	function enable_2fa() {
		document.getElementById("2fa_button").disabled = true;
		document.getElementById("2fa_loading").style.display = "block";

		document.getElementById("telegram_chat_id_error").innerHTML = "";

		let telegram_chat_id = document.getElementById("telegram_chat_id").value;

		$.ajax({
			url: "members/enable-2fa-telegram-operations.php",
			method: "POST",
			data: {
				telegram_chat_id: telegram_chat_id
			},
			dataType: "json",
			success: function(data) {
				document.getElementById("2fa_button").disabled = false;
				document.getElementById("2fa_loading").style.display = "none";

				if (data.error == 0) {
					Swal.fire({
						html: data.error_msg,
						icon: 'success',
						confirmButtonText: 'OK',
						confirmButtonColor: '#ffcf40'
					}).then(function() {
						location.reload();
					});

				} else {
					if (data.telegram_chat_id_error) {
						document.getElementById("telegram_chat_id_error").innerHTML = data.telegram_chat_id_error;
					} else {
						var error_msg;
						if (!data.error_msg) {
							error_msg = "Oops, something went wrong, please try again later";
						} else {
							error_msg = data.error_msg;
						}
						Swal.fire({
							html: error_msg,
							icon: 'error',
							confirmButtonText: 'OK',
							confirmButtonColor: '#ffcf40'
						});
					}
				}
			},
			error: function(data) {
				document.getElementById("2fa_button").disabled = false;
				document.getElementById("2fa_loading").style.display = "none";

				Swal.fire({
					text: 'Oops, something went wrong, please try again later',
					icon: 'error',
					confirmButtonText: 'OK',
					confirmButtonColor: '#ffcf40'

				}).then(function() {
					location.reload();
				});
			}
		});
	}
</script>