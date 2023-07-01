<?php
session_start();
if (isset($_SESSION['session_id'])) {
	include_once("../config.php");

	// if (!isset($_SESSION['lang_id'])) {
    //     $_SESSION['lang_id'] = 1;
    // }

	$session_id = $_SESSION['session_id'];

	$user_details = DB::queryFirstRow("SELECT u.user_id, u.first_name, u.last_name, u.email, u.initial, w.tron_wallet_address, w.public_key, w.private_key, w.wallet_status, w.wallet_id FROM users u LEFT JOIN wallet_info w ON u.user_id = w.user_id WHERE u.session_id = %s AND u.user_status = %i", $session_id, 1);
	if ($user_details != NULL) {
		$user_id 		  = $user_details['user_id'];
        $first_name       = $user_details['first_name'];
        $last_name        = $user_details['last_name'];
		$name    		  = $user_details['first_name'] . " " . $user_details['last_name'];
		$email 			  = $user_details['email'];
        $initial          = $user_details['initial'];
        $wallet_add       = $user_details['tron_wallet_address'];
        $public_key       = $user_details['public_key'];
        $private_key      = $user_details['private_key'];
        $wallet_status    = $user_details['wallet_status'];
        $wallet_id        = $user_details['wallet_id'];

        echo '
		<script>
			var check_token = window.setInterval(function(){
				$.ajax({
					url: "check-token.php",
					method: "POST",
					dataType: "json",
					success: function(data){
						if(data.error == 1){
							clearInterval(check_token);
                            Swal.fire({
                                text: data.error_msg,
                                icon: "warning",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#ffcf40"
                                
                            }).then(function(){										 
                                    window.location.href = "signout.php";
                            });	
						}
					}
				});
			}, 5000);
		</script>';

	} else {
		echo '<script>window.location.href="login.php"</script>';
	}
} else {
	echo '<script>window.location.href="login.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../images/favicon.png">
    <!-- Page Title  -->
    <title>Login | DashLite Admin Template</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../assets/css/dashlite.css?ver=3.1.1">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme-gold.css?ver=3.1.1">
</head>


<!-- <body class="nk-body bg-white has-sidebar dark-mode no-touch nk-nio-theme">
    <div class="nk-app-root"> -->
<body class="nk-body npc-crypto bg-white has-sidebar no-touch nk-nio-theme dark-mode">
    <div class="nk-app-root">