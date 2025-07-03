<?php
$id = $_GET['id'];

$ch = curl_init("http://localhost/apirest/clientes/$id");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    die('Error al eliminar cliente con la API (DELETE).');
}

header("Location: ../view/admin/clientes.php");
exit;
