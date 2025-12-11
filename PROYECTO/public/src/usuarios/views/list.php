<?php 
ob_start();
?>

<div class="usuarios-container">
    <h2>Gestión de Usuarios</h2>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    
    <div class="usuario-form" style="background: #f5f5f5; padding: 20px; margin-bottom: 30px; border-radius: 8px;">
        <h3>Registrar Nuevo Usuario</h3>
        <form method="POST" action="index.php?action=create">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label for="nombre" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Nombre Completo: <span style="color: red;">*</span>
                    </label>
                    <input type="text" id="nombre" name="nombre" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                           placeholder="Ej: Juan Pérez">
                </div>

                <div>
                    <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Email: <span style="color: red;">*</span>
                    </label>
                    <input type="email" id="email" name="email" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                           placeholder="ejemplo@correo.com">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label for="contraseña" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Contraseña: <span style="color: red;">*</span>
                    </label>
                    <input type="password" id="contraseña" name="contraseña" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                           placeholder="Contraseña segura">
                </div>

                <div>
                    <label for="telefono" style="display: block; margin-bottom: 5px; font-weight: bold;">
                        Teléfono:
                    </label>
                    <input type="text" id="telefono" name="telefono" 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                           placeholder="+52 123 456 7890">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="direccion" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Dirección:
                </label>
                <textarea id="direccion" name="direccion" rows="2"
                          style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;"
                          placeholder="Dirección completa..."></textarea>
            </div>

            <button type="submit" class="btn" 
                    style="background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Registrar Usuario
            </button>
        </form>
    </div>

    <h3>Lista de Usuarios Registrados</h3>
    <?php if (empty($usuarios)): ?>
        <p style="padding: 20px; background: #fff3cd; border-radius: 4px; color: #856404;">
            No hay usuarios registrados. Usa el formulario de arriba para registrar el primer usuario.
        </p>
    <?php else: ?>
        <div style="display: grid; gap: 15px;">
            <?php foreach ($usuarios as $usuario): ?>
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 10px 0; color: #333; font-size: 18px;">
                                👤 <?= htmlspecialchars($usuario['nombre']) ?>
                            </h4>
                            <p style="margin: 5px 0; color: #666;">
                                <strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?>
                            </p>
                            
                            <?php if (!empty($usuario['telefono'])): ?>
                                <p style="margin: 5px 0; color: #666;">
                                    <strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($usuario['direccion'])): ?>
                                <p style="margin: 5px 0; color: #666;">
                                    <strong>Dirección:</strong> <?= htmlspecialchars($usuario['direccion']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <div style="margin: 10px 0;">
                                <span style="background: #ffd700; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-weight: bold;">
                                    ⭐ Puntos: <?= htmlspecialchars($usuario['puntos']) ?>
                                </span>
                            </div>
                            
                            <p style="margin: 10px 0 0 0; color: #999; font-size: 12px;">
                                <strong>Registrado:</strong> <?= htmlspecialchars($usuario['created_at']) ?> | 
                                <strong>ID:</strong> <?= htmlspecialchars($usuario['id_usuario']) ?>
                            </p>
                        </div>
                        
                        <div style="margin-left: 15px; display: flex; gap: 10px;">
                            <a href="index.php?action=edit&id=<?= $usuario['id_usuario'] ?>" 
                               class="btn" 
                               style="background: #2196F3; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block;">
                                ✏️ Editar
                            </a>
                            <a href="index.php?action=delete&id=<?= $usuario['id_usuario'] ?>" 
                               class="btn" 
                               style="background: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block;"
                               onclick="return confirm('¿Estás seguro de eliminar el usuario: <?= htmlspecialchars($usuario['nombre']) ?>?')">
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