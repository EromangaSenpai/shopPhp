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
    $review->quality = $_POST['quality'];
    $review->price = $_POST['price'];
    $review->average = ($review->quality + $review->price) / 2;
    R::store($review);
    header('Location: ../product_php.php')

?>