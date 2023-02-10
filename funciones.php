<?php 

	//Enlazamos consultas.php
	include "consultas.php";

	// Esta funcion nos devolverá un menu desplegable de categorias. Las categorias las conocera llamando la funcion getCategorias
	function pintaCategorias($defecto) {	
		$categoryList = getCategorias();
		$outerHTML = "<select name='categorias'>";
		foreach ($categoryList as $category) {
			$outerHTML.="<option";
			if($defecto == $category["CategoryID"]){
				$outerHTML.=" selected='selected'";
			}
			$outerHTML.=" value='".$category["CategoryID"]."'>".$category["Name"]."</option>";
		}
		$outerHTML.="</select>";
		return $outerHTML;
	}

	//Nos devuelve una tabla con usuarios, los conocemos gracias a la funcion getListaUsuarios
	function pintaTablaUsuarios(){
		$userList = getListaUsuarios();
		$outerHTML = "<table>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Email</th>
				<th>Autorizado</th>
			</tr>
		</thead>
		<tbody>";

		//Volcamos los usuarios en la tabla. Los que tengan autorizacion 1 se pintarán de rojo
		foreach($userList as $user){
			$outerHTML .= "<tr><td>".$user["FullName"] ."</td><td>".$user["Email"]."</td><td";

			if($user["Enabled"]==1){
				$outerHTML .= " style= 'background-color:red'";
			}
			$outerHTML .= ">".$user["Enabled"]."</td></tr>";
		}
		$outerHTML .= "</tbody>
		</table>";

		return $outerHTML;
		
	}

		//Nos devuelve una tabla de productos. Los conocemos llamando la funcion getProductos. 
		//Los encabezados de las columnas se pueden apretar y nos redirigen a una pagina que tendrá los productos 
		//ordenados segun el criterio apretado
	function pintaProductos($orden) {
		$productList = getProductos($orden);
		$outerHTML = "<table>
		<thead>
			<tr>
				<th><a href='articulos.php?orderby=ProductID'>ID</a></th>
				<th><a href='articulos.php?orderby=productName'>Name</a></th>
				<th><a href='articulos.php?orderby=Cost'>Coste</a></th>
				<th><a href='articulos.php?orderby=Price'>Precio</a></th>
				<th><a href='articulos.php?orderby=categoryName'>Categoría</a></th>
				<th>Acciones</th>
			</tr>
		</thead><tbody>";
		foreach($productList as $product){
			$outerHTML .= "<tr><td>".$product["ProductID"] ."</td><td>".$product["productName"]."</td><td>"
			.$product["Cost"] ."</td><td>".$product["Price"] ."</td><td>".$product["categoryName"] ."</td>
			<td> <a href='formArticulos.php?action=edit&productID=".$product["ProductID"]."'>
			Editar</a>-<a  href='formArticulos.php?action=delete&productID=".$product["ProductID"]."'>
			Borrar</a></td></tr>";}

			$outerHTML .= "</tbody>
			</table>";	

			return $outerHTML;
	} 

?>



	