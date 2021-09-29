<?php

class Idioma{

    public static function obtenerIdiomas(){

        $idiomas = [];
        
        $db=Db::generarConexion();

		$sql = $db->prepare('SELECT * FROM idiomas ORDER BY idioma ASC');
        $sql->execute();

        $idiomas = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $idiomas;

    }

    public static function obtenerComposicion($id){
        
        $db=Db::generarConexion();

        $arrComposicion = [];

        //Obtenemos los indices de los tipos en la composicion del idioma
        $query = 'SELECT composicion_prosa FROM idiomas WHERE id="'.$id.'" LIMIT 1';

		$sql = $db->prepare($query);
        $sql->execute();

        $compoIdiomaArr = $sql->fetchAll(PDO::FETCH_ASSOC);
        $compoIdiomaArr = explode(",", $compoIdiomaArr[0]['composicion_prosa']);


        //Obtenemos los tipos
        $tipos = Tipo::obtenerTipos();

        //recorremos la composicion y creamos nuestro arreglo con los indices y nombres en orden
        //de la composicion del idioma

        foreach ($compoIdiomaArr as $indiceTipo) {

            foreach ($tipos as $tipo) {
                if($indiceTipo == $tipo['id']){
                    $arrComposicion[] = ['id' => $tipo['id'],
                                         'tipo' => $tipo['tipo']];
                }
            }
        }

        return $arrComposicion;
    }

    public static function guardarComposicion($id, $composicion){

        $db=Db::generarConexion();

		$sql = $db->prepare('UPDATE idiomas SET composicion_prosa ="'.$composicion.'" WHERE id="'.$id.'" ');
        $sql->execute();

        if($sql->execute()){

            return ['mensaje' => 'ok'];
        }else{
            return ['mensaje' => 'err'];
        }

    }

}

?>