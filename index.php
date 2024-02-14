<?php
// location - /eranei.com/php/index.php
  session_start();
  require_once("php/auth/config.php");

  if (isset($_SESSION["user_id"]) && $_SESSION["user_name"] !== "guest") {
    header("Location: /php/dashboard/user.php");
    exit();
  } else {
    header("Location: /php/auth/login.php");
    exit();
  }
?>
