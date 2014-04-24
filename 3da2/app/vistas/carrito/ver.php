<div>
    <?php echo \core\HTML_Tag::a_boton("boton", array("carrito"), "ver carrito"); ?>
    <button id='btn_carrito' onclick='<?php echo \core\URL::generar("carrito"); ?>' >Ver carrito</button>
    <button id='btn_carrito' onclick='$("#carrito_detalles").css("display","block");' >Carrito</button>
        
    <?php
    $articulos = $datos["carrito"]->get_articulos();
    //var_dump($articulos);
    //var_export($articulos);
    ?>
    <div id='carrito_detalles' >
    <?php if ($articulos) : ?>
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
                    $nombre_corto = substr($articulo['nombre'], 0, 8);
                    $nombre_corto = strlen($articulo['nombre']) <8 ? $nombre_corto : $nombre_corto.'...' ;
                    echo "
                        

                        <form method='post' action='".\core\URL::generar("carrito/modificar")."'>
                            <input type='hidden' name='articulo_id' value='$articulo_id' />
                            <input type='hidden' name='unidades' value='".number_format($articulo["unidades"], 0, ",", ".")."' />
                            <span class='car_nxart'>".number_format($articulo["unidades"], 0, ",", ".")." x $nombre_corto</span>
                            <span>".number_format($total,2,",",".")."</span>
                            <input name='accion' type='submit' value='x' />
                        </form>
                            ";
                }
                echo "<b><span class='car_nxart'>Total</span>
                    ".number_format($total_acumulado,2,",",".") ." €</b>";
                //number_format(self::ejecutar("carrito","valor"),2,",",".")
            ?>
            
        </div>
        
	<button type='button' onclick='window.location.assign("<?php echo \core\URL::generar("carrito/comprar")?>");' >Comprar</button>
<?php else : 
	echo "<b><span class='car_nxart'>Total</span>
            ".number_format(self::ejecutar("carrito","valor"),2,",",".")." €</b>";
 endif; ?>

</div>
	
</div>