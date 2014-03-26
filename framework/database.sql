SET FOREIGN_KEY_CHECKS = 0;

/* FRAMEWORK */
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    rol_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    login VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (rol_id) REFERENCES roles (id)
);

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS permisos;
CREATE TABLE permisos (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    controller VARCHAR(255) NOT NULL,
    accion VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS roles_permisos;
CREATE TABLE roles_permisos (
    id INT NOT NULL AUTO_INCREMENT,
    rol_id INT NOT NULL,
    permiso_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (rol_id) REFERENCES roles (id),
    FOREIGN KEY (permiso_id) REFERENCES permisos (id)
);

INSERT INTO roles
(nombre)
VALUES
('ADMINISTRADOR');

INSERT INTO usuarios
(rol_id, nombre, login, password)
VALUES
(1, 'Administrador General', 'admin',SHA1('asd123'));

INSERT INTO permisos
(nombre, descripcion, controller, accion)
VALUES
('Permisos Inicio','Permiso que habilita la pantalla inicial de Permisos','permisos','index'),
('Permisos Busqueda','Permiso que habilita la busqueda de Permisos','permisos','search'),
('Permisos Nuevo','Permiso que habilita el formulario de Crear Permisos','permisos','new'),
('Permisos Editar','Permiso que habilita Editar un Permiso','permisos','edit'),
('Permisos Grabar','Permiso que habilita Grabar un Permiso','permisos','save'),
('Permisos Crear','Permiso que habilita Crear un Permiso','permisos','create'),
('Permisos Borrar','Permiso que habilita Borrar un Permiso','permisos','delete'),
('Roles Inicio','Permiso que habilita la pantalla inciial de Roles','roles','index'),
('Roles Busqueda','Permiso que habilita la busqueda de Roles','roles','search'),
('Roles Nuevo','Permiso que habilita el formulario de Crear Rol','roles','new'),
('Roles Editar','Permiso que habilita Editar una Rol','roles','edit'),
('Roles Grabar','Permiso que habilita Grabar una Rol','roles','save'),
('Roles Crear','Permiso que habilita Crear una Rol','roles','create'),
('Roles Borrar','Permiso que habilita Borrar una Rol','roles','delete'),
('Usuarios Inicio','Permiso que habilita la pantalla inciial de Usuarios','usuarios','index'),
('Usuarios Busqueda','Permiso que habilita la busqueda de Usuarios','usuarios','search'),
('Usuarios Nuevo','Permiso que habilita el formulario de Crear Usuario','usuarios','new'),
('Usuarios Editar','Permiso que habilita Editar una Usuario','usuarios','edit'),
('Usuarios Grabar','Permiso que habilita Grabar una Usuario','usuarios','save'),
('Usuarios Crear','Permiso que habilita Crear una Usuario','usuarios','create'),
('Usuarios Borrar','Permiso que habilita Borrar una Usuario','usuarios','delete');

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
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20);
