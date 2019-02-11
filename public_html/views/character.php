<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db/dbConnection.php';
include '../php/functions.php';



if(empty($_GET["characterSlug"])){
    header('HTTP/1.0 404 Not Found');
    header('Location: /404/');
    die;
}

$characterSlug=$_GET["characterSlug"];
$sql="SELECT idCharacter, nameCharacter, slugCharacter FROM tb_Characters WHERE slugCharacter='$characterSlug'";
$result = $conn->query($sql);
$row= $result->fetch_assoc();



if($conn->affected_rows == 0) {
    header('HTTP/1.0 404 Not Found');
    header('Location: /404/');
    die;
}

echo '<br>';
echo '<br>';
echo $characterSlug;
//echo $idImage;


?>