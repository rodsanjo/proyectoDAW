<div>
        
    <?php
        $articulos = $datos["carrito"]->get_articulos();
        //var_dump($articulos);
        //var_export($articulos);
    ?>
    <div id='carrito_index' >
    <?php if ($articulos) :?>
        
        <!--<table border="1">-->
        <table>
            <thead>
                <tr>
                    <th colspan="2">Producto</th>
                    <th>precio</th>
                    <th>nº</th>
                    <th>total</th>
                    <th>acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_acumulado = 0;
                foreach ($articulos as $articulo_id => $articulo) {
                    //var_dump($articulo);
                    $img = ($articulo["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$articulo["foto"]."' width='30px' />" :"";
                    $total = $articulo['unidades'] * $articulo['precio'];
                    $total_acumulado += $total;
                    echo "
                        <form method='post' action='".\core\URL::generar("carrito/modificar")."'>
                            <input type='hidden' name='articulo_id' value='$articulo_id' />
                            <tr>
                                <td></td>
                                <td>$img {$articulo['nombre']}</td>
                                <td>"
                                    .number_format($articulo['precio'], 2, ",", ".").
    //								.$articulo["precio"].
                                    "</td>
                                <td> x <input id='unidades' name='unidades' size='1' value='".number_format($articulo["unidades"], 0, ",", ".")."' /> = </td>
                                <td>"
                                . number_format($total,2,",",".") .
                                "</td>
                                <td>								
                                <input name='accion' type='submit' value='corregir' />
                                <input name='accion' type='submit' value='quitar' />
                                </td>
                            </tr>
                        </form>
                        ";
                }
                echo "<tr><td colspan='4'></td><td><b>".number_format($total_acumulado,2,",",".") ."</b></td><td></td></tr>";
                ?>
            </tbody>
	</table>
        
        
    <form id="form_vaciar_carrito" method='post' action='<?php echo \core\URL::generar("carrito/vaciar"); ?>'>
        <button  id="boton_vaciar_carrito"type='submit'>Vaciar Carrito</button>
    </form>
    <button id="boton_comprar" type='button' onclick='window.location.assign("<?php echo \core\URL::generar("carrito/comprar")?>");' >Comprar</button>

    <?php else :  ?>
	<h2>Carrito vacío.</h2>
    <?php endif; ?>    
        
    <span id='carrito_importe'><?php echo number_format(self::ejecutar("carrito","valor"),2,",","."); ?> €</span>


</div>
	
</div>