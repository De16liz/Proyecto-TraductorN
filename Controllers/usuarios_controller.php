<?php

class UsuarioController {

    public static function estado(){

        //verificamos si hay una sesion activa
        $estado = false;

        if(isset($_SESSION['usuario'])){

            if($_SESSION['usuario'] != null){
                $estado = true;
            }

        }

        return $estado;

    }

    public static function ingresar($get, $post){

        echo json_encode(Usuario::ingresar($get, $post));

    }

    public static function salir(){

        echo json_encode(Usuario::salir());

    }

}

?>