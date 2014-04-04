<?php

namespace modelos;

class carrito extends \modelos\carrito_objeto {

	private static $id = null;
	
	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
		"articulo_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:articulo_id/articulos/id",
		"unidades" => "errores_requerido && errores_numero_entero_positivo",
		"precio" => "errores_requerido && errores_numero_decimal_positivo",
		"nombre" => "errores_requerido && errores_texto",
		"foto" => "errores_texto"
	);
	
	
	public static $validaciones_update = array(
		"articulo_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:articulo_id/articulos/id",
		"unidades" => "errores_requerido && errores_numero_entero_positivo",
		
	);
	

	public static $validaciones_delete = array(
		"articulo_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:articulo_id/articulos/id",
	);

	
}