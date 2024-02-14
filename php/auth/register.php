<?php
// location - /eranei.com/php/auth/register.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("/eranei.com/php/auth/config.php");

// check if data was submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $agree = isset($_POST["agree"]) ? $_POST["agree"] : '';

        // check if email is in use
        $query = "SELECT * FROM user_details WHERE user_email = :email";
        $statement = $connect->prepare($query);
        $statement->execute(['email' => $email]);
        $count += $statement->rowCount();

        if ($count > 0) {
            $message = "<div class='alert alert-danger'>Email already exists</div>";
        } else {
            // insert new user into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO user_details (user_name, user_email, user_password, user_type, user_status)
                                        VALUES (:username, :email, :password, 'user', 'Active')";
            $statement = $connect->prepare($query);
            $statement->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);

            // redirect to dashboard with success message
            $_SESSION['msg_success'] = "Account created successfully. Please log in.";
            header("Location: /php/dashboard/user.php");
            exit();
        }

}
?>
<!-- registration form -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>eranei.com - register</title>
            <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/default.css">
        <link rel="stylesheet" href="/css/header.css">
        <link rel="shortcut icon" type="image/png" href="/images/r1_icon.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style> </style>
    </head>
    <body>
        <header>
            <div class="header-top">
                <h1>register</h1>
            </div>
        </header>
    <br />
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">registration</div>
            <div class="panel-body">
                <form class="form-group" action="register.php" method="post">
                    <?php if (isset($message)) echo $message; ?>
                    <div class="form-group">
                        <!-- <label class="control-label col-sm-1" for="username"></label> -->
                        <input type="text" name="username" class="form-control" placeholder="username" required />
                    </div>
                    <div class="form-group">
                        <!-- <label class="control-label col-sm-1" for="email"></label> -->
                        <input type="email" class="form-control" name="email" id="email" placeholder="email" required>
                    </div>
                    <div class="form-group">
                        <!-- <label class="control-label col-sm-1" for="password"></label> -->
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
                    </div>
                    <div class="form-group">
                        <!-- <label class="control-label col-sm-1" for="password2"></label> -->
                        <input type="password" class="form-control" name="password2" id="password2" placeholder="confirm password" required>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="agree" id="agree" value="yes" required> i hereby waive all of my rights.</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-style">submit</button>
                    </div>
                    <footer>have an account? <a href="/php/auth/login.php" class="btn-auth">sign in</a></footer>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

