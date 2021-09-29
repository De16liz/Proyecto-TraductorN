<?php

class Palabra{

    public static function guardar($post){

        $db=Db::generarConexion();

        $idPalabraOrigen = null;
        $idPalabraTraduccion = null;

        $existeOrigen = false;
        $existeTraduccion = false;

        $data = [
            'palabra' => $post['palabra-origen'],
            'tipo' => $post['tipo'],
            'idioma' => $post['idioma-origen'],
        ];

        $data2 = [
            'palabra' => $post['palabra-traducida'],
            'tipo' => $post['tipo'],
            'idioma' => $post['idioma-traduccion'],
        ];

        //verificamos si ya existe la palabra de origen
        
        $sql = $db->prepare('SELECT id FROM palabras WHERE palabra = "'.$data['palabra'].'" AND id_idioma = "'.$data['idioma'].'" LIMIT 1');
        $sql->execute();

        $palabraDB = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(count($palabraDB) == 0){

            //Como no existe la agregamos
            $sql = $db->prepare('INSERT INTO palabras(palabra, id_tipo, id_idioma) VALUES("'.$data['palabra'].'", "'.$data['tipo'].'", "'.$data['idioma'].'")');
            $sql->execute();

            //obtenemos el id insertado
            $idPalabraOrigen = $db->lastInsertId();

        }else{

            //obtenemos el id de la palabra existente
            $idPalabraOrigen = $palabraDB[0]['id'];

            $existeOrigen = true;
        }

        //verificamos si ya existe la palabra de traduccion
        $sql = $db->prepare('SELECT id FROM palabras WHERE palabra = "'.$data2['palabra'].'" AND id_idioma = "'.$data2['idioma'].'" LIMIT 1');
        $sql->execute();

        $palabraDB = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(count($palabraDB) == 0){

            //Como no existe la agregamos
            $sql = $db->prepare('INSERT INTO palabras(palabra, id_tipo, id_idioma) VALUES("'.$data2['palabra'].'", "'.$data2['tipo'].'", "'.$data2['idioma'].'")');
            $sql->execute();

            //obtenemos el id insertado
            $idPalabraTraduccion = $db->lastInsertId();

        }else{

            //obtenemos el id de la palabra existente
            $idPalabraTraduccion = $palabraDB[0]['id'];

            $existeTraduccion = true;
        }

        
        if(!$existeOrigen || !$existeTraduccion){ // si no existia alguna de las palabras creamos la relacion

            $sql = $db->prepare('INSERT INTO relacion_palabras(id_palabra_origen, id_palabra_traduccion) VALUES("'.$idPalabraOrigen.'", "'.$idPalabraTraduccion.'")');
            $sql->execute();

            return ['mensaje' => 'Palabra agregada'];
            //header('Location: ./?controlador=InterfazController&accion=indice&mensaje=palabras%20agregadas');

        }else{

            return ['mensaje' => 'Ya existen estas palabras'];
            //header('Location: ./?controlador=InterfazController&accion=indice&mensaje=Ya%20existen%20las%20palabras');
        }

    }

