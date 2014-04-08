/*
 * @file: 3da2_tables.sql
 * @author: jergo23@gmail.com
 * @since: 2014 marzo
*/
drop database if exists daw2;
create database daw2;
/*//Crear usuario
create user daw2_user identified by 'daw2_user';
# Concedemos al usuario daw2_user todos los permisos sobre esa base de datos
grant all privileges on daw2.* to daw2_user;
*/
use daw2;

set names utf8;

set sql_mode = 'traditional';

/* TABLAS */

drop table if exists 3da2_pedidos_detalles;
drop table if exists 3da2_pedidos;
drop table if exists 3da2_carritos;
drop table if exists 3da2_comentarios_articulo;
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
,referencia integer(5) zerofill unsigned not null unique
,nombre varchar(50) unique not null comment 'titulo del juego de mesa'
,autor varchar(50)
,editorial varchar(30)
,anho integer
,foto varchar(50)
,video varchar(50)
,manual varchar(50)
,categoria_id integer default 0
,tematica varchar(20) comment 'Que tema trata el juego o ambientacion'
,num_min_jug integer
,num_max_jug integer
,edad_min integer default 3 comment 'por contener piezas pequeñas generalmente'
,duracion varchar(10) comment 'minutos aproximados de duracion de una partida'
,precio decimal(12,2) not null default 0.00 comment 'precio en € con IVA incluido'
,unds_stock integer
,resenha varchar(300) comment 'breve reseña sobre el juego de mesa'
,descripcion varchar(1000) comment 'podrá ser una palabra para luego traducirla en el diccionario'
,primary key(id)
,unique(nombre)
,foreign key(categoria_id) references 3da2_categorias(id)
)
engine = myisam default charset=utf8
;

create table if not exists 3da2_comentarios_articulo
(id integer auto_increment
,articulo_nombre varchar(50) not null
,usuario_login varchar(20) not null
,comentario varchar(300) not null
,fecha_comentario datetime default now()
,fecha_ult_edicion timestamp 
,num_ediciones integer default 0
,primary key(id)
,foreign key(usuario_login) references 3da2_usuarios(login) on delete set default on update cascade
,foreign key(articulo_nombre) references 3da2_articulos(articulo) on delete restrict on update cascade
)
engine = myisam default charset=utf8
;

/* TRIGGERS */

/*Número de referencia*/
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
delimiter ;


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
,(1,'Accesorios' , null)
,(2,'2jugadores', 'Para 2 jugadores')
,(3,'Cartas', 'Se juega sobre un tablero')
,(4,'Tablero', 'El componente principal del juego son cartas')
,(5,'Dados', 'Juegos que utilizan dados sin tablero ni cartas')
,(6,'Infantil', 'Recomendado para los más pequeños')
,(7,'Solitario' , 'Juego para una sola persona')
;

