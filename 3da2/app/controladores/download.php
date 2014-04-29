<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controladores;

/**
 * Description of download
 *
 * @author jesus
 */
class download extends \core\Controlador {
	
	public function file (array $datos = array()) {
		
		$validaciones = array(
			"p3" => "errores_requerido && errores_identificador",
			"p4" => "errores_requerido && errores_texto"
		);
		if ( ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			
                        $ruta = PATH_APPLICATION."recursos/ficheros/".$datos["values"]["p3"]."/";
			$fichero = urldecode($datos["values"]["p4"]);
			
			$extension = substr($fichero, strpos($fichero,"."));
//			echo("Path_Fichero: ".$ruta.$fichero);
//			echo("Tamaño: " .filesize($ruta.$fichero));
//			exit(__METHOD__.$extension.\modelos\ficheros::get_mime_type($extension));

			$fila["fichero"] = $datos["values"]["p3"]."/".$fichero;
			$fila["remote_addr"] = $_SERVER["REMOTE_ADDR"];
			$fila["request_time"] = gmdate("Y-m-d H:i:s", $_SERVER["REQUEST_TIME"]);
			if( ! \modelos\descargas::tabla("descargas")->insert($fila) ) {
				exit(\modelos\descargas::get_error());
			}
			
                        //Ponemos nombre a la descarga:
                        $nombre_descarga = self::nombrar_descarga_manual($fichero);
                                                
			header("Content-type: " . \modelos\ficheros::get_mime_type($extension));
			header('Content-Disposition: attachment; filename="'.$nombre_descarga.'"');
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($ruta.$fichero));
			$fp = fopen($ruta.$fichero, "r");
			fpassthru($fp); // Lee y lo envia a HTTP salida
			fclose($fp);
			
		}
		else {
			header("Location: ".\core\URL::generar());
		}
		
	}
	
	
	
	public function js(array $datos = array()) {
		
		$validaciones = array(
			"p3" => "errores_requerido && errores_identificador",
			"p4" => "errores_requerido && errores_texto"
		);
		if ( ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			
			$datos["ruta"] = PATH_APP."ficheros/".$datos["values"]["p3"]."/";
			$datos["fichero"] = urldecode($datos["values"]["p4"]);
			
			$extension = substr($datos["fichero"], strpos($datos["fichero"],"."));
//			echo("Path_Fichero: ".$ruta.$fichero);
//			echo("Tamaño: " .filesize($ruta.$fichero));
//			exit(__METHOD__.$extension.\modelos\ficheros::get_mime_type($extension));

			$fila["fichero"] = $datos["values"]["p3"]."/".$datos["fichero"];
			$fila["remote_addr"] = $_SERVER["REMOTE_ADDR"];
			$fila["request_time"] = gmdate("Y-m-d H:i:s", $_SERVER["REQUEST_TIME"]);
			if( ! \modelos\descargas::tabla("descargas")->insert($fila) ) {
				exit(\modelos\descargas::get_error());
			}
			
			header("Content-type: " . \modelos\ficheros::get_mime_type($extension));
//			header('Content-Disposition: attachment; filename="'.$fichero.'"');
//			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($datos["ruta"].$datos["fichero"]));
//			$http_body = \core\Vista::generar(__FUNCTION__, $datos);
//			echo $http_body;
			$file_path = $datos["ruta"].$datos["fichero"];
			include $file_path;
		}
		else {
			header("Location: ".\core\URL::generar());
		}
		
	}
        
        /**
         * Funcion que da el nombre del articulo a la descarga
         * @author Jorge
         * @param type $fichero
         * @return string
         */
        private static function nombrar_descarga_manual($fichero){
            $sql = 'select * from '.\core\sgbd\mysqli::get_prefix_tabla("articulos").' where manual = "'.$fichero.'"';
            $fila = \core\sgbd\mysqli::execute($sql);
            //var_dump($fila[0]);   //Al descomentar el var_dump da fallo ladescarga.
            $nombre_descarga = str_replace(" ", "-", $fila[0]['nombre']).'_reglamento.pdf';
            return $nombre_descarga;
        }
	
	
}
