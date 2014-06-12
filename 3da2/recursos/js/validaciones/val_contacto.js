var ok = false;    
function validarNombre(){
	var valor = document.getElementById("nombre").value;
	var patron=/^([A-ZÑ]([a-zñ]{0,})(\s[A-ZÑa-zñ]([a-zñ]{0,})){0,})\s{0,}$/;
	if(!patron.test(valor)){
		document.getElementById("error_nombre").innerHTML="Debe empezar con mayúsculas y solo contener letras";
		//document.getElementById("nombre").value="";
		ok = false;
	}else{
		document.getElementById("error_nombre").innerHTML="";
	}                      
}

function validarEmail(){
	var valor = document.getElementById("email").value;
        //alert(valor);
	var patron= /^([a-z]{1}[a-z\d]{0,})(([\.|\_\-]{1}[a-z\d]{1,}){1,}){0,}@([a-z]{1}[a-z\d]{0,})(([\.|\_\-]{1}[a-z\d]{1,}){1,}){0,}(\.[a-z]{2,4})$/i;
	if(!patron.test(valor)){
		document.getElementById("error_email").innerHTML="El email es incorrecto. Formato cuenta@servidor.net";
		ok = false;
	}else{
		document.getElementById("error_email").innerHTML="";
	}
}

function validarAsunto(){
	var valor = document.getElementById("asunto").value;
        //alert(valor);
	var patron= /([\w]{1,})/i;
	if(!patron.test(valor)){
		document.getElementById("error_asunto").innerHTML="Debe contener al menos un caracter válido";
		ok = false;
	}else{
		document.getElementById("error_asunto").innerHTML="";
	}
}
function validarMensaje(){
	var valor = document.getElementById("mensaje").value;
        //alert(valor);
	var patron= /([\w]{1,})/i;
	if(!patron.test(valor)){
		document.getElementById("error_mensaje").innerHTML="Debe contener al menos un caracter válido";
		ok = false;
	}else{
		document.getElementById("error_mensaje").innerHTML="";
	}
}

function validarForm(){
	var f=formulario;
	ok=true;
	
	validarNombre();
	validarEmail();
	validarAsunto();
	validarMensaje()

	return ok;
}