<?php
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $descripcion = $mysqli->real_escape_string($_POST['descripcion']);
    $puntos = intval($_POST['puntos_necesarios']);

    $sql = "INSERT INTO premios (nombre, descripcion, puntos_necesarios)
            VALUES ('$nombre', '$descripcion', $puntos)";

    if ($mysqli->query($sql)) {
        header('Location: ../view/admin/premios.php');
        exit();
    } else {
        echo "Error al insertar: " . $mysqli->error;
    }
}
?>
