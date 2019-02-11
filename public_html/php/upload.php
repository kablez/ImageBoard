<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../db/dbConnection.php');
$target_dir = "../gallery/";
$target_dirThumb = "../gallery/thumb/";
include '../php/functions.php';
include './generateThumbnail.php';

if(empty($_POST["artistRadio"]) || empty($_POST["tagCheckbox"]) || empty($_POST["sourceCheckbox"]) || empty($_POST["characterCheckbox"])){
    echo json_encode(['code'=>404, 'msgError'=>'Preencha todos os campos.']);
    return;
}else{
    $artist=$conn->real_escape_string($_POST["artistRadio"]);
    $tags=$_POST["tagCheckbox"];
    $sources=$_POST["sourceCheckbox"];
    $characters=$_POST["characterCheckbox"];
}

if(getCurrentUserId()==0){
    exit;
}

$userId=getCurrentUserId();
$error="";

//push tags to array
$allTags=array();
foreach ($tags as $tag){ 
    array_push($allTags, $tag);
}

//push sources to array
$allSources=array();
foreach ($sources as $source){ 
    array_push($allSources, $source);
}

//push sources to array
$allCharacters=array();
foreach ($characters as $character){ 
    array_push($allCharacters, $character);
}

//verificar se alguma imagem foi carregada
if ((empty($_FILES['imageUpload']['tmp_name'])) ) {
    $error .= "<li>Image not Uploaded.</<li>";
}else{
    $imageFileType = strtolower(pathinfo(basename($_FILES["imageUpload"]["name"]),PATHINFO_EXTENSION));
    //verificar se o ficheiro corresponde aos formatos jpg, png, jpeg e gif
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $error .= "<li>You can only Upload Images.</<li>";
    }else{
        //verificar dimensoes
        $file = $_FILES["imageUpload"]['tmp_name'];
        list($width, $height, $type, $attr) = getimagesize($file);
        if(($width > "3000" || $height > "3000")) {
            $error .= "<li>The Image must not be bigger than 3000x3000</<li>";
        }
        //verificar tamanho do ficheiro
        if ($_FILES["imageUpload"]["size"] > 3048576) {
            $error .= "<li>You can't upload pictures with more than 1MB./<li>";
        }
    }       
    
}

//se houver erros devolve-los. Se n houver criar conta.
if(empty($error)){

    $sql="INSERT INTO tb_Images (idUploader,idArtist,height,width,rating,category) VALUES ($userId,$artist,$height,$width,'Cute','Anime')";
    $conn->query($sql) or die($conn->error);
    $idImagem = mysqli_insert_id($conn);
    
    //Comando sql pra dar update ao path da imagem
    $path=$idImagem.'.'.$imageFileType;
    $pathThumb=$idImagem.'t.'.$imageFileType;
    $sql="UPDATE tb_Images SET imagePath='$path', imagePathThumb='$pathThumb' WHERE idImage='$idImagem';";

    //Comando sql das tags
    $sql.="INSERT INTO tb_Images_Tags_Rel(idImage,idTag) VALUES ";
    foreach($allTags as $tag) {
        $sql.="($idImagem,$tag),";
    }
    //remover virgula
    $sql=substr($sql, 0, -1);
    $sql.=";";

    //Comando sql das Sources
    $sql.="INSERT INTO tb_Images_Sources_Rel(idImage,idSource) VALUES ";
    foreach($allSources as $source) {
        $sql.="($idImagem,$source),";
    }
    //remover virgula
    $sql=substr($sql, 0, -1);
    $sql.=";";

    //Comando sql das Characters
    $sql.="INSERT INTO tb_Images_Characters_Rel(idImage,idCharacter) VALUES ";
    foreach($allCharacters as $character) {
        $sql.="($idImagem,$character),";
    }
    //remover virgula
    $sql=substr($sql, 0, -1);
    $sql.=";";

    

    //mover a imagem de upload pra a pasta gallery
    $target_file = $target_dir .$idImagem.'.'.$imageFileType;
    $target_fileThumb = $target_dirThumb .$idImagem.'t.'.$imageFileType;
    move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);

    createThumbnail($target_file,$target_fileThumb, 150);

    

    $conn->query($sql) or die($conn->error);

    echo json_encode(['code'=>200, 'msg'=>$sql]);
}else{
    echo json_encode(['code'=>404, 'msgError'=>$error]);
}
exit;
?>