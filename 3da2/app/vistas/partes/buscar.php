<form class="form_buscar" method='post' action='<?php echo \core\URL::generar("articulos/busqueda"); ?>' onsubmit='return(document.getElementById("buscar_nombre").value.length>0);'>
    <input type='submit' value='<?php echo iText('Buscar', 'dicc'); ?>' title='<?php echo iText('Buscar', 'dicc'); ?>'/>
    <input type='text' id='buscar_nombre' name='buscar_nombre' title='Introduzca el nombre o parte del nombre delrticulo a buscar'/>        
</form>