    public static function buscar($busqueda){

        $db=Db::generarConexion();


        $busqueda = $busqueda;
        $palabrasDB = [];
        $palabrasTraduccionDB = [];
        $palabrasTraduccionDBExtra = [];
        $listaPalabrasTraduccion = [];

        //buscamos la palabra y obtenemos su idioma y tipo
        $sql = $db->prepare('SELECT palabras.id, palabras.palabra, tipos.tipo, idiomas.idioma 
                            FROM palabras 
                            LEFT JOIN idiomas ON palabras.id_idioma = idiomas.id 
                            LEFT JOIN tipos ON palabras.id_tipo = tipos.id
                            WHERE LOWER(palabra) LIKE LOWER("'.$busqueda.'%") ORDER BY palabra ASC');
        $sql->execute();

        $palabrasDB = $sql->fetchAll(PDO::FETCH_ASSOC);

        //buscamos las traducciones de las palabras encontradas
        if(count($palabrasDB) > 0){

            //generamos el string de la clausula where para la palabra como origen
            $cadenaCondicion = [];
            foreach ($palabrasDB as $palabraArr) {
                $cadenaCondicion[] = ' relacion_palabras.id_palabra_origen = "'.$palabraArr['id'].'" ';
            }

            $query = 'SELECT palabras.id AS id_traduccion, palabras.palabra AS traduccion, idiomas.idioma AS idioma_traduccion, relacion_palabras.id_palabra_origen AS id_palabra_origen  
            FROM relacion_palabras
            LEFT JOIN palabras ON relacion_palabras.id_palabra_traduccion = palabras.id
            LEFT JOIN idiomas ON palabras.id_idioma = idiomas.id
            WHERE '.implode('OR', $cadenaCondicion).' ';

            $sql = $db->prepare($query);
            $sql->execute();
            $palabrasTraduccionDB = $sql->fetchAll(PDO::FETCH_ASSOC);

            //generamos el string de la clausula where para la palabra como traduccion
            $cadenaCondicion = [];
            foreach ($palabrasDB as $palabraArr) {
                $cadenaCondicion[] = ' relacion_palabras.id_palabra_traduccion = "'.$palabraArr['id'].'" ';
            }

            $query = 'SELECT palabras.id AS id_traduccion, palabras.palabra AS traduccion, idiomas.idioma AS idioma_traduccion, relacion_palabras.id_palabra_traduccion AS id_palabra_traduccion   
            FROM relacion_palabras
            LEFT JOIN palabras ON relacion_palabras.id_palabra_origen = palabras.id
            LEFT JOIN idiomas ON palabras.id_idioma = idiomas.id
            WHERE '.implode('OR', $cadenaCondicion).' ';

            $sql = $db->prepare($query);
            $sql->execute();
            $palabrasTraduccionDBExtra = $sql->fetchAll(PDO::FETCH_ASSOC);



            //Ordenamos el array final emparejando las palabras buscadas con sus traducciones
            foreach ($palabrasDB as $key => $palabra) {
                
                $listaPalabrasTraduccion[$key] = [
                                            'palabra' => $palabra,
                                            'traducciones' => []
                ];

                //recorremos las traducciones para irlas agregando a la lista final
                foreach ($palabrasTraduccionDB as $traduccion) {
                    if($traduccion['id_palabra_origen'] == $palabra['id']){
                        $listaPalabrasTraduccion[$key]['traducciones'][] = $traduccion; 
                    }
                }


                //recorremos las traducciones extras para irlas agregando a la lista final
                foreach ($palabrasTraduccionDBExtra as $traduccion) {
                    if($traduccion['id_palabra_traduccion'] == $palabra['id']){
                        $listaPalabrasTraduccion[$key]['traducciones'][] = $traduccion;
                    }
                }

            }


        }




        //return array_merge($palabrasDB, $palabrasTraduccionDB, $palabrasTraduccionDBExtra);
        return $listaPalabrasTraduccion;

    }

    public static function obtenerTodas(){

        $db=Db::generarConexion();

        $sql = $db->prepare('SELECT palabras.palabra, idiomas.idioma 
                                FROM palabras 
                                LEFT JOIN idiomas ON palabras.id_idioma = idiomas.id 
                                ORDER BY palabra ASC');
        $sql->execute();

        $palabrasDB = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($palabrasDB)){
            $palabrasDB = $palabrasDB;
        }else{
            $palabrasDB = [];
        }

        return $palabrasDB;

    }

    public static function ordenarFrase($orden, $idioma, $conjuntoPalabras){

        $composicion = Idioma::obtenerComposicion($idioma);
        $compoSimple = [];
        $traduccionTexto = "";

        
        //creamos array simple con el orden de composicion
        foreach ($composicion as $tipo) {
            $compoSimple[] = $tipo['id'];
        }

        if($orden == 'ordenEntrada'){

            //recorremos el conjunto tal y como llegó creamos el string de traducción
            foreach ($conjuntoPalabras AS $palabra) {
                
                if($palabra['traduccion'] != ""){
                    $traduccionTexto .= '<span class="tooltip" data-origen="'.$palabra['origen'].'">'.$palabra['traduccion'].'</span> ';
                }else{
                    $traduccionTexto .= '<span class="palabra-no-traducida tooltip" data-origen="Sin traducción">'.$palabra['origen'].'</span> ';
                }
                

            }

        }else if($orden == 'composicionIdioma'){

            //creamos un array con las posiciones de palabras vacias
            $conjuntoOrdenado = array_fill(0, count($conjuntoPalabras), null);

            //ahora guardamos en la posicion original las palabras no traducidas
            foreach ($conjuntoPalabras AS $key => $palabra) {
                    if($palabra['traduccion'] == ""){
                        $conjuntoOrdenado[$key] = $palabra;
                    }
            }


            //recorremos el orden de la composicion del idioma y vamos juntando y ordenando por tipos
            foreach ($compoSimple as $tipoCompo) {
                
                foreach ($conjuntoPalabras AS $palabra) {
                    
                    if($tipoCompo == $palabra['id_tipo']){

                        $palabraAgregada = false;

                        //recorremos el conjuntoOrdenado y ubicamos la palabra en la primera posicion vacia
                        foreach ($conjuntoOrdenado as $key => $palabraOrdenada) {
                            if(empty($conjuntoOrdenado[$key]) && $palabraAgregada == false){
                                $conjuntoOrdenado[$key] = $palabra;
                                $palabraAgregada = true;
                            }
                        }

                    }

                }
            }

            //recorremos el conjunto ya ordenado por composicion y creamos el string de traducción
            foreach ($conjuntoOrdenado AS $palabra) {
                
                if($palabra['traduccion'] != ""){
                    $traduccionTexto .= '<span class="tooltip" data-origen="'.$palabra['origen'].'">'.$palabra['traduccion'].'</span> ';
                }else{
                    $traduccionTexto .= '<span class="palabra-no-traducida tooltip" data-origen="Sin traducción">'.$palabra['origen'].'</span> ';
                }
                

            }


        }


        return trim($traduccionTexto);

    }

    public static function traducirtexto($idFrase, $frase, $idiomaOrigen, $idiomaTraduccion){

        $db=Db::generarConexion();

        $palabraDB = [];
        $palabrasDB = [];
        $resultado = [];

        //dividimos el texto para obtener las palabras

        $palabrasArr = explode(' ', $frase);

        //primero creamos la cadena de condiciones para todas las palabras
        $cadenaCondicion = [];

        foreach ($palabrasArr as $palabraTexto) {
            $cadenaCondicion[] = ' (LOWER(palabra) = LOWER("'.$palabraTexto.'") AND id_idioma="'.$idiomaOrigen.'") ';
        }

        $query = 'SELECT id, palabra, id_tipo FROM palabras WHERE '.implode('OR', $cadenaCondicion);


        $sql = $db->prepare($query);
        $sql->execute();

        $palabrasDB = $sql->fetchAll(PDO::FETCH_ASSOC);

        //print_r($palabrasDB);

        //si encontramos las palabras buscamos sus traducciones
        if(count($palabrasDB) > 0){


            $cadenaCondicion = [];

            foreach ($palabrasDB as $palabra) {
                $cadenaCondicion[] = '  ((relacion_palabras.id_palabra_origen = "'.$palabra['id'].'" OR relacion_palabras.id_palabra_traduccion = "'.$palabra['id'].'") AND idiomas.id = "'.$idiomaTraduccion.'" )  ';
            }

            $query = 'SELECT palabras.palabra, palabras.id_tipo, idiomas.id AS id_idioma, relacion_palabras.id_palabra_origen AS id_origen
                        FROM relacion_palabras
                        LEFT JOIN palabras ON relacion_palabras.id_palabra_traduccion = palabras.id 
                        LEFT JOIN idiomas ON palabras.id_idioma = idiomas.id 
                    WHERE '.implode('OR', $cadenaCondicion);

            //echo $query;

            $sql = $db->prepare($query);
            $sql->execute();
            $traduccionDB = $sql->fetchAll(PDO::FETCH_ASSOC);

            //cambiamos la busqueda de origenes a traducciones

            $query = 'SELECT palabras.palabra, palabras.id_tipo, idiomas.id AS id_idioma, relacion_palabras.id_palabra_traduccion AS id_origen
                        FROM relacion_palabras
                        LEFT JOIN palabras ON relacion_palabras.id_palabra_origen = palabras.id 
                        RIGHT JOIN idiomas ON palabras.id_idioma = "'.$idiomaTraduccion.'"
                    WHERE '.implode('OR', $cadenaCondicion);

            //echo $query;

            $sql = $db->prepare($query);
            $sql->execute();
            $traduccionExtraDB = $sql->fetchAll(PDO::FETCH_ASSOC);


            $traduccionesDB = array_merge($traduccionDB, $traduccionExtraDB);

            $conjuntoPalabras = [];

            foreach ($palabrasArr as $key => $palabraBusqueda) {

                $conjuntoPalabras[$key] = ['origen' => $palabraBusqueda,
                                           'traduccion' => '',
                                           'id_tipo' => '',
                                           'otras_traducciones' => ''];

                //Recorremos las palabras originales que tenemos en la BD
                foreach ($palabrasDB as $palabraDB) {

                    $palabraEncontrada = false;
                    
                    //si la palabra encontrada en la DB corresponde a la del texto original
                    if(strtolower($palabraDB['palabra']) == strtolower($palabraBusqueda)){

                        //Recorremos las traducciones encontradas
                        foreach ($traduccionesDB as $traduccion) {
                            
                            //Si corresponden los id de origen y de relacion la guardamos en el array del conjunto
                            if($traduccion['id_origen'] == $palabraDB['id']  && !$palabraEncontrada){

                                $conjuntoPalabras[$key]['traduccion'] = $traduccion['palabra'];       
                                $conjuntoPalabras[$key]['id_tipo'] = $traduccion['id_tipo'];

                                $palabraEncontrada = true;

                            }else if($traduccion['id_origen'] == $palabraDB['id']){

                                $conjuntoPalabras[$key]['otras_traducciones'] = $conjuntoPalabras[$key]['otras_traducciones'].",".$traduccion['palabra'];
                            }
                        }

                    }
                } 
            }

            /// ordenamos la frase con alguno de los dos tipos: ordenEntrada o composicionIdioma
            $traduccionFinal = self::ordenarFrase('composicionIdioma', $idiomaTraduccion, $conjuntoPalabras);




            $resultado = ['id_frase' => $idFrase,
                            'traduccion' => trim($traduccionFinal),
                            'traducciones' => $traduccionesDB];

        }

        return $resultado;
    }

    public static function prepararTraduccion($post){


        $texto = $post['texto'];
        $idiomaOrigen = $post['idioma_origen'];
        $idiomaTraduccion = $post['idioma_traduccion'];
        $traduccionFrases = [];

        //reemplazamos saltos de linea
        $texto = preg_replace('/\r|\n/', ' <br> ', $texto);
        $textoTraducido = $texto;

        //separamos el texto por comas, punto y coma y dos puntos

        $frases = multiExplode(array(',','.',';',':'), $texto);

        foreach ($frases as $key => $frase) {

            //buscamos signos de puntuacions y los eliminamos
            $frase = str_replace(array('¡','!','¿','?','(',')','{','}','[',']','=','/','\\','"','#','@','$','%','&','+','-','_','-'), '', $frase);

            //excluimos espacios en blanco o nulos
            if(trim($frase) != ""){
                
                $traduccionFrases[] = self::traducirtexto($key, $frase, $idiomaOrigen, $idiomaTraduccion);
            }
        }


        if(isset($traduccionFrases[0]['id_frase'])){

            //ahora recorremos las frases y componemos el texto completo traducido
            //agregando las comas y puntos tomando como fuente el texto original.

            foreach ($traduccionFrases as $traduccionFrase) {

                if(!empty($traduccionFrase)){

                    foreach ($frases as $key => $frase) {
                    
                        if($traduccionFrase['id_frase'] == $key){
        
                            $textoTraducido = str_replace($frase, $traduccionFrase['traduccion'], $textoTraducido);
        
                        }
        
                    }

                }
            }



        }else{
            $textoTraducido = null;
        }


        return ['traduccion' => $textoTraducido];

    }

}

?>