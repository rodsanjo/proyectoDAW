<div>
    
    <h2 class='nombre_articulo' title='<?php echo $datos['articulo']['nombre'] ?>'><?php echo $datos['articulo']['nombre'] ?></h2>
    
    <?php
    echo \core\HTML_Tag::a_boton("boton", array("articulos", "form_modificar", $datos['articulo']['id']), "Modificar");
    $fila = $datos['articulo'];
    $img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' width='200px'style='float:left' />" :"";
    $num_max_jug = isset($fila['num_max_jug'])?$fila['num_max_jug']:null;
    if(is_null($num_max_jug) || $num_max_jug == $fila['num_min_jug']){
        $num_max_jug ='';
    }else{
        $num_max_jug ='-'.$num_max_jug;
    }
    $rangoJug = $fila['num_min_jug'].$num_max_jug;
    $duracion = $fila['duracion'].' min.';
    $articulo_nombre = str_replace(" ", "-", $fila['nombre']);
    $resenha = ((isset($fila['resenha']) and strlen($fila['resenha'])) ? $fila['resenha'] : ''); 
    $descripcion = ((isset($fila['descripcion']) and strlen($fila['descripcion'])) ? $fila['descripcion'] : ''); 
    echo "<div class='text_justificado'>
        
        <p>$resenha</p>
        $img
        <p>&nbsp;</p>
        <p>Edad: {$fila['edad_min']}+</p>
        <p>Jugadores: $rangoJug</p>
        <p>Duración: $duracion</p>
        <p>$descripcion</p>
        </div>
        <form method='post' action='".\core\URL::generar('carrito/meter')."' >
            <input type='hidden' name='articulo_id' value='{$fila['id']}' />
            <tr>
                <td><input type='hidden' readonly='readonly' name='nombre' value='{$fila['nombre']}' /></td>
                <td><input type='hidden' readonly='readonly' name='precio' value='{$fila['precio']}' /></td>
                <td><input type='text'  name='unidades' value='1' size='2'/></td>
                <td>
                    <input name='accion' type='submit' value='añadir' />
                </td>
            </tr>
        </form>
    ";
                
    //Descarga:
    if (\core\Usuario::$login != 'anonimo'){
        $datos["carpeta"] = 'manuales';       
        $metodo = ($datos["carpeta"] == "js") ? "js" : "file";
        //No funciona en amigable:
        //$manual = ($fila["manual"]) ? "<a href='".\core\URL::generar("download/$metodo/manuales/{$fila["manual"]}")."'>Descargar reglamento</a>" : ""; //No funciona en amigable           
        $manual = ($fila["manual"]) ? "<a href='".URL_ROOT."?p1=download&p2=$metodo&p3=manuales&p4={$fila["manual"]}' >Descargar reglamento</a>" : "";            
        echo $manual;
    }

    //Introdución de comentarios
    if( \core\Usuario::tiene_permiso('articulo', 'form_comentario')){
        echo "<div id='comentario' > ¡Danos tu opinión!
            <form class='form_comentario' name='form_comentario' method='post' 
                action='".\core\URL::generar('articulos/validar_form_comentario')."' 
                onsubmit='return (form_comentario.comentario.value.length>0)'>
                ".
                //Si usamos el articulo_id como FK
                //<input name='articulo_id' type='hidden' value='{$datos['articulo']['id']}'/>
                "
                <input name='articulo_nombre' type='hidden' value='{$datos['articulo']['nombre']}'/>
                <input name='usuario_login' type='hidden' value='".\core\Usuario::$login."'/>
                <textarea type='text' id='comentario' name='comentario' maxlength='500' cols='50' rows='5'></textarea>      
                ".\core\HTML_Tag::span_error('errores_validacion', $datos)."
                <input type='submit' value='Enviar'/>
            </form></div>
        ";
    }

    $array = $datos['comentarios']; 
    foreach ($array as $key => $comentario) {
        echo "fecha: ".$comentario['fecha_comentario']."<br/>";
        echo "<b>".$comentario['usuario_login']."</b> escribió:<br/>";
        echo $comentario['comentario']."<br/><br/>";
    }
    ?>
</div>
