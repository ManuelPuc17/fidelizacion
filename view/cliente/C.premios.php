<?php
include 'header.php';

$cliente_id = $_SESSION['usuario_id'];
$cliente = $mysqli->query("SELECT puntos FROM clientes WHERE id = $cliente_id")->fetch_assoc();

$premios = $mysqli->query("SELECT * FROM premios ORDER BY puntos_necesarios");
?>

<div class="mb-4">
  <h4>Premios disponibles</h4>
  <div class="row">
    <?php if ($premios->num_rows > 0): ?>
      <?php while ($p = $premios->fetch_assoc()): 
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
                  <button class="btn btn-sm btn-primary" onclick="return confirm('¿Canjear este premio?')">Canjear</button>
                </form>
              <?php else: ?>
                <button class="btn btn-sm btn-secondary" disabled>No tienes suficientes puntos</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
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