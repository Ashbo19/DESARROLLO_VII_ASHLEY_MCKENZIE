CREATE TABLE IF NOT EXISTS libros (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    autor VARCHAR(150) NOT NULL,
    categoria VARCHAR(100),
    estado ENUM('nuevo', 'usado', 'buen estado', 'aceptable') NOT NULL DEFAULT 'buen estado',
    descripcion TEXT,
    id_usuario INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- Create indexes for better query performance
CREATE INDEX idx_usuario ON libros(id_usuario);
CREATE INDEX idx_categoria ON libros(categoria);
CREATE INDEX idx_estado ON libros(estado);