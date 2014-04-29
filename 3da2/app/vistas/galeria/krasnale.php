<h2><img src="<?php echo URL_ROOT ?>/recursos/imagenes/Wroclaw_escudo.jpg" width="50px"/>  Krasnale encontrados en Wroclaw:</h2>
<div class='krasnale'>
<?php
    $i=0;
    foreach ($datos["ficheros"] as $fichero => $contador_descargas) {
        $fichero_ = explode('_', $fichero);  //Me quedo solo con lo anterior al guion bajo
        $i%2 == 0 ? $style = 'style="background: red; color: white;"' : $style = 'style="background: yellow;"';
        $src = URL_ROOT.'/recursos/ficheros/Krasnale/$fichero';
        echo "
            <div class='krasnal'>
                <img src='".URL_ROOT."/recursos/ficheros/Krasnale/$fichero' title='$fichero_[0]' alt='$fichero' height='150px'/>
                <br/>
                <center $style title='$fichero_[0]'><b>$fichero_[0]</b></center>
            </div>
";
        $i++;
    }
?>
</div>