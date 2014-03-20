<!DOCTYPE html>
<html lang='<?php echo \core\Idioma::get(); ?>'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    
    <title><?php echo \core\Idioma::text("title", "dicc"); ?></title>
    <link href="<?php echo URL_ROOT ?>3da2.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="<?php echo URL_ROOT ?>3da2.ico" rel="icon" type="image/x-icon" />    
    
    <meta name="Description" content="Explicación de la página: se explican los diferentes tipos de materiales para la construccci�n" />
    <meta name="Keywords" content="juegos de mesa, ocio,board game, rol, frikis, dados" />
    <meta name="Generator" content="con qué se ha hecho" />
    <meta name="Origen" content="3da2" />
    <meta name="Author" content="Jergo" />
    <meta name="Locality" content="Madrid, España" />
    <meta name="Lang" content="<?php echo \core\Idioma::get(); ?>" />
    <meta name="Viewport" content="maximum-scale=10.0" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="INDEX,FOLLOW,NOODP" />
    <meta http-equiv="Content-Language" content="<?php echo \core\Idioma::get(); ?>"/>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <style type="text/css" >
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/menu_up.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/menu_left_v.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/image_slide.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT.'recursos/css/'.\core\Distribuidor::get_controlador_instanciado(); ?>.css" />
    
    <script type="text/javascript" src="<?php echo \core\URL::generar_sin_idioma(); ?>recursos/js/f_cookies.js"></script>
    <script type="text/javascript" src="<?php echo \core\URL::generar_sin_idioma(); ?>recursos/js/idiomas.js"></script>
    
    <script type="text/javascript" src=""></script>
    <script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/jquery/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/funciones.js"></script>
    <script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/image_slide.js"></script>
    <script type="text/javascript">       
    /* líneas del script */
    </script>
</head>
<body>
    <div id="encabezado">
        <div class="teu">
            <img width="15%" style="float:left" src="<?php echo URL_ROOT; ?>recursos/imagenes/logo.jpg" alt="logo: 3da2"/>
            <div id="menu_up">
                <?php 
                    include PATH_APPLICATION."app/vistas/partes/menu_up.php";
                ?>
            </div>
        </div>
        
        <div id="idioma">
            <?php 
                include PATH_APPLICATION_APP."vistas/partes/idiomas.php";
            ?>
        </div>

        <hr/>
    </div>
    <div class="teu">
        <div id="menu_left_v">
            <?php 
                include PATH_APPLICATION_APP."vistas/partes/menu_left.php";
            ?>
        </div>
        <div id="view_content">
            <?php
                echo $datos['view_content'];
            ?>
        </div>
        <div class="slideshow" style="float:left">
                <?php 
                    include PATH_APPLICATION_APP."vistas/partes/image_slide.php";
                ?> 
        </div>
        <div id="view_content">
            <?php
                echo $datos['view_content'];
            ?>
        </div>
    </div>
    <div id="pie">
        <hr/><div>© 3da2<br/>
            <?php echo \core\Idioma::text("Diseñada por", "dicc"); ?>: <a href="mailto:jergo23@gmail.com" style="color:blue">Jergo</a><br/>
        </div>
    </div>
</body>
</html>
