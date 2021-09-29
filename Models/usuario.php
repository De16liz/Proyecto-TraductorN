<?php

class Usuario{

    public static function ingresar($get, $post){

        $db=Db::generarConexion();

        //validamos los datos en la db
        $query = 'SELECT * FROM usuarios WHERE usuario="'.$post['usuario'].'" AND contrasena="'.md5($post['contrasena']).'" LIMIT 1 ';

		$sql = $db->prepare($query);
        $sql->execute();

        $usuario = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(count($usuario) > 0){

            //creamos las variables de sesion
            $_SESSION["usuario"] = $usuario[0]['usuario'];
            $_SESSION["id_usuario"] = $usuario[0]['id'];


            
            $resultado = ['mensaje' => 'Bienvenido '.$usuario[0]['usuario'],
                          'estadoIngreso' => 'ok'];
        }else{
            $resultado = ['mensaje' => 'Usuario o contraseña desconocida',
                          'estadoIngreso' => 'error'];
        }


        return $resultado;

    }

    public static function salir(){

        //eliminamos las variables de sesion
        $_SESSION["usuario"] = null;
        $_SESSION["id_usuario"] = null;

        session_destroy();

        $resultado = ['mensaje' => 'ok'];


        return $resultado;

    }

}

?>