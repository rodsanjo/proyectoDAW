
<div>
    <center>
        <?php echo \core\HTML_Tag::a_boton("boton1", array("carrito"), "Ver contenido del carrito"); ?>
        <button id='btn_desplegar_carrito'>Mostrar <b>/</b> Ocultar</button>
    </center>
        
    <?php
        $articulos = $datos["carrito"]->get_articulos();
    //var_dump($articulos);
    //var_export($articulos);
    ?>
    <div id='carrito_detalles' >
        <?php if ($articulos) : ?>
            <div id="carrito_lateral">
                <?php
                    $total_acumulado = 0;
                    foreach ($articulos as $articulo_id => $articulo) {
                        $total = $articulo['unidades'] * $articulo['precio'];
                        $total_acumulado += $total;
                        $nombre_corto = substr($articulo['nombre'], 0, 8);
                        $nombre_corto = strlen($articulo['nombre']) <8 ? $nombre_corto : $nombre_corto.'...' ;
                        $cubo_basura = "<img src='".URL_ROOT."recursos/imagenes/papelera.jpg' width='15px'/>";
                        echo "


                            <form method='post' action='".\core\URL::generar("carrito/modificar")."'>
                                <input type='hidden' name='articulo_id' value='$articulo_id' />
                                <input type='hidden' name='unidades' value='".number_format($articulo["unidades"], 0, ",", ".")."' />
                                <span class='car_nxart'>".number_format($articulo["unidades"], 0, ",", ".")." x $nombre_corto</span>
                                <span>".number_format($total,2,",",".")."</span>4
                                
                                <input name='accion' type='submit' value='quitar' />
                            </form>
                                ";
                    }
                ?>

            </div>
        
            <b><span class='car_nxart'>Total</span>
            <?php echo number_format($total_acumulado,2,",","."); ?> €</b>
            <?php number_format(self::ejecutar("carrito","valor"),2,",",".") ?>

            <form id="form_vaciar_carrito" method='post' action='<?php echo \core\URL::generar("carrito/vaciar"); ?>'>
                <button  id="boton_vaciar_carrito"type='submit'>Vaciar Carrito</button>
            </form>
            <button id="boton_comprar" type='button' onclick='window.location.assign("<?php echo \core\URL::generar("carrito/comprar")?>");' >Comprar</button>
        <?php else : 
            echo "<b><span class='car_nxart'>Total</span>
                ".number_format(self::ejecutar("carrito","valor"),2,",",".")." €</b>";
     endif; ?>

    </div>
	
</div>