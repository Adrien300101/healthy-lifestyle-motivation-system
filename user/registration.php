<?php 
include_once("head-reg.php");
?>
<body class="dark-mode nk-body bg-light ui-clean npc-default pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="html/index.html" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered border-primary">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Register</h4>
                                        <div class="nk-block-des">
                                            <p>Create New Healthyverse Account</p>
                                        </div>
                                    </div>
                                </div>
                                <form >
                                    <div class="form-group">
                                        <label class="form-label" for="fname">First Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="fname" placeholder="Enter your name">
                                            <span id="fname_error" class="invalid" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="lname">Last Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="lname" placeholder="Enter your name">
                                            <span id="lname_error" class="invalid" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="email" placeholder="Enter your email address">
                                            <span id="email_error" class="invalid" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" placeholder="Enter your password">
                                            <span id="password_error" class="invalid" style="display: none;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="con_password">Confirm Password</label>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="con_password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="con_password" placeholder="Confirm your password">
                                            <span id="con_password_error" class="invalid" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-control-xs custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox" name="check" value="check">
                                            <label class="custom-control-label" for="checkbox">I agree to Healthyverse <a href="privacy-policy.php">Privacy Policy</a> &amp; <a href="terms-and-conditions.php"> Terms.</a></label>
                                            <span id="checkbox_error" class="invalid" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block" onclick="register()" id="reg_button"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="reg_loading" style="display:none;"></span><span>Register</span></button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4"> Already have an account? <a href="../user/login.php"><strong>Sign in instead</strong></a>
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
                                            <a class="nav-link text-primary" href="terms-and-conditions.php">Terms & Condition</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-primary" href="privacy-policy.php">Privacy Policy</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">&copy; 2023 HealthyVerse. All Rights Reserved.</p>
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


    <script>
        function register() {
            document.getElementById("reg_button").disabled = true;
            document.getElementById("reg_loading").style.display = "block";
            document.getElementById("email").disabled = true;
            document.getElementById("password").disabled = true;
            document.getElementById("con_password").disabled = true;
            document.getElementById("fname").disabled = true;
            document.getElementById("lname").disabled = true;
            document.getElementById("checkbox").disabled = true;

            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            let con_password = document.getElementById("con_password").value;
            let fname = document.getElementById("fname").value;
            let lname = document.getElementById("lname").value;
            let checkbox = document.getElementById("checkbox").checked;

            let check = true;

            if (!checkbox) {
                check = false;
            }

            document.getElementById("email_error").innerHTML = "";
            document.getElementById("password_error").innerHTML = "";
            document.getElementById("con_password_error").innerHTML = "";
            document.getElementById("fname_error").innerHTML = "";
            document.getElementById("lname_error").innerHTML = "";
            document.getElementById("checkbox_error").innerHTML = "";

            $.ajax({
                url: "../user/registration-operations.php",
                method: "POST",
                data: {
                    fname: fname,
                    lname: lname,
                    email: email,
                    password: password,
                    con_password: con_password,
                    check: check
                },
                dataType: "json",
                success: function(data) {
                    document.getElementById("reg_button").disabled = false;
                    document.getElementById("reg_loading").style.display = "none";
                    document.getElementById("email").disabled = false;
                    document.getElementById("password").disabled = false;
                    document.getElementById("con_password").disabled = false;
                    document.getElementById("fname").disabled = false;
                    document.getElementById("lname").disabled = false;
                    document.getElementById("checkbox").disabled = false;

                    if (data.error == 0) {
                        Swal.fire({
                            html: data.error_msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#ffcf40'
                        }).then(function() {
                            window.location = "../user/login.php";
                        });

                    } else {
                        document.getElementById("fname_error").innerHTML = data.fname_error;
                        document.getElementById("fname_error").style.display = "block"; 

                        document.getElementById("lname_error").innerHTML = data.lname_error;
                        document.getElementById("lname_error").style.display = "block"; 

                        document.getElementById("email_error").innerHTML = data.email_error;
                        document.getElementById("email_error").style.display = "block"; 

                        document.getElementById("password_error").innerHTML = data.password_error;
                        document.getElementById("password_error").style.display = "block"; 

                        document.getElementById("con_password_error").innerHTML = data.con_password_error;
                        document.getElementById("con_password_error").style.display = "block"; 

                        if (data.checkbox_error !== "") {
                            document.getElementById("checkbox_error").innerHTML = data.checkbox_error;
                            document.getElementById("checkbox_error").style.display = "block"; 
                        }
                    }
                },
                error: function(data) {
                    console.log(data);
                    document.getElementById("reg_button").disabled = false;
                    document.getElementById("reg_loading").style.display = "none";
                    document.getElementById("email").disabled = false;
                    document.getElementById("password").disabled = false;
                    document.getElementById("con_password").disabled = false;
                    document.getElementById("fname").disabled = false;
                    document.getElementById("lname").disabled = false;
                    document.getElementById("checkbox").disabled = false;
                    
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

</html>