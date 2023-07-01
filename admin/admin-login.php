<?php
include_once("../config.php");
session_start();
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $admin_details = DB::queryFirstRow("SELECT admin_first_name, admin_last_name, admin_email FROM admin WHERE admin_session_id = %s", $session_id);
    if ($admin_details != NULL) {
        echo '<script>window.location.href="user-management.php"</script>';
    } else {
        session_destroy();
    }
} else {
    session_destroy();
}

include_once("header-main-no-login.php");
?>

<body class="nk-body bg-white npc-general pg-auth dark-mode">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="admin/user-management.php" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="./images/healthyverse-logo.png" srcset="./images/healthyverse-logo.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="./images/healthyverse-logo.png" srcset="./images/healthyverse-logo.png 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Admin Sign In</h4>
                                        <div class="nk-block-des">
                                        </div>
                                    </div>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Email</label>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" id="email" placeholder="Sign In">
                                        <span id="email_error" class="invalid"></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" placeholder="Enter Password">
                                            <span id="password_error" class="invalid"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button id="signin_button" type="button" class="btn btn-lg btn-primary btn-block" onclick="sign_in()"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="signin_loading" style="display:none;"></span><span>Sign In</span></button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    include_once("footer-no-login.php");
                    ?>
                </div>
                <!-- content @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script>
        function sign_in() {
            document.getElementById("signin_button").disabled = true;
            document.getElementById("signin_loading").style.display = "block";

            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;

            document.getElementById("email_error").innerHTML = "";
            document.getElementById("password_error").innerHTML = "";

            $.ajax({
                url: "admin/signin-operations.php",
                method: "POST",
                data: {
                    email: email,
                    password: password
                },
                dataType: "json",
                success: function(data) {
                    document.getElementById("signin_button").disabled = false;
                    document.getElementById("signin_loading").style.display = "none";
                    if (data.error == 0) {
                        Swal.fire({
                            html: data.error_msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ffcf40'
                        }).then(function() {
                            window.location = data.redirect_url;
                        });

                    } else {
                        if (data.email_error && data.password_error) {
                            document.getElementById("email_error").innerHTML = data.email_error;
                            document.getElementById("password_error").innerHTML = data.password_error;
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
                    document.getElementById("signin_button").disabled = false;
                    document.getElementById("signin_loading").style.display = "none";
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
    </script>

    </html>