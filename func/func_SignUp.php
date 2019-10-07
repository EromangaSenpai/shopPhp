<?php
//Little check
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Get data info about already existed users
function GetData($path)
{
    static $final_str = "";
    $file = fopen($path, 'r') or die("Не удалось открыть файл. Скорее всего путь к файлу задан не верно или его не существет.");

    while(!feof($file))
    {
        $str = fgets($file);
        $final_str .= $str . " ";
    }
    fclose($file);
    $arr = explode(" ", $final_str);
    $final_str = "";
    return $arr;


}

//Write new user
function WriteData($path, $data)
{
    $file = fopen($path, 'a') or die("Не удалось открыть файл. Скорее всего путь к файлу задан не верно или его не существет.");
    fwrite($file, $data);
    fclose($file);
}
?>