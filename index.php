<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
</head>
<body>

	<?php
		//Enlazamos consulta.php
		include "consultas.php";

	
	$userPermision=null;
	//El usuario introduce los datos y se comprueban en la base de datos
	if ($_POST && $_POST["user"] && $_POST["mail"]){
	$userPermision = tipoUsuario($_POST["user"], $_POST["mail"]);

	//Los datos del usuario se guardan en una cookie
	setcookie("userPermision", $userPermision, time() + (86400 * 30), "/"); 
}
	?>

	<!--Formulario de acceso-->
	<form method="post" action="index.php">
		<label>Usuario: <input type="text" name="user"></label>
		<label>Correo: <input type="text" name="mail"></label>
		<input type="submit" value="Enviar" ></input>
	</form>

	<!-- Distintos mensajes y posibles acciones que aparecerán a los usuarios segun el permiso que tengan-->
	<?php
if ($userPermision == "superadmin"){
	?>
	<p>Bienvenido <?php echo($_POST["user"]) ?>. Pulsa <a href="usuarios.php">AQUÍ</a> para entrar en el panel de usuarios. </p>
	<?php
} elseif ($userPermision == "autorizado") {
	?>
	<p>Bienvenido <?php echo($_POST["user"]) ?>. Pulsa <a href="articulos.php">AQUÍ</a> para entrar en el panel de articulos. </p>
	<?php
} elseif ($userPermision == "registrado") {
	?>
	<p>Bienvenido <?php echo($_POST["user"]) ?>. No tienes permisos para acceder. </p>
	<?php
} elseif ($userPermision == "no registrado") {
	?>
	<p>El usuario no está registrado en el sistema. </p>
	<?php
} 

?>
	
</body>
</html>