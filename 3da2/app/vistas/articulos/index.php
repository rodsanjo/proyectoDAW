<script type="text/javascript">
    function ordenar_por(url){
        tipo_ordenacion = document.getElementById(ordenar_por).innerHTML;
        alert(tipo_ordenacion);
        return url += tipo_ordenacion;
    }
   
</script>

<div>
    <div>
        <h3 id="titulo_seccion"><?php echo iText('Artículos disponibles', 'dicc'); ?>:</h3>
        <form method='post' action='<?php echo \core\URL::generar("articulos/index"); ?>'>
            <input type="hidden" name="categoria" value="<?php echo isset($_REQUEST['p3']) ? $_REQUEST['p3'] : ''; ?>"/>
            <input type="hidden" name="seccion" value="<?php echo isset($_REQUEST['p4']) ? $_REQUEST['p4'] : ''; ?>"/>
            <p>Ordenar por:
                <select id='ordenar_por' name="ordenar_por" onchange="ordenar_por(<?php echo \core\URL::actual(); ?>);">
                    <option value='nombre' selected='selected'>Nombre</option>
                    <option value='precio' >Precio</option>
                    <option value='precio desc' >Precio descendente</option>
                </select>  
                <input type="submit" value="Ordenar" title="Solo se mostrarán los <?php echo \controladores\articulos::$num_arts_por_pag; ?> primeros artículos sin diferenciar categoría"/>
            </p>       
        </form>
    </div>
    
    <div class="align_right">
        <?php
        echo \core\HTML_Tag::a_boton_onclick("boton", array("articulos", "form_insertar"), "Insertar un nuevo artículo");
        echo \core\HTML_Tag::a_boton("boton", array("articulos", "form_insertar"), "insertar un nuevo artículo");
        ?>
    </div>
    
    <?php
    foreach ($datos['filas'] as $key => $fila){ //cada fila corresponde a un juego de mesa        
        $img = ($fila["foto"]) ? "<img class='img_index' src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' alt='{$fila['nombre']}' title='{$fila['nombre']}' />" :"";
        $num_max_jug = isset($fila['num_max_jug'])?$fila['num_max_jug']:null;
        if(is_null($num_max_jug) || $num_max_jug == $fila['num_min_jug']){
            $num_max_jug ='';
        }else{
            $num_max_jug ='-'.$num_max_jug;
        }
        $rangoJug = $fila['num_min_jug'].$num_max_jug;
        $articulo_nombre = str_replace(" ", "-", $fila['nombre']);
        $href = \core\URL::generar(array('articulos','juego',$articulo_nombre));
        $title = ((isset($fila['resenha']) and strlen($fila['resenha'])) ? $fila['resenha'] : $fila['nombre']); 
        echo "<a href='$href' title='$title'><h3>{$fila['nombre']}</h3></a>"
            .$img.
            "<div class='text_justificado'>
                <p>&nbsp;</p>
                <p>Precio: <b class='precio'>{$fila['precio']} €</b></p>                    
                <p>Jugadores: $rangoJug</p>
                <a class='button' href='$href'>Mas detalles</a>
            </div>
                
            <form method='post' action='".\core\URL::generar('carrito/meter')."' >
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
            </form>"
              
            ."<div class='align_right'>"
            //.\core\HTML_Tag::a_boton_onclick("boton", array("articulos", "form_modificar", $fila['id']), "Modificar")
            .\core\HTML_Tag::a_boton("boton", array("articulos", "form_modificar", $fila['id']), "Modificar")
            //<a class='boton' href='?menu={$datos['controlador_clase']}&submenu=form_modificar&id={$fila['id']}' >modificar</a>
            //.\core\HTML_Tag::a_boton_onclick("boton", array("articulos", "form_borrar", $fila['id']), "Borrar")
            .\core\HTML_Tag::a_boton("boton", array("articulos", "form_borrar", $fila['id']), "Borrar")
            //<a class='boton' href='".\core\URL::generar("articulos/form_borrar/{$fila["id"]}")."' >borrar</a>
        ."<hr/></div>";
        //<p>Precio: <b class='precio'>".\core\Conversiones::decimal_punto_a_coma_y_miles($fila['precio'])." €</b></p>
  
    }
    
//    $categoria = isset($_REQUEST['categoria'])?$_REQUEST['categoria']:'seccion';
    $categoria = isset($_REQUEST['p3'])?$_REQUEST['p3']:'seccion'; //'seccion' no vale para nada, solo para que p3 no quede vacio a la vista del usuario
    
    $num_grupo = isset($_REQUEST['p4'])?$_REQUEST['p4']:'';
    
//    $order_by = isset($_REQUEST['ordenar_por'])?$_REQUEST['ordenar_por']:'';
//    $order_by = isset($_REQUEST['p5'])?$_REQUEST['p5']:$order_by;
    
    $num_total_juegos = $datos["num_total_juegos"][0]['num_total_juegos'];
    $ult_grupo = floor($num_total_juegos/\controladores\articulos::$num_arts_por_pag);
    //var_dump($num_total_juegos);
    if($ult_grupo > 1 && $num_total_juegos%\controladores\articulos::$num_arts_por_pag == 0){    //Evto el cero por indeterminación y el 1 por ser primo
        $ult_grupo--; 
    }elseif($ult_grupo == 1 && $num_total_juegos == \controladores\articulos::$num_arts_por_pag){    //Evita el 1
        $ult_grupo = 0;
    }
    
    $grupo_ant = $num_grupo-1;
    if($grupo_ant < 0) $grupo_ant = 0;
    $grupo_sig = $num_grupo+1;
    if($grupo_sig > $ult_grupo) $grupo_sig = $ult_grupo;
    
    $href1 = \core\URL::generar(array('articulos','index',$categoria));
    $href2 = \core\URL::generar(array('articulos','index',$categoria,$grupo_ant));
    $href3 = \core\URL::generar(array('articulos','index',$categoria,$grupo_sig));
    $href4 = \core\URL::generar(array('articulos','index',$categoria,$ult_grupo));
    ?>
    <br/>
    
    <div style="text-align: center;">
        <a class='boton_flecha_izq' href='<?php echo $href1 ?>' title="primero">   <<   </a>
        <a class='boton_flecha_izq' href='<?php echo $href2 ?>' title="anterior">  <  </a>
        <?php echo iText('Artículos', 'dicc'); ?>
        <a class='boton_flecha_der' href='<?php echo $href3 ?>' title="siguiente">  >  </a>
        <a class='boton_flecha_der' href='<?php echo $href4 ?>' title="último">   >>   </a>

        <!--<span title="total"><?php //echo $num_total_juegos; ?></span>-->

        <br/>
        <a class='boton' style="text-align: right;" href='#titulo_seccion' ><?php echo iText('Subir', 'dicc'); ?></a><br/>
    </div>
</div>