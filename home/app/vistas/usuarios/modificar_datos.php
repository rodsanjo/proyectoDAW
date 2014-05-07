<?php
    $usuario = $datos['filas'][0];
    //var_dump($usuario);
?>
<div >
    <h2>Modificación de datos del usuario <?php echo \core\Usuario::$login ?></h2>
    <ul>
        <li>
            <?php echo \core\HTML_Tag::a_boton("boton", array("usuarios", "form_cambiar_password", $usuario['id']), iText('Cambiar contraseña', 'frases') ) ?>
        </li>
    </ul>
	
</div>
