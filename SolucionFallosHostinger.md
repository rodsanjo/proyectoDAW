1.Lo primero de todo es modificar la DB en:
    /public_html/3da2/app/core/configuracion.php
2.Eliminar la impresión de $_GLOBALS y de $_datos
    /public_html/3da2/app/vistas/plantilla_principal.php

3.Al Subir la aplicación de Localhost a un Host hay funciones que no trabajan de forma correcta, editar:
    1.Deslizamiento de imagenes:
        /public_html/3da2/app/vistas/inicio/index.php
            comentar Linea 13:   //include PATH_APP."vistas/partes/image_slide.php";
    2.Ajax, cambiar:
            <script type='text/javascript' src="<?php echo URL_APPLICATION_ROOT."recursos/js/carrito/carrito_localhost.js"; ?>" ></script>
        por:     
            <script type='text/javascript' src="<?php echo URL_APPLICATION_ROOT."recursos/js/carrito/carrito.js"; ?>" ></script>
    3.Si no funciona ajax:
        /public_html/3da2/app/vistas/articulos/index.php
            aprox. copiar linea 59 en linea 62
                <form id='form_carrito' name='form_carrito' method='post' action='".\core\URL::generar('carrito/meter_ajax')."' >
            en lugar de: 
                <form method='post' onsubmit='carrito_meter(this, event); return(false);'  >