<div id="carrito_lateral">
    <center>
        <?php $src = URL_ROOT.'recursos/imagenes/baul.gif'; ?>
        <h3><img src="<?php echo $src ?>" title="baul" width="40px"/><?php echo iText('Baúl', 'dicc'); ?></h3>
        <button id='btn_desplegar_carrito'><?php echo iText('Mostrar', 'dicc'); ?> <b>/</b> <?php echo iText('Ocultar', 'dicc'); ?></button>
    </center>
        
    <div id='carrito_detalles' >
    
        <!-- Contenido de carrito se completa con ajax -->
        <?php
            //Sin ajax
            //Para que la primera vez al cargar aparezca el carrito, después será rellenado con ajax
            echo self::incluir("carrito", "ver");
        ?>
    </div>
    <center>
        <?php echo \core\HTML_Tag::a_boton("boton1", array("carrito"), iText('Ver el contenido del baúl', 'frases') ); ?>
    </center>
	
</div>
