<?php
// premio_update.php

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$puntos = $_POST['puntos_necesarios'];


$data = [
    'nombre'            => $nombre,
    'descripcion'       => $descripcion,
    'puntos_necesarios' => $puntos,
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST', // Asumimos que usas POST para editar
        'content' => http_build_query($data),
    ],
];

$context = stream_context_create($options);
$response = file_get_contents("http://localhost/apirest/premios/editar/$id", false, $context);

if ($response === false) {
    die('Error al actualizar el premio usando la API.');
}

header('Location: ../view/admin/premios.php');
exit;
