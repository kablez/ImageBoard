<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db/dbConnection.php';
include 'functions.php';


$userName="";
$password="";
$mensagemErro="";

//verificar input email
if (empty($_POST["inputUsernameLogin"])) {
    $mensagemErro .= "<li>Username não inserido</<li>";
} else {
    $userName = utf8_decode($conn->real_escape_string($_POST["inputUsernameLogin"]));
}
if (empty($_POST["inputPasswordLogin"])){
    $mensagemErro .="<li>Password não inserida</li>";
} else {
    $password = utf8_decode($conn->real_escape_string($_POST["inputPasswordLogin"]));
}

$sql="SELECT * FROM tb_Users WHERE username = '".$userName."' AND passwordUser = SHA1('".$password."')";
$result = $conn->query($sql);
$row= $result->fetch_assoc();

//em caso de erro devolve os erros atraves de uma variavel de sessão e em caso de sucesso guarda o id e o nome em variaveis de sessão e dirige-se para o home
if($conn->affected_rows == 0) {
    $mensagemErro .="<li>Esse username ou password estão incorretos.</li>";
}


if(empty($mensagemErro)){

    $userInfo = array(
        "idUser"=>$row["idUser"], 
        "username"=>$row["username"], 
        "emailUser"=>$row["emailUser"],
        "avatarUser"=>$row["avatarUser"], 
        "userType"=>$row["userType"], 
        "birthdayUser"=>$row["birthdayUser"]
    );


    $_SESSION["user"] = $userInfo;
    echo json_encode(['code'=>200, 'msg'=>'Sucess']);
    exit;
}

echo json_encode(['code'=>404, 'msg'=>$mensagemErro]);
exit;
?>