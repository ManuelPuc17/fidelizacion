<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'cliente') {
    header('Location: ../V.login.php');
    exit();
}

echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . "</h1>";
echo "<a href='../../process/P.logout.php'>Cerrar sesión</a>";
?>
