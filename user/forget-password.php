<?php
session_start();
include_once("head-main-no-login.php");
include_once("../config.php");
?>

<body class="nk-body bg-white npc-general pg-auth dark-mode">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white w-lg-45">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <!-- <a href="#" class="toggle btn btn-white btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a> -->
                            </div>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="html/index.html" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo">
                                        <img class="logo-dark logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Forgot password?</h5>
                                        <div class="nk-block-des">
                                            <p>If you forgot your password, well, then we’ll email you instructions to reset your password.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <form action="html/pages/auths/auth-success.html">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="email" placeholder="Enter your email address">
                                            <span id="email_error" class="invalid" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button onclick="sendLink();" class="btn btn-lg btn-primary btn-block" id="reset_button"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="reset_loading" style="display:none;"></span><span>Send Reset Link</span></button>
                                    </div>
                                </form><!-- form -->
                                <div class="form-note-s2 pt-5">
                                    <a href="login.php"><strong>Return to login</strong></a>
                                </div>
                            </div><!-- .nk-block -->
                            <div class="nk-block nk-auth-footer">
                                <div class="nk-block-between">
                                    <ul class="nav nav-sm">
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="#">Terms & Condition</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Privacy Policy</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Help</a>
                                        </li> -->
                                        <!-- <li class="nav-item dropup">
                                            <a class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-bs-toggle="dropdown" data-offset="0,10"><small>English</small></a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                <ul class="language-list">
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="./images/flags/english.png" alt="" class="language-flag">
                                                            <span class="language-name">English</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="./images/flags/spanish.png" alt="" class="language-flag">
                                                            <span class="language-name">Español</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="./images/flags/french.png" alt="" class="language-flag">
                                                            <span class="language-name">Français</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="./images/flags/turkey.png" alt="" class="language-flag">
                                                            <span class="language-name">Türkçe</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>.dropup -->
                                    </ul><!-- .nav -->
                                </div>
                                <div class="mt-3">
                                    <p>&copy; 2023 HealthyVerse. All Rights Reserved.</p>
                                </div>
                            </div><!-- .nk-block -->
                        </div><!-- .nk-split-content -->
                        <!-- <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="w-100 w-max-550px p-3 p-sm-5 m-auto">
                                <div class="nk-feature nk-feature-center">
                                    <div class="nk-feature-img">
                                        <img class="round" src="./images/slides/promo-a.png" srcset="./images/slides/promo-a2x.png 2x" alt="">
                                    </div>
                                    <div class="nk-feature-content py-4 p-sm-5">
                                        <h4>Dashlite</h4>
                                        <p>You can start to create your products easily with its user-friendly design & most completed responsive layout.</p>
                                    </div>
                                </div>
                            </div>
                        </div>.nk-split-content -->
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
    <script src="../assets/js/bundle.js?ver=3.1.1"></script>
    <script src="../assets/js/scripts.js?ver=3.1.1"></script>
   

    <script>
        function sendLink() {
            let email = document.getElementById("email").value;

            document.getElementById("reset_button").disabled = true;
            document.getElementById("reset_loading").style.display = "block";

            console.log("here");

            $.ajax({
                url: "../user/forget-password-operations.php",
                method: "POST",
                data: {
                    email: email,
                },
                dataType: "json",
                success: function(data){
                    document.getElementById("reset_button").disabled = false;
                    document.getElementById("reset_loading").style.display = "none";
            
                    if(data.error == 0){
                        Swal.fire({
                            text: data.error_msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ffcf40'
                        }).then(function(){
                            window.location = 'login.php';
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

                    console.log(data);
                    
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

</html>