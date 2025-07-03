<?php
include 'header.php';

// ID del cliente desde sesión
$cliente_id = $_SESSION['usuario_id'];

// Obtener los puntos del cliente desde la API
$cliente = [];
$clienteJson = @file_get_contents("http://localhost/apirest/clientes/$cliente_id");
if ($clienteJson !== false) {
    $cliente = json_decode($clienteJson, true);
} else {
    echo "<div class='alert alert-danger'>Error al obtener los datos del cliente desde la API.</div>";
    exit;
}

// Obtener los premios desde la API
$premios = [];
$premiosJson = @file_get_contents("http://localhost/apirest/premios");
if ($premiosJson !== false) {
    $premios = json_decode($premiosJson, true);
} else {
    echo "<div class='alert alert-danger'>Error al obtener los premios desde la API.</div>";
    exit;
}
?>

<div class="mb-4">
  <h4>Premios disponibles</h4>
  <div class="row">
    <?php if (!empty($premios)): ?>
      <?php foreach ($premios as $p): 
        $puedeCanjear = $cliente['puntos'] >= $p['puntos_necesarios'];
      ?>
        <div class="col-md-4">
          <div class="card mb-3 <?= $puedeCanjear ? '' : 'bg-light text-muted' ?>">
            <div class="card-body">
              <h5><?= htmlspecialchars($p['nombre']) ?></h5>
              <p><?= htmlspecialchars($p['descripcion']) ?></p>
              <p><strong>Puntos requeridos:</strong> <?= $p['puntos_necesarios'] ?></p>
              
              <?php if ($puedeCanjear): ?>
                <form action="../../process/premio_canjear.php" method="POST">
                  <input type="hidden" name="premio_id" value="<?= $p['id'] ?>">
                  <input type="hidden" name="cliente_id" value="<?= $cliente_id ?>">
                  <input type="hidden" name="puntos_necesarios" value="<?= $p['puntos_necesarios'] ?>">
                  <button class="btn btn-sm btn-primary" onclick="return confirm('¿Canjear este premio?')">Canjear</button>
                </form>
              <?php else: ?>
                <button class="btn btn-sm btn-secondary" disabled>No tienes suficientes puntos</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-warning text-center mt-3">
        No hay premios disponibles por el momento.
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="mb-4">
  <h4>Mis puntos</h4>
  <div class="alert alert-info">
    Tienes <strong><?= $cliente['puntos'] ?></strong> puntos acumulados.
  </div>
</div>
