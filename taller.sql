CREATE DATABASE taller;
USE taller;
CREATE TABLE Clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    correo_electronico VARCHAR(100)
);

CREATE TABLE Empleados (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    especialidad VARCHAR(50)
);

CREATE TABLE Relojes (
    id_reloj INT PRIMARY KEY AUTO_INCREMENT,
    marca VARCHAR(50),
    modelo VARCHAR(50),
    numero_serie VARCHAR(50),
    id_cliente INT,
    FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente)
);

CREATE TABLE Reparaciones (
    id_reparacion INT PRIMARY KEY AUTO_INCREMENT,
    id_reloj INT,
    id_empleado INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    coste DECIMAL(8,2),
    descripcion VARCHAR(255),
    FOREIGN KEY (id_reloj) REFERENCES Relojes(id_reloj),
    FOREIGN KEY (id_empleado) REFERENCES Empleados(id_empleado)
);

INSERT INTO Clientes (nombre, telefono, correo_electronico)
VALUES 
('Juan Pérez', '600123456', 'juanperez@email.com'),
('Laura Gómez', '611987654', 'lauragomez@email.com'),
('Carlos Ruiz', '622333444', 'carlosruiz@email.com');

INSERT INTO Relojes (marca, modelo, numero_serie, id_cliente)
VALUES
('Seiko', 'Presage', 'S12345', 1),
('Casio', 'G-Shock', 'G99887', 2),
('Omega', 'Speedmaster', 'O55667', 1),
('Rolex', 'Submariner', 'R99901', 3);

INSERT INTO Reparaciones (id_reloj, id_empleado, fecha_inicio, fecha_fin, coste, descripcion)
VALUES
(1, 1, '2025-09-01', '2025-09-05', 120.00, 'Cambio de cristal'),
(2, 2, '2025-09-10', NULL, 0.00, 'Pendiente de revisión'),
(3, 1, '2025-09-12', '2025-09-14', 200.00, 'Mantenimiento general'),
(4, 3, '2025-09-15', '2025-09-20', 350.00, 'Reparación del mecanismo'),
(1, 2, '2025-10-01', NULL, 0.00, 'Pendiente de ajustar precisión');

ALTER TABLE Empleados ADD password VARCHAR(255) NOT NULL;