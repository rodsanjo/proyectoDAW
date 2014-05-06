<?php
    if( isset($_GET['p2']) && $_GET['p2'] == 'desconectar' ){
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
        echo " <a class='destacado_r' href='".\core\URL::generar("usuarios/desconectar")."'>Log out</a>";
    ?>
    <br/><br/>
    <form method="post" action="<?php echo \core\URL::generar("usuarios/modificar_datos"); ?>">
        <input type="hidden" name="login" value="<?php echo \core\Usuario::$login ?>"/>
        <input type="submit" value="Modificar datos"/>
    </form>
</div>
     <?php } ?>
