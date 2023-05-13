<?php 

include('../conexion/conexion.php');

$conexion = conectar();

//en esta parte busca por medio del nombre
if (isset($_GET['buscar'])){
	$nombre = $_GET['buscar'];
	$query = $conexion->prepare("SELECT id_producto, nombre, descripcion, stock, precio_venta FROM producto WHERE nombre LIKE '%$nombre%'");
}else{
	$query = $conexion->prepare("SELECT id_producto, nombre, descripcion, stock, precio_venta FROM producto");
}
$query->execute();
$resultado = $query->get_result();

desconectar($conexion);

?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Productos</h1>
        <a href="agregar.html" class="btn btn-primary mb-3">Agregar producto</a>
        <form action="" method="GET">
			<label for="buscar">Buscar por nombre:</label>
			<input type="text" id="buscar" name="buscar">
			<button type="submit" class="btn btn-primary">Buscar</button>
		</form>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Precio de venta</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($producto = $resultado->fetch_assoc()){
                    echo '<tr>';
                    echo '<td>'. $producto['id_producto'] . '</td>';
                    echo '<td>'. $producto['nombre'] . '</td>';
                    echo '<td>'. $producto['descripcion'] . '</td>';
                    echo '<td>'. $producto['stock'] . '</td>';                
                    echo '<td>'. $producto['precio_venta'] . '</td>';
                    echo '<td><a href="update.php?id='. $producto['id_producto'] .'" class="btn btn-primary">Editar</a> |
                     <a href="delete.php?id='. $producto['id_producto'] .'" class="btn btn-danger">Eliminar</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>