insert into 3da2_articulos
(nombre                         ,autor                          ,anho,editorial         ,categoria_id,tematica   ,num_min_jug,num_max_jug,edad_min,duracion   ,precio,unds_stock,resenha,descripcion)
values
('Bang!'                        ,'Emiliano Sciarra'             ,2002,'daVinci'         ,3,'Oeste'                  ,4,7                    ,null,null       ,9.95,13, 'Juego de cartas basado en el lejano oeste, donde los forajidos quieren acabar con el Sheriff', null)
,('Bang! dodge city'            ,'Emiliano Sciarra'             ,2004,'daVinci'         ,3,'Oeste'                  ,4,8                    ,null,null       ,5.95,9, null, null)
,('Carcassone'                  ,'Klaus-Jürgen Wrede'           ,2001,'Devir'           ,4,'Medieval Historia'               ,2,5                    ,8      ,null       ,21.95,18, null, null)
,('Formula Dé'                  ,'Lauren Lavaur & Eric Randall' ,1996,'Euro games'      ,4,'Motor'                  ,2,10                   ,null,null       ,39.90,6, null, null)
,('Blood Bowl Team Manager'     ,'Jay Little'                   ,2010,'edge'            ,3,null                     ,2,4                    ,null,null        ,31.95,11, null, null)
,('Spartacus'                   ,'John Kovaleski'               ,2012,'GaleForce'       ,4,'Roma Historia'                   ,3,4                    ,18,120             ,32.95,12, 'Un juego de tablero dinámico ambientado en la Roma antigua en el que participarás en conspiraciones traicioneras, pujas y combates sangrientos entre Gladiadores en la Arena del Circo.', null)
,('Small World'                 ,'Philippe Keyaerts'            ,2010,'Days of wonder'  ,4,null                     ,2,5                    ,null,null       ,41.95,11, null, null)
,('Small World underground'     ,'Philippe Keyaerts'            ,2011,'Days of wonder'  ,4,null                     ,2,5                    ,null,null        ,39.95,9, null, null)
,('Demarrage'                   ,'Rob Bontenbal'                ,1972,'Jumbo'           ,4,'Ciclismo'               ,2,4                    ,null,60         ,19.95,3, null, null)
,('Leader 1'                    ,'A. Ollier & C. Leclerq'       ,2008,'Ghenos games'    ,4,'Ciclismo'               ,2,10                   ,14,90           ,22.95,6, null, null)
,('1911 Amundsen vs Scott'      ,'Perepau LListosella'          ,2013,'Looping Games'   ,4,'Historia'               ,2,2                    ,10,20            ,13.45,22, null, null)
,('El Señor de los Anillos LCG' ,'Nate French'                  ,2010,'edge'            ,3,'Fantasia'               ,1,4                    ,13,30-90         ,35.95,2, null, null)
,('Zombicide' 			,'Jean-Baptiste'               	,2012,'edge'            ,4,'Terror'               ,1,6                    ,13,60              ,79.95,10, null, null)
,('Los Colonos de Catán' 	,'Klaus Teuber'               	,1995,'Devir'            ,4,'Medieval'               ,2,4                    ,10,45          ,39.95,22, null, null)
,('Dado de 6 caras'             ,null                           ,null,null              ,1,null                     ,null,null              ,null,null        ,0.75,45, null, null)
,('Un mundo sin fin'             ,'Michael Riencek & Stefan Stadler'                           ,2009,'Devir'              ,4,'Medieval'                     ,2,4              ,12,'90-120'          ,9.99,4, null, null)
,('Los Colonos de Catán: el juego de dados' 	,'Klaus Teuber'               	,2007,'Devir'            ,5,'Medieval'               ,1,4                    ,7,'15-30'          ,2.95,15, null, null)
;

/*Descripciones de los articulos*/
update 3da2_articulos
set descripcion = 'En el Salvaje Oeste, los Forajidos dan caza al Sheriff, el Sheriff da caza a los Forajidos, y el Renegado urde su plan en secreto, listo para unirse a cualquiera de los bandos. Dentro de poco, ¡las balas comenzarán a zumbar! ¿Quiénes serán los Alguaciles, dispuestos a dar su vida por el Sheriff? ¿Quiénes serán los implacables Forajidos, que intentan acabar con él? El juego de cartas más famoso del Salvaje Oeste vuelve, en un formato mejorado, con nuevos componentes, ¡más fácil de aprender y jugar que nunca! Versión integra en castellano
Contiene:
<ul>
<li>103 Cartas de juego</li>
<li>7 Cartas de resumen</li>
<li>7 Tableros</li>
<li>30 Fichas de bala</li>
<li>1 Libro de reglas</li>
</ul>'
where nombre = 'Bang!'
;

update 3da2_articulos
set descripcion = 'Planes y Maquinaciones
Diseña conspiraciones y desbarata los planes de tus rivales jugando tus cartas. La traición y la felonía serán tus mejores armas.

El Mercado 
El oro engrasa la maquinaria del poder. Puja en el Mercado contra tus adversarios para conseguir los mejores candidatos para la Arena y los beneficios de esclavos y equipo. 

Sangre en la Arena 
Enfrenta a tu Campeón contra los Gladiadores de las Ludus rivales y apuesta sin escrúpulos por el resultado final. ¡El camino a la victoria atraviesa la tierra sagrada de la Arena!'
where nombre = 'Spartacus!'
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