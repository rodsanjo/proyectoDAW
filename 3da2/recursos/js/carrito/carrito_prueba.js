jQuery(document).ready(function() {
      $("#form_carrito_ajax").submit(function() {
        // debugger;
            jQuery.post(
                "/DAW/proyecto/3da2/carrito/meter_ajax" 
                ,jQuery("#form_ajax").serialize()
                ,function(data, textStatus, jqXHR) {
//                    debugger;
//                    alert("cargar_meter: "+data);	
                    $("#carrito_detalles").html(data);
                }
          );

            return false; // avoid to execute the actual submit of the form.
        }); 
      }
    );