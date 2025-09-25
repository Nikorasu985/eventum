
CREATE DATABASE IF NOT EXISTS EventumDB;
USE EventumDB;

-- Tabla de roles del sistema
CREATE TABLE roles_sistema (
    id_rol_sistema INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL UNIQUE,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    id_rol_sistema INT NOT NULL,
    FOREIGN KEY (id_rol_sistema) REFERENCES roles_sistema(id_rol_sistema)
);

-- Tabla de tipos de presupuesto
CREATE TABLE tipos_presupuesto (
    id_tipo_presupuesto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo ENUM('fijo', 'sugerido') NOT NULL UNIQUE
);

-- Tabla de eventos
CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    id_anfitrion INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    lugar VARCHAR(150),
    sitio VARCHAR(150),
    id_tipo_presupuesto INT DEFAULT 2, -- por defecto 'sugerido'
    presupuesto DECIMAL(10, 2),
    numero_integrantes INT DEFAULT 0,
    codigo_evento VARCHAR(20) UNIQUE,
    fecha_inicio DATE,
    hora_inicio TIME,
    fecha_fin DATE,
    hora_fin TIME,
    fecha_limite_invitacion DATE,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anfitrion) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_tipo_presupuesto) REFERENCES tipos_presupuesto(id_tipo_presupuesto)
);

-- Tabla de roles en eventos
CREATE TABLE roles_evento (
    id_rol_evento INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Usuarios en eventos
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

-- Tabla de tipos de solicitud
CREATE TABLE tipos_solicitud (
    id_tipo_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo ENUM('codigo', 'directa') NOT NULL UNIQUE
);

-- Tabla de estados de solicitud
CREATE TABLE estados_solicitud (
    id_estado_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    nombre_estado ENUM('pendiente', 'aceptada', 'rechazada') NOT NULL UNIQUE
);

-- Solicitudes de invitación
CREATE TABLE solicitudes_invitacion (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    id_usuario INT NOT NULL,
    id_tipo_solicitud INT NOT NULL,
    id_estado_solicitud INT DEFAULT 1, -- pendiente
    mensaje TEXT,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_tipo_solicitud) REFERENCES tipos_solicitud(id_tipo_solicitud),
    FOREIGN KEY (id_estado_solicitud) REFERENCES estados_solicitud(id_estado_solicitud),
    UNIQUE (id_evento, id_usuario)
);

-- Tabla de estados de participación
CREATE TABLE estados_participacion (
    id_estado_participacion INT AUTO_INCREMENT PRIMARY KEY,
    nombre_estado ENUM('confirmada', 'no asistió', 'cancelada') NOT NULL UNIQUE
);

-- Participaciones
CREATE TABLE participaciones (
    id_participacion INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha_confirmacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_estado_participacion INT DEFAULT 1, -- confirmada
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_estado_participacion) REFERENCES estados_participacion(id_estado_participacion),
    UNIQUE (id_evento, id_usuario)
);

-- Tabla de tipos de notificación
CREATE TABLE tipos_notificacion (
    id_tipo_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo ENUM('invitacion', 'solicitud', 'evento', 'recordatorio', 'aviso') NOT NULL UNIQUE
);

-- Notificaciones
CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_evento INT,
    id_tipo_notificacion INT NOT NULL,
    contenido TEXT NOT NULL,
    leida TINYINT(1) DEFAULT 0,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_tipo_notificacion) REFERENCES tipos_notificacion(id_tipo_notificacion)
);

-- Tabla de reportes de eventos
CREATE TABLE reportes_evento (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    id_usuario INT NOT NULL,
    motivo TEXT NOT NULL,
    fecha_reporte DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'revisado', 'rechazado') DEFAULT 'pendiente',
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE cosas_por_llevar (
    id_cosa INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    cantidad VARCHAR(50),
    id_usuario INT,
    estado ENUM('pendiente', 'comprado', 'cancelado') DEFAULT 'pendiente',
    observaciones TEXT,
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);


