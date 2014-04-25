<?php
namespace modelos;

/**
 * Obtener si el usuario es empleado
 *
 * @author jesus
 */
class roles  extends \core\Modelo_SQL {
    
    public static $empleado = false;

    /**
     * Función que nos dice si el usuario que esta conectado es empleado o no.
     * Con ella podemos evitar que un empleado pueda añadir articulos para comprar.
     * @param type $login
     * @return type boolean
     */
    public static function es_empleado($login) {

        //Para que los empleados no tengan la opción de crear un carrito de la compra
        $sql = 'select * from 3da2_usuarios_roles where login = "'.$login.'" and rol = "empleados" ';
        if ( count( \modelos\Modelo_SQL::execute($sql) ) ){ //if ( count( self::execute($sql) ) ){
            self::$empleado = true;
        }else{
            self::$empleado = false;
        }

        return self::$empleado;

    }
	
}
