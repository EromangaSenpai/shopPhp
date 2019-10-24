<?php
session_start();
require_once 'db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

$subscribers = R::Dispense('subscribers');
$subscribers->email = $_POST['email'];
R::store($subscribers);
header('Location: ../product_php.php')

?>