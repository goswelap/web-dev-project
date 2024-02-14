<?php
// location - /eranei.com/php/polls/functions/submit_poll.php
session_start();
require_once("/eranei.com/php/auth/config.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // debug
        echo "attempting to submit poll.<br>";

        $user_id = $_SESSION['user_id'];
        $question = trim($_POST['question']);
        $options = explode(',', trim($_POST['options']));

        // insert poll question into database
        $query_poll = "INSERT INTO polls (id, user_id, title) VALUES (:poll_id, :user_id, :title)";
        $statement_poll = $connect->prepare($query_poll);
        $statement_poll->execute(['poll_id' => $unique_poll_id, 'user_id' => $user_id, 'title' => $question]);

        // debug
        echo "poll inserted into the database.<br>";

        // get ID of newly inserted poll
        $poll_id = $connect->lastInsertId();

        // insert poll options into database
        $query_option = "INSERT INTO poll_options (poll_id, name) VALUES (:poll_id, :name)";
        $statement_option = $connect->prepare($query_option);

        foreach ($options as $option) {
            $option = trim($option);
            $statement_option->execute(['poll_id' => $poll_id, 'name' => $option]);
        }

        // debug
        echo "options inserted into the poll.<br>";

        header("Location: /php/dashboard/user.php");
    } catch (Exception $e) {
        // debug
        echo "error submitting poll: " . $e->getMessage() . "<br>";
    }
} else {
    // debug
    echo "invalid request method.<br>";

}

function generate_unique_poll_id($connect) {
    do {
        $poll_id = rand(10000, 99999);
        $statement = $connect->prepare("SELECT COUNT(*) FROM polls WHERE id = :poll_id");
        $statement->execute(['id' => $poll_id]);
        $count = $statement->fetchColumn();
    } while ($count > 0);

    return $poll_id;
}

$unique_poll_id = generate_unique_poll_id($connect);

?>
