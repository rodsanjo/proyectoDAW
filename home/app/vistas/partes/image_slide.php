<ul class="slideshow">
    <?php
        $ruta_imagenes = URL_ROOT."recursos/imagenes/image_slide/";
        $imagenes = \modelos\ImageSlide::get_imageSlide();
        
        foreach ($imagenes as $key => $imagen) {
            echo "           
                <li class='show'>
                    <img src='$ruta_imagenes{$imagen['fichero']}' alt='&quot;{$imagen['comentario']}&quot;'/>
                </li>
            ";
        }
    ?>
</ul>
