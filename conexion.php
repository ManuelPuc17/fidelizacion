<?php
$host = "localhost";
$usuario = "root";
$password = "";
$basedatos = "fidelizacion";

$mysqli = new mysqli($host, $usuario, $password, $basedatos);

if ($mysqli->connect_errno) {
    die("Error de conexión: " . $mysqli->connect_error);
}
?>
