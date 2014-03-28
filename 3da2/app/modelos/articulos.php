<?php

namespace modelos;

class articulos extends \core\sgbd\bd {

	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
            "nombre" =>"errores_requerido && errores_texto && errores_unicidad_insertar:id,nombre/articulos/id,nombre"
            , "referencia" =>""
            , "autor" =>""
            , "editorial" =>""
            , "anho" =>""
            , "num_min_jug" => "errores_texto"
            , "num_max_jug" => "errores_texto"
            , "duracion" => "errores_texto"
            , "edad_min" => "errores_texto"                        
            , "categoria_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:categoria_id/categorias/id"
            , "tematica" => "errores_texto"
            , "precio" => "errores_precio"
            , "unidades_stock" => "errores_texto"
            , "resenha" => "errores_texto"
            , "descripcion" => "errores_texto"
	);


	public static $validaciones_update = array(
            "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/articulos/id"
            , "nombre" =>"errores_requerido && errores_texto && errores_unicidad_modificar:id,nombre/articulos/id,nombre"
            , "referencia" =>""
            , "autor" =>""
            , "editorial" =>""
            , "anho" =>""
            , "num_min_jug" => "errores_texto"
            , "num_max_jug" => "errores_texto"
            , "duracion" => "errores_texto"
            , "edad_min" => "errores_texto"                        
            , "categoria_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:categoria_id/categorias/id"
            , "tematica" => "errores_texto"
            , "precio" => "errores_precio"
            , "unidades_stock" => "errores_texto"
            , "resenha" => "errores_texto"
            , "descripcion" => "errores_texto"
	);


	public static $validaciones_delete = array(
            "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/articulos/id"
	);


}
