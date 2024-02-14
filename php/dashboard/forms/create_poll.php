<!-- location - /eranei.com/php/dashboard/forms/create_poll.php -->
<br>
<div class="container">
    <h2 class="text-center">create poll</h2>
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-group" action="/php/dashboard/functions/submit_poll.php" method="post">
                <div class="form-group">
                    <label for="question">question:</label>
                    <input type="text" name="question" class="form-control" placeholder="enter your question" required />
                </div>
                <div class="form-group">
                    <label for="options">options (separated by commas):</label>
                    <input type="text" class="form-control" name="options" id="options" placeholder="option 1, option 2, option 3, option 4" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-style">create</button>
                </div>
            </form>
        </div>
    </div>
</div>
