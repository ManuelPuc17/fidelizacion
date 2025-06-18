<?php
include 'header.php'; // Incluye sesión y conexión

$cliente_id = $_SESSION['usuario_id'];

$historial = $mysqli->query("
  SELECT premios.nombre, premios.puntos_necesarios, canjeos.fecha 
  FROM canjeos 
  JOIN premios ON canjeos.premio_id = premios.id 
  WHERE canjeos.cliente_id = $cliente_id 
  ORDER BY canjeos.fecha DESC
");
?>

<div>
  <h4>Historial de Premios Canjeados</h4>
  <?php if ($historial->num_rows > 0): ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Premio</th>
          <th>Puntos usados</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($h = $historial->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($h['nombre']) ?></td>
            <td><?= $h['puntos_necesarios'] ?></td>
            <td><?= $h['fecha'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-muted">Aún no has canjeado ningún premio.</p>
  <?php endif; ?>
</div>
