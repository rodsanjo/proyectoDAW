<h2 class="titulo_seccion"><?php echo iText('Reglamentos de juego disponibles', 'frases'); ?>:</h2>
<ul>
<?php
    
    $metodo = ($datos["carpeta"] == "js") ? "js" : "file";

    foreach ($datos["ficheros"] as $fichero => $contador_descargas) {
        
        //Conseguir el titulo del juego para que lo ponga escrito:
        $titulo = \modelos\ficheros::get_titulo_articulo($fichero);
        
        echo "<li><a href='".URL_ROOT."?p1=download&p2=$metodo&p3=manuales&p4=$fichero' >Reglamento de $titulo</a> <span style=''text-align: right;'>Total descargas: $contador_descargas</span></li>";
        //No funciona en amigable:
        //echo "<li><a href='".\core\URL::generar("download/$metodo/{$datos["carpeta"]}/$fichero")."'>Reglamento de $titulo</a> <span style=''text-align: right;'>Total descargas: $contador_descargas</span></li>";
    }
?>
</ul>