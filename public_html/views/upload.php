<?php
include '../php/functions.php';

if (getCurrentUserId()==0 ){
    header("Location:".HOMEURL.'/login/');
}

include '../db/dbConnection.php'

?>
<!DOCTYPE html>
<html>
    <head>
        <title>ImageBoard</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
<body>

<?php

?>
<div class="container">
    <?php
            include '../menus/menuLoggedIn.php';
            //https://codepen.io/rustybailey/pen/GJjvYB
            //https://codepen.io/valerypatorius/pen/oXGMGL/
            //https://codepen.io/duongld/pen/WbRyKJ?html-preprocessor=pug
    ?>
    <form id="uploadForm" enctype="multipart/form-data">
        <br>
        <label>Upload</label>
        <br>
        <label>Artist</label>
        <div class="searchArtist">
            <div class="form-input">
                <input class="keywordArtists" type="text">
            </div>

            <div id="radioArtists" class="radioArtists" style="background-color:red;">
                <ul>
                <?php
                    $sql="SELECT * FROM tb_Artist";
                    $result = $conn->query($sql) or die($conn->error);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <li>
                        <label>
                            <input type="radio" value="<?php echo $row["idArtist"];?>" name="artistRadio">
                            <?php echo $row["nameArtist"];?>
                        </label>
                    </li>
                    <?php
                    }
                ?>
                </ul>
            </div>
        </div>

        <label>Tags</label>
        <div class="searchTags">
            <div class="form-input">
                <input class="keywordTags" type="text">
            </div>
            <div id="checkboxTags" class="checkboxTags" style="background-color:red;">
                <ul>
                <?php
                    $sql="SELECT * FROM tb_Tags";
                    $result = $conn->query($sql) or die($conn->error);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <li>
                        <label>
                            <input type="checkbox" value="<?php echo $row["idTag"];?>" name="tagCheckbox[]">
                            <?php echo $row["tagName"];?>
                        </label>
                    </li>
                    <?php
                    }
                ?>
                </ul>
            </div>
        </div>


        <label>Source</label>
        <div class="searchSources">
            <div class="form-input">
                <input class="keywordSources" type="text">
            </div>
            <div id="checkboxSources" class="checkboxSources" style="background-color:red;">
                <ul>
                <?php
                    $sql="SELECT * FROM tb_Sources";
                    $result = $conn->query($sql) or die($conn->error);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <li>
                        <label>
                            <input type="checkbox" value="<?php echo $row["idSource"];?>" name="sourceCheckbox[]">
                            <?php echo $row["nameSource"];?>
                        </label>
                    </li>
                    <?php
                    }
                ?>
                </ul>
            </div>
        
        </div>

        <label>Charaters</label>
        <div class="searchCharaters">
            <div class="form-input">
                <input class="keywordSources" type="text">
            </div>
            <div id="checkboxSources" class="checkboxSources" style="background-color:red;">
                <ul>
                <?php
                    $sql="SELECT * FROM tb_Characters";
                    $result = $conn->query($sql) or die($conn->error);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <li>
                        <label>
                            <input type="checkbox" value="<?php echo $row["idCharacter"];?>" name="characterCheckbox[]">
                            <?php echo $row["nameCharacter"];?>
                        </label>
                    </li>
                    <?php
                    }
                ?>
                </ul>
            </div>
        </div>


        <input type="file" name="imageUpload" id="imageUpload"  accept="image/*"><br><br>            



        <input type="submit" value="Upload">
    </form>


</div>

</body>
</html>

<script>
$("form#uploadForm").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);
    this.reset();
    $.ajax({
        url: "https://weebguy1test.000webhostapp.com/php/upload.php",
        type: 'POST',
        data: formData,
        success: function (response) {
                try{
                    data = JSON.parse(response);
                    //receber o codigo
                    if (data.code == "200"){
                        console.log(data.msg);
                        //window.location="https://weebguy1test.000webhostapp.com/";
                    } else {
                        alert(data.msgError);
                    }
                }catch(e){
                    console.log(response+' // '+ e.message);
                }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


$( "#showArtists" ).click(function() {
    document.getElementById("checkboxArtists").style.display = "block";
});


$(".keywordArtists").on('keyup', function(e) {
var $this = $(this);
var exp = new RegExp($this.val(), 'i');
$(".radioArtists li label").each(function() {
    var $self = $(this);
    if(!exp.test($self.text())) {
    $self.parent().hide();
    } else {
    $self.parent().show();
    }
});
});

$(".keywordTags").on('keyup', function(e) {
var $this = $(this);
var exp = new RegExp($this.val(), 'i');
$(".checkboxTags li label").each(function() {
    var $self = $(this);
    if(!exp.test($self.text())) {
    $self.parent().hide();
    } else {
    $self.parent().show();
    }
});
});

$(".keywordSources").on('keyup', function(e) {
var $this = $(this);
var exp = new RegExp($this.val(), 'i');
$(".checkboxSources li label").each(function() {
    var $self = $(this);
    if(!exp.test($self.text())) {
    $self.parent().hide();
    } else {
    $self.parent().show();
    }
});
});


</script>