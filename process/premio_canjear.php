<?php
session_start();
include '../conexion.php';

// Verifica si el usuario es cliente
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'cliente') {
    header('Location: ../view/V.login.php');
    exit();
}

$cliente_id = $_SESSION['usuario_id'];
$premio_id = isset($_POST['premio_id']) ? intval($_POST['premio_id']) : 0;

// Obtener información del premio
$premio = $mysqli->query("SELECT puntos_necesarios FROM premios WHERE id = $premio_id")->fetch_assoc();

if (!$premio) {
    die("Premio no encontrado.");
}

// Obtener puntos actuales del cliente
$cliente = $mysqli->query("SELECT puntos FROM clientes WHERE id = $cliente_id")->fetch_assoc();

if ($cliente['puntos'] < $premio['puntos_necesarios']) {
    die("No tienes suficientes puntos para este premio.");
}

// Descontar puntos al cliente
$nuevos_puntos = $cliente['puntos'] - $premio['puntos_necesarios'];
$mysqli->query("UPDATE clientes SET puntos = $nuevos_puntos WHERE id = $cliente_id");

// Registrar canje
$stmt = $mysqli->prepare("INSERT INTO canjeos (cliente_id, premio_id) VALUES (?, ?)");
$stmt->bind_param("ii", $cliente_id, $premio_id);
$stmt->execute();
$stmt->close();

// Redirigir con mensaje (puedes adaptar según tu sistema de notificaciones)
header("Location: ../view/cliente/C.premios.php?success=1");
exit();
