<!-- content @e -->
<!-- footer @s -->
<div class="nk-footer" style="background-image:url('images/캡처.JPG'); background-size:100% 100%;">
    <div class="container-fluid">
        <div class="nk-footer-wrap">
        </div>
    </div>
</div>
<!-- footer @e -->
</div>
<!-- wrap @e -->
</div>
<!-- main @e -->
</div>
<!-- app-root @e -->
<div class="modal fade" tabindex="-1" id="confirm_modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm_header"></h5>
                <a class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body" id="confirm_body">
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button id="confirm_btn" class="btn btn-success">Confirm</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="inform_success" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title" id="inform_success_header">Success</h4>
                    <div class="nk-modal-text">
                        <div id="inform_success_body" class="caption-text"></div>
                    </div>
                    <div class="nk-modal-action">
                        <button id="inform_success_btn" class="btn btn-lg btn-mw btn-primary">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="inform_danger" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                    <h4 class="nk-modal-title">Unable To Process</h4>
                    <div class="nk-modal-text">
                        <p id="inform_danger_body" class="lead"></p>
                    </div>
                    <div class="nk-modal-action mt-5">
                        <button id="inform_danger_btn" class="btn btn-lg btn-mw btn-light">Confirm</a>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>
<!-- JavaScript -->
<script src="../assets/js/bundle.js?ver=3.1.1"></script>
<script src="../assets/js/scripts.js?ver=3.1.1"></script>
<script src="../assets/js/example-chart.js"></script>
<script src="../assets/js/charts/gd-default.js"></script>
<script src="https://kit.fontawesome.com/0a14a1d42d.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<script src="../js/TronWeb.js"></script>
<script src="../js/bignumber.js-master/bignumber.js"></script>
</body>

</html>