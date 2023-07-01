<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
	<div class="card-inner-group">
		<div class="card-inner">
			<div class="user-card">
				<div class="user-avatar md">
					<em class="icon ni ni-user-alt"></em>
				</div>
				<div class="user-info">
					<span class="lead-text"><?php echo $name; ?></span>
					<span class="sub-text"><?php echo $email; ?></span>
				</div>
			</div><!-- .user-card -->
		</div><!-- .card-inner -->
		<div class="card-inner">
			<div class="user-account-info py-0">
				<h6 class="overline-title-alt">HealthyVerse STC Wallet</h6>
                <ul id="spinner_stc_profile_balance" class="preview-list g-1">
                    <li class="preview-item" style="width: 100%;">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </li>
                </ul>
				<div class="user-balance" id="stc_balance" style="display:none;"> <small class="currency currency-btc">STC</small></div>
			</div>
		</div><!-- .card-inner -->
		<div class="card-inner p-0">
			<ul class="link-list-menu">
			<?php
				$account_sidebar_self = $_SERVER['PHP_SELF'];
				if($account_sidebar_self == "/hlms/healthy-lifestyle-motivation-system/user/edit-personal-info.php"){
					$class_pInfo = "class='active'";
					$class_sSettings = "";
				}elseif($account_sidebar_self == "/hlms/healthy-lifestyle-motivation-system/user/edit-security-settings.php"){
					$class_pInfo = "";
					$class_sSettings = "class='active'";
				}else{
					$class_pInfo = "";
					$class_sSettings = "";
				}
			?>
				<li><a <?php echo $class_pInfo; ?> href="edit-personal-info.php"><em class="icon ni ni-user-fill-c"></em><span>Personal Information</span></a></li>
				<li><a <?php echo $class_sSettings; ?> href="edit-security-settings.php"><em class="icon ni ni-lock-alt-fill"></em><span>Security Settings</span></a></li>
			</ul>
		</div><!-- .card-inner -->
	</div><!-- .card-inner-group -->
</div><!-- card-aside -->
