<?php 
    include_once("header-main.php");
?>
        <!-- main @s -->
        <div class="nk-main ">
                
                <!-- content @s -->
                <div class="nk-content p-0">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-chat">
                                
                                <div class="nk-chat-body show-chat">
                                    <div class="nk-chat-head">
                                        <ul class="nk-chat-head-info">
                                            <li class="nk-chat-body-close">
                                                <a href="../user/index.php" class="btn btn-icon btn-trigger nk-chat-hide ms-n1"><em class="icon ni ni-arrow-left"></em></a>
                                            </li>
                                            <li class="nk-chat-head-user">
                                                <div class="user-card">
                                                    <div class="user-avatar bg-purple">
                                                        <span>HA</span>
                                                    </div>
                                                    <div class="user-info">
                                                        <div class="lead-text">HAIA</div>
                                                        <div class="sub-text"><span class="d-none d-sm-inline me-1">Active </span></div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        
                                        <div class="nk-chat-head-search">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-left">
                                                        <em class="icon ni ni-search"></em>
                                                    </div>
                                                    <input type="text" class="form-control form-round" id="chat-search" placeholder="Search in Conversation">
                                                </div>
                                            </div>
                                        </div><!-- .nk-chat-head-search -->
                                    </div><!-- .nk-chat-head -->
                                    <div class="nk-chat-panel" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -20px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="chat-container" style="position: relative;"><div id="chat_container" class="simplebar-content" style="padding: 20px;">
                                    <?php 
                                    $chat_details = DB::query("SELECT user_msg, response, date_created FROM chat_history WHERE user_id = %i AND date_created >= DATE_SUB(NOW(), INTERVAL 3 DAY)", $user_id);
                                    if ($chat_details != null) {
                                        foreach ($chat_details as $detail) {
                                    ?>
                                    <div class="chat is-me">
                                        <div class="chat-content">
                                            <div class="chat-bubbles">
                                                <div class="chat-bubble">
                                                    <div class="chat-msg"><?php echo $detail['user_msg'] ?></div>
                                                </div>
                                            </div>
                                            <ul class="chat-meta">
                                                <li><?php echo $name ?></li>
                                                <li><?php echo $detail['date_created'] ?></li>
                                            </ul>
                                        </div>
                                    </div><!-- .chat -->
                                    <div class="chat is-you">
                                        <div class="chat-avatar">
                                            <div class="user-avatar bg-purple">
                                                <span>HA</span>
                                            </div>
                                        </div>
                                        <div class="chat-content">
                                            <div class="chat-bubbles">
                                                <div class="chat-bubble">
                                                    <div class="chat-msg"> <?php echo $detail['response'] ?> </div>
                                                </div>
                                            </div>
                                            <ul class="chat-meta">
                                                <li>HAIA</li>
                                                <li><?php echo $detail['date_created'] ?></li>
                                            </ul>
                                        </div>
                                    </div><!-- .chat -->
                                    <?php 
                                        }
                                    }
                                    ?>
                                    </div><div class="d-flex justify-content-center" id="send_loading"></div></div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 1095px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 457px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div><!-- .nk-chat-panel -->
                                    <div class="nk-chat-editor">
                                        <div class="nk-chat-editor-form">
                                            <div class="form-control-wrap">
                                                <textarea id="msg_container" class="form-control form-control-simple no-resize" rows="1" id="default-textarea" placeholder="Type your message..."></textarea>
                                            </div>
                                        </div>
                                        <ul class="nk-chat-editor-tools g-2">
                                            <li>
                                                <button id="send_btn" class="btn btn-round btn-primary btn-icon" onclick='send_msg(<?php echo json_encode($user_id) ?>);'><em class="icon ni ni-send-alt"></em></button>
                                            </li>
                                        </ul>
                                    </div><!-- .nk-chat-editor -->
                                    <div class="nk-chat-profile" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">
                                        <div class="user-card user-card-s2 my-4">
                                            <div class="user-avatar md bg-purple">
                                                <span>IH</span>
                                            </div>
                                            <div class="user-info">
                                                <h5>Iliash Hossain</h5>
                                                <span class="sub-text">Active 35m ago</span>
                                            </div>
                                            <div class="user-card-menu dropdown">
                                                <a href="#" class="btn btn-icon btn-sm btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><em class="icon ni ni-eye"></em><span>View Profile</span></a></li>
                                                        <li><a href="#"><em class="icon ni ni-na"></em><span>Block Messages</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat-profile">
                                            <div class="chat-profile-group">
                                                <a href="#" class="chat-profile-head" data-bs-toggle="collapse" data-bs-target="#chat-options">
                                                    <h6 class="title overline-title">Options</h6>
                                                    <span class="indicator-icon"><em class="icon ni ni-chevron-down"></em></span>
                                                </a>
                                                <div class="chat-profile-body collapse show" id="chat-options">
                                                    <div class="chat-profile-body-inner">
                                                        <ul class="chat-profile-options">
                                                            <li><a class="chat-option-link" href="#"><em class="icon icon-circle bg-light ni ni-edit-alt"></em><span class="lead-text">Nickname</span></a></li>
                                                            <li><a class="chat-option-link chat-search-toggle" href="#"><em class="icon icon-circle bg-light ni ni-search"></em><span class="lead-text">Search In Conversation</span></a></li>
                                                            <li><a class="chat-option-link" href="#"><em class="icon icon-circle bg-light ni ni-circle-fill"></em><span class="lead-text">Change Theme</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .chat-profile-group -->
                                            <div class="chat-profile-group">
                                                <a href="#" class="chat-profile-head" data-bs-toggle="collapse" data-bs-target="#chat-settings">
                                                    <h6 class="title overline-title">Settings</h6>
                                                    <span class="indicator-icon"><em class="icon ni ni-chevron-down"></em></span>
                                                </a>
                                                <div class="chat-profile-body collapse show" id="chat-settings">
                                                    <div class="chat-profile-body-inner">
                                                        <ul class="chat-profile-settings">
                                                            <li>
                                                                <div class="custom-control custom-control-sm custom-switch checked">
                                                                    <input type="checkbox" class="custom-control-input" checked="" id="chat-notification-enable">
                                                                    <label class="custom-control-label" for="chat-notification-enable">Notifications</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <a class="chat-option-link" href="#">
                                                                    <em class="icon icon-circle bg-light ni ni-bell-off-fill"></em>
                                                                    <div>
                                                                        <span class="lead-text">Ignore Messages</span>
                                                                        <span class="sub-text">You won’t be notified when message you.</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="chat-option-link" href="#">
                                                                    <em class="icon icon-circle bg-light ni ni-alert-fill"></em>
                                                                    <div>
                                                                        <span class="lead-text">Something Wrong</span>
                                                                        <span class="sub-text">Give feedback and report conversion.</span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .chat-profile-group -->
                                            <div class="chat-profile-group">
                                                <a href="#" class="chat-profile-head" data-bs-toggle="collapse" data-bs-target="#chat-photos">
                                                    <h6 class="title overline-title">Shared Photos</h6>
                                                    <span class="indicator-icon"><em class="icon ni ni-chevron-down"></em></span>
                                                </a>
                                                <div class="chat-profile-body collapse show" id="chat-photos">
                                                    <div class="chat-profile-body-inner">
                                                        <ul class="chat-profile-media">
                                                            <li><a href="#"><img src="./images/slides/slide-a.jpg" alt=""></a></li>
                                                            <li><a href="#"><img src="./images/slides/slide-b.jpg" alt=""></a></li>
                                                            <li><a href="#"><img src="./images/slides/slide-c.jpg" alt=""></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .chat-profile-group -->
                                        </div> <!-- .chat-profile -->
                                    </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 759px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; display: none;"></div></div></div><!-- .nk-chat-profile -->
                                </div><!-- .nk-chat-body -->
                            </div><!-- .nk-chat -->
                        </div>
                    </div>
                </div>
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->

