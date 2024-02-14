<?php
// location - /eranei.com/php/dashboard/user.php
session_start();
require_once("/eranei.com/php/auth/config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: /php/auth/login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title><?php echo $user_name; ?>'s dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/images/r1_icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/default.css">
    <link rel="stylesheet" href="/css/header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/js/dashboard.js"></script>
</head>

<body>

<header>
    <div class="header-top">
        <h1><?php echo $user_name; ?>'s dashboard</h1>
    </div>
    <div class="header-banner">
        <a href="#" class="header-link" id="view-polls">view polls</a>
        <a href="#" class="header-link" id="create-poll">create poll</a>
        <div class="user-info">
            <span><?php echo $user_name;?>  |  </span>
            <a href="/php/auth/logout.php"> logout</a>
        </div>
    </div>
</header>

<div class="container mt-4">

    <div id="view-polls-container" style="display: block;">
        <!-- view polls content will be loaded here -->
    </div>

    <div id="create-poll-container" style="display: none;">
        <!-- create poll content will be loaded here -->
    </div>
</div>
</body>
</html>
