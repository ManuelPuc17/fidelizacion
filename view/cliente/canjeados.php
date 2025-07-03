<?php
include 'header.php';

$cliente_id = $_SESSION['usuario_id'];
$api_url = "http://localhost/apirest/canjeos/$cliente_id";

$response = @file_get_contents($api_url);

if ($response === FALSE) {
    die("Error al obtener el historial de canjeos.");
}

$canjeos = json_decode($response, true);

?>

<h4>Historial de Premios Canjeados</h4>

<?php if (!empty($canjeos) && !isset($canjeos['message'])): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Premio</th>
                <th>Puntos usados</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($canjeos as $canjeo): ?>
                <tr>
                    <td><?= htmlspecialchars($canjeo['premio']['nombre'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($canjeo['premio']['puntos_necesarios'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($canjeo['fecha']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-muted">Aún no has canjeado ningún premio.</p>
<?php endif; ?>
