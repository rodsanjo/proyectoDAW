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
(nombre                         ,autor                          ,anho,editorial         ,categoria_id,tematica_id   ,num_min_jug,num_max_jug,edad_min,duracion   ,descripcion    ,precio,unds_stock)
values
('Bang!'                        ,'Emiliano Sciarra'             ,2002,'daVinci'         ,3,'Oeste'                  ,4,7                    ,null,null       ,null       ,9.95,13)
,('Bang! dodge city'            ,'Emiliano Sciarra'             ,2004,'daVinci'         ,3,'Oeste'                  ,4,8                    ,null,null       ,null       ,5.95,9)
,('Carcassone'                  ,'Klaus-Jürgen Wrede'           ,2001,'devir'           ,4,'Medieval Historia'               ,2,5                    ,8,null          ,null       ,21.95,18)
,('Formula Dé'                  ,'Lauren Lavaur & Eric Randall' ,1996,'Euro games'      ,4,'Motor'                  ,2,10                   ,null,null       ,null       ,39.90,6)
,('Blood Bowl Team Manager'     ,'Jay Little'                   ,2010,'edge'            ,3,null                     ,2,4                    ,null,null       ,null       ,31.95,11)
,('Spartacus'                   ,'John Kovaleski'               ,2012,'GaleForce'       ,4,'Roma Historia'                   ,2,4                    ,18,120         ,null       ,32.95,12)
,('Small World'                 ,'Philippe Keyaerts'            ,2010,'Days of wonder'  ,4,null                     ,2,5                    ,null,null       ,null       ,41.95,11)
,('Small World underground'     ,'Philippe Keyaerts'            ,2011,'Days of wonder'  ,4,null                     ,2,5                    ,null,null       ,null       ,39.95,9)
,('Demarrage'                   ,'Rob Bontenbal'                ,1972,'Jumbo'           ,4,'Ciclismo'               ,2,4                    ,null,60       ,null       ,19.95,3)
,('Leader 1'                    ,'A. Ollier & C. Leclerq'       ,2008,'Ghenos games'    ,4,'Ciclismo'               ,2,10                   ,14,90         ,null       ,22.95,6)
,('1911 Amundsen vs Scott'      ,'Perepau LListosella'          ,2013,'Looping Games'   ,4,'Historia'               ,2,2                    ,10,20         ,null       ,13.45,22)
,('El Señor de los Anillos LCG' ,'Nate French'                  ,2010,'edge'            ,3,'Fantasia'               ,1,4                    ,13,30-90         ,null       ,35.95,2)
,('Zombicide' 			,'Jean-Baptiste'               	,2012,'edge'            ,4,'Terror'               ,1,6                    ,13,60         ,null       ,79.95,10)
,('Los Colonos de Catán' 	,'Klaus Teuber'               	,1995,'Devir'            ,4,'Medieval'               ,2,4                    ,10,45         ,null       ,39.95,22)
,('Dado de 6 caras'             ,null                           ,null,null              ,1,null                     ,null,null              ,null,null         ,null       ,0.75,45)
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

insert into 3da2_metodos
  (controlador          ,metodo) values
  ('articulos'  	,'*')
, ('articulos'		,'index')
, ('articulos'		,'form_borrar')
, ('articulos'		,'form_insertar')
, ('articulos'		,'form_modificar')
;

insert into 3da2_roles_permisos
  (rol			,controlador		,metodo) values
  ('usuarios'		,'articulos'		,'index')
, ('usuarios_logueados' ,'articulos'		,'form_modificar')
, ('usuarios_logueados' ,'articulos'		,'form_insertar')
; 

/* El siguiente insert ya esta incluido en el anterior permiso*/
insert into 3da2_usuarios_permisos
  (login		,controlador		,metodo) values
  ('anonimo'		,'articulos'		,'index')
;


















/* *********************************** */
/* Para la aplicación tienda_carrito   */
/* *********************************** */

insert into 3da2_metodos
  (controlador,		metodo) values
  ('expositor'		,'*')
, ('expositor'		,'categoria')
, ('expositor'		,'categoria_ajax')

, ('carrito'		,'*')
, ('carrito'		,'comprar')
, ('carrito'		,'meter')
, ('carrito'		,'modificar')
, ('carrito'		,'pagar')
, ('carrito'		,'vaciar')
, ('carrito'		,'ver')
, ('categorias'		,'*')
, ('categorias'		,'index')
, ('categorias'		,'form_borrar')
, ('categorias'		,'form_insertar')
, ('categorias'		,'form_modificar')
, ('categorias'		,'recuento_articulos')
, ('categorias'		,'recuento_articulos_ajax')
, ('articulos'		,'*')
, ('articulos'		,'index')
, ('articulos'		,'form_borrar')
, ('articulos'		,'form_insertar')
, ('articulos'		,'form_modificar')
, ('articulos'		,'form_buscar')

, ('pedidos'		,'mostrar')
;

insert into 3da2_roles_permisos
  (rol					,controlador		,metodo) values
  ('usuarios'			,'expositor'		,'*')
, ('usuarios'			,'carrito'			,'*')
, ('usuarios'			,'articulos'		,'form_buscar')

, ('usuarios'			,'categorias'		,'recuento_articulos')
, ('usuarios'			,'categorias'		,'recuento_articulos_ajax')
, ('usuarios_logueados'	,'pedidos'			,'mostrar')
, ('usuarios_logueados'	,'categorias'		,'index')
;

-- insert into 3da2_usuarios_permisos
--   (login			,controlador			,metodo) values
--   
-- ;