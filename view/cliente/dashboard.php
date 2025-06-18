<?php
include 'header.php';
include '../../conexion.php';


if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'cliente') {
    header('Location: ../V.login.php');
    exit();
}

$cliente_id = $_SESSION['usuario_id'];
$cliente = $mysqli->query("SELECT nombre, telefono, puntos FROM clientes WHERE id = $cliente_id")->fetch_assoc();
?>

<div class="container mt-4">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 420px; background: linear-gradient(135deg, #4e54c8, #8f94fb); color: white; border-radius: 1rem;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Tarjeta de Fidelidad</h5>
                    <small class="text-light">Cliente registrado</small>
                </div>
                <div>
                    <i class="bi bi-person-circle fs-1"></i>
                </div>
            </div>

            <hr style="border-color: rgba(255, 255, 255, 0.3);">

            <p class="mb-2"><strong>Nombre:</strong> <?= htmlspecialchars($cliente['nombre']) ?></p>
            <p class="mb-2"><strong>Teléfono:</strong> <?= htmlspecialchars($cliente['telefono']) ?></p>
            <p class="mb-0"><strong>Puntos actuales:</strong> <?= $cliente['puntos'] ?></p>
        </div>
    </div>
</div>
<!-- Historial de Compras -->
<div class="container mt-5">
    <h4>Historial de Compras</h4>
    <table class="table table-striped table-bordered mt-3">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Puntos Ganados</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $compras = $mysqli->query("SELECT monto, puntos, fecha FROM ventas WHERE cliente_id = $cliente_id ORDER BY fecha DESC");
            if ($compras->num_rows > 0):
                while ($compra = $compras->fetch_assoc()):
            ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($compra['fecha'])) ?></td>
                    <td>$<?= number_format($compra['monto'], 2) ?></td>
                    <td><?= $compra['puntos'] ?></td>
                </tr>
            <?php
                endwhile;
            else:
            ?>
                <tr>
                    <td colspan="3" class="text-center">No hay compras registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
