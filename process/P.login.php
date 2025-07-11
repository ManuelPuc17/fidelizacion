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
            $_SESSION['usuario_rol'] = $cliente['rol']; // 'admin' o 'cliente'

            // Señalamos que falta verificación por voz
            $_SESSION['verificacion_voz_pendiente'] = true;

            // Redirigir a la verificación por voz
            header('Location: ../view/verificacion-voz.php');
            exit();
        } else {
            $mensaje = "<div class='alert alert-danger'>Contraseña incorrecta</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>No existe ese teléfono registrado</div>";
    }
}
?>
