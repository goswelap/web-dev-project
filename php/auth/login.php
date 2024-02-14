<?php
// location - /eranei.com/php/auth/login.php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("/eranei.com/php/auth/config.php");

if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== 999) {
    header("Location: /php/dashboard/user.php");
    exit();
}

$message = '';
if (isset($_SESSION['msg_success'])) {
    $message = $_SESSION['msg_success'];
    unset($_SESSION['msg_success']);
}

if (isset($_POST["login"])) {
    if (empty($_POST["user_name"]) || empty($_POST["user_password"])) {
        $message = "<div class='alert alert-danger'>both fields are required</div>";
    } else {
        $query = "
        SELECT * FROM user_details
        WHERE user_name = :user_name
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                'user_name' => $_POST["user_name"]
            )
        );
        $user_count = $statement->rowCount();
        if ($user_count > 0) {
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                if (password_verify($_POST["user_password"], $row["user_password"])) {
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["user_image"] = $row["user_image"];
                    $_SESSION["user_name"] = $row["user_name"];
                    $_SESSION["user_type"] = $row["user_type"];
                    $_SESSION["user_status"] = $row["user_status"]; // i'll use this later for email verification
                    $_SESSION["user_type"] = $row["user_type"];
                    header("Location: /php/dashboard/user.php?");
                    exit();
                } else {
                    $message = '<div class="alert alert-danger">wrong password</div>';
                }
            }
        } else {
            $message = "<div class='alert alert-danger'>user not found</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>eranei.com - sign in</title>
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/default.css">
        <link rel="stylesheet" href="/css/header.css">
        <link rel="shortcut icon" type="image/png" href="/images/r1_icon.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

<body>

    <header>
        <div class="header-top">
            <h1>sign in, or continue as guest</h1>
        </div>
    </header>

    <br />

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">sign in</div>
            <div class="panel-body">
                <form class="form-group" method="post" id="login_form">
                    <div class="form-group">
                        <!-- <label>username</label> -->
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="username" required />
                    </div>
                    <div class="form-group">
                        <!-- <label>password</label> -->
                        <input type="password" name="user_password" id="user_password" placeholder="password" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" id="login" class="btn btn-style" value="sign in" />
                        <!-- <button type="button" class="btn btn-style" onclick="window.location.href='/php/dashboard/guest.php'">continue as guest</button> -->
                    </div>
                    <footer>don't have an account? <a href="/php/auth/register.php" class="btn-auth">register</a></footer>
                </form>
            </div>
        </div>
        <br />
    </div>
</body>

</html>
