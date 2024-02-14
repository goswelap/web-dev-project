<?php
// location - /eranei.com/php/auth/logout.php
session_start();

// unset all session variables
$_SESSION = array();

header("Location: /php/auth/login.php");

// destroy session upon logout
session_destroy();
exit();
?>
