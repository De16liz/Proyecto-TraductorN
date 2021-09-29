<?php

class IdiomasController{

    public static function obtenerIdiomas(){

        return Idioma::obtenerIdiomas();
    }

    public static function obtenerComposicion($get, $post){

        echo json_encode(Idioma::obtenerComposicion($post['id']));
    }

    public static function guardarComposicion($get, $post){

        echo json_encode(Idioma::guardarComposicion($post['id'], $post['composicion']));
    }

}

?>