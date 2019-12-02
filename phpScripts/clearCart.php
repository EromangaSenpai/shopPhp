<?php
session_start();
require_once 'db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['key'])
{
    unset($_SESSION['savingCart']);
    $_SESSION['count'] = 0;
    header('Location: ../MainPage.php');
}
else
    header('Location: ../MainPage.php');