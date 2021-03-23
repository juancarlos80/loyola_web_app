<?php
//require_once '../config/database.php';

//session_name("LoyolaSocio");
//session_start();



$request_body = file_get_contents('php://input');
$data_json = json_decode($request_body);


die ( json_encode(array(
"success" => true,
"data" => $data_json    
)));
