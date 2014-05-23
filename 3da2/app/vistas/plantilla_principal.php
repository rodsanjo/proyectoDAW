<!DOCTYPE html>
<html lang='<?php echo \core\Idioma::get(); ?>'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    
    <title><?php echo \core\Idioma::text("title", "dicc"); ?></title>
    <link href="<?php echo URL_ROOT ?>favicon_3da2.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="<?php echo URL_ROOT ?>favicon_3da2.ico" rel="icon" type="image/x-icon" />    
    
    <meta name="description" content="tienda online de juegos de mesa shop online about board games" />
    <meta name="keywords" content="juegos,mesa,ocio,board,game,boardgame,dados,rol,frikis" />
    <meta name="rating" content="General">
    <meta name="generator" content="con qué se ha hecho" />
    <meta name="origen" content="3da2" />
    <meta name="author" content="Jergo" />
    <meta name="owner" content="3da2">
    <meta name="locality" content="Madrid, España" />
    <meta name="lang" content="<?php echo \core\Idioma::get(); ?>" />
    <meta name="viewport" content="maximum-scale=10.0" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="INDEX,FOLLOW,NOODP" />
    <meta http-equiv="content-Language" content="<?php echo \core\Idioma::get(); ?>"/>
    <meta http-equiv="content-Type" content="text/html;charset=utf-8" />

    <style type="text/css" >
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo URL_HOME_ROOT ?>recursos/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/menu_up.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/menu_left_v.css" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT.'recursos/css/'.\core\Distribuidor::get_controlador_instanciado(); ?>.css" />
    
    <script type="text/javascript" src="<?php echo URL_HOME_ROOT ?>recursos/js/f_cookies.js"></script>
    <script type="text/javascript" src="<?php echo URL_HOME_ROOT ?>recursos/js/idiomas.js"></script>
    
    <script type="text/javascript" src=""></script>
    <script type="text/javascript" src="<?php echo URL_HOME_ROOT ?>recursos/js/jquery/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/funciones.js"></script>
    <script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/image_slide.js"></script>
    
    <script type="text/javascript">       
    /* líneas del script */
    </script>
</head>
<body>
    <div id="encabezado">
        <div class="teu">
            <div id="titulo_cabecera">
                <?php 
                include PATH_APPLICATION_APP."vistas/partes/titulo_cabecera.php";
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
            <?php echo \core\HTML_Tag::li_menu("menu_adm", array("usuarios"), "Usuarios"); ?>
            <?php echo \core\HTML_Tag::li_menu("menu_adm", array("roles"), "Roles"); ?>
        </div>
        
        <div id="sidebar_right">
            <div id="buscar">
                <?php 
                    include PATH_APPLICATION_APP."vistas/partes/buscar.php";
                ?>
            </div>       
            <div id="cuadro_login">
                <?php 
                    include PATH_APPLICATION_APP."vistas/partes/cuadro_login.php";
                ?>  
            </div>
            <div id='carrito'>
                <?php
                    echo self::incluir("carrito", "ver");
                    //echo $datos["carrito"];
                ?>
            </div>
            
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
    
<?php
if (isset($_SESSION["alerta"])) {
    echo <<<heredoc
<script type="text/javascript" />
    alert("{$_SESSION["alerta"]}");
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
//                print("\$_GET "); print_r($_GET);
//                print("\$_POST ");print_r($_POST);
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
