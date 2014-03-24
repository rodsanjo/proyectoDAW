<?php

namespace modelos;

class Menus{    //la clase se tiene que llamar igual que el archivo
    private static $menuUp = array(
        /*
            item => "controlador,metodo/clausula,title"
            item => array( subitem, subitem, ...)
                subitem => "controlador,metodo,title"

        */
        "Inicio" => "inicio,index,Home"
        ,"Juegos de mesa" => 
            "articulos,index,Juegos de mesa"
//            array(
//                "Juegos de tablero"=>"articulos,juegosTablero,Juegos de Tablero"
//                ,"Juegos de cartas"=>"articulos,juegosCartas,Juegos de Cartas"
//                ,"2 jugadores"=>"articulos,2juegadores,2 jugadores"
//        )
        ,"Accesorios" => "articulos,index/accesorios,Accesorios"
        ,"Galería" => "galeria,index,Galeria de imagenes"
        ,"Enlaces" => "enlaces,index,Enlaces de interés"
        ,"Contacto" => "contacto,index,Contacto"
    );
    
    public static function get_menuUp(){
        return self::$menuUp;
    }
    
    private static $menuLeft = array(
        /*
            item => "controlador,metodo/clausula,title"
            item => array( subitem, subitem, ...)
                subitem => "controlador,metodo,clausula,title"

        */
        "Inicio" => "inicio,index,Home"
        ,"Juegos de mesa" => array(
            "Juegos de tablero"=>"articulos,index,tablero,Juegos de Tablero"
            ,"Juegos de cartas"=>"articulos,index,cartas,Juegos de Cartas"
            ,"2 jugadores"=>"articulos,index,2jugadores,2 jugadores"            
        )
        ,"Accesorios" => "articulos,index/accesorios,Accesorios"
        ,"Galería" => "galeria,index,Galeria de imagenes"
        ,"Enlaces" => "enlaces,index,Enlaces de interés"
        ,"Contacto" => "contacto,index,Contacto"
    );
    
    public static function get_menuLeft(){
        return self::$menuLeft;
    }

}

?>
