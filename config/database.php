<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'idiorm.php';
define ('APP_NAME', "loyola_socios");

define ('HOST', "localhost");
define ('NAME_DB', "loyola_app");
define ('USER_DB', "root");
define ('PASSWD_DB', "");
define ('IS_LINUX', false);

define("SMTP_SERVER", false);
//Solo configurar los siguientes campos solo si el servidor es SMTP
define("SMTP_DEBUG", false); // solo usar true para pruebas de diagnstico 
define("SMTP_HOST", "");
define("SMTP_PORT", "");
define("SMTP_USER_NAME", "");
define("SMTP_PASSWORD", "");
define("SMTP_SECURE", "");//Valores posibles ssl y tls

define("NAME_SERVER","http://localhost/");
define("ROUTE_SERVER","loyola_socio/");
define("EMAIL_FROM", "no-reply@socioloyola.com");
define("EMAIL_FROM_NAME", "No responder");
define("EMAIL_SUBJECT", "Recuperar Contraseña");
define("EMAIL_CC", "");

date_default_timezone_set("America/La_Paz");

// Configuracion del servidor
/*define ('HOST', "localhost");
define ('NAME_DB', "quarks5_loyola_socio");
define ('USER_DB', "quarks5_loyola_socio");
define ('PASSWD_DB', "LoyolaSocio72718sy28.-");
define ('IS_LINUX', true); */


ORM::configure('mysql:host='.HOST.';dbname='.NAME_DB.';charset=utf8');
ORM::configure('username', USER_DB);
ORM::configure('password', PASSWD_DB);