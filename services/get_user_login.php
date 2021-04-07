<?php
require_once '../config/database.php';
require_once '../config/configure.php';

session_name(APP_NAME);
session_start();

$request_body = file_get_contents('php://input');
$data_json = json_decode($request_body);

//Obtenemos el usuario en funcion a los parametros enviados

$user = null;
if( isset($data_json->oauth_uid) ){
  $user = ORM::for_table("user")
        ->where("oauth_uid", $data_json->oauth_uid)
        ->where_null("deleted_at")  
        ->find_one();            
} else {
  if( isset($data_json->email) && isset($data_json->password) ){
    $user = ORM::for_table("user")
          ->where("email", $data_json->email)
          ->where("password", $data_json->password)
          ->where_null("deleted_at")  
          ->find_one();   
  }
}

if( $user == null ){
  die ( json_encode(array(
    "success" => false,
    "reason" => "No se encuentra el usuario"    
  )));
} else {
  die (json_encode(array(
    "success" => true,
    "user" => $user->as_array()
  )));
}