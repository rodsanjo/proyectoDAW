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
,('Spartacus'                   ,'John Kovaleski'               ,2012,'GaleForce'       ,4,'Roma Historia'                   ,2,4                    ,18,120             ,32.95,12, 'Un juego de tablero dinámico ambientado en la Roma antigua en el que participarás en conspiraciones traicioneras, pujas y combates sangrientos entre Gladiadores en la Arena del Circo.', null)
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
(articulo_nombre /*articulo_id*/     ,usuario_login      ,comentario) values
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
, ('empleados'          ,'articulos'		,'form_modificar')
, ('empleados'          ,'articulos'		,'form_insertar')
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