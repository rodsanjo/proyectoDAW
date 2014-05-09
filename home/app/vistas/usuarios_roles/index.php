<div >
	<h2>Listado de roles asignados al usuario <i><?php echo $datos["login"]; ?></i></h2>
	<?php include "form_and_inputs.php"; ?>
	<script type='text/javascript'>
		$(" [type=checkbox] ").attr("disabled", "disabled");
		$(" [type=submit], [type=reset], [type=button] ").css("display", "none");
		
		function modificar_permisos() {
			$(" [type=checkbox] ").removeAttr("disabled");
			$(" [type=submit], [type=reset], [type=button] ").css("display", "inline");
			$(" button#btn_modificar, button#btn_cancelar ").css("display", "none");
		}
	</script>
        <?php
	if( \core\Usuario::tiene_permiso('usuarios_roles', 'form_modificar_validar')){ ?>
            <button id='btn_cancelar'type='button' onclick='location.assign("<?php echo\core\URL::generar("roles/index"); ?>");'>Cancelar</button>
            <button id='btn_modificar' type='button' onclick='modificar_permisos();'>Modificar Permisos</button>
        <?php } ?>
</div>