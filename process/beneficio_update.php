<?php
// beneficio_update.php

$id = $_POST['id'];
$empresa = $_POST['empresa'];
$descripcion = $_POST['descripcion'];

$data = [
    'empresa' => $empresa,
    'descripcion' => $descripcion
];

// Puedes usar PUT (si la API está definida así) o POST
$url = "http://localhost/apirest/beneficios/$id"; // Requiere ruta: app()->put("/beneficios/{id}", ...)
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

$response = curl_exec($ch);

if ($response === false) {
    echo "Error al comunicarse con la API: " . curl_error($ch);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode != 200) {
    die("Error al actualizar el beneficio. Código: $httpCode. Respuesta: $response");
}

header("Location: ../view/admin/dashboard.php");
exit;
