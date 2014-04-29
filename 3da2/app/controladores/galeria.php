<?php
namespace controladores;

class galeria extends \core\Controlador {
    
    public function index(array $datos = array()) {
        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos, true);
        $http_body = \core\Vista_Plantilla::generar('plantilla_principal',$datos);
        \core\HTTP_Respuesta::enviar($http_body);
    }
    
    public function carpeta(array $datos = array()) {
        
        $validaciones = array(
            "p3" => "errores_requerido && errores_identificador"
        );
        if ( ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
            $datos["carpeta"] = $datos["values"]["p3"];
            $datos["ficheros"] = \modelos\ficheros::get_ficheros($datos["values"]["p3"]);
            
            if($datos["values"]["p3"] == 'krasnale'){
                $datos["view_content"] = \core\Vista::generar('krasnale', $datos);
            }else{        
                $datos["view_content"] = \core\Vista::generar(__FUNCTION__, $datos);
            }
            $http_body_content = \core\Vista_Plantilla::generar("DEFAULT", $datos);
            \core\HTTP_Respuesta::enviar($http_body_content);

        }
        else {
            header("Location: ".\core\URL::generar());
        }
	
    }

}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
