<?php
// location - /eranei.com/php/polls/details.php
session_start();

require_once("/eranei.com/php/auth/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/auth/login.php");
    exit();
}

$user_name = $_SESSION['user_name'];

$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$poll_id = intval($_GET['id']);

// cetch poll details
$query = $connect->prepare("SELECT * FROM polls WHERE id = :poll_id");
$query->execute(['poll_id' => $poll_id]);
$poll = $query->fetch(PDO::FETCH_ASSOC);

// cetch poll options
$query = $connect->prepare("SELECT * FROM poll_options WHERE poll_id = :poll_id");
$query->execute(['poll_id' => $poll_id]);
$options = $query->fetchAll(PDO::FETCH_ASSOC);

$is_public = $poll['visibility'] == 'public';

// check if the user has already voted
$query = $connect->prepare("SELECT * FROM user_votes WHERE user_id = :user_id AND poll_id = :poll_id");
$query->execute(['user_id' => $_SESSION['user_id'], 'poll_id' => $poll_id]);
$has_voted = $query->fetch(PDO::FETCH_ASSOC);

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
<script src="/js/poll_details.js"></script>
</head>
<body>

<header>
    <div class="header-top">
        <h1>poll details</h1>
    </div>
    <div class="header-banner">
        <a href="/php/dashboard/user.php" class="header-link" id="dashboard-link">&larr; dashboard</a>
        <a href="#" class="header-link" id="view-vote">vote</a>
        <a href="#" class="header-link" id="view-results">results</a>
        <div class="user-info">
            <span><?php echo $user_name;?></span> | <a href="/php/auth/logout.php"> logout</a>
        </div>
    </div>
</header>


    <div id="vote-container" style="display: block;">
        <!-- vote content will be loaded here -->
    </div>

    <div id="results-container" style="display: none;">
        <!-- results content will be loaded here -->
    </div>

</body>
</html>
