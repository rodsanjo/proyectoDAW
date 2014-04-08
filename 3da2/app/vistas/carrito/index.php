<div>	
    <button id='btn_carrito' onclick='$("#carrito_detalles").css("display","block");' >Carrito</button>
        
    <?php
    $articulos = $datos["carrito"]->get_articulos();
    //var_dump($articulos);
    //var_export($articulos);
    ?>
    <div id='carrito_detalles' >
    <?php if ($articulos) :?>
	<form method='post' action='<?php echo \core\URL::generar("carrito/vaciar"); ?>'>
            <button type='submit'>Vaciar Carrito</button>
	</form>
        <button onclick='$("#carrito_detalles").css("display","none");'>Ocultar</button>
        <div id="carrito_lateral">
            <?php
                $total_acumulado = 0;
                foreach ($articulos as $articulo_id => $articulo) {
                    $total = $articulo['unidades'] * $articulo['precio'];
                    $total_acumulado += $total;
                    echo "
                        <td>".number_format($articulo["unidades"], 0, ",", ".")." x </td>
                        <td>{$articulo['nombre']}</td>
                        <td>".number_format($total,2,",",".")."</td>
                            
                            <form method='post' action='".\core\URL::generar("carrito/modificar")."'>
                                    <input type='hidden' name='articulo_id' value='$articulo_id' />
                            <tr>
                                    <td>{$articulo['nombre']}</td>
                                    <td></td>
                                    <td><input id='unidades' name='unidades' size='8' value='".number_format($articulo["unidades"], 0, ",", ".")."' /></td>
                                    <td>"
                                                    .number_format($articulo['precio'], 2, ",", ".").
//								.$articulo["precio"].
                                                    "</td>

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
            
        </div>
        <table border='1'>
            <thead>
                    <tr>
                            <th>nombre</th>
                            <th>foto</th>
                            <th>unidades</th>
                            <th>precio</th>
                            <th>total</th>
                            <th>acciones</th>
                    </tr>
            </thead>
            <tbody>
                    <?php
                    $total_acumulado = 0;
                    foreach ($articulos as $articulo_id => $articulo) {
//				$img = ($articulo["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$articulo["foto"]."' width='100px' />" :"";
                            $total = $articulo['unidades'] * $articulo['precio'];
                            $total_acumulado += $total;
                            echo "
                                    <form method='post' action='".\core\URL::generar("carrito/modificar")."'>
                                            <input type='hidden' name='articulo_id' value='$articulo_id' />
                                    <tr>
                                            <td>{$articulo['nombre']}</td>
                                            <td></td>
                                            <td><input id='unidades' name='unidades' size='8' value='".number_format($articulo["unidades"], 0, ",", ".")."' /></td>
                                            <td>"
                                                            .number_format($articulo['precio'], 2, ",", ".").
//								.$articulo["precio"].
                                                            "</td>

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
	<button type='button' onclick='window.location.assign("<?php echo \core\URL::generar("carrito/comprar")?>");' >Comprar</button>
<?php else :  ?>
	<h2>Carrito vacío.</h2>
<?php endif; ?>
        
        
    <span id='carrito_importe'><?php echo number_format(self::ejecutar("carrito","valor"),2,",","."); ?> €</span>


</div>
	
</div>