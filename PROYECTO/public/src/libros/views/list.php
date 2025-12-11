<?php 
// Iniciamos el buffer de salida
//ob_start();
//echo 'Mis Libros'
?>

<div class="task-list">
    <h2>Catálogo de Libros</h2>
    
    <!-- Added test form to create books -->
    <div class="libro-form" style="background: #f5f5f5; padding: 20px; margin-bottom: 30px; border-radius: 8px;">
        <h3>Agregar Nuevo Libro</h3>
        <form method="POST" action="index.php?action=create">
            <div style="margin-bottom: 15px;">
                <label for="titulo" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Título: <span style="color: red;">*</span>
                </label>
                <input type="text" id="titulo" name="titulo" required 
                       style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                       placeholder="Ej: Cien Años de Soledad">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="autor" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    Autor: <span style="color: red;">*</span>
                </label>
                <input type="text" id="autor" name="autor" required 
                       style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                       placeholder="Ej: Gabriel García Márquez">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label for="isbn" style="display: block; margin-bottom: 5px; font-weight: bold;">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                           placeholder="Ej: 978-3-16-148410-0">
                </div>

                <div>
                    <label for="anio_publicacion" style="display: block; margin-bottom: 5px; font-weight: bold;">Año de Publicación:</label>
                    <input type="number" id="anio_publicacion" name="anio_publicacion" min="1000" max="<?= date('Y') ?>"
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                           placeholder="<?= date('Y') ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label for="cantidad_disponible" style="display: block; margin-bottom: 5px; font-weight: bold;">Cantidad:</label>
                    <input type="number" id="cantidad_disponible" name="cantidad_disponible" min="1" value="1"
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div>
                    <label for="categoria" style="display: block; margin-bottom: 5px; font-weight: bold;">Categoría:</label>
                    <select id="categoria" name="categoria" 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="Ficción">Ficción</option>
                        <option value="No Ficción">No Ficción</option>
                        <option value="Ciencia">Ciencia</option>
                        <option value="Historia">Historia</option>
                        <option value="Biografía">Biografía</option>
                        <option value="Tecnología">Tecnología</option>
                        <option value="Arte">Arte</option>
                        <option value="General" selected>General</option>
                    </select>
                </div>

                <div>
                    <label for="estado" style="display: block; margin-bottom: 5px; font-weight: bold;">Estado:</label>
                    <select id="estado" name="estado" 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="nuevo">Nuevo</option>
                        <option value="usado">Usado</option>
                        <option value="buen_estado" selected>Buen Estado</option>
                        <option value="aceptable">Aceptable</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="descripcion" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="3"
                          style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;"
                          placeholder="Descripción del libro..."></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="id_usuario" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    ID Usuario: <span style="color: red;">*</span>
                </label>
                <input type="number" id="id_usuario" name="id_usuario" required value="1"
                       style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                       placeholder="ID del usuario propietario">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="fecha_registro" style="display: block; margin-bottom: 5px; font-weight: bold;">Fecha de Registro:</label>
                <input type="date" id="fecha_registro" name="fecha_registro" value="<?= date('Y-m-d') ?>"
                       style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <button type="submit" class="btn" 
                    style="background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Agregar Libro
            </button>
        </form>
    </div>

    <!-- Improved book list display with all fields -->
    <h3>Lista de Libros Registrados</h3>
    <?php if (empty($libros)): ?>
        <p style="padding: 20px; background: #fff3cd; border-radius: 4px; color: #856404;">
            No hay libros registrados. Usa el formulario de arriba para agregar tu primer libro.
        </p>
    <?php else: ?>
        <div style="display: grid; gap: 15px;">
            <?php foreach ($libros as $libro): ?>
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 10px 0; color: #333; font-size: 18px;">
                                📚 <?= htmlspecialchars($libro['titulo']) ?>
                            </h4>
                            <p style="margin: 5px 0; color: #666;">
                                <strong>Autor:</strong> <?= htmlspecialchars($libro['autor']) ?>
                            </p>
                            
                            <?php if (!empty($libro['isbn'])): ?>
                                <p style="margin: 5px 0; color: #666;">
                                    <strong>ISBN:</strong> <?= htmlspecialchars($libro['isbn']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <div style="display: flex; gap: 20px; margin: 10px 0; flex-wrap: wrap;">
                                <?php if (!empty($libro['anio_publicacion'])): ?>
                                    <span style="background: #e3f2fd; padding: 4px 8px; border-radius: 4px; font-size: 14px;">
                                        📅 <?= htmlspecialchars($libro['anio_publicacion']) ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if (!empty($libro['categoria'])): ?>
                                    <span style="background: #f3e5f5; padding: 4px 8px; border-radius: 4px; font-size: 14px;">
                                        🏷️ <?= htmlspecialchars($libro['categoria']) ?>
                                    </span>
                                <?php endif; ?>
                                
                                <span style="background: #e8f5e9; padding: 4px 8px; border-radius: 4px; font-size: 14px;">
                                    ✨ <?= ucfirst(str_replace('_', ' ', htmlspecialchars($libro['estado']))) ?>
                                </span>
                                
                                <span style="background: #fff3e0; padding: 4px 8px; border-radius: 4px; font-size: 14px;">
                                    📦 Cantidad: <?= htmlspecialchars($libro['cantidad_disponible']) ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($libro['descripcion'])): ?>
                                <p style="margin: 10px 0; color: #555; font-style: italic;">
                                    <?= htmlspecialchars($libro['descripcion']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <p style="margin: 10px 0 0 0; color: #999; font-size: 12px;">
                                <strong>Registrado:</strong> <?= htmlspecialchars($libro['fecha_registro'] ?? 'N/A') ?> | 
                                <strong>Usuario ID:</strong> <?= htmlspecialchars($libro['id_usuario']) ?> |
                                <strong>ID Libro:</strong> <?= htmlspecialchars($libro['id_libro']) ?>
                            </p>
                        </div>
                        
                        <div style="margin-left: 15px;">
                            <a href="index.php?action=delete&id=<?= $libro['id_libro'] ?>" 
                               class="btn" 
                               style="background: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block;"
                               onclick="return confirm('¿Estás seguro de eliminar el libro: <?= htmlspecialchars($libro['titulo']) ?>?')">
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
// Guardamos el contenido del buffer en la variable $content
//$content = ob_get_clean();
// Incluimos el layout
require __DIR__ . '/../../../views/layout.php';
?>