var ok = false;    
function validarLogin(){
	var valor = formulario.login.value; //document.getElementById("login").value;
        //alert(valor);
	var patron=/^[a-z]{1}[a-z\d]{3,}$/;
	if(!patron.test(valor)){
		document.getElementById("error_login").innerHTML="Debe empezar por letra y tener al menos 4 caracteres, admitiendose letras y números, pero no la ñ";
		document.getElementById("login").style.color = "red";
		//document.getElementById("login").value="";
		document.getElementById("login").focus();
		ok = false;
	}else{
		document.getElementById("login").style.color = "black";
		document.getElementById("error_login").innerHTML="";
	}                      
}

function validarPassword(){
	var valor = formulario.password.value;
	var patron=/\W/;
	if(patron.test(valor)||valor.length<6){
		document.getElementById("error_password").innerHTML="Debe tener mínimo 6 caracteres con al menos 2 letras y 2 números, conteniendo caracteres válidos (letras, números o guión bajo)";
		document.getElementById("password").value="";
		ok = false;
	}else{
		document.getElementById("error_password").innerHTML="";
	}
}

function validarRePassword(){
	var valor1 = formulario.password.value;
	var valor2 = formulario.password2.value;
        //alert(valor1+' - '+valor2);
	if(valor1!==valor2){
		document.getElementById("error_password2").innerHTML="Ambas contraseñas deben de coincidir";
		document.getElementById("password2").value="";               
		ok = false;
	}else{
		document.getElementById("error_password2").innerHTML="";
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

function validarAceptado(){        
	var valor = formulario.aceptado;	//document.getElementById("aceptado")
	if(!valor.checked){
	   document.getElementById("error_aceptado").innerHTML="Debe aceptar esta clausula";                
	   ok = false;
	}else{
	   document.getElementById("error_aceptado").innerHTML="";               
   }
}

function validarForm(){
	var f=formulario;
	ok=true;
	
	validarLogin();
	validarPassword();
	validarRePassword();
	validarDNI(f.dni.value);
	validarSexo();
	validarAceptado();

	return ok;
}