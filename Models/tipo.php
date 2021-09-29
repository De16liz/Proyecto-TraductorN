<?php

class Tipo{

    public static function obtenerTipos(){

        $tipos = [];
        
        $db=Db::generarConexion();

		$sql = $db->prepare('SELECT * FROM tipos');
        $sql->execute();

        $tipos = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $tipos;

    }
}
?>