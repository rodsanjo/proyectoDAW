<!DOCTYPE html>
<html lang='<?php echo \core\Idioma::get(); ?>'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    
    <title><?php echo \core\Idioma::text("title", "dicc"); ?></title>
    <link href="<?php echo URL_ROOT ?>favicon_3da2.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="<?php echo URL_ROOT ?>favicon_3da2.ico" rel="icon" type="image/x-icon" />    
    
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
            <img width="15%" style="float: left;" src="<?php echo URL_ROOT; ?>recursos/imagenes/logo.jpg" title="logo: 3da2" alt="logo: 3da2"/>
            <div id="central_head" style="float: left;">
                <img width="20%" src="<?php echo URL_ROOT; ?>recursos/imagenes/logo_letras.jpg" title="3da2" alt="3da2"/>
                <div id="menu_up" >
                    <?php 
                        include PATH_APPLICATION."app/vistas/partes/menu_up.php";
                    ?>
                </div>
                <div id="sendero_migas_pan">
                    <?php echo \controladores\sendero::ver(); ?>
                </div>
            </div>
            <!--- inicio codigo relojesflash.com--->
            <table><tr><td><a href="http://www.relojesflash.com" title="relojes web"><embed style="margin: 15px;" src="http://www.relojesflash.com/swf/clock2015.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed></a></td></tr></table>
            <!--- fin codigo relojesflash.com--->
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
            <form class="form_buscar" method='post' action='<?php echo \core\URL::generar("articulos/busqueda"); ?>' onsubmit='return(document.getElementById("buscar_nombre").value.length>0);'>
                <input type='submit' value='Buscar' title='Buscar'/>
                <input type='text' id='buscar_nombre' name='buscar_nombre' title='Introduzca el nombre o parte del nombre del articulo a buscar'/>        
            </form>
            
            <div id="cuadro_login">
                <?php if( isset($_GET['p2']) && $_GET['p2'] == 'desconectar' ){
                        echo "<a class='destacado_l' href='".\core\URL::generar("usuarios/form_login")."'>Log in</a>";
                        echo "<br/><br/><a class='destacado_r' href='".\core\URL::generar("usuarios/form_insertar_externo")."'>Sign up</a>";
                    } else if (\core\Usuario::$login == 'anonimo') { ?>
                        <form class="validar_form_login" method='post' action='<?php echo \core\URL::generar("usuarios/form_login_validar"); ?>' >
                            <?php echo \core\HTML_Tag::form_registrar("form_login", "post"); ?>
                            Usuario:<br/><input type='text' id='login' name='login' value='<?php echo \core\Datos::values('login', $datos) ?>'/><br/>
                            Contraseña:<br/><input type='password' id='password' name='password' value='<?php echo \core\Datos::values('password', $datos) ?>'/><br/>
                            <input type='submit' value='Log in' class="destacado_l"/>
                        </form>
                <?php
                    if ((\core\Usuario::$login == "anonimo") && ! (\core\Distribuidor::get_controlador_instanciado() == "usuarios" && \core\Distribuidor::get_metodo_invocado() == "form_insertar_externo")) {
                        echo "
                            <a class='destacado_r' href='".\core\URL::generar("usuarios/form_insertar_externo")."'>Sign up</a>    
                        ";
                    }
                }else{ 
                ?>

                <div style="text-align: center;">
                    Usuario:
                    <?php 
                        echo "<b>".\core\Usuario::$login."</b><br/>";
                        echo " <a class='destacado_r' href='".\core\URL::generar("usuarios/desconectar")."'>Sign out</a>";
                    ?>
                </div>
                     <?php } ?>
                    
                
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
