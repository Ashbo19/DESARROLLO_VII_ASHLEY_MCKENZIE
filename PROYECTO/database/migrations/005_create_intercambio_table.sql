-- Migration: Create intercambio table
-- Description: Table to manage book exchanges between users

CREATE TABLE IF NOT EXISTS intercambios (
    id_intercambio INT AUTO_INCREMENT PRIMARY KEY,
    id_solicitante INT NOT NULL,
    id_ofertante INT NOT NULL,
    id_libro_solicitado INT NOT NULL,
    id_libro_ofrecido INT NOT NULL,
    fecha_intercambio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'aceptado', 'completado', 'cancelado') NOT NULL DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_solicitante) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_ofertante) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_libro_solicitado) REFERENCES libros(id_libro) ON DELETE CASCADE,
    FOREIGN KEY (id_libro_ofrecido) REFERENCES libros(id_libro) ON DELETE CASCADE,
    
    INDEX idx_solicitante (id_solicitante),
    INDEX idx_ofertante (id_ofertante),
    INDEX idx_estado (estado),
    INDEX idx_fecha (fecha_intercambio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;