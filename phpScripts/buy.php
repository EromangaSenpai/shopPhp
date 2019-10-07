<?php
session_start();
$cartArr = explode('/', $_SESSION['id']);
for($i = 0; $i < $cartArr.count(); $i++)
{
    $item = R::load('goods', (int)$cartArr[$i]);
    $item->amount -= 1;
}
$_SESSION['id'] = '';
