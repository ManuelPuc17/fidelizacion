<?php 
include 'header.php'; 
include '../../conexion.php';

$beneficios = $mysqli->query("SELECT * FROM beneficios ORDER BY empresa");

$modalesEditar = ''; // Aquí vamos a acumular los modales
?>

<h2 class="mb-4">Empresas con Convenio</h2>

<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">+ Agregar nuevo beneficio</button>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fila = $beneficios->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['empresa']) ?></td>
                <td><?= htmlspecialchars($fila['descripcion']) ?></td>
                <td>
                    <button class="btn btn-sm btn-warning" 
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditar<?= $fila['id'] ?>">
                        Editar
                    </button>
                    <a href="../../process/beneficio_delete.php?id=<?= $fila['id'] ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Estás seguro de eliminar este beneficio?')">
                       Eliminar
                    </a>
                </td>
            </tr>

            <?php
            // Acumulamos el modal fuera de la tabla
            $modalesEditar .= '
            <div class="modal fade" id="modalEditar' . $fila['id'] . '" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="../../process/beneficio_update.php" method="POST" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar beneficio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="' . $fila['id'] . '">

                            <div class="mb-3">
                                <label class="form-label">Empresa</label>
                                <input type="text" name="empresa" class="form-control" required value="' . htmlspecialchars($fila['empresa']) . '">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control">' . htmlspecialchars($fila['descripcion']) . '</textarea>
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
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Modales de edición (fuera del tbody) -->
<?= $modalesEditar ?>

<!-- Modal de agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="../../process/beneficio_insert.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nuevo beneficio</h5>
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
