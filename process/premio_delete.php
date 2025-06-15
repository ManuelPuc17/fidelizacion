<?php
include '../conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM premios WHERE id = $id";

    if ($mysqli->query($sql)) {
        header('Location: ../view/admin/premios.php');
        exit();
    } else {
        echo "Error al eliminar: " . $mysqli->error;
    }
}
?>
