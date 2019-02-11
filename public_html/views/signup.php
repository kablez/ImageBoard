<?php 
include '../php/functions.php';
if(isset($_SESSION["idUser"])){

}
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
<body>

<?php

?>
<div class="container">
    <form id="signUpForm" method="post" enctype="multipart/form-data">
        <label class="lbSignUp">Username</label>
        <input type="text" name="inputUserNameSignUp"><br><br>
        <label class="lbSignUp">Email</label>
        <input type="email" name="inputUserEmail"><br><br>
        <label class="lbSignUp">Password</label>
        <input type="password" name="inputUserPassword"><br><br>
        <label class="lbSignUp"> Repeat Password</label>
        <input type="password" name="inputUserPassowrd2"><br><br>
        <label class="lbSignUp">Birthday</label>
        <input type="text" placeholder="19/01/2000" maxlength="10" name="inputUserBirthday"><br><br>
        <label class="lbSignUp">What are you?</label><br>
        <label class="radio-inline"><input type="radio" value="Artist" name="typeUser">Artist</label> <br>
        <label class="radio-inline"><input checked type="radio" value="Viewer" name="typeUser">Viewer</label> <br>
        <label></label><br>
        <label class="lbSignUp">Avatar</label>
        <input type="file" name="inputAvatar" id="inputAvatar"  accept="image/*"><br><br>
        <input type="submit" value="Sign Up">
    </form>
</div>

</body>
</html>

<script>
$("#signUpForm").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);
    this.reset();
    $.ajax({    
        url: "https://weebguy1test.000webhostapp.com/php/signup.php",
        type: 'POST',
        data: formData,
        success: function (response) {
                try{
                    data = JSON.parse(response);
                    //receber o codigo
                    if (data.code == "200"){
                        console.log(data.msg);
                        window.location="https://weebguy1test.000webhostapp.com/";
                    } else {
                        console.log(data.msgError);
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
</script>