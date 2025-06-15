<?php
include '../conexion.php';

$empresa = $mysqli->real_escape_string($_POST['empresa']);
$descripcion = $mysqli->real_escape_string($_POST['descripcion']);

$mysqli->query("INSERT INTO beneficios (empresa, descripcion) VALUES ('$empresa', '$descripcion')");

header('Location: ../view/admin/dashboard.php');
exit();
