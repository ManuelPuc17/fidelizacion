<?php 
include 'header.php'; 
include '../../conexion.php';

$clientes = $mysqli->query("SELECT * FROM clientes ORDER BY nombre");
?>

<h2 class="mb-4">Clientes registrados</h2>

<!-- Botón para agregar -->
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">+ Agregar nuevo cliente</button>

<!-- Tabla -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Ciudad</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($cliente = $clientes->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellidos']) ?></td>
                <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                <td><?= htmlspecialchars($cliente['correo']) ?></td>
                <td><?= htmlspecialchars($cliente['ciudad']) ?></td>
                <td><?= htmlspecialchars($cliente['rol']) ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $cliente['id'] ?>">Editar</button>
                    <a href="../../process/cliente_delete.php?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este cliente?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Modal de agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="../../process/cliente_insert.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Campos -->
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label>Apellidos</label>
            <input type="text" name="apellidos" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control">
          </div>
          <div class="col-md-6 mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control">
          </div>
          <div class="col-md-3 mb-3">
            <label>Estado</label>
            <input type="text" name="estado" class="form-control">
          </div>
          <div class="col-md-3 mb-3">
            <label>Ciudad</label>
            <input type="text" name="ciudad" class="form-control">
          </div>
          <div class="col-md-6 mb-3">
            <label>Rol</label>
            <select name="rol" class="form-select" required>
              <option value="cliente">Cliente</option>
              <option value="admin">Administrador</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label>Contraseña</label>
            <input type="password" name="contrasena" class="form-control" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" type="submit">Guardar</button>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modales de edición FUERA del tbody -->
<?php
$clientes->data_seek(0); // Reiniciar puntero
while ($cliente = $clientes->fetch_assoc()):
?>
<div class="modal fade" id="modalEditar<?= $cliente['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="../../process/cliente_update.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($cliente['nombre']) ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label>Apellidos</label>
            <input type="text" name="apellidos" class="form-control" required value="<?= htmlspecialchars($cliente['apellidos']) ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" required value="<?= htmlspecialchars($cliente['telefono']) ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($cliente['correo']) ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($cliente['direccion']) ?>">
          </div>
          <div class="col-md-3 mb-3">
            <label>Estado</label>
            <input type="text" name="estado" class="form-control" value="<?= htmlspecialchars($cliente['estado']) ?>">
          </div>
          <div class="col-md-3 mb-3">
            <label>Ciudad</label>
            <input type="text" name="ciudad" class="form-control" value="<?= htmlspecialchars($cliente['ciudad']) ?>">
          </div>
          <div class="col-md-6 mb-3">
            <label>Rol</label>
            <select name="rol" class="form-select">
              <option value="cliente" <?= $cliente['rol'] == 'cliente' ? 'selected' : '' ?>>Cliente</option>
              <option value="admin" <?= $cliente['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Guardar cambios</button>
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>
<?php endwhile; ?>

<?php include 'footer.php'; ?>
