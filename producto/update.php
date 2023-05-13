<?php

//en esta parte me arroga error a la hora de editar

include('../conexion/conexion.php');

$conexion = conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $precio_venta = $_POST['precio_venta'];

    // Actualizar el registro en la base de datos
    $query = $conexion->prepare("UPDATE producto SET nombre=?, descripcion=?, stock=?, precio_venta=? WHERE idproducto=?");
    $query->bind_param("ssidi", $nombre, $descripcion, $stock, $precio_venta, $id);
    $query->execute();

    if ($query->affected_rows == 1) {
        // El registro se actualizó correctamente
        header('Location: producto.php');
        exit();
    } else {
        // Error al actualizar el registro
        $mensaje = 'Error al actualizar el producto';
    }
} else {
    // Mostrar el formulario con los datos actuales del producto
    $id = $_GET['id'];
    $query = $conexion->prepare("SELECT nombre, descripcion, stock, precio_venta FROM producto WHERE id_producto=?");
    $query->bind_param("i", $id);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows == 1) {
        // El producto existe, mostrar el formulario con los datos actuales
        $producto = $resultado->fetch_assoc();
    } else {
        // El producto no existe, redirigir al listado de productos
        header('Location: producto.php');
        exit();
    }
}

desconectar($conexion);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Editar producto</h1>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-danger"><?= $mensaje ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= $producto['nombre'] ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?= $producto['descripcion'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
            </div>
            <div class="form-group">
                <label for="precio_venta">Precio de venta:</label>
                <input type="number" id="precio_venta" name="precio_venta" class="form-control" value="<?= $producto['precio_venta'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="producto.php" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</body>
</html>
