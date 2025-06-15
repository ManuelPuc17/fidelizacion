<?php
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header('Location: ../view/V.login.php');
    exit();
}

echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['cliente_nombre']) . "</h1>";
echo "<a href='../process/P.logout.php'>Cerrar sesión</a>";
?>
