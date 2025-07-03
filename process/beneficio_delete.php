<?php
// beneficio_delete.php

$id = $_GET['id'];
$url = "http://localhost/apirest/beneficios/$id"; // Ruta DELETE: app()->delete("/beneficios/{id}", ...)

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

$response = curl_exec($ch);

if ($response === false) {
    echo "Error al comunicarse con la API: " . curl_error($ch);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode != 200) {
    die("Error al eliminar el beneficio. Código: $httpCode. Respuesta: $response");
}

header("Location: ../view/admin/dashboard.php");
exit;
