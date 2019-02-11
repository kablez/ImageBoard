<?php
define('notAllowed', true);
include './php/functions.php';
include 'db/dbConnection.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ImageBoard</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="https://weebguy1test.000webhostapp.com/css/style.css">

    </head>
<body>

    <?php
        if(getCurrentUserId()==0){
            include './menus/menuLoggedOff.php';
        }
        else{
            include './menus/menuLoggedIn.php';
        }
        ?>
        <section class="leftSection">
            <a class="menuOption" href="https://weebguy1test.000webhostapp.com/">New</a><br>
            <a class="menuOption" href="https://weebguy1test.000webhostapp.com/">Popular Today</a><br>
            <a class="menuOption" href="https://weebguy1test.000webhostapp.com/">You Favorite Artists</a><br>
        </section>

        <section class="middleSection">
            <?php
            $sql="SELECT * FROM tb_Images";
            $result = $conn->query($sql) or die($conn->error);
            while ($row = $result->fetch_assoc()) {
            $pathThumb=$row["imagePathThumb"];
            $idImage=$row["idImage"];
                


            ?>
                    <a href="<?php echo HOMEURL.'/g/'.$idImage.'/' ?>"><img src="<?php echo HOMEURL.'/gallery/thumb/'.$pathThumb;?>"></a>
                    <br>
            <?php
            }
            ?>
        </section>
    

</body>
</html>