<div >
    <h2 class="titulo_seccion">Edicción de comentario</h2>
    <?php include "form_comentario.php"; ?>
    <script type='text/javascript'>
        var formulario = <?php echo \core\Array_Datos::contenido("form_name", $datos); ?>;
        window.document.getElementById("id").readOnly='readonly';
        window.document.getElementById("usuario_login").readOnly='readonly';
        formulario.restablecer.style.display = "none";                
    </script>
</div>
