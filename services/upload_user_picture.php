<?php
require_once '../config/database.php';

session_name(APP_NAME);
session_start();

//first confirming that we have the image and tags in the request parameter
if( !isset($_FILES['imageFile']['name'])){
  die( json_encode(array(
      "success" => false,
      "reason" => "No se envio la foto"
  )));  
}

if( !isset($_POST["type_photo"]) ){
  die( json_encode(array(
      "success" => false,
      "reason" => "No se envio el tipo de foto"
  )));  
}
$type = $_POST["type_photo"];
  /*echo json_encode(array(
      "success" => true,
      "name" => $_FILES['imageFile']['name'],
      "email" => $_POST['email']
  ));
  die();*/
  
$user = null;  
if( isset($_POST["oauth_uid"]) ){
  $user = ORM::for_table("user")
          ->where("oauth_uid", $_POST["oauth_uid"])
          ->find_one();  
} else {
  if( isset($_POST["email"]) ){
    $user = ORM::for_table("user")
            ->where("email", $_POST["email"])
            ->find_one();  
  }
}

if( $user == null ){
  die( json_encode(array(
      "success" => false,
      "reason" => "No se encontro el usuario para subir su foto"
  )));  
}
  

$directorio = "/uploads/".$user->id."/";        
    
if( !file_exists( "../".$directorio) ){
    if(!mkdir("../".$directorio, 0777, true)) {
        echo json_encode(array(
            "success" => false,
            "reason" => "Fallo al crear el directorio para las fotografias"
        ));
        die();
    }
}

$tempFile = $_FILES['imageFile']['tmp_name'] ;          
$targetFile =  "..\\".str_replace("/", "\\",$directorio.$_FILES['imageFile']['name']); 

if( !move_uploaded_file($tempFile, $targetFile) ){
  die( json_encode(array(
        "success" => false,
        "reason" => "No se pudo guardar la fotografia en el servidor ".$tempFile
  )));
}

//Guardamos la referencia en la bd
if( $type == "picture_1"){
  $user->picture_id_1 = $_FILES['imageFile']['name'];
}
if( $type == "picture_2"){
  $user->picture_id_2 = $_FILES['imageFile']['name'];
}
if( $type == "selfie"){
  $user->selfie = $_FILES['imageFile']['name'];
}

if( !$user->save() ){
  die( json_encode(array(
        "success" => false,
        "reason" => "No se pudo guardar lo datos de la foto del usuario"
  )));
}
  
die( json_encode(array(
    "success" => true    
)));
        
?>