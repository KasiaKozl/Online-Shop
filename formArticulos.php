<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulario de artículos</title>
</head>
<body>

	<?php 

	//Si el usuario tiene permisos o es superadmin puede estar en la pagina del formulario
	if ($_COOKIE["userPermision"]== "autorizado" || $_COOKIE["userPermision"]== "superadmin"){
	
	 	//se enlazan las funciones
		include "funciones.php";

		$action = "";
		if($_GET && isset($_GET['action']) && isset($_GET['productID'])){
			$action = "action=".$_GET['action'];
			$productId = $_GET['productID'];
			if($productId){
				$product = getProducto($productId);
			}
		}
		
		//Llamamos las funciones adecuadas segun la accion a realizar y mostramos un mensaje correspondiente
		if($_POST){
			$message = "Ha sucedido un error, por favor intentelo mas tarde...";

			//Si el usuario edita un producto, se llama la funcion editarProducto
			if($_GET && $_GET['action']=='edit'){
				editarProducto($_POST['ID'], $_POST['Nombre'], $_POST['Coste'], $_POST['Precio'], $_POST['categorias']);
				$message = "El producto se ha editado correctamente";
			}
			//Si el usuario borra un producto, se llama la funcion borrarProducto
			elseif($_GET && $_GET['action']=='delete'){
				borrarProducto($_POST['ID']);
				$message = "El producto se ha borrado correctamente";
			}
			//Si no edita, ni borra el producto, significa que llama la funcion anadirProducto
			else{
				anadirProducto( $_POST['Nombre'], $_POST['Coste'], $_POST['Precio'], $_POST['categorias']);
				$message = "El producto se ha creado correctamente";
			}
		}
	
	?>

	<!--Creamos el formulario, en caso de borrar o editar un producto, el formulario aparecerá cumplimentado-->
	<form method="post" action="formArticulos.php?<?php echo($action);?>">
		<label>ID: <input type="text" name="ID" readonly  value ="<?php if(isset($product)){echo($product['ProductID']);}?>"></label>
		<label>Nombre: <input type="text" name="Nombre" value=" <?php 
		if(isset($product)){
		echo($product['Name']);}
		
		?>"></label>
		
		<label>Coste: <input type="number" step= "0.01" name="Coste" value ="<?php if(isset($product)){echo($product['Cost']);}?>"></label>
		<label>Precio: <input type="number" step="0.01" name="Precio" value="<?php if(isset($product)){echo($product['Price']);}?>"></label>
		<label>Categoría: 
			<?php
			$defaultCategory = 1;
			 if(isset($product)){
				$defaultCategory = $product['CategoryID'];
			}
			echo (pintaCategorias($defaultCategory));
			?>
		</label> 

		<!--El boton cambia para corresponderse a la accion que se realiza-->
		<button type="submit"><?php 
			if($_GET && $_GET['action']=="delete"){
				echo("Borrar");
			}elseif($_GET && $_GET['action']=="edit"){
				echo("Editar");
				}
			else{echo("Añadir");}
			?></button>

<?php 
	if($_POST){
		echo($message);
		?>
		<a href="articulos.php">Volver</a>
	</form><?php
	}}else {
		?>
		<p>No tienes permiso para estar aquí. <a href="index.php">Volver al inicio</a></p>
		<?php
		}
?>
</body>
</html>