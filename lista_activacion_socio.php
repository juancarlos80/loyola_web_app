<?php
require_once 'config/database.php';

session_name("loyola");
session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
  die();
}
$usuario = $_SESSION['usuario'];

$texto="";
$where_texto = "";
if( isset( $_GET['texto'] ) ){
  $texto = $_GET['texto']; 
  //Escapar aqui los caracteres del texto 
  $where_texto = " AND(  LOWER(last_name_1) LIKE LOWER('%$texto%') OR"
          . " LOWER(last_name_2) LIKE LOWER('%$texto%') OR LOWER(verification_code) LIKE LOWER('%$texto%') OR LOWER(id_number) LIKE LOWER('%$texto%') ) ";
}
$estado = "para verificacion";
if(isset($_GET["estado"])){
  $estado = $_GET["estado"];
}

$pagina_actual = 0;
if( isset($_GET["pagina_actual"]) ){
  $pagina_actual = $_GET["pagina_actual"];
}
$items_x_pagina = 7;

$total_items = ORM::for_table('user')
        ->raw_query(
        " SELECT count(id) total ".
        " FROM user ".
        " WHERE  state= '".$estado."' ".        
        $where_texto)
        ->find_one();

$total_items = $total_items->total;

$socios = ORM::for_table('user')
        ->raw_query(
        " SELECT * ".
        " FROM  user ".
        " WHERE state = '".$estado."' ".
        $where_texto.
        " ORDER BY created_at desc ".
        " LIMIT ".($pagina_actual*$items_x_pagina).", $items_x_pagina")
        ->find_many();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/logo.png" />
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">  
    <link href="css/style.css?v=1.3" media="screen" rel="stylesheet" type="text/css" />

    <script src="js/libs/jquery-3.3.1.min.js"></script>     
    <script src="bootstrap/js/bootstrap.min.js"></script>            
    <script src="js/lista_activacion_socio.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {        
        iniciar();                                    
      });            
    </script>
    <title>Cooperativa LOYOLA</title>
  </head>
  <body>
    <div class="container-fluid">
      <?php $home = true;
      include ("cabecera.php");?>
      <div class="fondo_app">  
        <div class="container">
          <div class="buscador">
            <select id="filtro_estado" class="form-control tm_select left">
              <option value="para verificacion" <?="para verificacion"==$estado?"selected":""?>>Para Verificación </option>  
              <option value="activo" <?="activo"==$estado?"selected":""?>>Activo </option>  
              <option value="inactivo" <?="inactivo"==$estado?"selected":""?>>Inactivo </option>  
            </select>
            <input type="text" id="buscar_texto" class="form-control css_text left" placeholder="Nombre Socio, Código Socio, CI" value="<?=isset($_GET['texto'])?$_GET['texto']:""?>">
            <img src="img/ico_buscar.png" id="btn_buscar" class="pointer">
          </div>
          <div class="clearfix"></div>
          <div class="margen"></div>
          <div class="contenedor_datos">
            <div class="row bg_cabecera_row">
              <div class="col-1">Nro</div>
              <div class="col">Código</div>
              <div class="col">Fecha Activación</div>
              <div class="col-3">Nombre Socio</div>
              <div class="col">Acción</div>
            </div>
            <?php 
            if($socios != null){
              $index = 1 + ($pagina_actual*$items_x_pagina);
            foreach($socios as $socio){ ?>
            <div class="row bg_col_row">
              <div class="col-1"><?=$index ++?></div>
              <div class="col"><?=$socio->verification_code?></div>
              <div class="col"><?=$socio->created_at?> </div>
              <div class="col-3"><?=$socio->names." ".$socio->last_name_1." ".$socio->last_name_2?></div>
              <div class="col">
                <a href="detalle_activacion_socio.php?id_socio=<?=$socio->id?>">
                  <img src="img/ico_revisar.png"><span class="font_accion"> <?=$socio->state != "activo"?" Revizar":" Ver Detalles"?></span>
                </a>
              </div>
            </div>
            <?php }
            } else {
              echo "En este momento no existe usuarios registrados";
            } ?>
            <div class="margen_inf"></div>
            <?php
            include("paginacion.php");
            ?>
          </div>
        </div>
      </div>
   </div>
  </body>
</html>