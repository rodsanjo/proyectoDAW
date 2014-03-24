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

/* TABLAS */

drop table if exists 3da2_pedidos_detalles;
drop table if exists 3da2_pedidos;
drop table if exists 3da2_carritos;
drop table if exists 3da2_comentarios_juego;
drop table if exists 3da2_articulos;
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
,foto varchar(50)
,autor varchar(50)
,editorial varchar(30)
,anho integer
,categoria_id integer not null
,tematica_id varchar(20)
,num_min_jug integer default 1
,num_max_jug integer
,edad_min integer
,duracion varchar(10) comment 'minutos aproximados de duracion de una partida'
,descripcion varchar(500)
,precio decimal(12,2) null comment 'precio en € con IVA incluido'
,unds_stock integer
,primary key(id)
,unique(nombre)
,foreign key(categoria_id) references 3da2_categorias(id)
,foreign key(tematica_id) references 3da2_tematicas(tematica)
)
engine = myisam default charset=utf8
;

/*Inserción datos*/
insert into 3da2_categorias values
(0,'Varios/Otros', null)
,(1,'Accesorio' , null)
,(2,'2jugadores', 'Para 2 jugadores')
,(3,'Cartas', 'Se juega sobre un tablero')
,(4,'Tablero', 'El componente principal del juego son cartas')
,(5,'Infantil', 'Recomendado para los más pequeños')
,(6,'Solitario' , 'Juego para una sola persona')
;

insert into 3da2_tematicas values
(0,'Varios/Otros')
,(1,'Historia')
,(2,'Deporte')
,(3,'Oeste')
,(4,'Roma')
,(5,'Grecia')
,(6,'Ciclismo')
,(7,'Motor')
,(8,'Politica')
,(9,'Economia')
,(10,'Ciencia ficción')
;


insert into 3da2_articulos
(nombre                         ,autor                          ,anho,editorial         ,categoria_id,tematica_id   ,num_min_jug,num_max_jug,edad_min,duracion   ,descripcion    ,precio,unds_stock)
values
('Bang!'                        ,'Emiliano Sciarra'             ,2002,'daVinci'         ,3,'Oeste'                  ,4,7                    ,null,null       ,null       ,9.95,13)
,('Bang! dodge city'            ,'Emiliano Sciarra'             ,2004,'daVinci'         ,3,'Oeste'                  ,4,8                    ,null,null       ,null       ,5.95,9)
,('Carcassone'                  ,'Klaus-Jürgen Wrede'           ,2001,'devir'           ,4,'Medieval Historia'               ,2,5                    ,8,null          ,null       ,21.95,18)
,('Formula Dé'                  ,'Lauren Lavaur & Eric Randall' ,1996,'Euro games'      ,4,'Motor'                  ,2,10                   ,null,null       ,null       ,39.90,6)
,('Blood Bowl Team Manager'   ,'Jay Little'                   ,2010,'edge'            ,3,null                     ,2,4                    ,null,null       ,null       ,24.95,11)
,('Spartacus'                   ,'John Kovaleski'               ,2012,'GaleForce'       ,4,'Roma Historia'                   ,2,4                    ,18,120         ,null       ,32.95,12)
,('Small World'                 ,'Philippe Keyaerts'            ,2010,'Days of wonder'  ,4,null                     ,2,5                    ,null,null       ,null       ,41.95,11)
,('Small World underground'     ,'Philippe Keyaerts'            ,2011,'Days of wonder'  ,4,null                     ,2,5                    ,null,null       ,null       ,39.95,9)
,('Demarrage'                   ,'Rob Bontenbal'                ,1972,'Jumbo'           ,4,'Ciclismo'               ,2,4                    ,null,60       ,null       ,19.95,3)
,('Leader 1'                    ,'A. Ollier & C. Leclerq'       ,2008,'Ghenos games'    ,4,'Ciclismo'               ,2,10                   ,14,90         ,null       ,22.95,6)
,('1911 Amundsen vs Scott'      ,'Perepau LListosella'          ,2013,'Looping Games'   ,4,'Historia'               ,2,2                    ,10,20         ,null       ,13.45,22)
;