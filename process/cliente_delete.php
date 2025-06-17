<?php
include '../conexion.php';

$id = $_GET['id'];

$stmt = $mysqli->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: ../view/admin/clientes.php");
exit;
