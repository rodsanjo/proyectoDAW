<div>
    
    <h1 class="titulo_seccion" class='nombre_articulo' title='<?php echo $datos['articulo']['nombre'] ?>'><?php echo $datos['articulo']['nombre'] ?></h1>
    
    <?php
    echo \core\HTML_Tag::a_boton("boton", array("articulos", "form_modificar", $datos['articulo']['id']), "Modificar");
    $fila = $datos['articulo'];
    $img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' width='200px' style='float:left' />" :"";  
    $num_max_jug = isset($fila['num_max_jug'])?$fila['num_max_jug']:null;
    if(is_null($num_max_jug) || $num_max_jug == $fila['num_min_jug']){
        $num_max_jug ='';
    }else{
        $num_max_jug ='-'.$num_max_jug;
    }
    $rangoJug = $fila['num_min_jug'].$num_max_jug;
    $duracion = (isset($fila['duracion'])?$fila['duracion'].' min.':"-");
    $edad = isset($fila['edad_min']) ? $fila['edad_min'].'+' : '-';
    
    $articulo_nombre = str_replace(" ", "-", $fila['nombre']);
    $resenha = ((isset($fila['resenha']) and strlen($fila['resenha'])) ? $fila['resenha'] : ''); 
    $descripcion = ((isset($fila['descripcion']) and strlen($fila['descripcion'])) ? $fila['descripcion'] : ''); 
    echo "
            <div id='resenha_articulo' class='text_justificado'>
                <p>$resenha</p>
            </div>
            <div id='media_articulo'>
                $img
                <div id='descarga_manual'>"; 
                //Descarga reglamento:
                if (\core\Usuario::$login != 'anonimo'){
                    $datos["carpeta"] = 'manuales';       
                    $metodo = ($datos["carpeta"] == "js") ? "js" : "file";
                    //No funciona en amigable:
                    //$manual = ($fila["manual"]) ? "<a href='".\core\URL::generar("download/$metodo/manuales/{$fila["manual"]}")."'>Descargar reglamento</a>" : ""; //No funciona en amigable           
                    $manual = ($fila["manual"]) ? "<a href='".URL_ROOT."?p1=download&p2=$metodo&p3=manuales&p4={$fila["manual"]}' >Descargar reglamento</a>" : iText('Reglamento no disponible', 'frases');            
                    echo $manual;
                }
                    echo "</div><br/>

                <form name='formulario_anhadir' method='post' action='".\core\URL::generar('carrito/meter')."' onsubmit='return hayDisponibilidad();' >
                    <input type='hidden' name='articulo_id' value='{$fila['id']}' />
                    <tr>
                        <td><input type='hidden' readonly='readonly' name='nombre' value='{$fila['nombre']}' /></td>
                        <td><input type='hidden' readonly='readonly' name='precio' value='{$fila['precio']}' /></td>
                        ";
                            if ( \core\Usuario::$login != 'anonimo' && ! \modelos\roles::es_empleado(\core\Usuario::$login)) {
                            //if (\core\Usuario::$login != 'anonimo' && ! \core\Usuario::$empleado ) {
                            echo "<td><input type='text'  name='unidades' value='1' size='2'/></td>
                            <td>
                                <input name='accion' type='submit' value='añadir' />
                            </td>";
                            }
            echo "
                    </tr>
                    <span id='error_disponibilidad' class='input_error'></span>
                </form>
        </div>
    ";
            $fila['unds_stock'] == 0 ? $src = "<img src='".URL_ROOT."recursos/imagenes/no_disponible.jpg' />" : $src = '';
    echo "
            <div id='datos_articulo'>
                <div id='datos_tecnicos'>
                    $src
                    <p>Edad: $edad</p>
                    <p>Jugadores: $rangoJug</p>
                    <p>Duración: $duracion</p>
                </div>
                <p>$descripcion</p>
            </div>
    ";

    //Introdución de comentarios
    if( \core\Usuario::tiene_permiso('articulos', 'form_comentario')){
        echo "<div id='cuadro_comentario' >".iText('opina', 'frases')."
            <form class='form_comentario' name='form_comentario' method='post' 
                action='".\core\URL::generar('articulos/validar_form_comentario')."' 
                onsubmit='return (form_comentario.comentario.value.length>0)'>
                ".
                
                //Dos opciones: usando articulo_id o articulo_nombre como FK
                "
                <input name='articulo_id' type='hidden' value='{$datos['articulo']['id']}'/>
                ".
                //<input name='articulo_nombre' type='hidden' value='{$datos['articulo']['nombre']}'/>
                
                "<input name='usuario_login' type='hidden' value='".\core\Usuario::$login."'/>
                <textarea type='text' id='comentario' name='comentario' maxlength='500' cols='92' rows='5'></textarea>      
                ".\core\HTML_Tag::span_error('errores_validacion', $datos)."
                <input type='submit' value='Enviar'/>
            </form></div>
        ";
    }
    echo "<div id='comentarios' >
            <h4>Comentarios:</h4>";
            $array = $datos['comentarios'];
            if( ! count($array)){
                echo "<center>".iText('sinComentarios', 'frases')."</center>";
            }
            $ahora = date("Y-m-d H:i:s");   // 2001-03-10 17:16:18 (el formato DATETIME de MySQL)
            foreach ($array as $key => $comentario) {
                if ( \core\Usuario::$login == $comentario['usuario_login'] && $comentario['fecha_ult_edicion'] > $ahora - (1/24)){
                    $editar_comentario = \core\HTML_Tag::a_boton("boton", array("articulos", "form_editar_comentario", $comentario['id']), iText('Editar', 'dicc') );
                }else{
                    $editar_comentario = "";
                }
                if( \core\Usuario::tiene_permiso('articulos', 'form_eliminar_comentario')){
                    $eliminar_comentario = \core\HTML_Tag::a_boton("boton", array("articulos", "form_eliminar_comentario", $comentario['id']), iText('Eliminar', 'dicc') );
                }else{
                    $eliminar_comentario = "";
                }
                $edicion = ($comentario['num_ediciones'] > 0 ) ? '<small>'.iText('Editado', 'dicc').' '.$comentario['num_ediciones'].' '.iText('veces', 'dicc').'.</small>' : "" ;
                echo "<div>
                        <div class='acciones_comentario'>$editar_comentario $eliminar_comentario</div>
                        fecha: ".$comentario['fecha_comentario'].'  '.$edicion."<br/>
                        <b>".$comentario['usuario_login']."</b> escribió:
                    </div>";
                echo "<div id='texto_comentario'>{$comentario['comentario']}</div><br/>";
            }
    echo "</div>";
    ?>
    
</div>

<script type="text/javascript">       
    var unds_stock = <?php echo $fila['unds_stock']; ?>;   //Me guardo la cantidad de unidades en stock disponibles, que serán usadas en el siguiente javascript 
</script>
    
<script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/validaciones/val_anhadir_juego_a_carrito.js"></script>