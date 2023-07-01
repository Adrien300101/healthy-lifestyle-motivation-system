<?php
include_once("header-main.php");
session_destroy();

echo '<script>window.location.href="../user/login.php"</script>';
?>