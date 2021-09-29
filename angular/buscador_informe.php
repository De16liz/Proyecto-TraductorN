
<?php
require_once('../Config/connection.php');
 header("Content-Type: application/json; charset=UTF-8");

 $n = "";
 //$conexion = mysqli_connect( "localhost", "root", "", "prueba12");
 $conexion = Db::conexion();
 $sql = "SELECT * FROM tb_informe";
 if( $n != "" && $n != "undefined" ) $sql .= "where texto like '%$n%'";


 $resultado = $conexion->query($sql);

 $filas = $resultado->fetch_all(MYSQLI_ASSOC);
 $filas = json_encode( $filas);
 echo $filas;
  //echo json_encode( $filas );
 ?>