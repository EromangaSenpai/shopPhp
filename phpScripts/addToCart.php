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
                <td>$item->amount</td></tr>";
    if(!isset($_SESSION['savingCart']))
    {
        $_SESSION['savingCart'] = '';
        $_SESSION['count'] = '';
    }

    $_SESSION['savingCart'] .= $tableCell;
    (int)$_SESSION['count'] += 1;
    echo $tableCell;
}