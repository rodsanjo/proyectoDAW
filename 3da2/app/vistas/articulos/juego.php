<div>
    
    <h2 class='titulo_articulo'><?php echo $datos['articulo']['nombre'] ?></h2>
    
    <?php
        \core\HTML_Tag::a_boton("boton", array("articulos", "form_modificar"), "Modificar");
        $fila = $datos['articulo'];
        $img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' width='200px' />" :"";
        $num_max_jug = isset($fila['num_max_jug'])?$fila['num_max_jug']:null;
        if(is_null($num_max_jug) || $num_max_jug == $fila['num_min_jug']){
            $num_max_jug ='';
        }else{
            $num_max_jug ='-'.$num_max_jug;
        }
        $rangoJug = $fila['num_min_jug'].$num_max_jug;
        $duracion = $fila['duracion'].' min.';
        $articulo_nombre = str_replace(" ", "-", $fila['nombre']);
        $href = \core\URL::generar("articulos/juego/$articulo_nombre");
        echo "<h3>{$fila['nombre']}</h3>"
            .$img.
            "<div class='text_justificado'>
                <p>{$fila['descripcion']}</p>
                <p>&nbsp;</p>
                <p>Edad: {$fila['edad_min']}+</p>
                <p>Jugadores: $rangoJug</p>
                <p>Duración: $duracion</p>
                <a class='boton' href='$href'>Más detalles</a>
            </div>
        ";
        
        $array = $datos['comentarios']; 
        foreach ($array as $key => $comentario) {
            echo "fecha: ".$comentario['fecha_comentario']."<br/>";
            echo "<b>".$comentario['usuario_login']."</b> escribió:<br/>";
            echo $comentario['comentario']."<br/><br/>";
        }
    ?>
