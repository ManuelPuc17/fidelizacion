<?php
if (!isset($_GET['id'])) {
    die("Falta el ID del premio.");
}

$id = intval($_GET['id']);

$url = "http://localhost/apirest/premios/$id";

// Crear contexto HTTP para método DELETE
$options = [
    'http' => [
        'method' => 'DELETE'
    ]
];
$context = stream_context_create($options);

// Llamar a la API
$response = @file_get_contents($url, false, $context);

// Verificar respuesta
if ($response === false) {
    die("Error al eliminar el premio.");
}

header('Location: ../view/admin/premios.php');
exit();
