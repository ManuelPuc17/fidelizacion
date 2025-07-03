<?php include 'header.php'; ?>

<?php
// Obtener lista de clientes desde la API
$clientes_json = file_get_contents('http://localhost/apirest/clientes');
$clientes = json_decode($clientes_json, true);

// Procesar formulario de nueva venta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $monto = floatval($_POST['monto']);
    $puntos = floor($monto / 100) * 5;

    $data = [
        'cliente_id' => $cliente_id,
        'monto' => $monto,
        'puntos' => $puntos,
        'fecha' => date('Y-m-d H:i:s') // agregamos fecha para la API
    ];

    // Enviar a la API con POST
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents('http://localhost/apirest/ventas', false, $context);

    if ($response === false) {
        echo "<div class='alert alert-danger'>Error al registrar venta en la API.</div>";
    } else {
        echo "<div class='alert alert-success'>Venta registrada. Se añadieron $puntos puntos al cliente.</div>";
    }
}

// Obtener historial de ventas desde API
$ventas_json = file_get_contents('http://localhost/apirest/ventas');
$ventas = json_decode($ventas_json, true);
?>

<h2 class="mb-4">Registrar Venta</h2>

<form method="POST" class="bg-white p-4 rounded shadow" style="max-width: 500px;">
    <div class="mb-3">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" class="form-select" required>
            <option value="">Selecciona un cliente</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Monto de la compra (MXN)</label>
        <input type="number" name="monto" class="form-control" step="0.01" min="0" required>
    </div>

    <button type="submit" class="btn btn-primary">Registrar venta</button>
</form>

<hr class="my-5">

<h2 class="mb-4">Historial de Ventas</h2>

<table class="table table-bordered table-striped" style="max-width: 800px;">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Monto (MXN)</th>
            <th>Puntos ganados</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($ventas)): ?>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td>
                        <?php
                        // Buscar nombre del cliente en la lista
                        $cliente = array_filter($clientes, fn($c) => $c['id'] == $venta['cliente_id']);
                        $cliente = array_values($cliente);
                        echo isset($cliente[0]) ? htmlspecialchars($cliente[0]['nombre']) : 'Cliente eliminado';
                        ?>
                    </td>
                    <td>$<?= number_format($venta['monto'], 2) ?></td>
                    <td><?= $venta['puntos'] ?></td>
                    <td><?= $venta['fecha'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No hay ventas registradas.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
