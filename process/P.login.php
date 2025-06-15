<?php
session_start();
include 'conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telefono = $mysqli->real_escape_string($_POST['telefono']);
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM clientes WHERE telefono = '$telefono' LIMIT 1";
    $result = $mysqli->query($sql);

    if ($result->num_rows == 1) {
        $cliente = $result->fetch_assoc();
        if (password_verify($contrasena, $cliente['contrasena'])) {
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['cliente_nombre'] = $cliente['nombre'];
            header('Location: ../view/dashboard.php'); 
            exit();
        } else {
            $mensaje = "<div class='alert alert-danger'>Contraseña incorrecta</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>No existe ese teléfono registrado</div>";
    }
}
?>