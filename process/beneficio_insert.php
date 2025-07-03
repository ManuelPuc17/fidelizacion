<?php
// beneficio_insert.php

$empresa = $_POST['empresa'];
$descripcion = $_POST['descripcion'];

$data = [
    'empresa' => $empresa,
    'descripcion' => $descripcion
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ]
];

$context = stream_context_create($options);
$response = file_get_contents('http://localhost/apirest/beneficios', false, $context);

if ($response === FALSE) {
    die('Error al crear el beneficio');
}

header("Location: ../view/admin/dashboard.php");
exit;
