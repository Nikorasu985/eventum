Create database EventumDB;
use EventumDB;



CREATE TABLE roles_sistema (
    id_rol_sistema INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

INSERT INTO roles_sistema (nombre_rol, descripcion) VALUES
('Administrador', 'Control total del sistema'),
('Moderador', 'Supervisa usuarios y contenido'),
('Usuario', 'Accede a funcionalidades básicas del sistema');

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    contraseña VARCHAR(255),
    id_rol_sistema INT,
    FOREIGN KEY (id_rol_sistema) REFERENCES roles_sistema(id_rol_sistema)
);

CREATE TABLE roles_evento (
    id_rol_evento INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

INSERT INTO roles_evento (nombre_rol, descripcion) VALUES
('Anfitrión', 'Organiza y lidera el evento'),
('Coanfitrión', 'Asiste al anfitrión'),
('Invitado', 'Ha sido invitado al evento'),
('Participante', 'Participa activamente en el evento');

CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    nombre_evento VARCHAR(100),
    descripcion TEXT,
    fecha DATE,
    ubicacion VARCHAR(150),
    fecha_limite_invitacion DATE,
    tipo_presupuesto ENUM('fijo', 'sugerido') NOT NULL,
    monto_presupuesto DECIMAL(10,2) DEFAULT NULL
);

CREATE TABLE usuarios_eventos (
    id_usuario_evento INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_evento INT,
    id_rol_evento INT,
    estado_invitacion ENUM('pendiente', 'aceptado', 'rechazado') DEFAULT 'pendiente',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_rol_evento) REFERENCES roles_evento(id_rol_evento)
);


CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_evento INT,
    tipo_notificacion ENUM('aviso', 'recordatorio') NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN DEFAULT FALSE,
    
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento)
);

CREATE TABLE invitaciones (
    id_invitacion INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT,
    id_usuario INT,
    id_enviada_por INT,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'aceptada', 'rechazada') DEFAULT 'pendiente',
    mensaje TEXT,
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_enviada_por) REFERENCES usuarios(id_usuario)
);

CREATE TABLE participaciones (
    id_participacion INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT,
    id_usuario INT,
    fecha_confirmacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    asistencia ENUM('confirmada', 'no asistió', 'cancelada') DEFAULT 'confirmada',
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