<?php include_once("footer-main.php") ?>

<script>
    function send_msg(user_id) {
        var user_msg = document.getElementById("msg_container").value;
        document.getElementById("msg_container").value = "";

        let currentDate = new Date();
        let year = currentDate.getFullYear();
        let month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        let day = currentDate.getDate().toString().padStart(2, '0');
        let hours = currentDate.getHours().toString().padStart(2, '0');
        let minutes = currentDate.getMinutes().toString().padStart(2, '0');
        let seconds = currentDate.getSeconds().toString().padStart(2, '0');
        let formattedDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

        if (user_msg != "") {
            document.getElementById("chat_container").innerHTML += '<div class="chat is-me"><div class="chat-content"><div class="chat-bubbles"><div class="chat-bubble"><div class="chat-msg">' + user_msg + '</div></div></div><ul class="chat-meta"><li><?php echo $name ?></li><li>' + formattedDate + '</li></ul></div></div>';
        }

        document.getElementById("send_btn").disabled = true;
        document.getElementById("send_loading").innerHTML='<ul class="preview-list g-1"><li class="preview-item"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden">Loading...</span></div></li><li class="preview-item"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden">Loading...</span></div></li><li class="preview-item"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden">Loading...</span></div></li></ul>';

        $.ajax({
            url: "../user/chatgpt-api.php",
            method: "POST",
            data: {
                user_id: user_id,
                user_msg: user_msg
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                document.getElementById("send_btn").disabled = false;
                document.getElementById("send_loading").innerHTML="";
                if (data.error == 0) {
                    //add the response to the chat
                    document.getElementById("chat_container").innerHTML += '<div class="chat is-you"><div class="chat-avatar"><div class="user-avatar bg-purple"><span>HA</span></div></div><div class="chat-content"><div class="chat-bubbles"><div class="chat-bubble"><div class="chat-msg"> ' + data.gpt_msg + ' </div></div></div><ul class="chat-meta"><li>HAIA</li><li>' + formattedDate + '</li></ul></div></div>';
                } else {
                    
                    Swal.fire({
                        html: data.error_msg,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffcf40'
                    });
                }
            },
            error: function(data) {
                console.log(data);
                document.getElementById("send_btn").disabled = false;
                document.getElementById("send_loading").innerHTML = "";
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