
<?php
	include_once("header-main.php");
?>


<body class="nk-body bg-white npc-general pg-auth dark-mode">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php
                include_once("nk-sidebar.php");
            ?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php 
                    include_once("nk-header.php");
                ?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Admin List</h3>
                                            <div class="nk-block-des text-soft">
                                                <p></p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li><button onclick="showAddModal()" class="btn btn-primary"><span>Add Admin</span></button></li>
                                                    </ul>
                                                </div>
                                            </div><!-- .toggle-wrap -->
                                        </div>
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner">
                                            <table class="datatable-init nowrap table">
                                                <thead>
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <th>Email</th>
                                                        <th>Admin Role</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $admin_details = DB::query("SELECT a.admin_id, a.admin_first_name, a.admin_last_name, a.admin_email, a.admin_initial, a.admin_status, ar.admin_role_name, ar.admin_role_id FROM admin a LEFT JOIN admin_role ar ON ar.admin_role_id = a.admin_role_id");

                                                    foreach ($admin_details as $detail) {
                                                        if ($detail['admin_status'] == 0) {
                                                            $txt_color = "text-success";
                                                            $status = "Active";
                                                        } else if ($detail['admin_status'] == 2) {
                                                            $txt_color = "text-warning";
                                                            $status = "Pending";
                                                        } else {
                                                            $txt_color = "text-danger";
                                                            $status = "Deactivated";
                                                        }
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="user-card">
                                                                <div class="user-avatar bg-primary">
                                                                    <span><?php echo $detail['admin_initial'] ?></span>
                                                                </div>
                                                                <div class="user-info">
                                                                    <span class="tb-lead"><?php echo $detail['admin_first_name']." ".$detail['admin_last_name'] ?> <span class="dot dot-success d-md-none ms-1"></span></span>
                                                                </div>
                                                            </div>
                                                            
                                                        </td>
                                                        <td>
                                                            <span class="tb-amount"><?php echo $detail['admin_email'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="tb-status text-info"><?php echo $detail['admin_role_name'] ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="tb-status <?php echo $txt_color; ?>"><?php echo $status; ?></span>
                                                        </td>
                                                        <td>
                                                            <ul class="nk-tb-actions gx-1">
                                                                <li>
                                                                    <div class="drodown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li><a data-bs-toggle="modal" onclick="showEditUserModal(<?php echo $detail['admin_id'] ?>, '<?php echo $detail['admin_first_name'] ?>', '<?php echo $detail['admin_last_name'] ?>', '<?php echo $detail['admin_email'] ?>', <?php echo $detail['admin_role_id'] ?>)"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                                                <?php 
                                                                                    if ($detail['admin_status'] != 0) {
                                                                                ?>
                                                                                <li><a onclick="activateAdmin(<?php echo $detail['admin_id'] ?>);"><em class="icon ni ni-mail-fill"></em><span>Send Activation Email</span></a></li>
                                                                                <?php 
                                                                                    } else {
                                                                                ?>
                                                                                <li><a onclick="deactivateAdmin(<?php echo $detail['admin_id'] ?>)"><em class="icon ni ni-cross"></em><span>Deactivate</span></a></li>
                                                                                <?php 
                                                                                    }
                                                                                ?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <?php 
                    include_once("nk-footer.php");
                ?>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    
    <div class="modal fade" id="editCustomer">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a onclick="closeModal();" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Edit Admin</h5>
                    <form action="#" class="mt-2">
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="first-name">First Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="first-name">
                                        <span id="first-name-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="last-name">Last Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="last-name">
                                        <span id="last-name-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="email">
                                        <span id="email-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="role">Admin Role</label>
                                    <div class="form-control-wrap ">
                                        <div class="form-control-select">
                                            <select class="form-control" id="role">
                                                <?php
                                                    $role_details = DB::query("SELECT admin_role_id, admin_role_name FROM admin_role WHERE admin_role_status = %i", 0);

                                                    foreach ($role_details as $detail) {
                                                ?>
                                                <option value="<?php echo $detail['admin_role_id'] ?>"><?php echo $detail['admin_role_name'] ?></option>
                                                <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="form-control-wrap">
                                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" id="password" placeholder="Enter Password">
                                        <span id="password-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="con-password">Retype Password</label>
                                    <div class="form-control-wrap">
                                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="con-password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" id="con-password" placeholder="Enter Password">
                                        <span id="con-password-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <button id="update-button" type="button" class="btn btn-lg btn-primary btn-block"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="update-loading" style="display:none;"></span><span>Update Admin</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .Edit Modal-Content -->

    <div class="modal fade" id="addCustomer">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a onclick="closeAddModal();" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Add Admin</h5>
                    <form action="#" class="mt-2">
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="add-first-name">First Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="add-first-name">
                                        <span id="add-first-name-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="add-last-name">Last Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="add-last-name">
                                        <span id="add-last-name-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="add-email">Email</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="add-email">
                                        <span id="add-email-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="add-role">Admin Role</label>
                                    <div class="form-control-wrap ">
                                        <div class="form-control-select">
                                            <select class="form-control" id="add-role">
                                                <?php
                                                    $role_details = DB::query("SELECT admin_role_id, admin_role_name FROM admin_role WHERE admin_role_status = %i", 0);

                                                    foreach ($role_details as $detail) {
                                                ?>
                                                <option value="<?php echo $detail['admin_role_id'] ?>"><?php echo $detail['admin_role_name'] ?></option>
                                                <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="add-password">Password</label>
                                    <div class="form-control-wrap">
                                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="add-password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" id="add-password" placeholder="Enter Password">
                                        <span id="add-password-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="add-con-password">Retype Password</label>
                                    <div class="form-control-wrap">
                                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="add-con-password">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" class="form-control form-control-lg" id="add-con-password" placeholder="Enter Password">
                                        <span id="add-con-password-error" class="invalid"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <button onclick="addAdmin()" id="add-button" type="button" class="btn btn-lg btn-primary btn-block"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="add-loading" style="display:none;"></span><span>Add Admin</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .Add Modal-Content -->
    
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.1.1"></script>
    <script src="./assets/js/scripts.js?ver=3.1.1"></script>
    <script src="./assets/js/libs/datatable-btns.js"></script>
    <script>
        function showEditUserModal(admin_id, first_name, last_name, email, role) {
            document.getElementById("first-name").value = first_name;
            document.getElementById("last-name").value = last_name;
            document.getElementById("email").value = email;
            document.getElementById("role").value = role;
            document.getElementById("update-button").setAttribute("onclick", "updateAdmin("+admin_id+")");
            $("#editCustomer").modal("show");
        }

        function updateAdmin(edited_admin_id) {
            document.getElementById("update-button").disabled = true;
            document.getElementById("update-loading").style.display = "block";

            let first_name = document.getElementById("first-name").value;
            let last_name = document.getElementById("last-name").value;
            let email = document.getElementById("email").value;
            let admin_role = document.getElementById("role").value;
            let password = document.getElementById("password").value;
            let con_password = document.getElementById("con-password").value;

            Swal.fire({
                html: "Please note that if you have changed the email, the account will be inactive until the user has verified the new email!",
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#ffcf40'
            }).then(function() {
                $.ajax({
                    url: "admin/admin-edit-operations.php",
                    method: "POST",
                    data: {
                        admin_id: `<?php echo $admin_id ?>`,
                        edited_admin_id: edited_admin_id,
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        admin_role: admin_role,
                        password: password,
                        con_password: con_password
                    },
                    dataType: "json",
                    success: function(data) {
                        document.getElementById("update-button").disabled = false;
                        document.getElementById("update-loading").style.display = "none";
                        console.log(data);
                        if (data.error == 0) {
                            Swal.fire({
                                html: data.error_msg,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#ffcf40'
                            }).then(function() {
                                window.location.reload();
                            });

                        } else if (data.error == 1) {
                            document.getElementById("email-error").innerHTML = data.email_error;
                            document.getElementById("password-error").innerHTML = data.password_error;
                            document.getElementById("con-password-error").innerHTML = data.con_password_error;
                            document.getElementById("first-name-error").innerHTML = data.fname_error;
                            document.getElementById("last-name-error").innerHTML = data.lname_error;
                            Swal.fire({
                                html: data.error_msg,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#ffcf40'
                            });
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
                        document.getElementById("update-button").disabled = false;
                        document.getElementById("update-loading").style.display = "none";
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
            });
        }

        function closeModal() {
            document.getElementById("password").value = "";
            document.getElementById("con-password").value = "";
            document.getElementById("password-error").innerHTML = "";
            document.getElementById("con-password-error").innerHTML = "";
            document.getElementById("first-name-error").innerHTML = "";
            document.getElementById("last-name-error").innerHTML = "";
            document.getElementById("email-error").innerHTML = "";
            $("#editCustomer").modal("hide");
        }

        // Function to handle the click event outside of the modal
        function handleClickOutside(event) {
            // Get the modal element
            let modalEdit = document.getElementById("editCustomer");
            let modalAdd = document.getElementById("addCustomer");

            if (event.target === modalEdit) {
                // User clicked outside the modal
                document.getElementById("password").value = "";
                document.getElementById("con-password").value = "";
                document.getElementById("password-error").innerHTML = "";
                document.getElementById("con-password-error").innerHTML = "";
                document.getElementById("first-name-error").innerHTML = "";
                document.getElementById("last-name-error").innerHTML = "";
                document.getElementById("email-error").innerHTML = "";

            } else if (event.target === modalAdd) {
                // User clicked outside the modal
                document.getElementById("add-password").value = "";
                document.getElementById("add-con-password").value = "";
                document.getElementById("add-password-error").innerHTML = "";
                document.getElementById("add-con-password-error").innerHTML = "";
                document.getElementById("add-first-name-error").innerHTML = "";
                document.getElementById("add-last-name-error").innerHTML = "";
                document.getElementById("add-email-error").innerHTML = "";
            }
        }

        // Event listener to detect clicks outside the modal
        document.addEventListener("click", handleClickOutside);

        function showAddModal() {
            $("#addCustomer").modal("show");
        }

        function addAdmin() {
            document.getElementById("add-button").disabled = true;
            document.getElementById("add-loading").style.display = "block";

            let first_name = document.getElementById("add-first-name").value;
            let last_name = document.getElementById("add-last-name").value;
            let email = document.getElementById("add-email").value;
            let admin_role = document.getElementById("add-role").value;
            let password = document.getElementById("add-password").value;
            let con_password = document.getElementById("add-con-password").value;

            Swal.fire({
                title: "Confirmation",
                html: "Are you sure you want to proceed?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#ffcf40',
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "admin/admin-add-operations.php",
                        method: "POST",
                        data: {
                            admin_id: `<?php echo $admin_id ?>`,
                            first_name: first_name,
                            last_name: last_name,
                            email: email,
                            admin_role: admin_role,
                            password: password,
                            con_password: con_password
                        },
                        dataType: "json",
                        success: function(data) {
                            document.getElementById("add-button").disabled = false;
                            document.getElementById("add-loading").style.display = "none";
                            console.log(data);
                            if (data.error == 0) {
                                Swal.fire({
                                    html: data.error_msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffcf40'
                                }).then(function() {
                                    window.location.reload();
                                });

                            } else if (data.error == 1) {
                                document.getElementById("add-email-error").innerHTML = data.email_error;
                                document.getElementById("add-password-error").innerHTML = data.password_error;
                                document.getElementById("add-con-password-error").innerHTML = data.con_password_error;
                                document.getElementById("add-first-name-error").innerHTML = data.fname_error;
                                document.getElementById("add-last-name-error").innerHTML = data.lname_error;
                                Swal.fire({
                                    html: data.error_msg,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ffcf40'
                                });
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
                            document.getElementById("add-button").disabled = false;
                            document.getElementById("add-loading").style.display = "none";
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
                } else {
                    document.getElementById("add-button").disabled = false;
                    document.getElementById("add-loading").style.display = "none";
                }
            });
        }

        function closeAddModal() {
            document.getElementById("add-password").value = "";
            document.getElementById("add-con-password").value = "";
            document.getElementById("add-password-error").innerHTML = "";
            document.getElementById("add-con-password-error").innerHTML = "";
            document.getElementById("add-first-name-error").innerHTML = "";
            document.getElementById("add-last-name-error").innerHTML = "";
            document.getElementById("add-email-error").innerHTML = "";
            $("#addCustomer").modal("hide");
        }

        function deactivateAdmin(edited_admin_id) {
            Swal.fire({
                title: "Confirmation",
                html: "Are you sure you want to proceed?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "OK",
                confirmButtonColor: '#ffcf40',
                cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Code to run when the "OK" button is clicked
                        $.ajax({
                            url: "admin/deactivate-admin.php",
                            method: "POST",
                            data: {
                                admin_id: `<?php echo $admin_id ?>`,
                                edited_admin_id: edited_admin_id
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if (data.error == 0) {
                                    Swal.fire({
                                        html: data.error_msg,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#ffcf40'
                                    }).then(function() {
                                        window.location.reload();
                                    });
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
            });
        }

        function activateAdmin(edited_admin_id) {
            Swal.fire({
                title: "Confirmation",
                html: "Are you sure you want to proceed?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "OK",
                confirmButtonColor: '#ffcf40',
                cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Code to run when the "OK" button is clicked
                        $.ajax({
                            url: "admin/activate-admin.php",
                            method: "POST",
                            data: {
                                admin_id: `<?php echo $admin_id ?>`,
                                edited_admin_id: edited_admin_id
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if (data.error == 0) {
                                    Swal.fire({
                                        html: data.error_msg,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#ffcf40'
                                    }).then(function() {
                                        window.location.reload();
                                    });
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
            });
        }
    </script>
</body>

</html>