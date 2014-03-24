<script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/validaciones.js"></script>
<style>
    span{
        color:red;
    }
    input, textarea{
        background: wheat;
    }
</style>
    
<h1 class="titulo">CONTACTO</h1>
<p>Si quiere poenrse en contacto con nostros para cualquier consulta, puede hacerlo
    a través de nuestro correo electrónico: <a href="mailto:email@3da2.es">email@3da2.es</a>
    o bien mediante el siguiente formulario y le contestaremos lo antes posible.
</p>
<form onsubmit="return validarForm();" name="formulario" action="pagina.php" method="post" enctype="multipart/form-data">
    <fieldset>
    <legend>Formulario de contacto</legend>
        <label for="nombre">Nombre:</label>
        <input id="nombre" onblur="validarNombre();" type="text" name= "nombre" value="" size="20" maxlength="30"/>
        <span id="error_nombre" class="span_error"></span><br/>
        
        <label for="email">Dirección de correo electrónico:</label>
        <input id="email" type="text" name="email"/><br/>

        <label for="mensaje">Mensaje:</label><br/>
        <textarea id="mensaje" name="mensaje" cols="30" rows="5"></textarea><br/>

        <small><p>*Atención: Todos los campos son obligatorios.</p></small>

        <input type="submit" name="enviar" value="Enviar" />
    </fieldset>
</form>

<script type="text/javascript">
    
</script>
