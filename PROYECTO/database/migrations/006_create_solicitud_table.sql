-- Migration: Create solicitud table
-- Description: Table to manage book requests from users

CREATE TABLE IF NOT EXISTS solicitudes (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_solicitante INT NOT NULL,
    id_libro INT NOT NULL,
    fecha_solicitud DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('en espera', 'aceptada', 'rechazada') NOT NULL DEFAULT 'en espera',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_usuario_solicitante) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_libro) REFERENCES libros(id_libro) ON DELETE CASCADE,
    
    INDEX idx_usuario_solicitante (id_usuario_solicitante),
    INDEX idx_libro (id_libro),
    INDEX idx_estado (estado),
    INDEX idx_fecha (fecha_solicitud)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;