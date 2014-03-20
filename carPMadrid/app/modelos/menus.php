<?php

namespace modelos;

class Menus{    //la clase se tiene que llamar igual que el archivo
    private static $menuUp = array(
        /*
            item => "controlador,metodo,title"
            item => array( subitem, subitem, ...)
                subitem => "controlador,metodo,title"

        */
        "Inicio" => "inicio,index,Home"
        ,"Juegos de mesa" => array(
            "Juegos de tablero"=>"juegosMesa,juegosTablero,Juegos de Tablero"
            ,"Juegos de cartas"=>"juegosMesa,juegosCartas,Juegos de Cartas"
            ,"2 jugadores"=>"juegosMesa,2juegadores,2 jugadores"
        )
        ,"Accesorios" => "accesorios,index,Accesorios"
        ,"Galería" => "galeria,index,Galeria de imagenes"
        ,"Enlaces" => "enlaces,index,Enlaces de interés"
        ,"Contacto" => "contacto,index,Contacto"
    );
    
    public static function get_menuUp(){
        return self::$menuUp;
    }
    
    private static $menuLeft = array(
        /*
            item => "controlador,metodo,title"
            item => array( subitem, subitem, ...)
                subitem => "controlador,metodo,title"

        */
        "Inicio" => "inicio,index,Home"
        ,"Juegos de mesa" => array(
            "Juegos de tablero"=>"juegosMesa,juegosTablero,Juegos de Tablero"
            ,"Juegos de cartas"=>"juegosMesa,juegosCartas,Juegos de Cartas"
            ,"2 jugadores"=>"juegosMesa,2juegadores,2 jugadores"
        )
        ,"Accesorios" => "accesorios,index,Accesorios"
        ,"Galería" => "galeria,index,Galeria de imagenes"
        ,"Enlaces" => "enlaces,index,Enlaces de interés"
        ,"Contacto" => "contacto,index,Contacto"
    );
    
    public static function get_menuLeft(){
        return self::$menuLeft;
    }

}

?>
