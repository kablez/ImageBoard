<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db/dbConnection.php';
include '../php/functions.php';

if(empty($_GET["artist"])){
    header('HTTP/1.0 404 Not Found');
    header('Location: /404/');
    die;
}

$idArtist=$_GET["artist"];
$sql="SELECT * FROM tb_Artist WHERE idArtist='$idArtist'";
$result = $conn->query($sql);
$row= $result->fetch_assoc();



if($conn->affected_rows == 0) {
    header('HTTP/1.0 404 Not Found');
    header('Location: /404/');
    die;
}

$name=$row["nameArtist"];

?>
<!DOCTYPE html>
<html>
    <head>
        <title>ImageBoard</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    </head>
<body>

<?php

?>
<div class="container">
    <?php
        if(getCurrentUserId()==0){
            include '../menus/menuLoggedOff.php';
        }
        else{
            include '../menus/menuLoggedIn.php';
        }
        
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo $name;
        
    ?>
    
</div>

</body>
</html>