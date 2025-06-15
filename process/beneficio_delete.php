<?php
include '../conexion.php';

$id = intval($_GET['id']);
$mysqli->query("DELETE FROM beneficios WHERE id = $id");

header('Location: ../view/admin/dashboard.php');
exit();
