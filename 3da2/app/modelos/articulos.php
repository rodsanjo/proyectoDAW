<?php

namespace modelos;

class articulos extends \core\sgbd\bd {
    
    private static $tabla = 'articulos';
    private static $tabla2 = 'comentarios_articulo';
    
	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
            "nombre" =>"errores_requerido && errores_texto && errores_unicidad_insertar:id,nombre/articulos/id,nombre"
            //, "referencia" =>""
            , "autor" =>"errores_texto"
            , "editorial" =>"errores_texto"
            , "anho" =>"errores_numero_entero_positivo"
            , "num_min_jug" => "errores_numero_entero_positivo"
            , "num_max_jug" => "errores_numero_entero_positivo"
            , "duracion" => "errores_texto"
            , "edad_min" => "errores_numero_entero_positivo"                        
            , "categoria_id" => "errores_numero_entero_positivo && errores_referencia:categoria_id/categorias/id"
            , "tematica" => "errores_texto"
            , "precio" => "errores_decimal"
            , "unds_stock" => "errores_numero_entero_positivo"
            , "resenha" => "errores_texto"
            , "descripcion" => "errores_texto"
	);


	public static $validaciones_update = array(
            "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/articulos/id"
            , "nombre" =>"errores_requerido && errores_texto && errores_unicidad_modificar:id,nombre/articulos/id,nombre"
            //, "referencia" =>""
            , "autor" =>"errores_texto"
            , "editorial" =>"errores_texto"
            , "anho" =>"errores_numero_entero_positivo"
            , "num_min_jug" => "errores_numero_entero_positivo"
            , "num_max_jug" => "errores_numero_entero_positivo"
            , "duracion" => "errores_texto"
            , "edad_min" => "errores_numero_entero_positivo"                        
            , "categoria_id" => "errores_numero_entero_positivo && errores_referencia:categoria_id/categorias/id"
            , "tematica" => "errores_texto"
            , "precio" => "errores_decimal"
            , "unds_stock" => "errores_numero_entero_positivo"
            , "resenha" => "errores_texto"
            , "descripcion" => "errores_texto"
	);


	public static $validaciones_delete = array(
            "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/articulos/id"
	);


}
