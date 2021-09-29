<?php

class PalabrasController{

    public static function guardar($get, $post){

        echo json_encode(Palabra::guardar($post));

    }

    public static function buscar($get, $post){
        
        echo json_encode(Palabra::buscar($post['busqueda']));
    }

    public static function obtenerTodas(){

        return Palabra::obtenerTodas();
    }

    public static function traducir($get, $post){

        echo json_encode(Palabra::prepararTraduccion($post));
    }
}

?>