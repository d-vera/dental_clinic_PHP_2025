-- Base de datos para Sistema de Clínica Médica
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS clinica_medica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE clinica_medica;

-- Tabla de Usuarios (para login con roles)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    rol ENUM('administrador', 'usuario') DEFAULT 'usuario',
    foto VARCHAR(255) DEFAULT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de Pacientes (CRUD 1)
CREATE TABLE IF NOT EXISTS pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    edad INT NOT NULL,
    genero ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    direccion TEXT NOT NULL,
    tipo_sangre VARCHAR(5),
    alergias TEXT,
    historial_medico TEXT,
    foto VARCHAR(255) DEFAULT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de Médicos (CRUD 2)
CREATE TABLE IF NOT EXISTS medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100) NOT NULL,
    cedula_profesional VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    direccion TEXT,
    horario_atencion VARCHAR(100),
    foto VARCHAR(255) DEFAULT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de Citas (relación entre pacientes y médicos)
CREATE TABLE IF NOT EXISTS citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    fecha_cita DATETIME NOT NULL,
    motivo TEXT NOT NULL,
    estado ENUM('Pendiente', 'Confirmada', 'Completada', 'Cancelada') DEFAULT 'Pendiente',
    notas TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar usuarios de prueba
-- Contraseña: admin123 (hash)
INSERT INTO usuarios (username, password, nombre_completo, email, rol) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador Sistema', 'admin@clinica.com', 'administrador'),
('usuario', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Usuario Regular', 'usuario@clinica.com', 'usuario');

-- Insertar médicos de ejemplo
INSERT INTO medicos (nombre, apellido, especialidad, cedula_profesional, telefono, email, horario_atencion) VALUES
('Juan', 'Pérez García', 'Cardiología', 'MED-12345', '809-555-0101', 'juan.perez@clinica.com', 'Lun-Vie 8:00-16:00'),
('María', 'López Rodríguez', 'Pediatría', 'MED-12346', '809-555-0102', 'maria.lopez@clinica.com', 'Lun-Vie 9:00-17:00'),
('Carlos', 'Martínez Santos', 'Medicina General', 'MED-12347', '809-555-0103', 'carlos.martinez@clinica.com', 'Lun-Sab 7:00-15:00'),
('Ana', 'González Díaz', 'Dermatología', 'MED-12348', '809-555-0104', 'ana.gonzalez@clinica.com', 'Mar-Sab 10:00-18:00');

-- Insertar pacientes de ejemplo
INSERT INTO pacientes (nombre, apellido, fecha_nacimiento, edad, genero, telefono, email, direccion, tipo_sangre, alergias) VALUES
('Pedro', 'Ramírez', '1985-03-15', 39, 'Masculino', '809-555-0201', 'pedro.ramirez@email.com', 'Calle Principal #123, Santo Domingo', 'O+', 'Ninguna'),
('Laura', 'Fernández', '1990-07-22', 34, 'Femenino', '809-555-0202', 'laura.fernandez@email.com', 'Av. Independencia #456, Santiago', 'A+', 'Penicilina'),
('José', 'Sánchez', '1978-11-08', 46, 'Masculino', '809-555-0203', 'jose.sanchez@email.com', 'Calle Duarte #789, La Vega', 'B+', 'Ninguna'),
('Carmen', 'Torres', '1995-05-30', 29, 'Femenino', '809-555-0204', 'carmen.torres@email.com', 'Av. Bolívar #321, San Pedro', 'AB+', 'Aspirina');
