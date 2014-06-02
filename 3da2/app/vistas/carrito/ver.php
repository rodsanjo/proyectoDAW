<div>    
    <?php
        $articulos = $datos["carrito"]->get_articulos();
    //var_dump($articulos);
    //var_export($articulos);
        if ($articulos) : ?>
            <div id="carrito_oculto">
                <?php
                    $total_acumulado = 0;
                    foreach ($articulos as $articulo_id => $articulo) {
                        $total = $articulo['unidades'] * $articulo['precio'];
                        $total_acumulado += $total;
                        $nombre_corto = substr($articulo['nombre'], 0, 16);
                        $nombre_corto = strlen($articulo['nombre']) <16 ? $nombre_corto : $nombre_corto.'...' ;
                        $cubo_basura = "<img src='".URL_ROOT."recursos/imagenes/no_check.jpg' width='10px' height='10px'/>";
//                        <form method='post' action='".\core\URL::generar("carrito/modificar")."'>
                        echo "
                            <form id='f_carrito_lateral_$articulo_id' method='post'>
                                <input type='hidden' name='articulo_id' value='$articulo_id' />
                                <input type='hidden' name='unidades' value='".number_format($articulo["unidades"], 0, ",", ".")."' />
                                <span class='car_nxart'>".number_format($articulo["unidades"], 0, ",", ".")." x $nombre_corto</span>
                                <span>".number_format($total,2,",",".")."</span>
                                <button name='accion' type='submit' value='quitar' class='boton_con_imagen' onclick='carrito_modificar(\"f_carrito_lateral_$articulo_id\",\"quitar\");' >$cubo_basura</button>
                            </form><br/>
                                ";
                    }
                ?>

            </div>

                <b><span class='car_nxart'><?php echo ucfirst(iText('total', 'dicc')); ?></span>
                <?php echo number_format($total_acumulado,2,",","."); ?> €</b>
                <?php number_format(self::ejecutar("carrito","valor"),2,",",".") ?>

                <form id="form_vaciar_carrito" method='post' action='<?php echo \core\URL::generar("carrito/vaciar"); ?>'>
                    <button  id="boton_vaciar_carrito"type='submit'><?php echo iText('Vaciar', 'dicc'); ?></button>
                </form>
            <button id="boton_comprar" type='button' onclick='window.location.assign("<?php echo \core\URL::generar("carrito/comprar")?>");' ><?php echo iText('Comprar', 'dicc'); ?></button>
    <?php else : 
        echo "<b><span class='car_nxart'>".ucfirst(iText('total', 'dicc'))."</span>
            ".number_format(self::ejecutar("carrito","valor"),2,",",".")." €</b>";
 endif; ?>

</div>