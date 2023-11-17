/*
* @author Rebeca Sánchez Pérez
* @version 1.3
* @since 13/11/2023
*/

/*Creacion de la base de datos*/
create database DB204DWESProyectoTema4;

/*Se pone en uso la base de datos*/
use DB204DWESProyectoTema4;

/*Creacion de la tabla Departamento*/
create table if not exists T02_Departamento(
T02_CodDepartamento varchar(3) primary key,
T02_DescDepartamento varchar(255),
T02_FechaCreacionDepartamento datetime,
T02_VolumenDeNegocio float,
T02_FechaBajaDepartamento datetime default null)engine=innodb;

/*Creacion del usuario*/
create user 'user204DWESProyectoTema4'@'%' identified by 'P@ssw0rd';
grant all privileges on DB204DWESProyectoTema4.* to 'user204DWESProyectoTema4'@'%';
