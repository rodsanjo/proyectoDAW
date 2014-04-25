<?php
namespace modelos;

/**
 * Description of descargas
 *
 * @author jesus
 */
class descargas  extends \core\Modelo_SQL {
	
	public static function  get_contador_descargas($fichero) {
	
		$sql = "select count(*) as contador_descargas "
				. " from ".self::get_prefix_tabla("descargas")
				. " where fichero = '$fichero'"
				. " ;";
		
		$filas = self::execute($sql);
		
		return ($filas ? $filas[0]["contador_descargas"] : 0);
		
	}
	
}
