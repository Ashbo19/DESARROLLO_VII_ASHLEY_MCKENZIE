-- Migration: Create historial_intercambios table
-- Description: Table to keep a record of all completed exchanges

CREATE TABLE IF NOT EXISTS historial_intercambios (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_intercambio INT NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    resultado ENUM('exitoso', 'fallido') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_intercambio) REFERENCES intercambios(id_intercambio) ON DELETE CASCADE,
    
    INDEX idx_intercambio (id_intercambio),
    INDEX idx_resultado (resultado),
    INDEX idx_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;