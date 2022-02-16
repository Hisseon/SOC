<?php

	class Conexion{

		static public function conectar(){
			#PDO("nombre del servidor; nombre de la base de datos", "usuario", "contraseña",)
			$link = new PDO("mysql:host=localhost;dbname=compras","root",""); #**********IMPORTANTE: CAMBIAR PUERTO Y PASSWORD*************#
			$link->exec("set names utf8");
			return $link;

		}
	}

?>