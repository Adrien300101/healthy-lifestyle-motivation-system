<?php
	include_once("header-main.php");
?>

    <body class="nk-body npc-default pg-error dark-mode">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- wrap @s -->
                <div class="nk-wrap nk-wrap-nosidebar">
                    <!-- content @s -->
                    <div class="nk-content ">
                        <div class="nk-block nk-block-middle wide-md mx-auto">
                            <div class="nk-block-content nk-error-ld text-center">
                                <img class="nk-error-gfx" src="./images/gfx/error-404.svg" alt="">
                                <div class="wide-xs mx-auto">
                                    <h3 class="nk-error-title">Oops! Why you’re here?</h3>
                                    <p class="nk-error-text">We are very sorry for inconvenience. It looks like you’re trying to access a page that either has been deleted or you don't have access to.</p>
                                    <a href="admin/user-management.php" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                                </div>
                            </div>
                        </div><!-- .nk-block -->
                    </div>
                    <!-- wrap @e -->
                </div>
                <!-- content @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
        <script src="./assets/js/bundle.js?ver=3.1.1"></script>
        <script src="./assets/js/scripts.js?ver=3.1.1"></script>

    </body>

</html>