<?php
namespace controladores;

class roles_permisos extends \core\Controlador {

	
	
	/**
	 * Presenta una <table> con las filas de la tabla con igual nombre que la clase.
	 * @param array $datos
	 */
	public function index(array $datos=array()) {
		
		$validaciones=array(
			"id" => "errores_requerido && errores_identificador && errores_referencia:id/roles/rol"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el rol a consultar';
//			 var_dump($_REQUEST); var_dump($datos); exit();
			\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else {
			
	
			if ( ! $filas = \modelos\roles_permisos::recuperar_permisos($datos["values"]["id"])) {
				$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
				\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$datos["rol"] = $datos["values"]["id"];
				$datos['filas'] = $filas;
			}
		}
		
		$datos['view_content'] = \core\Vista::generar("index", $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	

	
	
	
	/**
	 * Recibe un formulario con múltiples input tipo checkbox
	 * 
	 * @param array $datos
	 */
	public function form_modificar_validar(array $datos=array()) {	
		
		
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request(\modelos\roles_permisos::$validaciones_update, $datos)) {
			
            $datos["mensaje"] = "Imposible identificar el rol al que modificar los permios.";
			
		}
		else {
			\modelos\Modelo_SQL::start_transaction();
			$clausulas["where"] = " rol = '{$datos["values"]["rol"]}' ";
			if ( ! $validacion = \modelos\Modelo_SQL::table("roles_permisos")->delete($clausulas)) {
					
				$datos["mensaje"] = "No se han podido grabar la modificaciones en la bd.";				
				
			}
			else {
				$permisos = \core\HTTP_Requerimiento::post();
				if ( ! $validacion = \modelos\roles_permisos::modificar_permisos($datos["values"]["rol"], $permisos)) {
					$datos["mensaje"] = "No se han podido grabar la modificaciones en la bd.";
				}
			}
			if ($validacion) {
				\modelos\Modelo_SQL::commit_transaction();
			}
			else {
				\modelos\Modelo_SQL::rollback_transaction();
			}
		}
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			$this->cargar_controlador("mensajes", "mensaje", $datos);
		
		else {
			$_SESSION["alerta"] = "Se ha modificado correctamente los permisos del rol";
			//header("Location: ".\core\URL::generar("roles/index"));
			\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("roles_permisos/index/{$datos["values"]["rol"]}"));
			\core\HTTP_Respuesta::enviar();
		}
		
	}

	
} // End of the class