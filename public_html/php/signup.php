<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../db/dbConnection.php');
$target_dir = "../uploads/userAvatar/";

$userName=$conn->real_escape_string($_POST["inputUserNameSignUp"]);
$password=$conn->real_escape_string($_POST["inputUserPassword"]);
$password2=$conn->real_escape_string($_POST["inputUserPassowrd2"]);
$email=$conn->real_escape_string($_POST["inputUserEmail"]);
$birthday=$conn->real_escape_string($_POST["inputUserBirthday"]);
$typeUser=$conn->real_escape_string($_POST["typeUser"]);

$error="";
$avatarUploaded=false;

//Verificar Campos vazios
if(empty($userName) || empty($password) || empty($password2) || empty($email) || empty($birthday) ){
    $error="<li>Preencha todos os campos.</li>";
    echo json_encode(['code'=>404, 'msgError'=>$error]);
    exit;
}

//verificar se o tipo de User é valido
$userTypes = array("Uploader", "Artist", "Viewer");
if (!in_array($typeUser, $userTypes)){
    exit;
}
//verificar se o username ja existe na base de dados
$sql="SELECT username FROM tb_Users WHERE username = '".$userName."'";
$result = $conn->query($sql);
if($conn->affected_rows != 0) {
    $error .= "<li>That username is already being used.</<li>";
}

//verificar se as 2 passes sao iguais
if($password!=$password2){
    $error .= "<li>The passwords are not identical.</<li>";
}

//verificar se o email ja existe na base de dados
$sql="SELECT emailUser FROM tb_Users WHERE emailUser = '".$email."'";
$result = $conn->query($sql);
if($conn->affected_rows != 0) {
    $error .= "<li>That email is already being used.</<li>";
}

//verificar se a data é valida.
$pieces=explode("/",$birthday);
if(isset($pieces[0]) && isset($pieces[1]) && isset($pieces[2])){
    if( !(is_numeric ($pieces[0]))  || !(is_numeric ($pieces[1])) || !(is_numeric ($pieces[2])) ){
        $error.="<li>Invalid Birthday</li>";
    }elseif(!checkdate($pieces[1],$pieces[0],$pieces[2])){
        $error.="<li>Invalid Birthday</li>";
    }else{
        $birthday=$pieces[2]."/".$pieces[1]."/".$pieces[0];
    }
}
else{
    $error.="<li>Invalid Birthday</li>";
}


//verificar se alguma imagem foi carregada
if ( !(empty($_FILES['inputAvatar']['tmp_name'])) ) {
    $imageFileType = strtolower(pathinfo(basename($_FILES["inputAvatar"]["name"]),PATHINFO_EXTENSION));
    //verificar se o ficheiro corresponde aos formatos jpg, png, jpeg e gif
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $error .= "<li>You can only Upload Images.</<li>";
    }else{
        //verificar dimensoes
        $file = $_FILES["inputAvatar"]['tmp_name'];
        list($width, $height, $type, $attr) = getimagesize($file);
        if(($width > "1000" || $height > "1000")) {
            $error .= "<li>The Image must not be bigger than 1000x1000</<li>";
        }
        //verificar tamanho do ficheiro
        if ($_FILES["inputAvatar"]["size"] > 1048576) {
            $error .= "<li>You can't upload pictures with more than 1MB./<li>";
        }
        $avatarUploaded=true;
    }       
    
}


//se houver erros devolve-los. Se n houver criar conta.
if(empty($error)){
    $avatar=$userName.'.'.$imageFileType;
    $sql = "INSERT INTO tb_Users (username, passwordUser, emailUser, birthdayUser,avatarUser) VALUES('".$userName."',SHA1('".$password."'),'".$email."','".$birthday."','".$avatar."')";
    $conn->query($sql) or die($conn->error);

    //mover imagem carregada para a pasta uploads
    if($avatarUploaded){
        $target_file = $target_dir .$userName.'.'.$imageFileType;
        move_uploaded_file($_FILES["inputAvatar"]["tmp_name"], $target_file);
    }

    echo json_encode(['code'=>200, 'msg'=>'Sucess']);
}else{
    echo json_encode(['code'=>404, 'msgError'=>$error]);
}
exit;
?>