<?php 

	// enlazo con conexion.php
	include "conexion.php";


	//El usuario se considera no registrado hasta que no se compruebe que es de otra manera 
	//Creamos la conexion y hacemos la consulta. Este va a ser el modo de operar en este archivo
	//Guardamos la consulta en una variable y la devolvemos
	function tipoUsuario($nombre, $correo){
		$user = null;
		$result = "no registrado";
		$connection = crearConexion();
		 $query = mysqli_query($connection, 
		 "SELECT * FROM user WHERE Email = '$correo' AND FullName = '$nombre'");
		while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
			$user= $row;
		}
		cerrarConexion($connection);

		//Si el usuario esta registrado, se comprueba si se da una de las dos opciones: estar autorizado o ser superadmin
		if ($user)  {
			$result = "registrado";
			if ($user['Enabled']) {
				$result = "autorizado";
			}
			if (esSuperadmin($nombre, $correo)){
				$result = "superadmin";
			}
		}
		return $result;
	}


	//Para empezar consideramos que un usuario no es superadmin a no ser que el resultado de la consulta lo refleje
	//Para hacer la consulta, hemos de comprobar datos en dos tablas
	function esSuperadmin($nombre, $correo){
		$isAdmin = false;
		$connection = crearConexion();
		 $query = mysqli_query($connection, 
		 "SELECT * FROM setup left join user on setup.SuperAdmin = user.UserID 
		 WHERE Email = '$correo' AND FullName = '$nombre'");
		while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
			if ($row){
				$isAdmin = true;
			}
		}
		cerrarConexion($connection);
		return $isAdmin;
	}


	//Consultamos los datos en la tabla setup y guardamos el resultado de la consulta en una variable
	function getPermisos() {
		$connection = crearConexion();
		$virtualQuery = "SELECT Autenticación from setup";
		$tempEnabled = mysqli_query($connection, $virtualQuery);
		while ($row = $tempEnabled-> fetch_array(MYSQLI_ASSOC)) {
			$autenticacion = $row;
		}
		cerrarConexion($connection);
		return $autenticacion;
	}


	//Consultamos el valor del registro que posteriormente cambiamos
	function cambiarPermisos() {
		$connection = crearConexion();
		$queryAutenticacion = "SELECT Autenticación from setup";
		$valorAutenticacion = mysqli_query($connection, $queryAutenticacion);
		$autenticacion = [];
		while ($row = $valorAutenticacion-> fetch_array(MYSQLI_ASSOC)) {
			$autenticacion = $row;
		}

		//Si el valor es 0, cambia a 1. Si el valor es 1, cambia a 0
		if($autenticacion["Autenticación"] == 1){
		$virtualQuery = "UPDATE setup SET Autenticación = 0 WHERE Autenticación = 1";
		}else {
			$virtualQuery = "UPDATE setup SET Autenticación = 1 WHERE Autenticación = 0";
		}
		$tempEnabled = mysqli_query($connection, $virtualQuery);
		cerrarConexion($connection);
	}

	//Consultamos los nombres de las categorías y los guardamos en un array
	function getCategorias() {
		$connection = crearConexion();
		$virtualQuery = "SELECT CategoryID, Name from category";
		$tempCategorias = mysqli_query($connection, $virtualQuery);
		$categorias = [];
		while ($row = $tempCategorias-> fetch_array(MYSQLI_ASSOC)) {
			$categorias[] = $row;
		}
		cerrarConexion($connection);
		return $categorias;
		
	}

	//Consultamos los datos de os usuarios y los guardamos en un array
	function getListaUsuarios() {
		$connection = crearConexion();
		$virtualQuery = "SELECT FullName, Email, Enabled from user";
		$tempUsers = mysqli_query($connection, $virtualQuery);
		$users = [];
		while ($row = $tempUsers-> fetch_array(MYSQLI_ASSOC)) {
			$users[] = $row;
		}
		cerrarConexion($connection);
		return $users;
	}


	//Consultamos los datos de un producto en concreto cuyo ID indicamos 
	function getProducto($ID) {
		$connection = crearConexion();
		$query = "SELECT * from product where ProductID = $ID";
		$response = mysqli_query($connection, $query);
		while ($row = $response-> fetch_array(MYSQLI_ASSOC)) {
			$product = $row;
		}
		cerrarConexion($connection);
		return $product;
	}


	//Consultamos productos y los ordenamos segun el parametro indicado
	function getProductos($orden) {
		$connection = crearConexion();
		if (!$orden) {
			$orden = "ProductID";
		}
		$query = "SELECT ProductID, product.Name as productName, Cost, Price, category.Name as categoryName from product 
		left join category on product.CategoryId = category.CategoryID ORDER BY $orden ";
		$response = mysqli_query($connection, $query);
		while ($row = $response-> fetch_array(MYSQLI_ASSOC)) {
			$product[] = $row;
		}
		cerrarConexion($connection);
		return $product;
	}


	//Añadimos un producto a la base de datos
	function anadirProducto($nombre, $coste, $precio, $categoria) {
		$connection = crearConexion();
		$query = "INSERT into product (Name, Cost, Price, CategoryID) values ('$nombre', $coste, $precio, $categoria)";
		mysqli_query($connection, $query);
		$querySelect = "SELECT * from product where Name='$nombre' and Cost=$coste and Price=$precio and CategoryID=$categoria";
		$response = mysqli_query($connection, $querySelect);
		while ($row = $response-> fetch_array(MYSQLI_ASSOC)) {
			$product = $row;
		}
		cerrarConexion($connection);
		return $product;
		
	}

	//Seleccionamos un producto por ID y despues lo eliminamos
	function borrarProducto($id) {
		$connection = crearConexion();
		$querySelect = "SELECT * from product where ProductID =$id";
		$response = mysqli_query($connection, $querySelect);
		$query = "DELETE from product where ProductID = $id";
		mysqli_query($connection, $query);
		while ($row = $response-> fetch_array(MYSQLI_ASSOC)) {
			$product = $row;
		}
		cerrarConexion($connection);
		return $product;
	}
	

	//Actualizamos los registros de un producto cuyo ID coincida con el que pasamos por parametro
	function editarProducto($id, $nombre, $coste, $precio, $categoria) {
		$connection = crearConexion();
		$query = "UPDATE product SET Name = '$nombre', Cost = $coste, Price = $precio, CategoryID = $categoria 
		WHERE ProductID =$id ";
		mysqli_query($connection, $query);
		$querySelect = "SELECT * from product where ProductID =$id";
		$response = mysqli_query($connection, $querySelect);
		while ($row = $response-> fetch_array(MYSQLI_ASSOC)) {
			$product = $row;
		}
		cerrarConexion($connection);
		return $product;
	}

?>