<link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/image_slide.css" />
<script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/image_slide.js"></script>

<p>
    <?php echo \core\Idioma::text("saludo1", "dicc"); ?>
</p>
<div class="slideshow" style="float:left">
    <?php 
        include PATH_APPLICATION_APP."vistas/partes/image_slide.php";
    ?> 
</div>

