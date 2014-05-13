/* líneas del script */
function saludo() {
	/*
        if(cookie[lang]=='en'){
            alert("Welcome to my internacional library");
        }else if(cookie[lang]=='de'){
            alert("Willkommen mmeine international Bibliothek");
        }else
        */
            alert("Bienvenido a mi bibliotca internacional");
                   
}

$(document).ready(function(){
    $("#idioma").mouseenter(function(){
        $("#idioma a").fadeIn(1000);
    });
    $("#idioma").mouseleave(function(){
        $("#idioma a").fadeOut(500);
    });
    
    $("#menu").click(function () { 			 	
            $("span#opcion_loc").slideToggle();
        }               
    );

    $("li.item").click(
        function () { 			 	
            $("span.desplegable").slideToggle();
        }               
    );
    $("li#recetas").click(
        function () { 			 	
            $("span#opcion_rec").slideToggle();
        }                
    );
        //Desplegar el carrito lateral
    $("#btn_desplegar_carrito").click(
        function(){
            $("#carrito_oculto").slideToggle();  
        }
    );
        //Desplegar las reseñas en articulos/index
//    $(".masDetalles").bind("click",
//        function(){
//            $(".masDetalles").css('background','khaki');
//            $(this).css('background','white');
//            $(".resenha").slideDown(2000);
//             
//        }
//    );
    $(".masDetalles").bind("click",
        function(){
            if($(".resenha").is(":hidden")){
                $(this).next('.resenha').show(2000);
            }else{
                $(".resenha").hide(2000);
            }
             
        }
    );
//    $(".resenha").hover(
//            function () { 			 	
//                $(this).show(2000);
//            }
//            ,function () { 			 	
//                $(this).fadeOut(5000);
//            }                
//        );
    $(".juego_index").bind("mouseleave",
        function(){
            //$(".resenha").delay(6000);
            $(".resenha").fadeOut(8000);
             
        }
    );
        
    
});