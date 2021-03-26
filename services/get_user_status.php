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
        ->find_one();            
} else {
  if( isset($data_json->email) ){
    $user = ORM::for_table("user")
          ->where("email", $data_json->email)
          ->find_one();   
  }
}

if( $user == null ){
  die ( json_encode(array(
    "success" => false,
    "reason" => "No se encuentra el usuario registrado a verificar estado"    
  )));
}

$activates_user = ORM::for_table("activate_user")
        ->where("user_id", $user->id)
        ->order_by_desc("created_at")
        ->find_array();

$user_status = null;
if( count($activates_user) > 0 ){
  $user_status = $activates_user[0];
}


die (json_encode(array(
    "success" => true,
    "user_status" => $user_status
)));