<?php
include '../conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$estado = $_POST['estado'];
$ciudad = $_POST['ciudad'];
$rol = $_POST['rol'];

$stmt = $mysqli->prepare("UPDATE clientes SET nombre=?, apellidos=?, telefono=?, correo=?, direccion=?, estado=?, ciudad=?, rol=? WHERE id=?");
$stmt->bind_param("ssssssssi", $nombre, $apellidos, $telefono, $correo, $direccion, $estado, $ciudad, $rol, $id);
$stmt->execute();
$stmt->close();

header("Location: ../view/admin/clientes.php");
exit;
