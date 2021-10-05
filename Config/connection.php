<?php

require_once "datos_conexion.php";
	class Db
	{
		private static $instance=NULL;
		private static $tipo_de_base = 'mysql';
		private static $host = SERVIDOR;
		private static $nombre_de_base = BASE_DATOS;
		private static $usuario = USUARIO;
		private static $contrasena = CONTRASENA; 
		
		private function __construct(){}

		private function __clone(){}
		
		public static function generarConexion(){
			if (!isset(self::$instance)) {

				$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
				$pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND]='SET NAMES  \'UTF8\'';

				self::$instance= new PDO(self::$tipo_de_base.':host='.self::$host.';dbname='.self::$nombre_de_base, self::$usuario, self::$contrasena, $pdo_options);
			}
			return self::$instance;
		}
		public static function conexion(){
			return mysqli_connect(self::$host, self::$usuario, self::$contrasena,self::$nombre_de_base);
		}
	}
?>