<div >
	<h2>Alta de un nuevo usuario</h2>
	<?php //echo __FILE__; var_dump($datos); ?>
	<form name="formulario"  method='post' action="<?php echo \core\URL::generar("usuarios/".\core\Distribuidor::get_metodo_invocado()."_validar"); ?>" >
		
		<input id='id'  name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos); ?>' />

		<label id="labelLogin" for="login">Login:</label>
                <input id='login' name='login' type='text' size='20'  maxlength='20' autocomplete='off' value='<?php echo \core\Array_Datos::values("login", $datos); ?>'/>
		<?php echo \core\HTML_Tag::span_error('login', $datos); ?>
		<br />

		Email:
                <input id='email' name='email' type='text' size='50' maxlength='100' autocomplete='off' value='<?php echo \core\Array_Datos::values('email', $datos); ?>'/>
		<?php echo \core\HTML_Tag::span_error('email', $datos); ?>
		<br />

		Repita el email:
                <input id='email' name='email2' type='text' size='50' maxlength='100' autocomplete='off' value='<?php echo \core\Array_Datos::values('email2', $datos); ?>'/>
		<?php echo \core\HTML_Tag::span_error('email2', $datos); ?>
		<br />

		Contraseña:
                <input id='password' name='password' type='password' size='20'  maxlength='20' autocomplete='off' value='<?php echo \core\Array_Datos::values('password', $datos); ?>'/>
		<?php echo \core\HTML_Tag::span_error('password', $datos); ?>
		<br />

		Repita la contraseña: <input id='password2' name='password2' type='password' size='30'  maxlength='30' autocomplete='off' value='<?php echo \core\Array_Datos::values('password2', $datos); ?>'/>
		<?php echo \core\HTML_Tag::span_error('password2', $datos); ?>
		<br />
                
                DNI:
                <input onblur="return validarDNI(document.formulario.dni.value);" type="text" name="dni" value="" size="10" maxlength="8" />
                -<input type="text" name="letraDNI" readonly="readonly" size="1"/>
                <span id="error_dni" class='input_error'></span><br/>

                Sexo:<span id="error_sexo" class='input_error'></span><br/>             
                <input id="sexo_hombre" type="radio" name="sexo" value="hombre"/>Hombre<br/>
                <input id="sexo_mujer" type="radio" name="sexo" value="mujer"/>Mujer<br/>
                
		<?php
		if (\core\Distribuidor::get_metodo_invocado() == "form_insertar_externo" && \core\Configuracion::$form_insertar_externo_catcha) {
			require_once(PATH_APP.'lib/php/recaptcha-php-1.11/recaptchalib.php');
			$publickey = "6Lem1-sSAAAAAGBkb_xsqktWUMRvoYBT4z0DZL3U"; // you got this from the signup page
			echo recaptcha_get_html($publickey);
		}
		?>
                <br/><small>*Todos los campos son obligatorios</small><br/>
                
                <br/>
                <input name="publ" type="checkbox" value="publicidad" checked="checked"/>  
                Deseo recibir publicidad sobre ofertas y promociones<br/>

                <input id="aceptado" name="aceptado" type="checkbox"/>  
                Acepto ser incluido en la base de datos de 3da2
                <span id="error_aceptado" class='input_error'></span><br/>
                
		
		<?php echo \core\HTML_Tag::span_error('validacion', $datos);?><br />
		<input type='submit' value='Enviar' onmousemove="validarAceptado();">
		<?php if (\core\Distribuidor::get_metodo_invocado() != "form_borrar" ): ?>
			<input type='reset' value='Limpiar'>
		<?php endif; ?>
			<input type='button' value='Cancelar' onclick='window.location.assign("<?php echo \core\Datos::contenido("url_cancelar", $datos); ?>");'/>
	</form>

	
</div>
<script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/validaciones/val_form_user.js"></script>