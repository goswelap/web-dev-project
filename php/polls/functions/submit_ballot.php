<?php
// location - /eranei.com/php/polls/functions/submit_ballot.php
session_start();
require_once("/eranei.com/php/auth/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/auth/login.php");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// changing to this soon just don't wanna break before submission

// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $option_id = $_POST['option'];
    $poll_id = $_POST['poll_id'];

    // insert vote into database
    $stmt = $connect->prepare('UPDATE poll_options SET votes = votes + 1 WHERE id = :option_id');
    $stmt->bindParam(':option_id', $option_id);
    $stmt->execute();

    $stmt = $connect->prepare('INSERT INTO user_votes (user_id, poll_id, option_id) VALUES (:user_id, :poll_id, :option_id)');
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->bindParam(':poll_id', $poll_id);
    $stmt->bindParam(':option_id', $option_id);
    $stmt->execute();

    header("Location: /php/polls/functions/view_results.php?id=$poll_id");

} else {

}
?>
