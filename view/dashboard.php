<?php
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['cliente_nombre']) . "</h1>";
echo "<a href='logout.php'>Cerrar sesión</a>";
?>
