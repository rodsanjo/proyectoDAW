<div id="enlaces">
    <h2 class="titulo_seccion"><?php echo iText('Enlaces', 'dicc'); ?></h2>
    <?php
        echo \core\HTML_Tag::a_boton("boton", array("enlaces", "form_anexar"), "Incluir un nuevo enlace");
    ?>
    <dl> 
        <?php          
            foreach ( $datos['enlaces'] as $id => $enlace ) {
                $patron = '/http:\/\//';
                if(! preg_match($patron, $enlace['url'])){
                    $enlace['url'] = 'http://'.$enlace['url'];
                }
                echo "<dt>
                        <a href='{$enlace['url']}' target='on_blank'>{$enlace['titulo']}</a>
                    </dt>
                    <dd>{$enlace['descripcion']}</dd>
                    <center>
                        ".\core\HTML_Tag::a_boton("", array("enlaces", "form_modificar", $id), "Modificar")
                            ." - "
                         .\core\HTML_Tag::a_boton("", array("enlaces", "form_borrar", $id), "Borrar")."
                    </center>
                    ";
            }
        ?>  
    </dl>
    <center>
        <?php
            echo \core\HTML_Tag::a_boton("boton1", array("enlaces", "form_anexar"), "Incluir un nuevo enlace");
        ?>
    </center>  
    <center><button onclick='window.location.assign(<?php echo URL_ROOT.\core\Distribuidor::get_controlador_instanciado()."/form_anexar" ?>);'>Incluir un nuevo enlace</button></center>
</div>
