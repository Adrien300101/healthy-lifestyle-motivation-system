<?php 
include_once("../config.php");
session_start();
if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    $user_details = DB::queryFirstRow("SELECT first_name, email FROM users WHERE session_id = %s AND user_status = %i", $session_id, 1);
    if ($user_details != NULL) {
        echo '<script>window.location.href="./index.php"</script>';
    }
} else {
    session_destroy();
}
include_once("head-login.php");
?>

<body class="dark-mode nk-body bg-light ui-clean npc-default pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                            </div>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="#" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo">
                                        <img class="logo-dark logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="card card-bordered border-primary">
                                    <div class="card-inner">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h5 class="nk-block-title">Sign-In</h5>
                                                <div class="nk-block-des">
                                                    <p>Access your HealthyVerse Account using your email and password.</p>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head -->
                                        
                                        <form action="#" class="form-validate is-alter" autocomplete="off">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="email-address">Email</label>
                                                    
                                                </div>
                                                <div class="form-control-wrap">
                                                    <input autocomplete="off" type="text" class="form-control form-control-lg" required id="email" placeholder="Enter your email address">
                                                    <span id="email_error" class="invalid" style="display: none;"></span>
                                                </div>
                                            </div><!-- .form-group -->
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="password">Password</label>
                                                    <a class="link link-primary link-sm" tabindex="-1" href="forget-password.php">Forgot Password?</a>
                                                </div>
                                                <div class="form-control-wrap">
                                                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input autocomplete="new-password" type="password" class="form-control form-control-lg" required id="password" placeholder="Enter your password">
                                                    <span id="password_error" class="invalid" style="display: none;"></span>
                                                </div>
                                            </div><!-- .form-group -->
                                            <div class="form-group">
                                                <button onclick="sign_in()" class="btn btn-lg btn-primary btn-block" id="signin_button"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="signin_loading" style="display:none;"></span><span>Sign in</span></button>
                                            </div>
                                        </form><!-- form -->
                                        
                                        <div class="form-note-s2 pt-4"> New on our platform? <a href="../user/registration.php">Create an account</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .nk-block -->
                            <?php 
                            include_once("footer-login.php");
                            ?>
                        </div><!-- .nk-split-content -->
                        <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                                <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="../images/slides/dashboard.png" srcset="../images/slides/dashboard.png 2x" alt="">
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>HealthyVerse Dashboard</h4>
                                                <p>Login to be redirected to your personalised dashboard.</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="../images/slides/leaderboard.png" srcset="../images/slides/leaderboard.png 2x" alt="">
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>HealthyVerse Leaderboard</h4>
                                                <p>Start exercise today and measure your skills against others.</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                    <div class="slider-item">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="../images/slides/wallet.png" srcset="../images/slides/wallet.png 2x" alt="">
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>HealthyVerse Wallet</h4>
                                                <p>Check your wallet out and your transactions. Transfer and receive Student Coins today.</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                </div><!-- .slider-init -->
                                <div class="slider-dots"></div>
                                <div class="slider-arrows"></div>
                            </div><!-- .slider-wrap -->
                        </div><!-- .nk-split-content -->
                    </div><!-- .nk-split -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <?php 
        if(isset($_GET['email'])){
            $email = $_GET['email'];
            $check_request = DB::queryFirstRow("SELECT user_id FROM users where email = %s AND user_status = %i", $email, 0);
            if($check_request == NULL){
                echo"
                <script>
                    Swal.fire({
                        html: 'Invalid Email Verification Request. Please Contact Our Administrator For Any Enquiries',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#0C0C87'
                        
                    }).then(function(){										 
                         window.location.href = 'login.php';
                    });	
                </script>";
                
            }else{
                $email_verify = DB::update('users',['user_status'=> '1'],"email = %s AND user_status = %i",$email, 0);
                echo"
                <script>
                    Swal.fire({
                        html: 'Email Verify Successfully! You Can Login To Your Account Now',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#0C0C87'
                        
                    }).then(function(){										 
                         window.location.href = 'login.php';
                    });	
                </script>";
            }
        }
    ?>

    <script>
        function sign_in() {
            document.getElementById("signin_button").disabled = true;
            document.getElementById("email").disabled = true;
            document.getElementById("password").disabled = true;
            document.getElementById("signin_loading").style.display = "block";

            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;

            document.getElementById("email_error").innerHTML = "";
            document.getElementById("password_error").innerHTML = "";

            $.ajax({
                url: "../user/login-operation.php",
                method: "POST",
                data: {
                    email: email,
                    password: password
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    document.getElementById("signin_button").disabled = false;
                    document.getElementById("email").disabled = false;
                    document.getElementById("password").disabled = false;
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
                        if (data.email_error) {
                            document.getElementById("email_error").innerHTML = data.email_error;
                            document.getElementById("email_error").style.display = "block";
                        } else {
                            document.getElementById("email_error").style.display = "none";
                        }
                        
                        if (data.password_error) {
                            document.getElementById("password_error").innerHTML = data.password_error;
                            document.getElementById("password_error").style.display = "block";
                        } else {
                            document.getElementById("password_error").style.display = "none";
                        }
                        
                        if (!data.email_error && !data.password_error) {
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
                    document.getElementById("signin_button").disabled = false;
                    document.getElementById("email").disabled = false;
                    document.getElementById("password").disabled = false;
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

    <script src="../assets/js/bundle.js?ver=3.1.1"></script>
    <script src="../assets/js/scripts.js?ver=3.1.1"></script>
    <!-- select region modal -->
    

</html>