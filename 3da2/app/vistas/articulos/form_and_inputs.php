
<form method='post' name='<?php echo \core\Array_Datos::contenido("form_name", $datos); ?>' action="<?php echo \core\URL::generar($datos['controlador_clase'].'/validar_'.$datos['controlador_metodo']); ?>" >
    <fieldset><legend>Datos artículo</legend>
	<?php echo \core\HTML_Tag::form_registrar($datos["form_name"], "post"); ?>
	
	<input id='id' name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos); ?>' />
	
        Nombre*: <input id='nombre' name='nombre' type='text' size='15'  maxlength='50' value='<?php echo \core\Array_Datos::values('nombre', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('nombre', $datos); ?>
	<br />
        
        Referencia: <input id='referencia' name='referencia' type='text' size='3'  maxlength='5' value='<?php echo \core\Array_Datos::values('referencia', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('simbolo_quimico', $datos); ?>
	<br />
        
        Autor: <input id='autor' name='autor' type='text' size='15'  maxlength='50' value='<?php echo \core\Array_Datos::values('autor', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('autor', $datos); ?>
	<br />
        
        Editorial: <input id='editorial' name='editorial' type='text' size='15'  maxlength='30' value='<?php echo \core\Array_Datos::values('editorial', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('editorial', $datos); ?>
	<br />
        
        Año: <input id='anho' name='anho' type='text' size='2'  maxlength='4' value='<?php echo \core\Array_Datos::values('anho', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('anho', $datos); ?>
	<br />
        
        Número de jugadores mínimo: <input id='num_min_jug' name='num_min_jug' type='text' size='1'  maxlength='2' value='<?php echo \core\Array_Datos::values('num_min_jug', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('num_min_jug', $datos); ?>
	<br />
        
        Número de jugadores máximo: <input id='num_max_jug' name='num_max_jug' type='text' size='1'  maxlength='2' value='<?php echo \core\Array_Datos::values('num_max_jug', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('num_max_jug', $datos); ?>
	<br />
        
        Duración: <input id='duracion' name='duracion' type='text' size='15'  maxlength='10' value='<?php echo \core\Array_Datos::values('duracion', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('duracion', $datos); ?>
	<br />
        
        Edad mínima recomendada: <input id='edad_min' name='edad_min' type='text' size='1'  maxlength='2' value='<?php echo \core\Array_Datos::values('edad_min', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('edad_min', $datos); ?>
	<br />
        
        Foto: <input id='foto' name='foto' type='file' size='100'  maxlength='50' value='<?php echo \core\Array_Datos::values('foto', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('foto', $datos); ?>
	<br />
        
        Video: <input id='video' name='video' type='file' size='100'  maxlength='50' value='<?php echo \core\Array_Datos::values('video', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('video', $datos); ?>
	<br />
        
        Manual:<input id='manual' name='manual' type='file' size='100'  maxlength='50' value='<?php echo \core\Array_Datos::values('manual', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('manual', $datos); ?>
	<br />
        
        <br/>
        Categoría:
        <select id='categoria' name="categoria">
            <?php
                $sql = 'select * from 3da2_categorias';
                $datos['categorias'] = \core\sgbd\mysqli::execute($sql);
                if (\core\Distribuidor::get_metodo_invocado() == "form_insertar") {
                    echo "<option disabled='true' selected='selected'>Seleccione una categoría</option>";
                }
                foreach ($datos['categorias'] as $key => $categoria) {
                    $value = "value = '$key'";
                    $selected = (\core\datos::values('categoria_id', $datos) == $categoria['categoria']) ? " selected='selected' " : "";
                    echo "<option $value $selected>{$categoria['categoria']}</option>\n";
                }
            ?>
        </select>
        <br/>
        
        Temática:
        <input id="tematica" name="tematica" type='text' maxlength='20'/>
        <br/>
        Reseña:<br/>
        <textarea id="resenha" name="resenha" maxlength='300' cols="50" rows="3"></textarea>
        <br/>
        Descripción:<br/>
        <textarea id="descripcion" name="descripcion" maxlength='500' cols="50" rows="5"></textarea>
        <br/>
        
        Precio: <input id='precio' name='precio' type='text' size='10'  maxlength='12' value='<?php echo \core\Array_Datos::values('precio', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('precio', $datos); ?>
	<br />
        
        Unidades en stock: <input id='unds_stock' name='unds_stock' type='text' size='3'  maxlength='5' value='<?php echo \core\Array_Datos::values('unds_stock', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('unds_stock', $datos); ?>
	<br />
        
        Fecha de salida: <input id='fecha_salida' name='fecha_salida' type='date' maxlength='10' value='<?php echo \core\Array_Datos::values('fecha_salida', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('fecha_salida', $datos); ?>
	<br />
        *Campos obligatorios
	<br />
	<?php echo \core\HTML_Tag::span_error('errores_validacion', $datos); ?>
	
	<input type='submit' value='Enviar'/>
	<input name="limpiar" type='reset' value='Limpiar'/>
        <button type='button' onclick='window.location.assign("<?php echo \core\URL::generar($datos['controlador_clase']); ?>");'>Cancelar</button>
    </fieldset>
</form>
