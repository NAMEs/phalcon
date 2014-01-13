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
