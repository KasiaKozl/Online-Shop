<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Articulos</title>
</head>
<body>

<!--Enlazo las funciones-->
	<?php 
		include "funciones.php";
	?>

	<h1>Lista de artículos</h1>

<!--Si el usuario esta autorizado puede ver la lista de productos-->
<?php 
if ($_COOKIE["userPermision"]== "autorizado" || $_COOKIE["userPermision"]== "superadmin"){
	$order = $_GET?$_GET["orderby"]:null;
	?>
	<a href="formArticulos.php?action=create">Añadir producto</a>
	<a href="index.php">Volver</a>
	<?php
	echo (pintaProductos($order));
?>

<!--Si el usuario no esta autorizado no puede ver la lista de productos y verá este mensaje-->
<?php
} else {
?>
<p>No tienes permiso para estar aquí. <a href="index.php">Volver al inicio</a></p>
<?php
}
?>
</body>
</html>