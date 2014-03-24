/*
 * @file: 3da2_tables.sql
 * @author: jergo23@gmail.com
 * @since: 2014 marzo
*/
drop database if exists daw2;
create database daw2;

create user daw2_user identified by 'daw2_user';
# Concedemos al usuario daw2_user todos los permisos sobre esa base de datos
grant all privileges on daw2.* to daw2_user;

use daw2;

set names utf8;

set sql_mode = 'traditional';

/* ****** */
/*  3da2  */
/* ****** */

/* TABLAS */

drop table if exists 3da2_pedidos_detalles;
drop table if exists 3da2_pedidos;
drop table if exists 3da2_carritos;
drop table if exists 3da2_comentarios_juego;
drop table if exists 3da2_articulos;
drop table if exists 3da2_tematicas;
drop table if exists 3da2_categorias;

create table if not exists 3da2_categorias
(id integer unsigned primary key
,categoria varchar(20) not null unique
,descripcion varchar(50)
)
engine=myisam
;

create table if not exists 3da2_tematicas
(id integer unsigned primary key
,tematica varchar(20) not null unique
)
engine=myisam
;

create table if not exists 3da2_articulos
(id integer auto_increment
,nombre varchar(50) unique not null comment 'titulo del juego de mesa'
,autor varchar(50)
,editorial varchar(30)
,anho integer
,foto varchar(50)
,manual varchar(50)
,categoria_id integer default 0
,tematica_id varchar(20)
,num_min_jug integer default 1
,num_max_jug integer
,edad_min integer
,duracion varchar(10) comment 'minutos aproximados de duracion de una partida'
,descripcion varchar(500) comment 'podrá ser una palabra para luego traducirla en el diccionario'
,precio decimal(12,2) null comment 'precio en € con IVA incluido'
,unds_stock integer
,primary key(id)
,unique(nombre)
,foreign key(categoria_id) references 3da2_categorias(id)
,foreign key(tematica_id) references 3da2_tematicas(tematica)
)
engine = myisam default charset=utf8
;

create table if not exists 3da2_comentarios_juego
(id integer auto_increment
,juego_id integer not null
,usuario_login varchar(20) not null
,comentario varchar(300) not null
,fecha_comentario timestamp default now()
,primary key(id)
,foreign key(usuario_login) references 3da2_usuarios(login) on delete default on update cascade
)
engine = myisam default charset=utf8
;


-- Carritos: se usará para guardar objetos serializados de la clase ClaseCarrito

create table if not exists 3da2_carritos
( id varchar(100) not null comment 'Será el id del usuario o el valor de la cookie de sesión'
, fechaHoraInicio timestamp not null default current_timestamp comment 'Fecha de apertura del pediddo'
, texto blob not null
, primary key (id)
)
engine = innodb
default charset=utf8
;



create table if not exists 3da2_pedidos
( id integer unsigned auto_increment
, fecha_hora_inicio timestamp not null default current_timestamp comment "Fecha de apertura del pediddo"
, fecha_hora_compra datetime null 
, usuario_id integer unsigned not null
, primary key (id)
, foreign key (usuario_id) references 3da2_usuarios(id)
)
engine = innodb
default charset=utf8
;


create table if not exists 3da2_pedidos_detalles
( id integer unsigned auto_increment
, pedido_id integer unsigned not null
, articulo_id integer unsigned not null
, nombre varchar(50) not null
, unidades integer unsigned not null default 1
, precio decimal(12,2) not null
, foto varchar(50) null
, primary key (id)
, foreign key (pedido_id) references 3da2_pedidos(id) on delete cascade
, foreign key (articulo_id) references 3da2_articulos(id)
)
engine = innodb
default charset=utf8
;


/* ************************************************** */
/* Contador de descargas */
/* ************************************************** */
create table 3da2_descargas
(id integer unsigned auto_increment not null
,fichero varchar(200) not null
,remote_addr varchar(50) not null
,request_time datetime not null

,primary key (id)
)
engine=myisam;
