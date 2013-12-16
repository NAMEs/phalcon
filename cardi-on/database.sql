SET FOREIGN_KEY_CHECKS = 0;

/* FRAMEWORK */
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    usuario_id INT NOT NULL AUTO_INCREMENT,
    usuario_rol INT NOT NULL,
    usuario_nombre VARCHAR(255) NOT NULL,
    usuario_login VARCHAR(255) NOT NULL UNIQUE,
    -- usuario_email VARCHAR(255) NOT NULL UNIQUE,
    usuario_password VARCHAR(255) NOT NULL,
    PRIMARY KEY(usuario_id),
    FOREIGN KEY (usuario_rol) REFERENCES roles (rol_id)
);

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    rol_id INT NOT NULL AUTO_INCREMENT,
    rol_nombre VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY(rol_id)
);

DROP TABLE IF EXISTS permisos;
CREATE TABLE permisos (
    permiso_id INT NOT NULL AUTO_INCREMENT,
    permiso_nombre VARCHAR(255) NOT NULL,
    permiso_descripcion TEXT,
    permiso_controller VARCHAR(255) NOT NULL,
    permiso_accion VARCHAR(255) NOT NULL,
    PRIMARY KEY(permiso_id)
);

DROP TABLE IF EXISTS roles_permisos;
CREATE TABLE roles_permisos (
    rol_permiso_id INT NOT NULL AUTO_INCREMENT,
    rol_id INT NOT NULL,
    permiso_id INT NOT NULL,
    PRIMARY KEY(rol_permiso_id),
    FOREIGN KEY (rol_id) REFERENCES roles (rol_id),
    FOREIGN KEY (permiso_id) REFERENCES permisos (permiso_id)
);

DROP TABLE IF EXISTS proveedores;
CREATE TABLE proveedores (
    proveedor_id INT NOT NULL AUTO_INCREMENT,
    proveedor_nombre VARCHAR(255) NOT NULL,
    proveedor_email VARCHAR(255) NOT NULL UNIQUE,
    proveedor_telefono VARCHAR(50) DEFAULT NULL,
    proveedor_celular VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY (proveedor_id)
);

DROP TABLE IF EXISTS direcciones;
CREATE TABLE direcciones (
    direccion_id INT NOT NULL AUTO_INCREMENT,
    direccion_pais VARCHAR(100) NOT NULL,
    direccion_provincia VARCHAR(100) NOT NULL,
    direccion_localidad VARCHAR(100) NOT NULL,
    direccion_calle VARCHAR(255) NOT NULL,
    direccion_coordx VARCHAR(50) NULL,
    direccion_coordy VARCHAR(50) NULL,
    direccion_coord VARCHAR(100) NULL,
    PRIMARY KEY (direccion_id)
);

DROP TABLE IF EXISTS proveedores_direcciones;
CREATE TABLE proveedores_direcciones (
    proveedor_direccion_id INT NOT NULL AUTO_INCREMENT,
    proveedor_id INT NOT NULL,
    direccion_id INT NOT NULL,
    PRIMARY KEY(proveedor_direccion_id),
    FOREIGN KEY (proveedor_id) REFERENCES proveedores (proveedor_id),
    FOREIGN KEY (direccion_id) REFERENCES direcciones (direccion_id)
);

/* INSERTS FRAMEWORK */
INSERT INTO roles
(rol_nombre)
VALUES
('ADMINISTRADOR');

INSERT INTO usuarios
(usuario_rol, usuario_nombre, usuario_login, usuario_password)
VALUES
(1, 'Administrador General', 'admin',MD5('Admin1234'));

