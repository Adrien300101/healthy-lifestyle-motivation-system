<?php
session_start();
if (isset($_SESSION['session_id'])) {
	include_once("../config.php");

	$session_id = $_SESSION['session_id'];

	$admin_details = DB::query("SELECT a.admin_id, a.admin_first_name, a.admin_last_name, a.admin_email, a.admin_initial, ar.admin_role_name, ar.admin_role_id, p.url FROM admin a LEFT JOIN admin_role ar ON ar.admin_role_id = a.admin_role_id LEFT JOIN admin_access aa ON ar.admin_role_id = aa.admin_role_id LEFT JOIN page_list p ON p.page_id = aa.page_id WHERE a.admin_session_id = %s AND a.admin_status = %i", $session_id, 0);
	if ($admin_details != NULL) {
		$admin_id 		  = $admin_details[0]['admin_id'];
		$name    		  = $admin_details[0]['admin_first_name']." ".$admin_details[0]['admin_last_name'];
		$email 			  = $admin_details[0]['admin_email'];
        $initial          = $admin_details[0]['admin_initial'];
        $admin_role       = $admin_details[0]['admin_role_name'];
		$admin_role_id	  = $admin_details[0]['admin_role_id'];

		$access = false;
		foreach ($admin_details as $detail) {
			if (stripos($_SERVER['PHP_SELF'], $detail['url']) !== false) {
				$access = true;
			}
		}

		if ($access == false) {
			echo '<script>window.location.href="../admin/access-denied.php"</script>';
		}

	} else {
		session_destroy();
		echo '<script>window.location.href="../admin/admin-login.php"</script>';
	}
}else{
	echo '<script>window.location.href="../admin/admin-login.php"</script>';
}
?>
<!DOCTYPE html>
<html class="js">

<head>
	<base href="../">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Fav Icon  -->
	<link rel="shortcut icon" href="./images/healthyverse-logo.png">
	<!-- Page Title  -->
	<title>Admin | HealthyVerse</title>
	<!-- StyleSheets  -->
	<link rel="stylesheet" href="./assets/css/dashlite-purple.css?ver=2.4.0">
	<link id="skin-default" rel="stylesheet" href="./assets/css/skins/theme-purple.css?ver=2.4.0">
</head>