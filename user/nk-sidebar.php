<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="html/crypto/index.html" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png" alt="logo">
                            <img class="logo-dark logo-img" src="../images/healthyverse-logo.png" srcset="../images/healthyverse-logo.png" alt="logo-dark">
                        </a>
                    </div>
                    <div class="nk-menu-trigger me-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-body" data-simplebar>
                        <div class="nk-sidebar-content">
                            <div class="nk-sidebar-widget d-none d-xl-block">
                                <div class="user-account-info between-center">
                                    <div class="user-account-main">
                                        <h6 class="overline-title-alt">Available Balance</h6>
                                        <ul id="spinner_stc_wallet_large" class="preview-list g-1">
                                            <li class="preview-item" style="width: 100%;">
                                                <div class="d-flex justify-content-center">
                                                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="user-balance" id="balance_large_screen" style="display:none;"> <small class="currency currency-btc"></small></div>
                                        <!-- <div class="user-balance-alt">18,934.84 <span class="currency currency-btc">BTC</span></div> -->
                                    </div>
                                    <!-- <a href="#" class="btn btn-white btn-icon btn-light"><em class="icon ni ni-line-chart"></em></a> -->
                                </div>
                               
                                <div class="user-account-actions">
                                    <ul class="g-3">
                                        <!-- <li><a href="#" class="btn btn-lg btn-primary"><span>Deposit</span></a></li>
                                        <li><a href="#" class="btn btn-lg btn-warning"><span>Withdraw</span></a></li> -->
                                    </ul>
                                </div>
                            </div><!-- .nk-sidebar-widget -->
                            <div class="nk-sidebar-widget nk-sidebar-widget-full d-xl-none pt-0">
                                <a class="nk-profile-toggle toggle-expand" data-target="sidebarProfile" href="#">
                                    <div class="user-card-wrap">
                                        <div class="user-card">
                                            <div class="user-avatar">
                                                <span><?php echo $initial ?></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?php echo $name ?></span>
                                                <span class="sub-text"><?php echo $email ?></span>
                                            </div>
                                            <div class="user-action">
                                                <em class="icon ni ni-chevron-down"></em>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="nk-profile-content toggle-expand-content" data-content="sidebarProfile">
                                    <div class="user-account-info between-center">
                                        <div class="user-account-main">
                                            <h6 class="overline-title-alt">Available Balance</h6>
                                            <ul id="spinner_stc_wallet_small" class="preview-list g-1">
                                                <li class="preview-item" style="width: 100%;">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="user-balance" id="balance_small_screen" style="display:none;"> <small class="currency currency-btc"></small></div>
                                            <!-- <div class="user-balance-alt">18,934.84 <span class="currency currency-btc">BTC</span></div> -->
                                        </div>
                                    
                                    </div>
                                    
                                    <ul class="user-account-links">
                                        <!-- <li><a href="#" class="link"><span>Withdraw Funds</span> <em class="icon ni ni-wallet-out"></em></a></li>
                                        <li><a href="#" class="link"><span>Deposit Funds</span> <em class="icon ni ni-wallet-in"></em></a></li> -->
                                    </ul>
                                    <ul class="link-list">
                                        <li><a href="../user/edit-personal-info.php"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                        <li><a href="../user/signout.php"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                        <!-- <li><a href="html/crypto/profile-security.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                        <li><a href="html/crypto/profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li> -->
                                    </ul>
                                    <!-- <ul class="link-list">
                                        <li><a href="#"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                    </ul> -->
                                </div>
                            </div><!-- .nk-sidebar-widget -->
                            <div class="nk-sidebar-menu">
                                <!-- Menu -->
                                <ul class="nk-menu">
                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title">Menu</h6>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="../user/index.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                            <span class="nk-menu-text">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="../user/exercise-list.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-user-c"></em></span>
                                            <span class="nk-menu-text">Exercise Now</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="leaderboard.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                            <span class="nk-menu-text">Leaderboard</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="../user/wallet.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-wallet-alt"></em></span>
                                            <span class="nk-menu-text">My Wallet</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="../user/marketplace.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-cart"></em></span>
                                            <span class="nk-menu-text">Market Place</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="../user/my-coupons.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                                            <span class="nk-menu-text">My Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="../user/chat-ai-coach.php" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-chat-circle"></em></span>
                                            <span class="nk-menu-text">Chat with HAIA</span>
                                        </a>
                                    </li>
                                </ul><!-- .nk-menu -->
                            </div><!-- .nk-sidebar-menu -->
                            <div class="nk-sidebar-footer">
                                <ul class="nk-menu nk-menu-footer">
                                    <!-- <li class="nk-menu-item">
                                        <a href="#" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-help-alt"></em></span>
                                            <span class="nk-menu-text">Support</span>
                                        </a>
                                    </li> -->
                                    <!-- <li class="nk-menu-item ms-auto">
                                        <div class="dropup">
                                            <a href="" class="nk-menu-link dropdown-indicator has-indicator" data-bs-toggle="dropdown" data-offset="0,10">
                                                <span class="nk-menu-icon"><em class="icon ni ni-globe"></em></span>
                                                <span class="nk-menu-text">English</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                <ul class="language-list">
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="../images/flags/english.png" alt="" class="language-flag">
                                                            <span class="language-name">English</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="../images/flags/spanish.png" alt="" class="language-flag">
                                                            <span class="language-name">Español</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="../images/flags/french.png" alt="" class="language-flag">
                                                            <span class="language-name">Français</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="language-item">
                                                            <img src="../images/flags/turkey.png" alt="" class="language-flag">
                                                            <span class="language-name">Türkçe</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li> -->
                                </ul><!-- .nk-footer-menu -->
                            </div><!-- .nk-sidebar-footer -->
                        </div><!-- .nk-sidebar-content -->
                    </div><!-- .nk-sidebar-body -->
                </div><!-- .nk-sidebar-element -->
            </div>
            
            
            