<?php 
include 'header.php'; 

// Consumir API REST en lugar de mysqli
$beneficios_json = file_get_contents('http://localhost/apirest/beneficios');
$beneficios = json_decode($beneficios_json, true);
?>

<h2 class="mb-4">Beneficios Registrados</h2>

<!-- Botón para agregar -->
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">+ Agregar beneficio</button>

<!-- Tabla -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $modalesEditar = '';
        foreach ($beneficios as $beneficio):
        ?>
        <tr>
            <td><?= htmlspecialchars($beneficio['empresa']) ?></td>
            <td><?= htmlspecialchars($beneficio['descripcion']) ?></td>
            <td>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $beneficio['id'] ?>">Editar</button>
                <a href="../../process/beneficio_delete.php?id=<?= $beneficio['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este beneficio?')">Eliminar</a>
            </td>
        </tr>

        <?php
        // Modal de edición
        $modalesEditar .= '
        <div class="modal fade" id="modalEditar' . $beneficio['id'] . '" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <form action="../../process/beneficio_update.php" method="POST" class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Editar beneficio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" value="' . $beneficio['id'] . '">
                <div class="mb-3">
                  <label class="form-label">Empresa</label>
                  <input type="text" name="empresa" class="form-control" required value="' . htmlspecialchars($beneficio['empresa']) . '">
                </div>
                <div class="mb-3">
                  <label class="form-label">Descripción</label>
                  <textarea name="descripcion" class="form-control">' . htmlspecialchars($beneficio['descripcion']) . '</textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              </div>
            </form>
          </div>
        </div>';
        endforeach;
        ?>
    </tbody>
</table>

<!-- Mostrar todos los modales de edición fuera del <table> -->
<?= $modalesEditar ?>

<!-- Modal de agregar beneficio -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="../../process/beneficio_insert.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar beneficio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Empresa</label>
          <input type="text" name="empresa" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Descripción</label>
          <textarea name="descripcion" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>
