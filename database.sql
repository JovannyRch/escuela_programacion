drop database if exists escuela_programacion_db;
create database escuela_programacion_db;
use escuela_programacion_db;

create table usuarios(
    id_usuario varchar(4) primary key not null,
    nombre_usuario varchar(50) unique,
    contrasenia varchar(50),
    nombre varchar(50),
    paterno varchar(50),
    materno varchar(50),
    tipo_usuario varchar(1) default 'E'
);



create table materias(
    id_materia int primary key auto_increment not null,
    nombre varchar(50) unique
);


create table calificaciones(
    id_calificacion int primary key auto_increment not null,
    id_usuario varchar(4) not null,
    id_materia int not null,
    calificacion float not null,
    foreign key(id_usuario) references usuarios(id_usuario) on delete cascade,
    foreign key(id_materia) references materias(id_materia) on delete cascade
);

INSERT INTO materias(nombre) values('Programación');
INSERT INTO materias(nombre) values('Matemáticas');
INSERT INTO materias(nombre) values('Algoritmos');
INSERT INTO materias(nombre) values('Lógica');
INSERT INTO materias(nombre) values('SO');
INSERT INTO materias(nombre) values('BD');

INSERT INTO 
usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario, nombre, paterno, materno) 
values('0000', 'Nombre del profesor', 'progweb2#', 'P','Nombre','Paterno', 'Materno');

INSERT INTO 
usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario, nombre, paterno, materno) 
values('9999', 'alumno1', 'progweb2#', 'E','Juan','Hernández', 'García');

INSERT INTO 
usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario, nombre, paterno, materno) 
values('9998', 'alumno2', 'progweb2#', 'E','Blanca','Benitez', 'García');

INSERT INTO 
usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario, nombre, paterno, materno) 
values('9997', 'alumno3', 'progweb2#', 'E','José','Gimenez', 'García');

INSERT INTO 
usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario, nombre, paterno, materno) 
values('9996', 'alumno4', 'progweb2#', 'E','María','Venegas', 'García');

INSERT INTO 
usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario, nombre, paterno, materno) 
values('9995', 'alumno5', 'progweb2#', 'E','Belinda','Nodal', 'García');