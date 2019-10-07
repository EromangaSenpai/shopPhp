<?php
session_start();
if ( session_id() ) {
    // Если есть активная сессия, удаляем куки сессии,
    setcookie(session_name(), session_id(), time()-60*60*24);
    // и уничтожаем сессию
    session_unset();
    session_destroy();
    header('Location: ../MainPage.php');
}
?>