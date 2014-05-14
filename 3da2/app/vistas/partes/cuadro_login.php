<?php
    $log_in = iText('Conectarse', 'dicc');
    $sign_up = iText('Registrarse', 'dicc');
    $log_out = iText('Desconectarse', 'dicc');
    if( isset($_GET['p2']) && $_GET['p2'] == 'desconectar' ){
        echo "<a class='destacado_l' href='".\core\URL::generar("usuarios/form_login")."'>$log_in</a>";
        echo "<br/><br/><a class='destacado_r' href='".\core\URL::generar("usuarios/form_insertar_externo")."'>$sign_up</a>";
    } else if (\core\Usuario::$login == 'anonimo') { ?>
        <form class="validar_form_login" method='post' action='<?php echo \core\URL::generar("usuarios/form_login_validar"); ?>' >
            <?php echo \core\HTML_Tag::form_registrar("form_login", "post"); ?>
            <?php echo iText('Usuario', 'dicc'); ?>:<br/><input type='text' id='login' name='login' value=''/><br/>
            <?php echo iText('Contraseña', 'dicc'); ?>:<br/><input type='password' id='password' name='password' value=''/><br/>
            <input type='submit' value='<?php echo $log_in ?>' class="destacado_l"/>
        </form>
<?php
    if ((\core\Usuario::$login == "anonimo") && ! (\core\Distribuidor::get_controlador_instanciado() == "usuarios" && \core\Distribuidor::get_metodo_invocado() == "form_insertar_externo")) {
        echo "
            <a class='destacado_r' href='".\core\URL::generar("usuarios/form_insertar_externo")."'>$sign_up</a>    
        ";
    }
}else{ 
?>

<div style="text-align: center;">
    <?php
        echo iText('Usuario', 'dicc').": ";
        echo "<b>".\core\Usuario::$login."</b><br/>";
        echo " <a class='destacado_r' href='".\core\URL::generar("usuarios/desconectar")."'>$log_out</a>";
    ?>
    <br/><br/>
    <form method="post" action="<?php echo \core\URL::generar("usuarios/modificar_datos"); ?>">
        <input type="hidden" name="login" value="<?php echo \core\Usuario::$login ?>"/>
        <input type="submit" value="<?php echo iText('Modificar datos', 'frases') ?>"/>
    </form>
</div>
     <?php } ?>
