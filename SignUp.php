<?php
session_start();
require_once "func/func_SignUp.php";
require 'phpScripts/db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

$nameErr = $surnameErr = $emailErr = $passwordErr = $dateErr = "";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (empty($_POST['name']))
    {
        $nameErr = 'Name is required';
    }
    else
    {
        $_POST['name'] = test_input($_POST['name']);
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST['name']))
        {
            $nameErr = 'Only letters and white space allowed';
        }
    }


    if (empty($_POST['surname']))
    {
        $surnameErr = 'Surname is required';
    }
    else
    {
        $_POST['surname'] = test_input($_POST['surname']);
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST['surname']))
        {
            $surnameErr = 'Only letters and white space allowed';
        }
    }


    if (empty($_POST['email']))
    {
        $emailErr = 'Email is required';
    }

    else
    {
        $_POST['email'] = test_input($_POST['email']);
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $emailErr = 'Invalid email format';
        }
        elseif(R::count('users', 'email = ?', array($_POST['email'])) > 0)
        {
            $emailErr = 'Email already registered';
        }
    }


    if(empty($_POST['pwd']))
    {
        $passwordErr = 'Password is required';
    }
    else
    {
        $_POST['pwd'] = strip_tags($_POST['pwd']);
        if (!preg_match("^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])\S*$^", $_POST['pwd']))
        {
             $passwordErr = 'Password must have at least 6 characters and one title character';
        }
    }


    if (empty($_POST['date']))
    {
        $dateErr = 'Date is required';
    }

    //User Registration
    if($nameErr == '' && $surnameErr == '' && $emailErr == '' && $passwordErr == '' && $dateErr == '')
    {
            $user = R::dispense('users');
            $user->name = $_POST['name'];
            $user->surname = $_POST['surname'];
            $user->date = $_POST['date'];
            $user->email = $_POST['email'];
            $user->password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
            $user->root = 'user';
            R::store($user);
            $_SESSION['key'] = 'true';
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            header('Location: MainPage.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <h2>Sign Up</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" value="<?php echo @$_POST['name'] ?>">
            <p class="text-danger"><?php echo $nameErr;?></p>
        </div>
        <div class="form-group">
            <label for="surname">Surname:</label>
            <input type="text" class="form-control" placeholder="Enter surname" name="surname" id="surname" value="<?php echo @$_POST['surname'] ?>">
            <p class="text-danger"><?php echo $surnameErr;?></p>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" name="date" id="date" value="<?php echo @$_POST['date'] ?>">
            <p class="text-danger"><?php echo $dateErr;?></p>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo @$_POST['email'] ?>">
            <p class="text-danger"><?php echo $emailErr;?></p>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
            <p class="text-danger"><?php echo $passwordErr;?></p>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>

</body>
</html>
