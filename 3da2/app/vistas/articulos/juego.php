<div>
    <h1>Listado de juegos disponibles</h1>
    
    <?php
    \core\HTML_Tag::a_boton("boton", array("articulos", "form_modificar"), "Modificar");
    foreach ($datos['filas'] as $key => $fila){ //cada fila corresponde a un juego de mesa        
        $img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' width='200px' />" :"";
        $rangoJug = $fila['num_min_jug'].isset($fila['num_max_jug'])?' - '.$fila['num_max_jug']:'';
        $duracion = isset($fila['duracion'])?$fila['duracion'].' min':'No disponible. Dependiente del numero de jugadores.';
        $href = \core\URL::generar("articulos/juego/{$fila['nombre']}");
        echo "<h3>{$fila['nombre']}</h3>"
            .$img.
            "<div class='text_justificado'>
                <p>{$fila['descripcion']}</p>
                <p>&nbsp;</p>
                <p>Edad: {$fila['min_edad']}+</p>
                <p>Jugadores: $rangoJug</p>
                <p>Duración: $duracion</p>
                <a class='boton' href='$href'>Mas detalles'</a>
            </div>
        ";
        if($key != count($datos['filas'])) echo "<hr/>";
        
    }
?>
