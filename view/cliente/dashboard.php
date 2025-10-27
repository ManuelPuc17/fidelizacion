<?php
include 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'cliente') {
    header('Location: ../V.login.php');
    exit();
}

$cliente_id = $_SESSION['usuario_id'];

// Obtener datos del cliente desde la API
$cliente_json = file_get_contents("http://localhost/apirest/clientes/$cliente_id");
$cliente = json_decode($cliente_json, true);

// Obtener historial de compras desde la API
$compras_json = file_get_contents("http://localhost/apirest/ventas/cliente/$cliente_id");
$compras = json_decode($compras_json, true);
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
            <?php if (!empty($compras)): ?>
                <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($compra['fecha'])) ?></td>
                        <td>$<?= number_format($compra['monto'], 2) ?></td>
                        <td><?= $compra['puntos'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No hay compras registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
$cliente_nombre = $cliente['nombre'];
?>
<script>
document.addEventListener('DOMContentLoaded', async () => {
  // Pedimos permiso si no está concedido
  if (Notification.permission === 'default') {
    await Notification.requestPermission();
  }

  // Mostramos la notificación solo si el usuario la permitió
  if (Notification.permission === 'granted') {
    new Notification("¡Bienvenido!", {
      body: "Hola <?= addslashes($cliente_nombre) ?>, disfruta tu sesión y revisa tus puntos.",
      icon: "../../icons/tienda-online.png",
      badge: "../../icons/tienda-online.png"
    });
    
  } 
    // Badging API: muestra el número de puntos nuevos
  if ('setAppBadge' in navigator) {
    const puntosNuevos = <?= $cliente['puntos'] ?>; // ejemplo
    navigator.setAppBadge(1);
    console.info("Badge actualizado con puntos:", puntosNuevos);
  } else {
    console.info("Badging API no soportada en este navegador");
  }
});

</script>