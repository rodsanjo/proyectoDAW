<h1 class="titulo_seccion"><?php echo ucfirst(iText('Comprar', 'dicc')); ?></h1>

<p>
    Para confirmar su compra debe realizar un ingreso al número de cuenta XXXX-XXXX-XX-XXXXXXXXXX por valor de un total de 
    <b><span id='carrito_importe'><?php echo number_format(self::ejecutar("carrito","valor"),2,",","."); ?> €</span></b>.    
</p>
<p> Después dirijase a la sección de contacto indicando en el asunto su referencia.</p>