INSERT INTO permisos
(permiso_nombre, permiso_descripcion, permiso_controller, permiso_accion)
VALUES
('Proveedores Inicio','Permiso que habilita la pantalla inicial de Proveedores','proveedores','index'),
('Proveedores Busqueda','Permiso que habilita la busqueda de Proveedores','proveedores','search'),
('Proveedores Nuevo','Permiso que habilita el formulario de Crear Proveedores','proveedores','new'),
('Proveedores Editar','Permiso que habilita Editar un Proveedor','proveedores','edit'),
('Proveedores Grabar','Permiso que habilita Grabar un Proveedor','proveedores','save'),
('Proveedores Crear','Permiso que habilita Crear un Proveedor','proveedores','create'),
('Proveedores Borrar','Permiso que habilita Borrar un Proveedor','proveedores','delete'),
('Direcciones Inicio','Permiso que habilita la pantalla inciial de Direcciones','direcciones','index'),
('Direcciones Busqueda','Permiso que habilita la busqueda de Direcciones','direcciones','search'),
('Direcciones Nuevo','Permiso que habilita el formulario de Crear Direccion','direcciones','new'),
('Direcciones Editar','Permiso que habilita Editar una Direccion','direcciones','edit'),
('Direcciones Grabar','Permiso que habilita Grabar una Direccion','direcciones','save'),
('Direcciones Crear','Permiso que habilita Crear una Direccion','direcciones','create'),
('Direcciones Borrar','Permiso que habilita Borrar una Direccion','direcciones','delete');

INSERT INTO roles_permisos
(rol_id, permiso_id)
VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15);

/* INSERTS NEGOCIO */

INSERT INTO proveedores 
(proveedor_nombre, proveedor_email)
VALUES
('CARDI-ON', 'info@cardi-on.com.ar'),
('HEARTSINE','info@heartsine.com');

INSERT INTO direcciones
(direccion_pais, direccion_provincia, direccion_localidad, direccion_calle)
VALUES
('ARGENTINA','CIUDAD AUTONOMA DE BUENOS AIRES','CIUDAD AUTONOMA DE BUENOS AIRES','DONADO 1740'),
('ESTADOS UNIDOS','WISCONSIN','WOODRUFF','1800 HWY 51 N');

INSERT INTO proveedores_direcciones
(proveedor_id, direccion_id)
VALUES
(1, 1),
(2, 2);

DROP TABLE IF EXISTS items_marcas;
CREATE TABLE equipos_marcas (
	equipos_marca_id INT NOT NULL AUTO_INCREMENT,
	equipos_marca_nombre VARCHAR(255) NOT NULL UNIQUE,
	PRIMARY KEY (equipos_marca_id)
);

DROP TABLE IF EXISTS equipos_modelos;
CREATE TABLE equipos_modelos (
	equipos_modelo_id INT NOT NULL AUTO_INCREMENT,
	equipos_modelo_marca INT NOT NULL,
	equipos_modelo_nombre VARCHAR(255) NOT NULL UNIQUE,
	equipos_modelo_precio DECIMAL(18, 2) NOT NULL DEFAULT 0.00,
	equipos_modelo_descripcion TEXT,
	PRIMARY KEY (equipos_modelo_id),
	FOREIGN KEY (equipos_modelo_marca) REFERENCES equipos_marcas (equipos_marca_id)
);

DROP TABLE IF EXISTS equipos;
CREATE TABLE equipos (
	equipo_id INT NOT NULL AUTO_INCREMENT,
	equipo_modelo INT NOT NULL,
	equipo_fecha_vencimiento DATETIME NOT NULL,
	PRIMARY KEY(equipo_id),
	FOREIGN KEY (equipo_modelo) REFERENCES equipos_modelos(equipos_modelo_id)
);

DROP TABLE IF EXISTS equipos_mantenimiento;
CREATE TABLE equipos_mantenimiento (
	equipo_id INT NOT NULL,
	equipos_mantenimiento_cantidad INT DEFAULT 0,
	equipos_mantenimiento_fecha DATETIME DEFAULT NULL,
	PRIMARY KEY (equipo_id)
);

DROP TABLE IF EXISTS equipos_inventario;
CREATE TABLE equipos_inventario (
	equipo_id INT NOT NULL,
	equipo_serie VARCHAR(255) NOT NULL UNIQUE,
	equipo_lote VARCHAR(255) NOT NULL UNIQUE,
	equipos_inventario_cantidad INT NOT NULL DEFAULT 0,
	equipos_inventario_punto_reposicion INT,
	equipos_intenvario_en_alquiler TINYINT DEFAULT 0,
	PRIMARY KEY(equipo_id, equipo_serie, equipo_lote)
);