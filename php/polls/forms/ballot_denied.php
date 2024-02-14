<?php
// location - /eranei.com/php/polls/forms/ballot_denied.php
session_start();

require_once("/eranei.com/php/auth/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/auth/login.php");
    exit();
}

$poll_id = $_GET['id'];

// fetch poll details
$query = $connect->prepare("SELECT * FROM polls WHERE id = ?");
$query->execute([$poll_id]);
$poll = $query->fetch();

// $is_public = $poll['visibility'] == 'public';

// fetch poll options
$query = $connect->prepare("SELECT * FROM poll_options WHERE poll_id = ?");
$query->execute([$poll_id]);
$options = $query->fetchAll();

// check if user has voted
$query = $connect->prepare("SELECT * FROM user_votes WHERE user_id = ? AND poll_id = ?");
$query->execute([$_SESSION['user_id'], $poll_id]);
$has_voted = $query->fetch();
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3><?= htmlspecialchars($poll['title'] ?? '') ?></h3>
        </div>
        <div class="card-body">
            <!-- <form action="/php/polls/functions/submit_ballot.php" method="post"> -->
            <form>
                <?php foreach ($options as $option): ?>
                    <div class="form-check">
                    <label class="form-check-label" for="option-<?= $option['id'] ?>">
                        <?= htmlspecialchars($option['name']) ?>
                    </label>
                    </div>
                <?php endforeach; ?>
                <p style="color: red; font-style: italic; margin-bottom: 0rem;">you've already voted in this poll  -  <a href="#" id="view-results" onclick="loadResults()">view results</a></p>
            </form>
        </div>
    </div>
</div>
