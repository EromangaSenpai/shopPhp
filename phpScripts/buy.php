<?php
session_start();
require_once 'db.php';
if($_SESSION['key'])
{
    $cartArr = explode('/', $_SESSION['savesId']);
    for($i = 0; $i < count($cartArr); $i++)
    {
        $item = R::load('goods', (int)$cartArr[$i]);
        if($item->amount > 0)
        {
            $item->amount -= 1;
        }
        R::store($item);
    }
    $_SESSION['id'] = '';

    unset($_SESSION['savingCart']);
    unset($_SESSION['count']);
    unset($_SESSION['savesId']);
    header('Location: ../MainPage.php');
}
else
    header('Location: ../MainPage.php');
