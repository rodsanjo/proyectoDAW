<div >
	<h2>Modificar Password</h2>
	<?php //echo __FILE__; var_dump($datos); ?>
	<form method='post' action="<?php echo \core\URL::generar("usuarios/".\core\Distribuidor::get_metodo_invocado()."_validar"); ?>" >
	    <fieldset>
            <legend>Modificación de datos</legend>
		<input id='id'  name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos); ?>' />

		Login: <input id='login' name='login' type='text' size='20'  maxlength='20' autocomplete='off' value='<?php echo \core\Array_Datos::values("login", $datos); ?>'/>
		<?php echo \core\HTML_Tag::span_error('login', $datos); ?>
		<br />
                
                Anterior contraseña: <input id='password_old' name='password_old' type='password' size='20'  maxlength='20' autocomplete='off' value=''/>
		<?php echo \core\HTML_Tag::span_error('password_old', $datos); ?>
		<br />

		Nueva contraseña: <input id='password' name='password' type='password' size='20'  maxlength='20' autocomplete='off' value='<?php echo \core\Array_Datos::values('password', $datos); ?>'/>
		<?php echo \core\HTML_Tag::span_error('password', $datos); ?>
		<br />

		Repita la contraseña: <input id='password2' name='password2' type='password' size='20'  maxlength='20' autocomplete='off' value='<?php echo \core\Array_Datos::values('password2', $datos); ?>'/>
		<?php echo \core\HTML_Tag::span_error('password2', $datos); ?>
		<br />

		<br />
                <small>*Todos los campos son requeridos</small>
		<?php echo \core\HTML_Tag::span_error('validacion', $datos);?><br />
		<input type='submit' value='Enviar'>
		<?php if (\core\Distribuidor::get_metodo_invocado() != "form_borrar" ): ?>
			<input type='reset' value='Limpiar'>
		<?php endif; ?>
			<input type='button' value='Cancelar' onclick='window.location.assign("<?php echo \core\Datos::contenido("url_cancelar", $datos); ?>");'/>
            </fieldset>
        </form>
	<script type='text/javascript'>
		window.document.getElementById("login").readOnly='readonly';
		
	</script>

	
</div>