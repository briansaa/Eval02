<?php

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $nombre = $_POST['nombre'];
  $descripcion = $_POST['descripcion'];
  $stock = $_POST['stock'];
  $precio_venta = $_POST['precio_venta'];
  
  $query = "UPDATE producto SET nombre=?, descripcion=?, stock=?, precio_venta=? WHERE id_producto=?";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("ssidi", $nombre, $descripcion, $stock, $precio_venta, $id);
  $stmt->execute();
  
  if ($stmt->affected_rows > 0) {
    echo "El producto ha sido actualizado exitosamente.";
  } else {
    echo "No se ha podido actualizar el producto.";
  }
  
  $stmt->close();
  $conexion->close();
  
} else if (isset($_GET['id'])) {
  $id = $_GET['id'];
  
  $query = "SELECT * FROM producto WHERE id_producto = ?";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $resultado = $stmt->get_result();
  
  if ($resultado->num_rows > 0) {
    $producto = $resultado->fetch_assoc();
  } else {
    echo "No se ha encontrado el producto.";
  }
  
  $stmt->close();
  $conexion->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Editar Producto</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Editar Producto</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
      <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $producto['nombre']; ?>">
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" class="form-control"><?php echo $producto['descripcion']; ?></textarea>
      </div>
      <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" class="form-control" value="<?php echo $producto['stock']; ?>">
      </div>
      <div class="form-group">
        <label for="precio_venta">Precio de venta:</label>
        <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.01" value="<?php echo $producto['precio_venta']; ?>">
      </div>
      <button type="submit" class="btn btn-primary">Actualizar Producto</button>
    </form>
  </div>
</body>
</html>
