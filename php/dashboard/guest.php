<?php
// location - /eranei.com/php/dashboard/guest.php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("/eranei.com/php/auth/config.php");

$_SESSION["user_email"] = "guest";
$_SESSION["user_id"] = 999; // default guest user ID for now
$_SESSION["user_name"] = "guest";
$_SESSION["user_type"] = "guest";
$_SESSION["user_status"] = "guest";

$user_name = $_SESSION['user_name'];

header("Location: /php/dashboard/user.php?");
?>
