<div>
    <h3>Artículos disponibles:</h3>
    
    <?php
    \core\HTML_Tag::a_boton_onclick("boton", array("articulos", "form_insertar"), "Insertar");
//    $num_arts_por_pag = 4;
//    for($i=0;$i<$num_arts_por_pag && $i<count($datos['filas']);$i++){
//        $fila = $datos['filas'][$i];
    foreach ($datos['filas'] as $key => $fila){ //cada fila corresponde a un juego de mesa        
        $img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' alt='{$fila['nombre']}' tittle='{$fila['nombre']}' width='200px' />" :"";
        $num_max_jug = isset($fila['num_max_jug'])?$fila['num_max_jug']:null;
        if(is_null($num_max_jug) || $num_max_jug == $fila['num_min_jug']){
            $num_max_jug ='';
        }else{
            $num_max_jug ='-'.$num_max_jug;
        }
        $rangoJug = $fila['num_min_jug'].$num_max_jug;
        $articulo_nombre = str_replace(" ", "-", $fila['nombre']);
        $href = \core\URL::generar(array('articulos','juego',$articulo_nombre));
        $title = ((isset($fila['resenha']) and strlen($filas['resenha'])) ? $filas['resenha'] : $fila['nombre']); 
        echo "<a href='$href' title='$title'><h3>{$fila['nombre']}</h3></a>"
            .$img.
            "<div class='text_justificado'>
                <p>&nbsp;</p>
                <p>Precio: <b class='precio'>{$fila['precio']} €</b></p>                    
                <p>Jugadores: $rangoJug</p>
                <a class='button' href='$href'>Mas detalles</a>
            </div>"
            .\core\HTML_Tag::a_boton_onclick("boton", array("articulos", "form_modificar", $fila['id']), "Modificar")
            //<a class='boton' href='?menu={$datos['controlador_clase']}&submenu=form_modificar&id={$fila['id']}' >modificar</a>
            .\core\HTML_Tag::a_boton_onclick("boton", array("articulos", "form_borrar", $fila['id']), "Borrar")
            //<a class='boton' href='".\core\URL::generar("articulos/form_borrar/{$fila["id"]}")."' >borrar</a>
        ."<hr/>";
        //<p>Precio: <b class='precio'>".\core\Conversiones::decimal_punto_a_coma_y_miles($fila['precio'])." €</b></p>
  
    }
    $categoria = isset($_REQUEST['p3'])?$_REQUEST['p3']:'g_juegos'; //g_juegos no vale para nada, solo para que p3 no quede vacio a la vista del usuario
    $num_grupo = isset($_REQUEST['p4'])?$_REQUEST['p4']:'';
    $num_total_juegos = $datos["num_total_juegos"][0]['num_total_juegos'];
    $ult_grupo = floor($num_total_juegos/\controladores\articulos::$num_arts_por_pag);
    if($ult_grupo > 1 && $num_total_juegos%$ult_grupo == 0){    //Evto el cero por indeterminación y el 1 por ser primo
        $ult_grupo--; 
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
    
    <a class='boton' href='<?php echo $href1 ?>' title="primero"><<</a>
    <a class='boton' href='<?php echo $href2 ?>' title="anterior"><</a>
    <?php echo 'Artículos'; ?>
    <a class='boton' href='<?php echo $href3 ?>' title="siguiente">></a>
    <a class='boton' href='<?php echo $href4 ?>' title="último">>></a>
    
    <span title="total"><?php echo $num_total_juegos; ?></span>
    
    <br/>
    <a class='boton' href='<?=$datos["url_volver"]?>' >Volver</a>
</div>