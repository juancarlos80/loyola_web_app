function iniciar(){
  $(".font_opt_menu").removeClass("opc_seleccionado")
  $("#act_socio").addClass("opc_seleccionado");
  $("#div_cargando").fadeOut();   

  $("#btn_activar").click(function() {
    $('#texto_mensaje').html("¿Seguro que desea activar al socio: "+$("#socio").val());
    $('#mensaje_form').fadeIn('slow');
    $(".btn_confirmacion").fadeIn();
    $('#fondo_pop').fadeIn();
    /*actualizar_estado(estado="activo");*/
  });
  
  $("#btn_rechazar").click(function() { 
    if($("#observacion").val() != "" ) {
      $("#div_cargando").fadeIn();
      activar_socio(estado ="inactivo");
    } else { 
      $('#texto_mensaje').html("Explique por favor el motivo del rechazo en el campo observación");
      $('#mensaje_form').fadeIn('slow');
      $('#fondo_pop').fadeIn();
    }
  });
  
  $("#btn_confirmar").click(function () {       
    $("#div_cargando").fadeIn();
    activar_socio(estado ="activo");
  });
  
  $("#btn_cerrar,#btn_cancelar").click(function () {       
    $('#mensaje_form').fadeOut();
    $('#fondo_pop').fadeOut();
  }); 
  
  $(".btn_volver").click(function () {       
    $("#div_cargando").fadeIn();
    if($("#estado_socio").val() === "activo" ){ 
      window.location.href = "lista_activacion_socio.php?estado=activo";
    } else {
      window.location.href = "lista_activacion_socio.php?estado=para verificacion";
    }
  });
}
  
  function activar_socio(estado){      
    var data = {
      id_socio: $("#id_socio").val(),
      estado: estado
    } 
    if($("#observacion").val() != ""){
      data.observacion = $("#observacion").val();
    }
    fetch('services/set_activacion_socio.php',  {
      method: 'POST',
      credentials: 'same-origin',
      body: JSON.stringify(data),
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(function(response) {      
      return response.json();
    })
    .then(function(response) {            
      if( response.success ){
        window.location.href = "lista_activacion_socio.php"        
      } else {               
        $("#div_cargando").fadeOut();
        if( response.reason ){
          mostrar_alerta( response.reason );
        } else {
          $('#texto_mensaje').html("No se pudo activar el usuario, intenta nuevamente por favor");
          $('#mensaje_form').fadeIn('slow');
          $('#fondo_pop').fadeIn();
        }
      }
    })
    .catch( function(error){      
      console.error(error);
      $("#div_cargando").fadeOut();
      $('#texto_mensaje').html("Ocurrio un problema con el servidor, intentelo nuevamente por favor");
      $('#mensaje_form').fadeIn('slow');
      $('#fondo_pop').fadeIn();
    });
}