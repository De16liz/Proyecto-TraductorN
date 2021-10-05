<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Public/css/styles.css">
    <title>Instaldor</title>
</head>
<body style="display: flex; justify-content: center;">
    
    <form style="color: white;" action="ejecutar-instalador.php" method="POST">
        <h1>Instalador de la APP</h1>
        A continuaci&oacute;n se proceder&aacute; a instalar el Traductor.<br>
		Sin embargo requiere de que la <strong>base de datos</strong> sea creada con anterioridad. <br><br>

        <div>Nombre servidor</div>
        <input type="text" name="servidor" >
        <br>
        <div>Nombre usuario</div>
        <input type="text" name="usuario" >
        <br>
        <div>Contraseña</div>
        <input type="password" name="contraseña" >
        <br>
        <div>Base de datos</div>
        <input type="text" name="base-de-datos" >
        <br>
        <br>
        <button type="submit">Enviar</button>
       
    
    </form>
</body>
</html>