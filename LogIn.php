<?php
// Contains GetData($path) function
if(!isset($_SESSION))
    session_start();
if(isset($_SESSION['key']))
    header('Location: MainPage.php'.'?'.session_name().'='.session_id());

require 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['email'] != '' && $_POST['pwd'] != '')
{
    $errors = array();
    $user = R::findOne('users', 'email = ?', array($_POST['email']));
    if($user)
    {
        if(password_verify($_POST['pwd'], $user->password)):
            $_SESSION["key"] = 'true';
            $_SESSION["user_login"] = $_POST["email"];
            $_SESSION["user_name"] = $user->name;
            $_SESSION["user_surname"] = $user->surname;
            $_SESSION["user_date"] = $user->date;
            $_SESSION["root"] = $user->root;
            header("Location: MainPage.php".'?'.session_name().'='.session_id());
        else:
            $errors[] = 'Password is incorrect';
        endif;
    }
    else
    {
        $errors[] = 'Account doesn&apos;t exist';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>

<div class="container" style="margin-top: 10px">
    <?php if (isset($_COOKIE['msg']))
    {
        echo $_COOKIE['msg'];
        //Delete cookie
        setcookie("msg", $_COOKIE['msg'], time()-3600, '/');
    }
    ?>

    <?php if(!empty($errors)):echo "<p class='text-danger'>".array_shift($errors)."</p><hr>";unset($errors); endif; ?>
    <h2>Log In</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
        <button type="submit" class="btn btn-success">Log In</button>
    </form>
    <a href="SignUp.php"><h2><small>Sign Up</small></h2></a>
</div>

</body>
</html>
