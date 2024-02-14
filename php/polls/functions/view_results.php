<?php
// location - /eranei.com/php/polls/functions/view_results.php
session_start();
require_once("/eranei.com/php/auth/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: /php/auth/login.php");
    exit();
}

$poll_id = intval($_GET['id']);

// fetch poll details
$statement_poll = $connect->prepare("SELECT * FROM polls WHERE id = :poll_id");
$statement_poll->execute(['poll_id' => $poll_id]);
$poll = $statement_poll->fetch(PDO::FETCH_ASSOC);

// fetch poll options
$statement_options = $connect->prepare("SELECT * FROM poll_options WHERE poll_id = :poll_id");
$statement_options->execute(['poll_id' => $poll_id]);
$options = $statement_options->fetchAll(PDO::FETCH_ASSOC);

// calculate total votes
$total_votes = 0;
foreach ($options as $option) {
    $total_votes += $option['votes'];
}

// fetch the user's previously submitted vote
$query_user_vote = "SELECT option_id FROM user_votes WHERE user_id = :user_id AND poll_id = :poll_id";
$statement_user_vote = $connect->prepare($query_user_vote);
$statement_user_vote->execute(['user_id' => $_SESSION['user_id'], 'poll_id' => $poll_id]);
$user_vote = $statement_user_vote->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2><?= htmlspecialchars($poll['title']) ?></h2>
    <ul class="list-group">
        <?php foreach ($options as $option) : ?>
            <?php
            $percentage = $total_votes > 0 ? round(($option['votes'] / $total_votes) * 100, 2) : 0;
            $voted = $user_vote && $user_vote['option_id'] == $option['id'];
            $plurality = ($option['votes'] == 1) ? 'vote' : 'votes';
            ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="mr-1"><?= htmlspecialchars($option['name']) ?></span>
            <span class="badge badge-style badge-pill mr-2"><?= $option['votes'] . ' ' . $plurality ?></span>
            </div>

            <div class="d-flex align-items-center mb-3">
                <div class="progress" style="flex-grow: 1;">
                    <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"><?= $percentage ?>%</div>
                </div>
            </div>
        <?php endforeach; ?>
    </ul>
    <p class="text-right">total votes: <?= $total_votes ?></p>
</div>
