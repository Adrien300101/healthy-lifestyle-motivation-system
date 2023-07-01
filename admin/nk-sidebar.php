            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="html/index.html" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="./images/healthyverse-logo.png" srcset="./images/healthyverse-logo.png 2x" alt="logo">
                            <img class="logo-dark logo-img" src="./images/healthyverse-logo.png" srcset="./images/healthyverse-logo.png 2x" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                
                                <li class="nk-menu-item">
                                    <a href="admin/user-management.php" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-user-list-fill"></em></span>
                                        <span class="nk-menu-text">User Management</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <?php 
                                    if($admin_role_id == 1) {
                                ?>
                                <li class="nk-menu-item">
                                    <a href="admin/admin-management.php" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                                        <span class="nk-menu-text">Admin Management</span>
                                    </a>
                                </li>
                                <?php 
                                    }
                                ?>
                                <li class="nk-menu-item">
                                    <a href="admin/coupon-management.php" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                        <span class="nk-menu-text">Coupon Management</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>