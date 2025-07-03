<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("No autenticado");
}

$premio_id = $_POST['premio_id'] ?? null;
$puntos_necesarios = $_POST['puntos_necesarios'] ?? null;
$cliente_id = $_SESSION['usuario_id']; // toma de sesión para seguridad

if (!$premio_id || !$puntos_necesarios) {
    die("Faltan datos para realizar el canje.");
}

// Datos que envías a la API
$data = [
    'cliente_id' => $cliente_id,
    'premio_id' => $premio_id,
    'puntos' => $puntos_necesarios,
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];

$context = stream_context_create($options);
$response = @file_get_contents('http://localhost/apirest/canjeos', false, $context);

if ($response === FALSE) {
    $error = error_get_last();
    die("Error al realizar el canje: " . ($error['message'] ?? 'Error desconocido'));
}

// Si quieres puedes decodificar y validar la respuesta JSON de la API
$resultado = json_decode($response, true);
if (isset($resultado['message'])) {
    echo "Respuesta API: " . htmlspecialchars($resultado['message']);
}

header("Location: ../view/cliente/C.premios.php");
exit;
