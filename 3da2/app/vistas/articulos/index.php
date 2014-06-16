<script type="text/javascript">
    function ordenar_por(orden){
        tipo_ordenacion = document.getElementById('ordenar_por').innerHTML;
        alert(tipo_ordenacion);
        return url += tipo_ordenacion;
    }
    var ordenacion = [
        { "name" : "Nombre" , "order_by" : "nombre" }, 
        { "name" : "Precio" , "order_by" : "precio" }, 
        { "name" : "Precio descendente" , "order_by" : "precio desc" },
        { "name" : "nº jugadores min" , "order_by" : "num_min_jug" }, 
        { "name" : "nº jugadores max" , "order_by" : "num_max_jug desc" }, 
    ];
    for(i=0; i<ordenacion.length ;i++){
        var tipoOrden = document.createElement("option"); //Creo la etiqueta
        tipoOrden.setAttribute("value",ordenacion[i].order_by[0]); //creo los atributos. value indicará el "orderby"
        var texto = document.createTextNode(ordenacion[i].name[0]); //Creo el texto
        tipoOrden.appendChild(texto);  //añado el texto a la etiqueta creada
        //alert(tipoOrden);
        document.getElementById("ordenar_por").appendChild(tipoOrden);
    }
   
</script>

<div>
    <div>
        <h2 id="titulo_seccion" class="titulo_seccion"><?php echo iText('Artículos disponibles', 'dicc'); ?>:</h2>
        
        <?php
            $categoria = isset($_REQUEST['p3']) ? $_REQUEST['p3'] : '';
            $seccion = isset($_REQUEST['p4']) ? $_REQUEST['p4'] : '';
        ?>
        <form method='post' action='<?php echo \core\URL::generar("articulos/index/".$categoria.'/'.$seccion); ?>'>
            <p>Ordenar por:
                <select id='ordenar_por' name="ordenar_por" onchange="ordenar_por(this.value);">
                    <option value='nombre' ><?php echo iText('Nombre', 'dicc'); ?></option>
                    <option value='precio' ><?php echo iText('Precio', 'dicc'); ?></option>
                    <option value='precio desc' ><?php echo iText('Precio descendente', 'dicc'); ?></option>
                    <option value='num_min_jug, num_max_jug' ><?php echo iText('nº jugadores min', 'frases'); ?></option>
                    <option value='num_max_jug desc, num_min_jug desc' ><?php echo iText('nº jugadores max', 'frases'); ?></option>
                    <option value='anho desc' selected='selected'><?php echo iText('Últimas novedades', 'frases'); ?></option>
                </select>  
                <input type="submit" value="<?php echo iText('Ordenar', 'dicc'); ?>" title="Solo se mostrarán los <?php echo 2*\controladores\articulos::$num_arts_por_pag; ?> primeros artículos"/>
            </p>       
        </form>
    </div>
    
    <div class="align_right">
        <?php
        //echo \core\HTML_Tag::a_boton_onclick("boton", array("articulos", "form_insertar"), "Insertar un nuevo artículo");
        echo \core\HTML_Tag::a_boton("boton", array("articulos", "form_insertar"), "insertar un nuevo artículo");
        ?>
    </div>
    <div id="articulos">
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
        $href = \core\URL::generar(array('articulos','juego',$fila['id'], $articulo_nombre));
        $title = ((isset($fila['resenha']) and strlen($fila['resenha'])) ? $fila['resenha'] : $fila['nombre']); 
        echo "<div class='juego_index'>
                <a href='$href' title='$title'>
                    <h3 class='titulo_art'>{$fila['nombre']}</h3>
                </a>
                <a href='$href' class='media_articulo'>$img</a>
                <div class='datos_articulo'>
                    <p>".iText('Precio', 'dicc').":<br/> <b class='precio'>{$fila['precio']} €</b></p>                    
                    <p>".iText('Jugadores', 'dicc').":<br/> $rangoJug</p>
                </div>
                <div class='masDetalles'>
                    <a class='masDetalles' title='".iText('Leer reseña', 'frases')."'>".iText('Más detalles', 'frases')."</a>
                    <p class='resenha'>{$fila['resenha']}</b></p>
                </div>
            ";
//                <form id='form_carrito' name='form_carrito' method='post' action='".\core\URL::generar('carrito/meter')."' >  //Si no funciona ajax en el Host
//                <form id='form_carrito_ajax' name='form_carrito_ajax'  >  //Usando carrito_prueba.js
        echo "
                    <form method='post' onsubmit='carrito_meter(this, event); return(false);'  >
                    
                    <input type='hidden' name='articulo_id' value='{$fila['id']}' />
                    <tr>
                        <td><input type='hidden' readonly='readonly' name='nombre' value='{$fila['nombre']}' /></td>
                        <td><input type='hidden' readonly='readonly' name='precio' value='{$fila['precio']}' /></td>
                        ";
                        if ( \core\Usuario::$login != 'anonimo' && ! \modelos\roles::es_empleado(\core\Usuario::$login)) {
                        //if (\core\Usuario::$login != 'anonimo' && ! \core\Usuario::$empleado ) {
                        echo "<td><input type='text'  name='unidades' value='1' size='2'/></td>
                        <td>
                            <input name='accion' type='submit'  value='".iText('añadir', 'dicc')."' />
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
                ."</div>
            </div>";
        if($key%2){
            echo "<div style='clear: left;'><hr/></div>";
        }
        
        //<p>Precio: <b class='precio'>".\core\Conversiones::decimal_punto_a_coma_y_miles($fila['precio'])." €</b></p>
  
    }
    
//    $categoria = isset($_REQUEST['categoria'])?$_REQUEST['categoria']:'seccion';
    $categoria = isset($_REQUEST['p3'])?$_REQUEST['p3']:'seccion'; //'seccion' no vale para nada, solo para que p3 no quede vacio a la vista del usuario
    $categoria = isset($_REQUEST['p2']) && $_REQUEST['p2'] == 'busqueda' ? 'busqueda': $categoria;
    
    $num_grupo = isset($_REQUEST['p4'])?$_REQUEST['p4']:'';
    
//    $order_by = isset($_REQUEST['ordenar_por'])?$_REQUEST['ordenar_por']:'';
//    $order_by = isset($_REQUEST['p5'])?$_REQUEST['p5']:$order_by;
    
    $num_total_juegos = $datos["num_total_juegos"][0]['num_total_juegos'];
    $ult_grupo = floor($num_total_juegos/\controladores\articulos::$num_arts_por_pag);
    //var_dump($num_total_juegos);
    if($ult_grupo > 1 && $num_total_juegos%\controladores\articulos::$num_arts_por_pag == 0){    //Evito el cero por indeterminación y el 1 por ser primo
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
    
    </div>
    
    <div class="flechas_cambio_pagina">
    <?php
        if( ! isset($_POST['ordenar_por'])){
    ?>
        <a class='boton_flecha_izq' href='<?php echo $href1 ?>' title="primero">   <<   </a>
        <a class='boton_flecha_izq' href='<?php echo $href2 ?>' title="anterior">  <  </a>
        <?php echo iText('Artículos', 'dicc'); ?>
        <a class='boton_flecha_der' href='<?php echo $href3 ?>' title="siguiente">  >  </a>
        <a class='boton_flecha_der' href='<?php echo $href4 ?>' title="último">   >>   </a>

        <div title="total"><small>Total: <?php echo $num_total_juegos; ?></small></div>
    <?php } ?>
        <br/>
        <a class='boton' style="text-align: right;" href='#titulo_seccion' ><?php echo iText('Subir', 'dicc'); ?></a><br/>
    </div>
</div>