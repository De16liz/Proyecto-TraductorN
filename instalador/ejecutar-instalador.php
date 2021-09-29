<?php
    // Notas.
    // Estructar de la base de datos
    // Primero las talas y llaves foraneas e insert
    // Al final funciones y procedimiento

    // Paso 1: Extramemos los datos de la url por metodo post

    $errorEjecucion = array();

    $servidor  = $_POST['servidor'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $baseDeDatos = $_POST['base-de-datos'];

    // Paso 2: Verificamos que la conexión es correcta.

    $conexion = @mysqli_connect($servidor, $usuario, $contraseña, $baseDeDatos);

    if (!$conexion){ // <-- Si si al conexion es false.
        $errorEjecucion[0] = 1;
        $errorEjecucion[1] = "La cadena de conexión es erronea.";
        header('Location: error.php');
    }else{
        // Paso 3: Si al conexión es correcta ejecutarmos el instalador.

        // Extrameno el sql de archivo base-de-datos.sql;

        $documentText = file_get_contents('base-de-datos.sql');
        $documentInserts = file_get_contents('insert.sql');


        // Limpiamos el documento
        $documentText = rtrim($documentText, ";"); // quitamos el punto y coma del final
        $documentText = str_replace('//', '', $documentText); // quitamos las "//"
        $documentText = str_replace('$$', '', $documentText); // quitamos las "$$"
        $documentText = str_replace('DELIMITER ;', 'DELIMITER', $documentText); // quitamos delimiter
        $documentText = str_replace("DELIMITER ", 'DELIMITER', $documentText); // quitamos las "$$"

        $scrips = explode('DELIMITER', $documentText);
        $documentInserts = explode('--', $documentInserts);
        


        // Estraemos el primer item que contien las tablas y llaver foraenas..
        $scriptsTablas = explode(';', array_shift($scrips));
        
        $scripts = array_merge($scriptsTablas, $scrips, $documentInserts);
 
        $errores = array(); 

        // Recorremos el arrey de los scrips y los ejecutamos
        foreach($scripts as $sql){
            if (strlen(trim($sql)) > 0){
                //$v = $conexion->query($sql);
                // echo "<br><hr>";
                // echo $sql . "<br>";
                if ($conexion->query($sql) == false){
                    $errores[] = array($sql, $conexion->error);
                }  
            }
        }

        if (count($errores) == 0){


            $archivocon = fopen("../Config/datos_conexion.php", "w");
            fputs( $archivocon, "<?php\n" );
            fputs( $archivocon, "\tdefine('BASE_DATOS', '$baseDeDatos');\n" );
            fputs( $archivocon, "\tdefine('USUARIO', '$usuario');\n" );
            fputs( $archivocon, "\tdefine('CONTRASENA', '$contraseña');\n" );
            fputs( $archivocon, "\tdefine('SERVIDOR', '$servidor');\n" );
            fputs( $archivocon, "?>" );


            $archivo = fopen("../Config/instalado.txt", "a");
            fputs($archivo, "Se instalo correctamente");
            fclose($archivo);

            header('Location: ../index.php');
            
        }else{
            header('Location: error.php');
        }
        
    }



?>