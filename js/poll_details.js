// location - /eranei.com/js/poll_details.js

let pollID;
$(document).ready(function() {
    pollID = new URLSearchParams(window.location.search).get("id");

    $.ajax({
        type: "GET",
        url: "/php/polls/functions/submission_status.php",
        data: { id: pollID },
        success: function(voted) {
            console.log(voted);
            if (voted === "true") {
                loadResults();
            } else {
                loadBallot();
            }
        }
    });


    $("#view-vote").on("click", function() {
        loadBallot();
    });

    $("#view-results").on("click", function() {
        loadResults();
    });
});

$(document).on("submit", "#submit-ballot-form", function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/php/polls/functions/submit_ballot.php",
        data: $(this).serialize(),
        success: function() {
            loadResults();
        }
    });
});

function loadBallot() {
    $("#vote-container").load(`/php/polls/forms/ballot.php?id=${pollID}`, function(response, status, xhr) {
        if (status == "success") {
            console.log("vote content loaded");
        } else {
            console.error("error loading vote content");
            alert("couldn't retrieve ballot with given ID");
        }
    });
    $("#view-vote").addClass("active");
    $("#view-results").removeClass("active");
    $("#results-container").hide();
    $("#vote-container").show();
}

function loadResults() {
    $("#results-container").load(`/php/polls/functions/view_results.php?id=${pollID}`, function(response, status, xhr) {
        if (status == "success") {
            console.log("results loaded");
        } else {
            console.error("error loading results");
            alert("error loading results");
        }
    });
    $("#view-results").addClass("active");
    $("#view-vote").removeClass("active");
    $("#vote-container").hide();
    $("#results-container").show();
}
