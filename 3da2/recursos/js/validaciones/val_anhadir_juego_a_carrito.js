function hayDisponibilidad(){
    var f = formulario_anhadir;
    var unidades_solicitadas = f.unidades.value;
    //alert("unidades solicitadas = "+unidades_solicitadas);
    //alert("unidades stock = "+unds_stock);
    if(unidades_solicitadas > unds_stock){
        document.getElementById("error_disponibilidad").innerHTML="Lo siento, no hay suficiente disponibilidad para la cantidad de articulos solicitados";                
	return false;
    }
    return true;
}


