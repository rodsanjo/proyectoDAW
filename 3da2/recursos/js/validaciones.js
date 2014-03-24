var ok = false;    
function validarNombre(){
	var valor = document.getElementById("nombre").value;
	var patron=/^([A-ZÑ]([a-zñ]{0,})(\s[A-ZÑa-zñ]([a-zñ]{0,})){0,})\s{0,}$/;
	if(!patron.test(valor)){
		document.getElementById("error_nombre").innerHTML="Debe empezar con mayúsculas y solo contener letras";
		document.getElementById("nombre").style.color = "red";
		//document.getElementById("nombre").value="";
		document.getElementById("nombre").focus();                
		ok = false;
	}else{
		document.getElementById("nombre").style.color = "black";
		document.getElementById("labelNombre").style.color = "green";
		document.getElementById("error_nombre").innerHTML="";
	}                      
}

function validarApellidos(){
	var valor = formulario.apellidos.value;
	var patron=/^([A-ZÑ]([a-zñ]{0,})(\s[A-ZÑa-zñ]([a-zñ]{0,})){0,})\s{0,}$/;
	if(!patron.test(valor)){
		document.getElementById("error_apellidos").innerHTML="Debe empezar con mayúsculas y contener letras o espacios en blanco";
		formulario.apellidos.style.color = "red";
		ok = false;
	}else{
		formulario.apellidos.style.color = "black";
		document.getElementById("error_apellidos").innerHTML="";
	}                      
}

function validarPassword(){
	var valor = document.getElementById("password").value;
	var patron=/\W/;
	if(patron.test(valor)||valor.length<4){
		document.getElementById("error_password").innerHTML="Debe tener mínimo 4 caracteres y contener caracteres válidos";
		document.getElementById("password").value="";
		ok = false;
	}else{
		document.getElementById("password").style.color = "black";
		document.getElementById("error_password").innerHTML="";
	}  
        //document.write(valor);
}

function validarRePassword(){
	var valor1 = document.getElementById("password").value;
	var valor2 = document.getElementById("re_password").value;
	if(valor1!==valor2){
		document.getElementById("error_re_password").innerHTML="Ambas contraseñas deben de coincidir";
		document.getElementById("re_password").value="";               
		ok = false;
	}else{
		document.getElementById("error_re_password").innerHTML="";
	}                      
}

function validarDNI(x){            
	var patron=/^\d{8}$/;
	if(!patron.test(x)){
		document.getElementById("error_dni").innerHTML="Debe escribir 8 números sin letra";                
		ok = false;
	}else{
		document.getElementById("error_dni").innerHTML="";
		ponerLetra(x);
	}
}
function ponerLetra(dni){			
	var letras = "TRWAGMYFPDXBNJZSQVHLCKET";			
	formulario.letraDNI.value = letras.substr(dni%23,1);	//letras.slice(dni%23,dni%23+1)
}

/*
function validarSexo(){        
	var hombre = document.getElementById("sexo_hombre").checked;
	var mujer = document.getElementById("sexo_mujer").checked;            
	if(!(hombre||mujer)){
	   document.getElementById("error_sexo").innerHTML="Debe marcar una opción";                
	   ok = false;
		//alert(document.formulario.sexo.checked);
	}else
	   document.getElementById("error_sexo").innerHTML="";
}
*/
//another way
function validarSexo(){     //no necesitas el id de los type='radio'
	var marcadoSexo = false;
	for(i=0; i<formulario.sexo.length && !marcadoSexo; i++){	//Optimización: && !marcadoSexo, type='radio' solo permite marcar una opción
		if(formulario.sexo[i].checked){
			marcadoSexo = formulario.sexo[i].checked; 	//true or false
			sexo = formulario.sexo[i].value;
		}
	}
	if(!marcadoSexo){	//Asi no funciona poorque siempre habrá una opción no seleccionada por lo que siempre entraria aqui.
		document.getElementById("error_sexo").innerHTML="Debe marcar una opción";                
		ok = false;
	}else{
		//alert("el sexo elegido es: "+sexo);
		document.getElementById("error_sexo").innerHTML="";			
	}
}

function validarAficiones(){
	var numAfic=0;
	var numAficMin = 3;
	
	if(document.formulario.ajedrez.checked)
		numAfic++;
	if(document.formulario.baloncesto.checked)
		numAfic++;
	if(document.formulario.ciclismo.checked)
		numAfic++;
	if(document.formulario.formula1.checked && numAfic < numAficMin)
		numAfic++;
	if(document.formulario.futbol.checked && numAfic < numAficMin)
		numAfic++;
	if(document.formulario.boardgame.checked && numAfic < numAficMin)
		numAfic++;
	if(document.formulario.motor.checked && numAfic < numAficMin)
		numAfic++;
	if(document.formulario.padel.checked && numAfic < numAficMin)
		numAfic++;
	if(document.formulario.tenis.checked && numAfic < numAficMin)
		numAfic++;
	if(document.formulario.tenismesa.checked && numAfic < numAficMin)
		numAfic++;
	if(document.formulario.videojuegos.checked && numAfic < numAficMin)
		numAfic++;
		
	if(numAfic < numAficMin){
		document.getElementById("error_aficiones").innerHTML = "Debe seleccionar al menos "+numAficMin+" aficiones.";
		ok =false;
	}else{
		document.getElementById("error_aficiones").innerHTML = "";
	}
}

function validarAceptado(){        
	var valor = formulario.aceptado;	//document.getElementById("aceptado")
	if(!valor.checked){
	   document.getElementById("error_aceptado").innerHTML="Debe aceptar los terminos de licencia";                
	   ok = false;
	}else{
	   document.getElementById("error_aceptado").innerHTML="";               
   }
}

function validarForm(){
	var f=formulario;
	ok=true;
	
	validarNombre();
	validarApellidos();
	validarPassword();
	validarRePassword()
	validarDNI(f.dni.value);
	validarSexo();
	validarAficiones();
	validarAceptado();
	
	if(ok){
		ponerCookies();    //Si los datos son validos los leemos con cookies
	}
	ok=false;	//Si devolvemos false, no se envia el formulario
	return ok;
}