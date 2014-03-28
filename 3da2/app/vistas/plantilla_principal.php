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
    <link rel="stylesheet" type="text/css" href="<?php echo URL_HOME_ROOT ?>recursos/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/menu_up.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/menu_left_v.css" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT.'recursos/css/'.\core\Distribuidor::get_controlador_instanciado(); ?>.css" />
    
    <script type="text/javascript" src="<?php echo \core\URL::generar_sin_idioma(); ?>recursos/js/f_cookies.js"></script>
    <script type="text/javascript" src="<?php echo \core\URL::generar_sin_idioma(); ?>recursos/js/idiomas.js"></script>
    
    <script type="text/javascript" src=""></script>
    <script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/jquery/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/funciones.js"></script>
    
    <script type="text/javascript">       
    /* líneas del script */
    </script>
</head>
<body>
    <div id="encabezado">
        <div class="teu">
            <img width="15%" style="float:left" src="<?php echo URL_ROOT; ?>recursos/imagenes/logo.jpg" alt="logo: 3da2"/>
            <div id="menu_up" style="clear:both">
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
        <div id="sendero_migas_pan">
            <?php echo \controladores\sendero::ver(); ?>
        </div>
        <form class="form_buscar" method='post' action='<?php echo \core\URL::generar("articulos/busqueda"); ?>' onsubmit='return(document.getElementById("buscar_nombre").value.length>0);'>
            <input type="text" id='buscar_nombre' name='nombre' />
            <input type='submit' value='Buscar' />
        </form>
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
    
<?php
if (isset($_SESSION["alerta"])) {
    echo <<<heredoc
<script type="text/javascript" />
    // alert("{$_SESSION["alerta"]}");
    var alerta = '{$_SESSION["alerta"]}';
</script>
heredoc;
    unset($_SESSION["alerta"]);
}
elseif (isset($datos["alerta"])) {
    echo <<<heredoc
<script type="text/javascript" />
    // alert("{$datos["alerta"]}");
    var alerta = '{$datos["alerta"]}';
</script>
heredoc;
}
?>	
	
    <div id='globals'>
        <?php
            var_dump($datos);
            print "<pre>"; 
                print_r($GLOBALS);
                print("\$_GET "); print_r($_GET);
                print("\$_POST ");print_r($_POST);
//                print("\$_COOKIE ");print_r($_COOKIE);
//                print("\$_REQUEST ");print_r($_REQUEST);
//    		print("\$_SESSION ");print_r($_SESSION);
//                print("\$_SERVER ");print_r($_SERVER);
            print "</pre>";
//            print("xdebug_get_code_coverage() ");
//            var_dump(xdebug_get_code_coverage());
        ?>
    </div>
</body>
</html>
