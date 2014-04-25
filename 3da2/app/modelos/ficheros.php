<?php
namespace modelos;

/**
 * Description of ficheros
 *
 * @author jesus
 */
class ficheros {
	
	

	public static function get_carpetas() {
//		echo __METHOD__;
		$carpetas = array();
		
		$directorio = PATH_APP."ficheros";
		
		if (is_dir($directorio)) {
			
			if ($dh = opendir($directorio)){
				while (($file = readdir($dh)) !== false){
//					echo "filename:" . $file . "<br>";
					if (is_dir($directorio."/$file")) {
						array_push($carpetas, $file);
					}
				}
				
				closedir($dh);
			
			}
		}
		return $carpetas;
	}
	
	/**
	 * 
	 * @return array $ficheros["carpeta"]=array("file1", "file2", ...)
	 */
	public static function get_ficheros($carpeta) {
		
		$directorio = PATH_APP."ficheros";

		$ficheros = array();
		
		$subdirectorio = $directorio."/$carpeta";
		if ($dh = opendir($subdirectorio)){
			while (($file = readdir($dh)) !== false){
//				echo "filename:" . $file . "<br>";
				if (is_file($subdirectorio."/$file")) {
//					array_push($ficheros, $file);
					$ficheros[$file] = \modelos\descargas::get_contador_descargas("$carpeta/$file");
				}
			}

			closedir($dh);

		}

		
		return $ficheros;
	}

	
	public static function get_mime_type($extension) {
		
		$mime_types = array ( 
		
			".mp3" => "audio/mpeg3",
			".js" => "application/x-javascript",
		);
		
		return (array_key_exists($extension,$mime_types) ? $mime_types[$extension] : null);
		
	}
	
}
