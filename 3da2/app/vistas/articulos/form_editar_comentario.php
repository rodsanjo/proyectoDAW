<div id='cuadro_edicion_comentario'>
    <h2 class="titulo_seccion">Edicción de comentario.</h2>
    
    <p>Ahora puedes editar tu comentario. Una vez editado pulse enviar para corregir el comentario y descartar el anterior.</p>
    <p>Tendrás <?php echo \core\Configuracion::$minutos_edicion_comentario; ?> minutos para una posible corrección<p>
    <p><b>Recuerda respetar a los demás usuarios</b></p>
    
    <?php include "form_comentario.php"; ?>
    
    <script type='text/javascript'>
        var formulario = <?php echo \core\Array_Datos::contenido("form_name", $datos); ?>;
        window.document.getElementById("id").readOnly='readonly';
        window.document.getElementById("usuario_login").readOnly='readonly';
        formulario.restablecer.style.display = "none";                
    </script>
</div>
