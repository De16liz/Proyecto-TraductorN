
<?php
//require_once('ini.php');
if (!file_exists("Config/instalado.txt")){
        
    // Si el archivo no esxiste ejecutamos el instalador.
    header('Location: instalador/instalador.php');
        
}else{ 

    header('Content-type: text/html; charset=utf-8');

    //Archivos requeridos
    //Conexion a la DB
    require_once('Config/connection.php');
    require_once('Config/functions.php');

    //Modelos
    require('Models/idioma.php');
    require('Models/palabra.php');
    require('Models/tipo.php');
    require('Models/usuario.php');

    //controladores
    require('Controllers/interfaz_controller.php');
    require('Controllers/idiomas_controller.php');
    require('Controllers/palabras_controller.php');
    require('Controllers/tipos_controller.php');
    require('Controllers/usuarios_controller.php');
    //require('angular/buscador_informe.php');

    //iniciamos o reanudamos la sesion
    session_start();

    //funcion para llamar al controlador con su respectiva accion
    function call($controlador, $accion){

        $controlador::{$accion}($_GET, $_POST);

    }
    //Verificamos si recibimos un controlador y su accion
    if (isset($_GET['controlador'])&&isset($_GET['accion'])) {
        $controlador=$_GET['controlador'];
        $accion=$_GET['accion'];

    } else {
        $controlador='InterfazController';
        $accion='inicio';
    }
    
    call($controlador, $accion);
}

?>

