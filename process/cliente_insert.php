<?php
include '../conexion.php';

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$estado = $_POST['estado'];
$ciudad = $_POST['ciudad'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];

$stmt = $mysqli->prepare("INSERT INTO clientes (nombre, apellidos, telefono, correo, direccion, estado, ciudad, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $nombre, $apellidos, $telefono, $correo, $direccion, $estado, $ciudad, $contrasena, $rol);
$stmt->execute();
$stmt->close();

header("Location: ../view/admin/clientes.php");
exit;
