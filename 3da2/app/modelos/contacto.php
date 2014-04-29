<?php
namespace modelos;

class contacto extends \modelos\Modelo_SQL {
    /* Rescritura de propiedades de validación */
    public static $validaciones_insert = array(
        'nombre' => 'errores_requerido',
        'email' => 'errores_requerido && errores_email',
        'asunto' => 'errores_requerido && errores_texto',
        'mensaje' => 'errores_requerido',
    );
}
