<?php
// premio_insert.php

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$puntos = $_POST['puntos_necesarios'];
$imagen = $_POST['imagen']; // Puede ser URL o base64, según lo manejes

$data = [
    'nombre'            => $nombre,
    'descripcion'       => $descripcion,
    'puntos_necesarios' => $puntos,
    'imagen'            => $imagen,
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];

$context = stream_context_create($options);
$response = file_get_contents('http://localhost/apirest/premios', false, $context);

if ($response === false) {
    die('Error al agregar premio usando la API.');
}

header('Location: ../view/admin/premios.php');
exit;
