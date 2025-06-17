<?php
include 'header.php';
include '../../conexion.php';

// Obtener lista de clientes para el select
$clientes = $mysqli->query("SELECT id, nombre FROM clientes ORDER BY nombre");

// Procsar el formulario de registro de venta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $monto = floatval($_POST['monto']);
    $puntos = floor($monto / 100) * 5;

    // Insertar la venta
    $stmt = $mysqli->prepare("INSERT INTO ventas (cliente_id, monto, puntos) VALUES (?, ?, ?)");
    $stmt->bind_param("idi", $cliente_id, $monto, $puntos);
    $stmt->execute();
    $stmt->close();

    // sumar puntos al cliente 
    $mysqli->query("UPDATE clientes SET puntos = puntos + $puntos WHERE id = $cliente_id");

    echo "<div class='alert alert-success'>Venta registrada. Se añadieron $puntos puntos al cliente.</div>";
}

// consultar historial de ventas junto con el nombre del cliente
$ventas = $mysqli->query("
    SELECT v.*, c.nombre 
    FROM ventas v 
    JOIN clientes c ON v.cliente_id = c.id 
    ORDER BY v.fecha DESC
");
?>

<h2 class="mb-4">Registrar Venta</h2>

<form method="POST" class="bg-white p-4 rounded shadow" style="max-width: 500px;">
    <div class="mb-3">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" class="form-select" required>
            <option value="">Selecciona un cliente</option>
            <?php while ($c = $clientes->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
            <?php endwhile; ?>
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
        <?php if ($ventas->num_rows > 0): ?>
            <?php while ($venta = $ventas->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($venta['nombre']) ?></td>
                    <td>$<?= number_format($venta['monto'], 2) ?></td>
                    <td><?= $venta['puntos'] ?></td>
                    <td><?= $venta['fecha'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No hay ventas registradas.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
