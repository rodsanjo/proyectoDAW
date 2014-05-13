<h2 class="titulo_seccion"><img src="<?php echo URL_ROOT ?>recursos/imagenes/Wroclaw_escudo.jpg" width="50px"/>  Krasnale encontrados en Wroclaw  <img src="<?php echo URL_ROOT ?>recursos/imagenes/Wroclaw_escudo.jpg" width="50px"/></h2>
<center>
    <div class='krasnale'>
    <?php
        $i=0;
        foreach ($datos["ficheros"] as $fichero => $contador_descargas) {
            $src = URL_ROOT.'recursos/imagenes/krasnale/'.$fichero;
            $fichero_ = explode('_', $fichero);  //Me quedo solo con lo anterior al guion bajo
            $i%2 == 0 ? $style = 'style="background: red; color: white;"' : $style = 'style="background: yellow;"';
            echo "
                <div class='krasnal'>
                    <img src='$src' title='$fichero_[0]' alt='$fichero' height='150px'/>
                    <br/>
                    <center $style title='$fichero_[0]'><b>$fichero_[0]</b></center>
                </div>
    ";
            $i++;
        }
    ?>
    </div>
</center>