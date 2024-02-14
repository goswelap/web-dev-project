// location - /eranei.com/js/dashboard.js

$(document).ready(function() {
    loadViewPolls();

    $("#view-polls").on("click", function() {
        loadViewPolls();
    });

    $("#create-poll").on("click", function() {
        loadCreatePoll();
    });
});

function loadViewPolls() {
    $("#view-polls-container").load("/php/dashboard/forms/view_polls.php");
    $("#view-polls").addClass("active");
    $("#create-poll").removeClass("active");
    $("#create-poll-container").hide();
    $("#view-polls-container").show();
}

function loadCreatePoll() {
    $("#create-poll-container").load("/php/dashboard/forms/create_poll.php");
    $("#create-poll").addClass("active");
    $("#view-polls").removeClass("active");
    $("#view-polls-container").hide();
    $("#create-poll-container").show();
}

function deletePoll(poll_id) {
    if (confirm("are you sure you want to delete this poll?")) {
        $.ajax({
            url: "/php/dashboard/functions/delete_poll.php",
            type: "POST",
            data: { poll_id: poll_id },
            success: function(response) {
                if (response == "success") {
                    loadViewPolls();
                } else {
                    alert("did not receive 'success' response.");
                }
            },
            error: function() {
                alert("error deleting poll.");
            },
        });
    }
}

