<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db/dbConnection.php';
include '../php/functions.php';



if(empty($_GET["image"])){
    header('HTTP/1.0 404 Not Found');
    header('Location: /404/');
    die;
}

$idImage=$_GET["image"];
$sql="SELECT * FROM tb_Images image INNER JOIN tb_Artist artist on image.idArtist=artist.idArtist WHERE idImage='$idImage'";
$result = $conn->query($sql);
$row= $result->fetch_assoc();



if($conn->affected_rows == 0) {
    header('HTTP/1.0 404 Not Found');
    header('Location: /404/');
    die;
}

$path=$row["imagePath"];

//echo $idImage;




/*$tags=array();
while ($row = $result->fetch_assoc()) {
    $tag=array("idTag"=>$row["idTag"],"tagName"=>$row["tagName"],"tagSlug"=>$row["tagSlug"]);
    array_push($tags,$tag);
}*/



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
        echo '<img src="'.HOMEURL.'/gallery/'.$path.'">';
        echo '<br>';
        echo '<br>';
        echo '<a href="https://weebguy1test.000webhostapp.com/artist/'.$row["idArtist"].'/">'.$row["nameArtist"].'</a>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        $sql="SELECT * FROM tb_Tags tags INNER JOIN tb_Images_Tags_Rel imagesTagsRel ON tags.idTag=imagesTagsRel.idTag WHERE imagesTagsRel.idImage=$idImage";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $tagName=$row["tagName"];
            $tagSlug=$row["tagSlug"];
            echo '<a href="https://weebguy1test.000webhostapp.com/tag/'.$tagSlug.'/">'.$tagName.'</a>';
            echo '<br>';
        }

        echo '<br>';
        echo '<br>';
        echo '<br>';
        $sql="SELECT * FROM tb_Sources sources INNER JOIN tb_Images_Sources_Rel imagesSourcesRel ON sources.idSource=imagesSourcesRel.idSource WHERE imagesSourcesRel.idImage=$idImage";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo $row["nameSource"];
            echo '<br>';
        }

        echo '<br>';
        echo '<br>';
        echo '<br>';
        $sql="SELECT * FROM tb_Characters characters INNER JOIN tb_Images_Characters_Rel imagesCharactersRel ON characters.idCharacter=imagesCharactersRel.idCharacter WHERE imagesCharactersRel.idImage=$idImage";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo $row["nameCharacter"];
            echo '<br>';
        }

        
    ?>
    
</div>

</body>
</html>