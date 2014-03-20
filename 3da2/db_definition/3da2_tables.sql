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

drop table if exists 3da2_juegos_mesa;
drop table if exists 3da2_categorias;

create table if not exists 3da2_categorias
(id integer unsigned primary key
,categoria varchar(20) not null unique
,descripcion varchar(50)
)
engine=myisam
;

create table if not exists 3da2_tematica
(id integer unsigned primary key
,tematica varchar(20) not null unique
)
engine=myisam
;

create table if not exists 3da2_juegos_mesa
(id integer auto_increment
,titulo varchar(50) unique not null
,autor varchar(50)
,editorial varchar(30)
,categoria_id vachar(20) not null
,tematica_id varchar(20)
,num_min_jug integer not null default 1
,num_max_jug integer
,precio 
,primary key(id)
,unique(titulo)
,foreign key(categoria_id) references 3da2_categorias(id)
,foreign key(tematica_id) references 3da2_tematicas(id)
)

, masa_atomica decimal(10,3) default null
, tipo_id integer unsigned
, fecha_entrada timestamp default now()
, fecha_salida date /*Solo admite un current_timestamp() por tabla - Error Code: 1293. Incorrect table definition; there can be only one TIMESTAMP column with CURRENT_TIMESTAMP in DEFAULT or ON UPDATE clause   */
, primary key(id)
, unique(nombre)
, unique(simbolo_quimico)
, foreign key(tipo_id) references daw2_tipos(id)
)
engine = myisam default charset=utf8
;

create table if not exists 3da2_comentarios_juego
