<?php
// location - /eranei.com/php/dashboard/forms/view_polls.php
session_start();
require_once("/eranei.com/php/auth/config.php");

$user_id = $_SESSION['user_id'];

// fetch polls for the user
$query_polls = "SELECT id, title, description FROM polls WHERE user_id = :user_id ORDER BY id ASC";
$statement_polls = $connect->prepare($query_polls);
$statement_polls->execute(['user_id' => $user_id]);
$polls = $statement_polls->fetchAll(PDO::FETCH_ASSOC);

// prepare the query for fetching poll options
$query_options = "SELECT name FROM poll_options WHERE poll_id = :poll_id ORDER BY id ASC";
$statement_options = $connect->prepare($query_options);
?>

<div class="row">
<link rel="stylesheet" href="/css/polls.css">
<?php foreach ($polls as $poll): ?>
    <?php
    // fetch options for the current poll
    $statement_options->execute(['poll_id' => $poll['id']]);
    $options = $statement_options->fetchAll(PDO::FETCH_ASSOC);
    ?>


    <div class='col-sm-6 col-md-4 col-lg-3 mb-4'>
        <div class='card'>
            <div class='card-body'>
                <h5 class='card-title'>
                    <a href='/php/polls/details.php?id=<?= htmlspecialchars($poll['id']) ?>' class='poll-card-link'>
                    <?= htmlspecialchars($poll['title']) ?>
                    &rarr;
                    </a>
                </h5>
                <hr>
                <ul class='list-group list-group-flush'>
                <?php foreach ($options as $option): ?>
                    <li class='list-group-item'><?= htmlspecialchars($option['name']) ?></li>
                <?php endforeach; ?>
                </ul>
                <hr>
                <button class='btn btn-scary mt-2' onclick='deletePoll(<?= htmlspecialchars($poll['id']) ?>)'>delete</button>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
