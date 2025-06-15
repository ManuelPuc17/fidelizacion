<?php
include '../conexion.php';

$id = intval($_POST['id']);
$empresa = $mysqli->real_escape_string($_POST['empresa']);
$descripcion = $mysqli->real_escape_string($_POST['descripcion']);

$mysqli->query("UPDATE beneficios SET empresa = '$empresa', descripcion = '$descripcion' WHERE id = $id");

header('Location: ../view/admin/dashboard.php');
exit();
