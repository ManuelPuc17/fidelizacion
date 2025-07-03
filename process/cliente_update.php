<?php
// cliente_update.php

$id         = $_POST['id'];
$nombre     = $_POST['nombre'];
$apellidos  = $_POST['apellidos'];
$telefono   = $_POST['telefono'];
$correo     = $_POST['correo'];
$direccion  = $_POST['direccion'];
$estado     = $_POST['estado'];
$ciudad     = $_POST['ciudad'];
$rol        = $_POST['rol'];
$contrasena = $_POST['contrasena'] ?? '';

// Preparamos los datos a enviar
$data = [
    'nombre'     => $nombre,
    'apellidos'  => $apellidos,
    'telefono'   => $telefono,
    'correo'     => $correo,
    'direccion'  => $direccion,
    'estado'     => $estado,
    'ciudad'     => $ciudad,
    'rol'        => $rol,
];

// Solo enviamos la contraseña si no está vacía
if (!empty($contrasena)) {
    $data['contrasena'] = $contrasena;
}

// URL de la API para editar cliente
$apiUrl = "http://localhost/apirest/clientes/editar/$id";

// Usamos cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true); // Leaf acepta POST aunque sea "editar"
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

$response = curl_exec($ch);

if ($response === false) {
    echo "Error al comunicarse con la API: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Redirigir después de guardar
header("Location: ../view/admin/clientes.php");
exit;
