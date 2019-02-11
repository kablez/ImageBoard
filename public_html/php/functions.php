<?php
//incluir ficheiro com constantes
include 'constants.php';

if(!isset($_SESSION["user"])){
    session_start();
}

function getCurrentUserId(){
    if(isset($_SESSION["user"]["idUser"])){
        return $_SESSION["user"]["idUser"];
    }  
    return 0;  
}


function sanitize($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}
?>