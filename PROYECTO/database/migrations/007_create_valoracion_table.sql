-- Migration: Create valoracion table
-- Description: Table to manage ratings and reviews for users and books

CREATE TABLE IF NOT EXISTS valoraciones (
    id_valoracion INT AUTO_INCREMENT PRIMARY KEY,
    id_valorador INT NOT NULL,
    id_valorado INT NULL,
    id_libro INT NULL,
    puntuacion TINYINT NOT NULL CHECK (puntuacion >= 1 AND puntuacion <= 5),
    comentario TEXT,
    fecha_valoracion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_valorador) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_valorado) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_libro) REFERENCES libros(id_libro) ON DELETE CASCADE,
    
    CHECK (
        (id_valorado IS NOT NULL AND id_libro IS NULL) OR 
        (id_valorado IS NULL AND id_libro IS NOT NULL)
    ),
    
    INDEX idx_valorador (id_valorador),
    INDEX idx_valorado (id_valorado),
    INDEX idx_libro (id_libro),
    INDEX idx_puntuacion (puntuacion),
    INDEX idx_fecha (fecha_valoracion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;