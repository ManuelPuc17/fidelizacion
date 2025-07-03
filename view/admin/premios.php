<?php 
include 'header.php'; 

//  Llamar a la API
$premios_json = file_get_contents('http://localhost/apirest/premios');
$premios = json_decode($premios_json, true);

// Acumulador para los modales de edición
$modalesEditar = '';
?>

<h2 class="mb-4">Premios Disponibles</h2>

<!-- Botón para abrir el modal de "Agregar" -->
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">+ Agregar nuevo premio</button>

<!-- Tabla de premios -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Puntos necesarios</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($premios as $premio): ?>
        <tr>
            <td><?= htmlspecialchars($premio['nombre']) ?></td>
            <td><?= htmlspecialchars($premio['descripcion']) ?></td>
            <td><?= htmlspecialchars($premio['puntos_necesarios']) ?></td>
            <td>
                <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditar<?= $premio['id'] ?>">
                        Editar
                </button>

                <a href="../../process/premio_delete.php?id=<?= $premio['id'] ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar este premio?')">
                   Eliminar
                </a>
            </td>
        </tr>

        <?php
        $modalesEditar .= '
        <div class="modal fade" id="modalEditar' . $premio['id'] . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="../../process/premio_update.php" method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar premio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="' . $premio['id'] . '">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required value="' . htmlspecialchars($premio['nombre']) . '">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control">' . htmlspecialchars($premio['descripcion']) . '</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Puntos necesarios</label>
                            <input type="number" name="puntos_necesarios" class="form-control" required value="' . htmlspecialchars($premio['puntos_necesarios']) . '">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>';
        ?>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Mostrar los modales de edición -->
<?= $modalesEditar ?>

<!-- Modal de agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="../../process/premio_insert.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nuevo premio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Puntos necesarios</label>
                    <input type="number" name="puntos_necesarios" class="form-control" required>
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
