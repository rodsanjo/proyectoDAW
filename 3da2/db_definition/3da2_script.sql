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

create table if not exists 3da2_articulos
(id integer auto_increment
,referencia integer(5) zerofill unsigned not null
,nombre varchar(50) unique not null comment 'titulo del juego de mesa'
,autor varchar(50)
,editorial varchar(30)
,anho integer
,foto varchar(50)
,manual varchar(50)
,categoria_id integer default 0
,tematica varchar(20) comment 'Que tema trata el juego o ambientacion'
,num_min_jug integer default 1
,num_max_jug integer
,edad_min integer default 10
,duracion varchar(10) comment 'minutos aproximados de duracion de una partida'
,resenha varchar(500) comment 'breve reseña sobre el juego de mesa'
,descripcion varchar(500) comment 'podrá ser una palabra para luego traducirla en el diccionario'
,precio decimal(12,2) null comment 'precio en € con IVA incluido'
,unds_stock integer
,primary key(id)
,unique(nombre)
,foreign key(categoria_id) references 3da2_categorias(id)
)
engine = myisam default charset=utf8
;

/* TRIGGERS */

create table if not exists 3da2_comentarios_articulo
(id integer auto_increment
,articulo_nombre varchar(50) not null
,usuario_login varchar(20) not null
,comentario varchar(300) not null
,fecha_comentario datetime
,fecha_ult_edicion timestamp default now()
,num_ediciones integer default 0
,primary key(id)
,foreign key(usuario_login) references 3da2_usuarios(login) on delete set default on update cascade
,foreign key(articulo_nombre) references 3da2_articulos(articulo) on delete restrict on update cascade
)
engine = myisam default charset=utf8
;

/*Número de referencia*/
drop function if exists 3da2_f_num_ref_articulo

delimiter //
create function 3da2_f_num_ref_articulo()
	returns integer unsigned
	language sql
	not deterministic
	contains sql
	reads sql data
begin
	declare _ultima_ref int;
	select max(referencia) into _ultima_ref from 3da2_articulos;
	if (isnull(_ultima_ref)) then set _ultima_ref = 0;
	end if;
	return _ultima_ref;
end;
//
delimiter ;


drop trigger if exists 3da2_t_ref_articulo_bi;

delimiter // 
create trigger 3da2_t_ref_articulo_bi before insert on 3da2_articulos for each row
begin
set new.referencia = 3da2_f_num_ref_articulo() + 1;
end;
//
delimiter ;

/*Otra forma:*/
drop trigger if exists 3da2_t_ref_articulo_bi;

delimiter // 
create trigger 3da2_t_ref_articulo_bi before insert on 3da2_articulos for each row
begin
    declare _ultima_ref int;
    select max(referencia) into _ultima_ref from 3da2_articulos;
    if (isnull(_ultima_ref)) then set _ultima_ref=0;
    end if;
    set new.referencia = _ultima_ref + 1;
    /*set new.referencia = ifnull(_ultima_ref,0)+1;*/
end;
//
delimiter ;


/*Fecha de comentario*//*Si default now() actua cada vez que se modifica y está en fecha_ult_edicion*/
drop trigger if exists 3da2_t_poner_fecha_comentario_bi;
delimiter //
create trigger 3da2_t_poner_fecha_comentario_bi before insert on 3da2_comentarios_articulo
for each row
begin
    set new.fecha_comentario = now();   /*Como es insert solo actua la primera vez*/
end;

//
delimiter;


/*Número de ediciones de comentario y fecha de edición*/
drop trigger if exists 3da2_t_num_ediciones_bu;
delimiter //
create trigger 3da2_t_num_ediciones_bu before update on 3da2_comentarios_articulo
for each row
begin
    set new.fecha_ult_edicion = now(); /*Si default now() está en fecha_comentario pues no cambia al hacer update*/
    set new.num_ediciones = old.num_ediciones + 1;
end;

//
delimiter ;

/*Inserción datos*/
insert into 3da2_categorias values
(0,'Varios/Otros', null)
,(1,'Accesorio' , null)
,(2,'2jugadores', 'Para 2 jugadores')
,(3,'Cartas', 'Se juega sobre un tablero')
,(4,'Tablero', 'El componente principal del juego son cartas')
,(5,'Dados', 'Juegos que utilizan dados sin tablero ni cartas')
,(5,'Infantil', 'Recomendado para los más pequeños')
,(6,'Solitario' , 'Juego para una sola persona')
;

