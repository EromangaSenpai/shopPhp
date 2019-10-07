<?php
if(!isset($_SESSION))
    session_start();

require 'db.php';


if (!R::testConnection())
    exit ('Нет соединения с базой данных');

if(!isset($_SESSION['key']))
{
    $user = R::findOne('users', 'email = ?', array($_POST['email']));
    if($user)
    {
        if(password_verify($_POST['password'], $user->password)):
            $_SESSION['key'] = 'true';
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['name'] = $user->name;
            header("Location: ../MainPage.php".'?'.session_name().'='.session_id());
        else:
            $errors[] = 'Password was incorrect';
            header("Location: ../MainPage.php");
        endif;
    }
    else
    {
        $errors[] = 'Account doesn&apos;t exist';
        header("Location: ../MainPage.php");
    }
}
