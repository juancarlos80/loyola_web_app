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