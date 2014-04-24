<?php
namespace controladores;

class carrito extends \controladores\carrito_objeto {
    
    public function index(array $datos = array()) {
        
        $carrito = $this->recuperar();		
        $datos["carrito"] = $carrito;
        
        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        
        $http_body = \core\Vista_Plantilla::generar('DEFAULT', $datos);
        \core\HTTP_Respuesta::enviar($http_body);
    }
	
} // Fin de la clase