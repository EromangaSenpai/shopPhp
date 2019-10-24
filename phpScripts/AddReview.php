<?php
session_start();
require_once 'db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

    $review = R::Dispense('review');
    $review->productId = $_SESSION['productId'];
    $review->nickname = $_POST['nickname'];
    $review->text = $_POST['text'];
    $date = date('Y-m-d');
    $review->date = $date;
    R::store($review);
    header('Location: ../product_php.php')

?>