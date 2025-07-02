CREATE DATABASE IF NOT EXISTS EventumDB;
USE EventumDB;

-- Tabla de roles del sistema
CREATE TABLE roles_sistema (
    id_rol_sistema INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Insertar roles del sistema
INSERT INTO roles_sistema (nombre_rol, descripcion) VALUES
('Administrador', 'Control total del sistema'),
('Moderador', 'Supervisa usuarios y contenido'),
('Usuario', 'Accede a funcionalidades básicas del sistema');

-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL UNIQUE,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    id_rol_sistema INT NOT NULL,
    FOREIGN KEY (id_rol_sistema) REFERENCES roles_sistema(id_rol_sistema)
);

-- Tabla de eventos
CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    id_anfitrion INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    lugar VARCHAR(150),
    sitio VARCHAR(150),
    fecha_inicio DATE,
    hora_inicio TIME,
    fecha_fin DATE,
    hora_fin TIME,
    tipo_presupuesto ENUM('fijo', 'sugerido') DEFAULT 'sugerido',
    presupuesto DECIMAL(10, 2),
    numero_integrantes INT DEFAULT 0,
    codigo_evento VARCHAR(20) UNIQUE,
    fecha_limite_invitacion DATE,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anfitrion) REFERENCES usuarios(id_usuario)
);

-- Tabla de roles en eventos
CREATE TABLE roles_evento (
    id_rol_evento INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Insertar roles de evento
INSERT INTO roles_evento (nombre_rol, descripcion) VALUES
('Anfitrión', 'Organiza y lidera el evento'),
('Coanfitrión', 'Asiste al anfitrión'),
('Invitado', 'Ha sido invitado al evento'),
('Participante', 'Participa activamente en el evento');

-- Usuarios en eventos (con rol y estado de invitación)
CREATE TABLE usuarios_eventos (
    id_usuario_evento INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_evento INT NOT NULL,
    id_rol_evento INT NOT NULL,
    estado_invitacion ENUM('pendiente', 'aceptado', 'rechazado') DEFAULT 'pendiente',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_rol_evento) REFERENCES roles_evento(id_rol_evento),
    UNIQUE (id_usuario, id_evento)
);

-- Solicitudes de invitación
CREATE TABLE solicitudes_invitacion (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    id_usuario INT NOT NULL,
    tipo ENUM('codigo', 'directa') NOT NULL,
    estado ENUM('pendiente', 'aceptada', 'rechazada') DEFAULT 'pendiente',
    mensaje TEXT,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    UNIQUE (id_evento, id_usuario)
);

-- Participaciones (confirmación de asistencia)
CREATE TABLE participaciones (
    id_participacion INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha_confirmacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    asistencia ENUM('confirmada', 'no asistió', 'cancelada') DEFAULT 'confirmada',
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    UNIQUE (id_evento, id_usuario)
);

-- Notificaciones
CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_evento INT,
    tipo ENUM('invitacion', 'solicitud', 'evento', 'recordatorio', 'aviso') NOT NULL,
    contenido TEXT NOT NULL,
    leida TINYINT(1) DEFAULT 0,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento)
);