insert into 3da2_articulos
(nombre                         ,autor                          ,anho,editorial         ,categoria_id,tematica   ,num_min_jug,num_max_jug,edad_min,duracion   ,descripcion    ,precio,unds_stock,resenha,descripcion)
values
('Bang!'                        ,'Emiliano Sciarra'             ,2002,'daVinci'         ,3,'Oeste'                  ,4,7                    ,null,null       ,null       ,9.95,13, null, null)
,('Bang! dodge city'            ,'Emiliano Sciarra'             ,2004,'daVinci'         ,3,'Oeste'                  ,4,8                    ,null,null       ,null       ,5.95,9, null, null)
,('Carcassone'                  ,'Klaus-Jürgen Wrede'           ,2001,'devir'           ,4,'Medieval Historia'               ,2,5                    ,8,null          ,null       ,21.95,18, null, null)
,('Formula Dé'                  ,'Lauren Lavaur & Eric Randall' ,1996,'Euro games'      ,4,'Motor'                  ,2,10                   ,null,null       ,null       ,39.90,6, null, null)
,('Blood Bowl Team Manager'     ,'Jay Little'                   ,2010,'edge'            ,3,null                     ,2,4                    ,null,null       ,null       ,31.95,11, null, null)
,('Spartacus'                   ,'John Kovaleski'               ,2012,'GaleForce'       ,4,'Roma Historia'                   ,2,4                    ,18,120         ,null       ,32.95,12, 'juego ambientado en la antigua Roma', null)
,('Small World'                 ,'Philippe Keyaerts'            ,2010,'Days of wonder'  ,4,null                     ,2,5                    ,null,null       ,null       ,41.95,11, null, null)
,('Small World underground'     ,'Philippe Keyaerts'            ,2011,'Days of wonder'  ,4,null                     ,2,5                    ,null,null       ,null       ,39.95,9, null, null)
,('Demarrage'                   ,'Rob Bontenbal'                ,1972,'Jumbo'           ,4,'Ciclismo'               ,2,4                    ,null,60       ,null       ,19.95,3, null, null)
,('Leader 1'                    ,'A. Ollier & C. Leclerq'       ,2008,'Ghenos games'    ,4,'Ciclismo'               ,2,10                   ,14,90         ,null       ,22.95,6, null, null)
,('1911 Amundsen vs Scott'      ,'Perepau LListosella'          ,2013,'Looping Games'   ,4,'Historia'               ,2,2                    ,10,20         ,null       ,13.45,22, null, null)
,('El Señor de los Anillos LCG' ,'Nate French'                  ,2010,'edge'            ,3,'Fantasia'               ,1,4                    ,13,30-90         ,null       ,35.95,2, null, null)
,('Zombicide' 			,'Jean-Baptiste'               	,2012,'edge'            ,4,'Terror'               ,1,6                    ,13,60         ,null       ,79.95,10, null, null)
,('Los Colonos de Catán' 	,'Klaus Teuber'               	,1995,'Devir'            ,4,'Medieval'               ,2,4                    ,10,45         ,null       ,39.95,22, null, null)
,('Dado de 6 caras'             ,null                           ,null,null              ,1,null                     ,null,null              ,null,null         ,null       ,0.75,45, null, null)
;

insert into 3da2_comentarios_articulo
(articulo_nombre                ,usuario_login      ,comentario) values
('Demarrage' /*9*/                   ,'juan'        ,'Muy básico, pero divertido')
,('Bang!'    /*1*/                   ,'jorge'       ,'Fenomenal en grupos variados, gusta a todo el mundo')
,('Demarrage'/*9*/                   ,'jorge'       ,'Que más se puede pedir')
,('Demarrage'/*8*/                   ,'juan'        ,'Se queda atrás con respecto a los juegos actuales')
,('Demarrage'/*9*/                   ,'jorge'       ,'Eso mismo le pasa al Formula Dé, se nota que ya es antiguo')
,('Formula Dé'/*4*/                   ,'jorge'      ,'A la gente le sigue gustando a pesar de haber nuevos juegos dedicados a la formula1 más elaborados')
;