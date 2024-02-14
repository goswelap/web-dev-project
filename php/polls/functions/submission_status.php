<?php
// location - /eranei.com/php/polls/functions/submission_status.php
session_start();
require_once("/eranei.com/php/auth/config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: /php/auth/login.php");
    exit();
}

// get url params
$poll_id = $_GET['id'];

$query = $connect->prepare("SELECT * FROM user_votes WHERE user_id = ? AND poll_id = ?");
$query->execute([$_SESSION['user_id'], $poll_id]);
$user_vote = $query->fetch();

if ($user_vote) {
    echo "true";
    exit();
}
?>
