<?php
session_start();
require_once 'db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

$query = 'WHERE ';
$count = count($_POST['filterCheckBox']);
$checkBoxArr = $_POST['filterCheckBox'];
$allGoods = R::findAll('goods');

for ($i = 0; $i < $count; $i++)
{
    if($i != $count - 1)
    {
        $query .= "firmname='$checkBoxArr[$i]' OR ";
    }
    else
    {
        $query.= "firmname='$checkBoxArr[$i]'";
    }
}

$goods = R::findAll('goods', $query);

//setcookie('goods', $goods, time() + (86400 * 30), '/');
header("Location: ../SortedPage.php?sortedArr=$goods");