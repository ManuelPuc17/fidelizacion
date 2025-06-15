<?php
session_start();
include '../conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telefono = $mysqli->real_escape_string($_POST['telefono']);
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM clientes WHERE telefono = '$telefono' LIMIT 1";
    $result = $mysqli->query($sql);

    if ($result->num_rows == 1) {
        $cliente = $result->fetch_assoc();
        if (password_verify($contrasena, $cliente['contrasena'])) {
            // Guardar datos en sesión
            $_SESSION['usuario_id'] = $cliente['id'];
            $_SESSION['usuario_nombre'] = $cliente['nombre'];
            $_SESSION['usuario_rol'] = $cliente['rol']; // puede ser 'admin' o 'cliente'

            // Redirigir según el rol
            if ($cliente['rol'] === 'admin') {
                header('Location: ../view/admin/dashboard.php');
            } else {
                header('Location: ../view/cliente/dashboard.php');
            }
            exit();
        } else {
            $mensaje = "<div class='alert alert-danger'>Contraseña incorrecta</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>No existe ese teléfono registrado</div>";
    }
}
?>
