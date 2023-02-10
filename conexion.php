<?php 

	function crearConexion() {
		$host = "127.0.0.1";
		$user = "root";
		$pass = "";
		$baseDatos = "pac3_daw";


	$conexion = mysqli_connect($host, $user, $pass, $baseDatos);
	if (!$conexion) {
    	die("Connection failed: " . mysqli_connect_error());
	}	
	return $conexion;
	}


	function cerrarConexion($conexion) {	
	mysqli_close($conexion);
	}
?>