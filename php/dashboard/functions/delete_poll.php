<?php
// location - /eranei.com/php/polls/functions/delete_poll.php

session_start();
require_once("/eranei.com/php/auth/config.php");

if (!isset($_SESSION['user_id']) || !isset($_POST['poll_id'])) {
    echo "error";
    exit();
}

$user_id = $_SESSION['user_id'];
$poll_id = $_POST['poll_id'];

try {
    // delete poll options
    $query_options = "DELETE FROM poll_options WHERE poll_id = :poll_id";
    $statement_options = $connect->prepare($query_options);
    $statement_options->execute(['poll_id' => $poll_id]);

    // delete poll
    $query_poll = "DELETE FROM polls WHERE id = :poll_id AND user_id = :user_id";
    $statement_poll = $connect->prepare($query_poll);
    $statement_poll->execute(['poll_id' => $poll_id, 'user_id' => $user_id]);

    echo "success";
} catch (Exception $e) {
    echo "error";
}
?>
