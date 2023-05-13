<?php

function conectar() {
    $conn = mysqli_connect('localhost','root','usbw','Eval02');
    return $conn;
}

function desconectar($conexion) {
    mysqli_close($conexion);
}

?>