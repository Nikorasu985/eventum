
-- Base de Datos: eventum

-- Tabla de Roles
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla de Usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    rol_id INT,
    FOREIGN KEY (rol_id) REFERENCES roles(id_rol)
);

-- Tabla de Eventos
CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha_hora DATETIME NOT NULL,
    ubicacion VARCHAR(200),
    presupuesto DECIMAL(10,2),
    estado VARCHAR(50) DEFAULT 'Activo',
    id_anfitrion INT,
    FOREIGN KEY (id_anfitrion) REFERENCES usuarios(id_usuario)
);

-- Tabla de Invitaciones (relación muchos a muchos con datos adicionales)
CREATE TABLE invitaciones (
    id_invitacion INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT,
    id_usuario INT,
    asistencia ENUM('Confirmado', 'Rechazado', 'Pendiente') DEFAULT 'Pendiente',
    fecha_respuesta DATETIME,
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabla de Notificaciones
CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    mensaje TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo VARCHAR(50),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
