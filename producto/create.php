<?php 

include('../conexion/conexion.php');

$conexion = conectar();

if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['stock']) && isset($_POST['precio_venta'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio_venta = $_POST['precio_venta'];
    $query = $conexion->prepare("INSERT INTO producto (nombre, descripcion, stock, precio_venta) VALUES (?, ?, ?, ?)");
    $query->bind_param("sssd", $nombre, $descripcion, $stock, $precio_venta);
    if ($query->execute()) {
        echo "Producto agregado correctamente.";
    } else {
        echo "Error al agregar el producto.";
    }
} else {
    echo "Por favor complete todos los campos.";
}

desconectar($conexion);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button><a href="producto.php">regresar</a></button>
</body>
</html>
