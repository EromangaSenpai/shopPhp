<?php
session_start();
require_once 'db.php';
if(isset($_SESSION['key']))
{
    $item = R::load('goods' ,$_REQUEST['id']);
    $tableCell = "<tr>
                <td>$item->id</td>
                <td>$item->productname</td>
                <td>$item->firmname</td>
                <td>$item->type</td>
                <td>$item->price</td></tr>";
    if(!isset($_SESSION['savingCart']))
    {
        $_SESSION['savingCart'] = '';
        $_SESSION['count'] = 0;
        $_SESSION['savesId'] = '';
    }
    for ($i = 0; $i < (int)$_REQUEST['count']; $i++)
    {
        $_SESSION['savingCart'] .= $tableCell;
        $_SESSION['savesId'] .= $item->id.'/';
        echo $tableCell;
    }

    $tmp = $_SESSION['count'];
    (int)$tmpCounter = $_REQUEST['count'];
    (int)$tmp += intval($tmpCounter);
    $_SESSION['count'] = $tmp;


}