<?php
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $descripcion = $mysqli->real_escape_string($_POST['descripcion']);
    $puntos = intval($_POST['puntos_necesarios']);

    $sql = "UPDATE premios 
            SET nombre = '$nombre', descripcion = '$descripcion', puntos_necesarios = $puntos 
            WHERE id = $id";

    if ($mysqli->query($sql)) {
        header('Location: ../view/admin/premios.php');
        exit();
    } else {
        echo "Error al actualizar: " . $mysqli->error;
    }
}
?>
