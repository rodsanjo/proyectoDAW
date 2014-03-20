<?php

namespace modelos;

class ImageSlide{    //la clase se tiene que llamar igual que el archivo
    private static $imageSlide = array(
        /*
         , 1 => array(
                "fichero" => "catan.jpg"
                ,"comentario" => "Los colonos de Catán"                       
            ),
        */
        0 => array(
                "fichero" => "spartacus.jpg"
                ,"comentario" => "Spartacus: A Game of Blood & Treachery"                       
            )
        , 1 => array(
                "fichero" => "LosColonosDeCatan.jpg"
                ,"comentario" => "The settlers of Catan"                       
            ),
    );
    
    public static function get_imageSlide(){
        return self::$imageSlide;
    }

}

?>
