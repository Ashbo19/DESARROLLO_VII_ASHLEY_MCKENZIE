-- Adding SET FOREIGN_KEY_CHECKS to prevent foreign key constraint errors
-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

--Eliminar tabla existente y recrearla con estructura correcta
--DROP TABLE IF EXISTS libros;

CREATE TABLE libros (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    autor VARCHAR(150) NOT NULL,
    isbn VARCHAR(20),
    anio_publicacion YEAR,
    cantidad_disponible INT DEFAULT 1,
    fecha_registro DATE,
    categoria VARCHAR(100),
    estado ENUM('nuevo', 'usado', 'buen_estado', 'aceptable') DEFAULT 'buen_estado',
    descripcion TEXT,
    id_usuario INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    INDEX idx_usuario (id_usuario),
    INDEX idx_categoria (categoria),
    INDEX idx_estado (estado),
    INDEX idx_isbn (isbn)
);

-- Re-enabling foreign key checks after table recreation
-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;