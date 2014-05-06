<form class="form_buscar" method='post' action='<?php echo \core\URL::generar("articulos/busqueda"); ?>' onsubmit='return(document.getElementById("buscar_nombre").value.length>0);'>
    <input type='submit' value='Buscar' title='Buscar'/>
    <input type='text' id='buscar_nombre' name='buscar_nombre' title='Introduzca el nombre o parte del nombre del articulo a buscar'/>        
</form>
