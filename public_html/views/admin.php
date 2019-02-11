<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db/dbConnection.php';
include '../php/functions.php';

$userType=$_SESSION["user"]["userType"];

if($userType=="admin"){
    //header('HTTP/1.0 404 Not Found');
    //header('Location: /404/');
    //die;
    echo 'you are an admin';
}else{
    echo 'xo xo normie';
}


?>