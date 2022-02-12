drop database if exists escuela_programacion_db;
create database escuela_programacion_db;
use escuela_programacion_db;

create table usuarios(
    id_usuario varchar(4) primary key not null,
    nombre_usuario varchar(50) unique,
    contrasenia varchar(50),
    tipo_usuario varchar(1) default 'E'
);




INSERT INTO usuarios(id_usuario, nombre_usuario, contrasenia, tipo_usuario) values('0000', 'Nombre del profesor', 'progweb2#', 'P')