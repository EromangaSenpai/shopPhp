<?php
if (!isset($_SESSION))
    session_start();

require 'phpScripts/db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

if(isset($_SESSION['key'])) {

}

else
{
    header("Location: 403.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin-pages.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <title>Admin Page</title>

</head>
<body class="background3" style="height: 140vh">

<div id="navbar">
    <a href="CreateProductPage.php" class="text-light">Create</a>
    <a href="ProductPage.php" class="text-light">Update</a>
    <a href="DeleteProductPage.php" class="text-light">Delete</a>
    <a href="#" class="text-light">Mail</a>
    <a style="float: right" class="text-light" href="MainPage.php">Go back</a>
    <!-- Small button groups (default and split) -->

</div>

<div class="container" style="margin-top: 80px">
    <?php if(isset($_SESSION['mailAlert'])): echo $_SESSION['mailAlert']; unset($_SESSION['mailAlert']); endif;?>
    <h2 class="text-center text-light">Send Message</h2>
    <form method="post" action="phpScripts/Mail.php">

        <div class="row form-group">
            <div class="col-sm-12">
                <label for="subject" class="text-light">Subject:</label>
                <input value="" type="text" maxlength="50" name="subject" class="form-control" id="subject" placeholder="Subject" required>
            </div>
        </div>
        <div class="form-group">
            <label for="msg" class="text-light">Message:</label>
            <textarea maxlength="1000" name="msg" class="form-control" id="msg" rows="10" placeholder="Text" required></textarea>
        </div>

        <hr>
        <div class="form-row justify-content-around form-group">
            <button type="reset" class="col-3 btn btn-danger" name="reset">Reset</button>
            <button type="submit" class="col-3 btn btn-success" name="add">Send</button>
        </div>

    </form>


</div>

<script>
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("navbar").style.top = "0";
        } else {
            document.getElementById("navbar").style.top = "-55px";
        }
        prevScrollpos = currentScrollPos;
    }
</script>

</body>
</html>


