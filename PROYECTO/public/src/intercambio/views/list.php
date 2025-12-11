<?php 
ob_start();

require_once __DIR__ . '/../../usuarios/UsuarioManager.php';
require_once __DIR__ . '/../../libros/librosManager.php';

$usuarioManager = new UsuarioManager();
$librosManager = new librosManager();

$usuarios = $usuarioManager->getAllUsuarios();
$libros = $librosManager->getAlllibros();
?>

<div class="intercambios-container">
    <h2>Gestión de Intercambios</h2>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" style="background: #d4edda; padding: 15px; border-radius: 4px; margin-bottom: 20px; color: #155724;">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-error" style="background: #f8d7da; padding: 15px; border-radius: 4px; margin-bottom: 20px; color: #721c24;">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    
    <div class="intercambio-form" style="background: #f5f5f5; padding: 20px; margin-bottom: 30px; border-radius: 8px;">
        <h3>Nuevo Intercambio</h3>
        <form method="POST" action="index.php?action=create">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label for="id_solicitante" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Usuario Solicitante: <span style="color: red;">*</span>
                    </label>
                    <select id="id_solicitante" name="id_solicitante" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Seleccionar usuario...</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id_usuario'] ?>">
                                <?= htmlspecialchars($usuario['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="id_ofertante" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Usuario Ofertante: <span style="color: red;">*</span>
                    </label>
                    <select id="id_ofertante" name="id_ofertante" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Seleccionar usuario...</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id_usuario'] ?>">
                                <?= htmlspecialchars($usuario['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label for="id_libro_solicitado" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Libro Solicitado: <span style="color: red;">*</span>
                    </label>
                    <select id="id_libro_solicitado" name="id_libro_solicitado" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Seleccionar libro...</option>
                        <?php foreach ($libros as $libro): ?>
                            <option value="<?= $libro['id_libro'] ?>">
                                <?= htmlspecialchars($libro['titulo']) ?> - <?= htmlspecialchars($libro['autor']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="id_libro_ofrecido" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Libro Ofrecido: <span style="color: red;">*</span>
                    </label>
                    <select id="id_libro_ofrecido" name="id_libro_ofrecido" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Seleccionar libro...</option>
                        <?php foreach ($libros as $libro): ?>
                            <option value="<?= $libro['id_libro'] ?>">
                                <?= htmlspecialchars($libro['titulo']) ?> - <?= htmlspecialchars($libro['autor']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn" 
                    style="background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Crear Intercambio
            </button>
        </form>
    </div>

    <h3>Lista de Intercambios</h3>
    <?php if (empty($intercambios)): ?>
        <p style="padding: 20px; background: #fff3cd; border-radius: 4px; color: #856404;">
            No hay intercambios registrados. Usa el formulario de arriba para crear un intercambio.
        </p>
    <?php else: ?>
        <div style="display: grid; gap: 15px;">
            <?php foreach ($intercambios as $intercambio): ?>
                <?php
                $estadoColor = [
                    'pendiente' => '#ffc107',
                    'aceptado' => '#2196F3',
                    'completado' => '#4caf50',
                    'cancelado' => '#f44336'
                ];
                $color = $estadoColor[$intercambio['estado']] ?? '#757575';
                ?>
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 10px 0; color: #333; font-size: 18px;">
                                🔄 Intercambio #<?= htmlspecialchars($intercambio['id_intercambio']) ?>
                            </h4>
                            <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 15px; margin: 15px 0;">
                                <div style="background: #e3f2fd; padding: 15px; border-radius: 8px;">
                                    <p style="margin: 0 0 5px 0; font-weight: bold; color: #1976d2;">Solicitante:</p>
                                    <p style="margin: 0; color: #666;"><?= htmlspecialchars($intercambio['nombre_solicitante'] ?? 'N/A') ?></p>
                                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #555;">
                                        📚 Solicita: <strong><?= htmlspecialchars($intercambio['titulo_solicitado'] ?? 'N/A') ?></strong>
                                    </p>
                                </div>
                                
                                <div style="display: flex; align-items: center; font-size: 24px;">
                                    ↔️
                                </div>
                                
                                <div style="background: #f3e5f5; padding: 15px; border-radius: 8px;">
                                    <p style="margin: 0 0 5px 0; font-weight: bold; color: #7b1fa2;">Ofertante:</p>
                                    <p style="margin: 0; color: #666;"><?= htmlspecialchars($intercambio['nombre_ofertante'] ?? 'N/A') ?></p>
                                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #555;">
                                        📚 Ofrece: <strong><?= htmlspecialchars($intercambio['titulo_ofrecido'] ?? 'N/A') ?></strong>
                                    </p>
                                </div>
                            </div>
                            
                            <div style="margin: 10px 0;">
                                <span style="background: <?= $color ?>; padding: 6px 12px; border-radius: 4px; font-size: 14px; color: white; font-weight: bold;">
                                    <?= ucfirst(htmlspecialchars($intercambio['estado'])) ?>
                                </span>
                            </div>
                            
                            <p style="margin: 10px 0 0 0; color: #999; font-size: 12px;">
                                <strong>Fecha:</strong> <?= htmlspecialchars($intercambio['fecha_intercambio']) ?>
                            </p>
                        </div>
                        
                        <div style="margin-left: 15px; display: flex; flex-direction: column; gap: 10px;">
                            <?php if ($intercambio['estado'] === 'pendiente'): ?>
                                <a href="index.php?action=cambiar_estado&id=<?= $intercambio['id_intercambio'] ?>&estado=aceptado" 
                                   class="btn" 
                                   style="background: #2196F3; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; text-align: center;">
                                    ✓ Aceptar
                                </a>
                            <?php elseif ($intercambio['estado'] === 'aceptado'): ?>
                                <a href="index.php?action=cambiar_estado&id=<?= $intercambio['id_intercambio'] ?>&estado=completado" 
                                   class="btn" 
                                   style="background: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; text-align: center;">
                                    ✓ Completar
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($intercambio['estado'] !== 'cancelado' && $intercambio['estado'] !== 'completado'): ?>
                                <a href="index.php?action=cambiar_estado&id=<?= $intercambio['id_intercambio'] ?>&estado=cancelado" 
                                   class="btn" 
                                   style="background: #FF9800; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; text-align: center;">
                                    ✗ Cancelar
                                </a>
                            <?php endif; ?>
                            
                            <a href="index.php?action=delete&id=<?= $intercambio['id_intercambio'] ?>" 
                               class="btn" 
                               style="background: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; text-align: center;"
                               onclick="return confirm('¿Estás seguro de eliminar este intercambio?')">
                                🗑️ Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../../views/layout.php';
?>