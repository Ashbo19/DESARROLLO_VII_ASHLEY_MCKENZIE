-- Migration: Create puntos table
-- Description: Table to track user points and their history

CREATE TABLE IF NOT EXISTS puntos (
    id_puntos INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    motivo VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    
    INDEX idx_usuario (id_usuario),
    INDEX idx_fecha (fecha),
    INDEX idx_motivo (motivo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;