<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<title>Usuarios</title>
</head>
<body>


<?php
	include "funciones.php";

	//Solo el superadmin puede cambiar permisos
	if ($_COOKIE["userPermision"]== "superadmin"){

	
	if (isset($_POST["changePermisions"]) && $_POST["changePermisions"]){

	cambiarPermisos();
}

$currentPermissions = getPermisos();

?>

<form method="post" action="usuarios.php">
	<input type="hidden" name="changePermisions" value="true">
<button type="submit" >Cambiar Permisos</button>
<p>Los permisos actuales están a 
	<?php 
	echo ($currentPermissions["Autenticación"]);
	?>
</p>
</form>

<a href="index.php">Volver</a>
	<?php 
		echo (pintaTablaUsuarios()); 
	}else {
		?>
		<p>No tienes permiso para estar aquí. <a href="index.php">Volver al inicio</a></p>
		<?php
		}
		?>
</body>
</html>