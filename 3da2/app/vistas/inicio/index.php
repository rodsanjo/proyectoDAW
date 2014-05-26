<script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/image_slide.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT ?>recursos/css/image_slide.css" />
<script type="text/javascript" src="<?php echo URL_ROOT ?>recursos/js/image_slide.js"></script>

<h2 class="titulo_seccion">
    <?php echo \core\Idioma::text("saludo1", "frases"); ?>
</h2>
<p style="text-align: justify;">
    <?php echo iText('parrafo1', 'frases') ?>
</p>
<div class="slideshow" style="float:left">
    <?php 
        include PATH_APP."vistas/partes/image_slide.php";
    ?> 
</div>

