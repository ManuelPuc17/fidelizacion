<?php
include '../conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telefono = $mysqli->real_escape_string($_POST['telefono']);
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $apellidos = $mysqli->real_escape_string($_POST['apellidos']);
    $direccion = $mysqli->real_escape_string($_POST['direccion']);
    $correo = $mysqli->real_escape_string($_POST['correo']);
    $estado = $mysqli->real_escape_string($_POST['estado']);
    $ciudad = $mysqli->real_escape_string($_POST['ciudad']);
    $contrasena = $_POST['contrasena'];

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO clientes (telefono, nombre, apellidos, direccion, correo, estado, ciudad, contrasena)
            VALUES ('$telefono', '$nombre', '$apellidos', '$direccion', '$correo', '$estado', '$ciudad', '$hash')";

    if ($mysqli->query($sql) === TRUE) {
        $mensaje = "<div class='alert alert-success'>Cliente registrado exitosamente.</div>";
        // Redirigir a la página de inicio de sesión o a otra página
        header('Location: ../view/V.login.php');
        exit();
    } else {
        $mensaje = "<div class='alert alert-danger'>Error: " . $mysqli->error . "</div>";
    }
}
?>