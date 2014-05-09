<div id='cuadro_comentario' >
    <form class='<?php echo \core\Array_Datos::contenido("form_name", $datos); ?>' name='<?php echo \core\Array_Datos::contenido("form_name", $datos); ?>' method='post' action='<?php echo \core\URL::generar($datos['controlador_clase'].'/validar_'.$datos['controlador_metodo']); ?>' onsubmit='return (window.document.getElementById("comentario").innnerHTML.length>0)'>
        
        <!--//Dos formas dependiendo si usamos articulo_id o articulo_nombre como FK-->
        <input id="id" name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos); ?>'/>
        <!--<input name='articulo_nombre' type='hidden' value='{$datos['articulo']['articulo_nombre']}'/>-->
        
        <input id="usuario_login" name='usuario_login' type='hidden' value='<?php echo \core\Array_Datos::values('usuario_login', $datos); ?>'/>
        <textarea type='text' id='comentario' name='comentario' maxlength='500' cols='95' rows='5'><?php echo \core\Array_Datos::values('comentario', $datos); ?></textarea>      
        
        <?php echo \core\HTML_Tag::span_error('errores_validacion', $datos); ?>
        
        <input type='submit' value='<?php echo \core\Idioma::text('Enviar', 'dicc'); ?>'/>
        <input name="restablecer" type='reset' value='<?php echo iText('Restablecer', 'dicc'); ?>'/>
        <a class='boton1' style="float:right;" href='<?=$datos["url_volver"]?>' ><?php echo \core\Idioma::text('Cancelar', 'dicc'); ?></a>
    </form>
</div>
