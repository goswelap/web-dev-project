<?php
// location - /eranei.com/php/polls/forms/ballot.php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("/eranei.com/php/auth/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/auth/login.php");
    exit();
}

// get url params
$poll_id = $_GET['id'];

// fetch poll data
$query = $connect->prepare("SELECT * FROM polls WHERE id = ?");
$query->execute([$poll_id]);
$poll = $query->fetch();

if (!$poll) {
    echo "err: no poll with given ID";
    exit;
}

// fetch poll options
$query = $connect->prepare("SELECT * FROM poll_options WHERE poll_id = ?");
$query->execute([$poll_id]);
$options = $query->fetchAll();

if (!$options) {
    echo "err: no poll options for given poll ID.";
    exit();
}

$query = $connect->prepare("SELECT * FROM user_votes WHERE user_id = ? AND poll_id = ?");
$query->execute([$_SESSION['user_id'], $poll_id]);
$user_vote = $query->fetch();

if ($user_vote) {
    header("Location: /php/polls/forms/ballot_denied.php?id=" . $poll_id);
    exit();
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3><?= htmlspecialchars($poll['title'] ?? '') ?></h3>
        </div>
        <div class="card-body">
            <!-- <form action="/php/polls/functions/submit_ballot.php" method="post"> -->
            <form id="submit-ballot-form" method="post">
                <?php foreach ($options as $option): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="option" id="option-<?= $option['id'] ?>" value="<?= $option['id'] ?>">
                        <label class="form-check-label" for="option-<?= $option['id'] ?>"><?= htmlspecialchars($option['name']) ?></label>
                    </div>
                <?php endforeach; ?>
                <input type="hidden" name="poll_id" value="<?= $poll_id ?>">
                <button type="submit" class="btn btn-style mt-3">vote</button>
            </form>
        </div>
    </div>
</div>
