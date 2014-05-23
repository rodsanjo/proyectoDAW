/*Vistas*/

/*Vista para ver todos los datos de los usuario*/
create or replace view 3da2_v_usuarios
as
select  
    u.id
    ,du.nombre as nombre
    ,du.apellidos as apellidos
    ,u.login as login
    ,u.password as password
    ,u.email as email
    ,du.fecha_alta as fecha_alta
    ,du.fecha_confirmacion_alta as fecha_confirmacion_alta datetime
    ,du.clave_confirmacion as
    ,du.fecha_nac as fecha_nac    
    ,du.tlfs as tlfs
    ,du.nif as nif
    ,du.direccion as direccion
    ,du.cp as cp
    ,du.localidad as localidad
    ,du.provincia as provincia
    ,du.pais as pais
from 3da2_usuarios u left join 3da2_datos_usuarios du on u.login=du.usuario_login
where year(fecha_inicio)=year(curdate())
group by a.asunto
order by 3 asc,2
;


/* ******************************************* */
/* Para la aplicación HOME (todos)         */
/* ******************************************* */

/*
Devuelve la relación de todos los métodos disponibles combinados con aquellas
filas de la tabla roles_permisos indicando a que rol han sido asignados como permiso.
El método no asignado a ningún rol tendrá como valor de rol NULL
*/
create or replace view daw2_v_permisos_roles_permisos
as
select
	mt.controlador, mt.metodo, rp.rol
from daw2_metodos mt left join daw2_roles_permisos rp on mt.controlador=rp.controlador and mt.metodo = rp.metodo
order by mt.controlador,mt.metodo
;


/*
Vista que recuperará todos los permisos de los que disfruta un usuario,
recopilando los asignados directamente en la tabla usuarios_permisos,
y los asignados indirectamente en la tabla usuarios_roles.
*/
create or replace view daw2_v_usuarios_permisos_roles
as
-- de usuarios_permisos
select
		 up.login
		,up.controlador
		,up.metodo
		,null as rol -- rol donante del permiso
from daw2_usuarios_permisos up
union distinct
-- de usuarios_roles
select
		 ur.login
		,rp.controlador
		,rp.metodo
		,ur.rol -- rol donante del permiso
from daw2_usuarios_roles ur inner join daw2_roles_permisos rp on ur.rol=rp.rol
order by login, controlador, metodo, rol
;

/*
Vista que devolverá una relación única de los permisos que tiene asignados
un usuario, sumados los directos más los indirectos (a través de los roles que 
tiene asignados).
*/
create or replace view daw2_v_usuarios_permisos
as
select distinct
		login
		,controlador
		,metodo
from daw2_v_usuarios_permisos_roles
order by login, controlador, metodo
;




create or replace view daw2_v_menu_submenu
(orden_nivel_1, orden_nivel_2, texto_menu, texto_submenu, accion_controlador, accion_metodo, title)
as
-- Items de nivel 1
select
	nivel as orden_nivel_1, null, texto as texto_menu, null, accion_controlador, accion_metodo, title
from daw2_menu
where nivel = 1
union
-- Items de nivel 2 o submenus
select
	m.nivel as orden_nivel_1, sm.orden as orden_nivel_2, m.texto as texto_menu, sm.texto as texto_submenu, sm.accion_controlador, sm.accion_metodo, sm.title
from daw2_menu as sm inner join daw2_menu as m on sm.es_submenu_de_id=m.id
where sm.nivel = 2
order by orden_nivel_1, orden_nivel_2, texto_menu, texto_submenu
;


/* ******************************************* */
/* Para la aplicación tienda_carrito           */
/* ******************************************* */

create or replace view daw2_v_categorias_articulos_recuento
as
select categoria_id, count(id) as cuenta_articulos
from daw2_articulos
group by categoria_id
;


create or replace view daw2_v_articulos
as
select a.*, c.nombre as categoria_nombre
from daw2_articulos a inner join daw2_categorias c on a.categoria_id = c.id
;