<?php 
ob_start();

require_once __DIR__ . '/../../intercambio/IntercambioManager.php';
$intercambioManager = new IntercambioManager();
$intercambios = $intercambioManager->getAllIntercambio();
?>

<div class="historial-container">
    <h2>Historial de Intercambios</h2>
    
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
    
    <div class="historial-form" style="background: #f5f5f5; padding: 20px; margin-bottom: 30px; border-radius: 8px;">
        <h3>Registrar Resultado de Intercambio</h3>
        <form method="POST" action="index.php?action=create">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label for="id_intercambio" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Intercambio: <span style="color: red;">*</span>
                    </label>
                    <select id="id_intercambio" name="id_intercambio" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Seleccionar intercambio...</option>
                        <?php foreach ($intercambios as $intercambio): ?>
                            <option value="<?= $intercambio['id_intercambio'] ?>">
                                #<?= $intercambio['id_intercambio'] ?> - 
                                <?= htmlspecialchars($intercambio['nombre_solicitante']) ?> ↔ 
                                <?= htmlspecialchars($intercambio['nombre_ofertante']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="resultado" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Resultado: <span style="color: red;">*</span>
                    </label>
                    <select id="resultado" name="resultado" required 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="exitoso">✓ Exitoso</option>
                        <option value="fallido">✗ Fallido</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn" 
                    style="background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Registrar en Historial
            </button>
        </form>
    </div>

    <h3>Historial Completo</h3>
    <?php if (empty($historial)): ?>
        <p style="padding: 20px; background: #fff3cd; border-radius: 4px; color: #856404;">
            No hay registros en el historial. Los intercambios completados aparecerán aquí.
        </p>
    <?php else: ?>
        <div style="display: grid; gap: 15px;">
            <?php foreach ($historial as $registro): ?>
                <?php
                $resultadoColor = $registro['resultado'] === 'exitoso' ? '#4caf50' : '#f44336';
                $resultadoIcon = $registro['resultado'] === 'exitoso' ? '✓' : '✗';
                ?>
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                <h4 style="margin: 0; color: #333; font-size: 18px;">
                                    📋 Intercambio #<?= htmlspecialchars($registro['id_intercambio']) ?>
                                </h4>
                                <span style="background: <?= $resultadoColor ?>; padding: 6px 12px; border-radius: 4px; font-size: 14px; color: white; font-weight: bold;">
                                    <?= $resultadoIcon ?> <?= ucfirst(htmlspecialchars($registro['resultado'])) ?>
                                </span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 15px; margin: 15px 0;">
                                <div>
                                    <p style="margin: 0; color: #666;">
                                        <strong>Solicitante:</strong> <?= htmlspecialchars($registro['nombre_solicitante'] ?? 'N/A') ?>
                                    </p>
                                    <p style="margin: 5px 0; font-size: 14px; color: #555;">
                                        📚 <?= htmlspecialchars($registro['titulo_solicitado'] ?? 'N/A') ?>
                                    </p>
                                </div>
                                
                                <div style="display: flex; align-items: center; font-size: 20px;">
                                    ↔️
                                </div>
                                
                                <div>
                                    <p style="margin: 0; color: #666;">
                                        <strong>Ofertante:</strong> <?= htmlspecialchars($registro['nombre_ofertante'] ?? 'N/A') ?>
                                    </p>
                                    <p style="margin: 5px 0; font-size: 14px; color: #555;">
                                        📚 <?= htmlspecialchars($registro['titulo_ofrecido'] ?? 'N/A') ?>
                                    </p>
                                </div>
                            </div>
                            
                            <p style="margin: 10px 0 0 0; color: #999; font-size: 12px;">
                                <strong>Fecha de Registro:</strong> <?= htmlspecialchars($registro['fecha']) ?> | 
                                <strong>Estado Original:</strong> <?= ucfirst(htmlspecialchars($registro['estado_intercambio'] ?? 'N/A')) ?>
                            </p>
                        </div>
                        
                        <div style="margin-left: 15px;">
                            <a href="index.php?action=delete&id=<?= $registro['id_historial'] ?>" 
                               class="btn" 
                               style="background: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block;"
                               onclick="return confirm('¿Estás seguro de eliminar este registro del historial?')">
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