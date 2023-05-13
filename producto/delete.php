<?php
include('../conexion/conexion.php');

$conexion = conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conexion->prepare("DELETE FROM producto WHERE id_producto = ?");
    $query->bind_param("i", $id);
    if ($query->execute()) {
        echo "Producto eliminado correctamente.";
    } else {
        echo "Error al eliminar el producto.";
    }
} else {
    echo "No se ha especificado un ID de producto.";
}

desconectar($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar producto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1> producto eliminado</h1>
        <p><?php echo $mensaje ?></p>
        <a href="producto.php" class="btn btn-primary">Regresar a Productos</a>
    </div>
</body>
</html>
