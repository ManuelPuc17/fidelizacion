<?php
// cliente_insert.php
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$estado = $_POST['estado'];
$ciudad = $_POST['ciudad'];
$rol = $_POST['rol'];
$contrasena = $_POST['contrasena'];

$data = [
    "nombre"     => $nombre,
    "apellidos"  => $apellidos,
    "telefono"   => $telefono,
    "correo"     => $correo,
    "direccion"  => $direccion,
    "estado"     => $estado,
    "ciudad"     => $ciudad,
    "rol"        => $rol,
    "contrasena" => $contrasena
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];
$context = stream_context_create($options);
$response = file_get_contents('http://localhost/apirest/clientes', false, $context);

if ($response === FALSE) {
    die('Error al enviar datos a la API');
}

header('Location: ../view/admin/clientes.php');
exit();
