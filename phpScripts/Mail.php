<?php
session_start();
require_once 'db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

if($_SESSION['key'])
{
    $to = R::findAll('subscribers');
    $subject = $_POST['subject'];
    $message = $_POST['msg'];
    $headers = 'From: paladen4@gmail.com' . "\r\n" .
        'Reply-To: paladen4@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    foreach ($to->email as $item)
        mail($item, $subject, $message, $headers);

    $_SESSION['mailAlert'] = "<div class=\"alert alert-success alert-dismissible\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>Success!</strong> Mails was successfully added.
</div>";
    header('Location: ../SendMail.php');
}
else
{
    header('Location: ../403.php');
}