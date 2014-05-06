<img width="15%" style="float: left;" src="<?php echo URL_ROOT; ?>recursos/imagenes/logo.jpg" title="logo: 3da2" alt="logo: 3da2"/>
<div id="central_head" style="float: left;">
    <img width="20%" src="<?php echo URL_ROOT; ?>recursos/imagenes/logo_letras.jpg" title="3da2" alt="3da2"/>
    <div id="menu_up" >
        <?php 
            include PATH_APPLICATION."app/vistas/partes/menu_up.php";
        ?>
    </div>
    <div id="sendero_migas_pan">
        <?php echo \controladores\sendero::ver(); ?>
    </div>
</div>
<!--- inicio codigo relojesflash.com--->
<table><tr><td><a href="http://www.relojesflash.com" title="relojes web"><embed style="margin: 15px;" src="http://www.relojesflash.com/swf/clock2015.swf" wmode="transparent" type="application/x-shockwave-flash" height="100" width="100"><param name=wmode value=transparent></embed></a></td></tr></table>
<!--- fin codigo relojesflash.com--->
