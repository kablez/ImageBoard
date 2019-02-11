<?php
include '../php/functions.php';

?>

<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<title>Social - Login</title>
</head>
<body>

<?php
    include '../menus/menuLoggedOff.php';
?>
<form id="loginForm" enctype="multipart/form-data">
    <label class="lbSignUp">UserName</label>
    <input type="text" name="inputUsernameLogin">
    <label class="lbSignUp">Password</label>
    <input type="password" name="inputPasswordLogin">
    <input type="submit" value="Login">
</form>

<?php

?>
</body>
</html>

<script>
$("form#loginForm").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);
    this.reset();
    $.ajax({
        url: "https://weebguy1test.000webhostapp.com/php/login.php",
        type: 'POST',
        data: formData,
        success: function (response) {
                try{
                    data = JSON.parse(response);
                    //receber o codigo
                    if (data.code == "200"){
                        //alert(data.msg);
                        window.location="https://weebguy1test.000webhostapp.com/";
                    } else {
                        
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