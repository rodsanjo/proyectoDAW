<?php
namespace controladores;

class inicio extends \core\Controlador {
	
	public function index(array $datos = array()) {
            
            // Aprovechamos para borrar en la base de datos los carritos de hace más de
            // 3 dias.
            $where = "timestampdiff(minute, fechaHoraInicio, now()) > 3*24*60*60";
            \modelos\Modelo_SQL::table("carritos")->delete(null, null, $where);
            
            $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos, true);
            $http_body = \core\Vista_Plantilla::generar('plantilla_principal',$datos);
            \core\HTTP_Respuesta::enviar($http_body);
	}
	
	
} // Fin de la clase