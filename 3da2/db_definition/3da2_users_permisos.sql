/*
 * @file: 3da2_users_permisos.sql
 * @author: jergo23@gmail.com
 * @since: 2014 abril
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

drop table if exists 3da2_menu;
drop table if exists 3da2_usuarios_permisos;
drop table if exists 3da2_usuarios_roles;
drop table if exists 3da2_roles_permisos;
drop table if exists 3da2_roles;
drop table if exists 3da2_metodos;
drop table if exists 3da2_datos_usuarios;
drop table if exists 3da2_usuarios;

create table if not exists 3da2_usuarios
(id integer unsigned not null auto_increment
,login varchar(20) unique not null
,email varchar(100) not null comment 'No lo pongo unique para poder hacer pruebas'
,password char(40) not null
,fecha_alta timestamp not null default current_timestamp()
,fecha_confirmacion_alta datetime default null
,clave_confirmacion char(30) null
,primary key (id)
)
engine=myisam
character set utf8 collate utf8_general_ci
;

/*
create table if not exists 3da2_usuarios
(id integer unsigned not null auto_increment primary key
,login varchar(20) unique not null
,password char(40) not null
,email varchar(100) unique not null
)
engine=myisam
;

create table if not exists 3da2_datos_usuarios
(usuario_login varchar(20)
,fecha_alta timestamp not null default now() /*current_timestamp()
,fecha_confirmacion_alta datetime
,clave_confirmacion char(30)
,fecha_nac date
,nombre varchar(45)
,apellidos varchar(100)
,tlfs varchar(30)
,nif varchar(10) unique
,direccion varchar(100)
,cp varchar(5)
,localidad varchar(45)
,provincia varchar(45)
,pais varchar(30) not null default 'España'
,primary key(usuario_login)
,foreign key(usuario_login) references 3da2_usuarios(login)
)
engine=myisam
;
*/

-- Recursos almacena la colección de funcionalidades que es posible desarrollar en la aplicación.

create table if not exists 3da2_metodos
( id integer unsigned auto_increment not null
, controlador varchar(50) not null comment 'Si vale * equivale a todos los controladores'
, metodo varchar(50) null comment 'Si vale * equivale a todos los métodos de un controlador. Si nulo equivale a una sección sin submenú.'
, primary key (id)
, unique (controlador, metodo)
)
engine=myisam
character set utf8 collate utf8_general_ci
;

/*
 * Un rol es igual que un grupo de trabajo o grupo de usuarios.
 * Todos los usuarios serán miembros del rol usuario.
 */
create table if not exists 3da2_roles
( id integer unsigned auto_increment not null
, rol varchar(50) not null
, descripcion varchar(255) null
, primary key (id)
, unique (rol)
)
engine=myisam
character set utf8 collate utf8_general_ci
;


/* seccion y subseccion se validarán en v_negocios_permisos */

create table 3da2_roles_permisos
( id integer unsigned auto_increment not null
, rol varchar(50) not null
, controlador varchar(50) not null comment 'Si vale * equivale a todos los controladores'
, metodo varchar(50) null comment 'Si vale * equivale a todos los métodos de un controlador'
, primary key (id)
, unique(rol, controlador, metodo) -- Evita que a un rol se le asinge más de una vez un mismo permiso
, foreign key (rol) references 3da2_roles(rol) on delete cascade on update cascade
, foreign key (controlador, metodo) references 3da2_metodos(controlador, metodo) on delete cascade on update cascade
)
engine=myisam
character set utf8 collate utf8_general_ci
;

create table 3da2_usuarios_roles
( id integer unsigned auto_increment not null
, login varchar(20) not null
, rol varchar(50) not null
, primary key (id)
, unique (login, rol) -- Evita que a un usuario se le asigne más de una vez el mismo rol
, foreign key ( login) references 3da2_usuarios(login) on delete cascade on update cascade
, foreign key ( rol) references 3da2_roles(rol) on delete cascade on update cascade
)
engine=myisam
character set utf8 collate utf8_general_ci
;

-- Algunos hosting no dan el permiso de trigger por lo que habrá que implementarlo en programación php.
drop trigger if exists 3da2_t_usuarios_ai;
delimiter //
create trigger 3da2_t_usuarios_ai after insert on 3da2_usuarios
for each row
begin
/*
    insert into 3da2_datos_usuarios (usuario_login, fecha_confirmacion_alta)
    values ( new.login, now());
*/
    insert into 3da2_usuarios_roles (login, rol) values ( new.login, 'usuarios');
    if (new.login != "anonimo") then
        insert into 3da2_usuarios_roles (login,  rol) values ( new.login, 'usuarios_logueados');
    end if;

end;

//
delimiter ;


create table 3da2_usuarios_permisos
( id integer unsigned auto_increment not null
, login varchar(20) not null
, controlador varchar(50) not null comment 'Si vale * equivale a todos los controladores'
, metodo varchar(50) null comment 'Si vale * equivale a todos los métodos de un controlador'
, primary key (id)
, unique(login, controlador, metodo) -- Evita que a un usuario se le asignen más de una vez un permiso
, foreign key (login) references 3da2_usuarios(login) on delete cascade on update cascade
, foreign key (controlador, metodo) references 3da2_metodos(controlador, metodo) on delete cascade on update cascade
)
engine=myisam
character set utf8 collate utf8_general_ci
;


create table 3da2_menu
( id integer unsigned not null
, es_submenu_de_id integer unsigned null
, nivel integer unsigned not null comment '1 menu principal, 2 submenú, ...'
, orden integer unsigned null comment 'Orden en que aparecerán'
, texto varchar(50) not null comment 'Texto a mostrar en el item del menú'
, accion_controlador varchar(50) not null
, accion_metodo varchar(50) null comment 'null si es una entrada de nivel 1 con submenu de nivel 2'
, title varchar(255) null
, primary key (id)
, foreign key (es_submenu_de_id) references 3da2_menu(id)
, unique (es_submenu_de_id, texto) -- Para evitar repeticiones de texto
, unique (accion_controlador, accion_metodo) -- Si una acción/funcionalidad solo debe aparecer una vez en el menú
)
engine=myisam
character set utf8 collate utf8_general_ci
;


/* ************** */
/*  inserts HOME  */
/* ************** */

insert into 3da2_roles
  (rol			, descripcion) values
  ('administradores'	,'Administradores de la aplicación')
, ('empleados'           ,'Empleados de la tienda. Solo los administradores pueden otorgar este rol')
, ('usuarios'		,'Todos los usuarios incluido anónimo')
, ('usuarios_logueados'	,'Todos los usuarios excluido anónimo. Algunas opciones no estarán disponibles para los empleados')
;

insert into 3da2_usuarios 
  (login, email, password, fecha_confirmacion_alta) values
  ('admin', '3da2@rodsanjo.esy.es', md5('admin00'), now())
, ('anonimo', 'anonimo@email.com', md5(''), now())
, ('jorge', 'jergo23@gmail.com', md5('jorge00'), now())
, ('juan', 'juan@email.com', md5('juan00'), now())
, ('anais', 'anais@email.com', md5('anais00'), now())
, ('lola', 'lola@email.es', md5('lola00'), now())
;
insert into 3da2_usuarios 
  (login, email, password, fecha_alta, fecha_confirmacion_alta, clave_confirmacion) values
 ('joseraul', 'albatros260@gmail.com', '80d46626da16fb73c8e5d14135b4a094', '2014-05-06 00:00:00', now(), 'jMpQGe*SS-spe}*8#P8Yy)Gt[MxJ[K')
, ('joseraulg', 'albatros260@gmail.com', '80d46626da16fb73c8e5d14135b4a094', '2014-05-06 00:00:00', '2014-05-08 00:00:00', 'WZTMWwj12C#A^qWiw#7UrOE(Wot5)O')
, ('Beto', 'sonbeto@gmail.com', '', '2014-05-06 00:00:00', now(), 'amLo]UKBb0*0XfcNK^PZjtkaG{TzfZ')
;

insert into 3da2_metodos
  (controlador          ,metodo) values
  ('*'			,'*')
, ('inicio'		,'*')
, ('inicio'		,'index')
, ('mensajes'		,'*')
, ('roles'		,'*')
, ('roles'		,'index')
, ('roles'		,'form_borrar')
, ('roles'		,'form_insertar')
, ('roles'		,'form_modificar')
, ('roles_permisos'	,'*')
, ('roles_permisos'	,'index')
, ('roles_permisos'	,'form_modificar')
, ('usuarios'		,'*')
, ('usuarios'		,'index')
, ('usuarios'		,'desconectar')
, ('usuarios'		,'form_login')
, ('usuarios'		,'form_login_validar')
, ('usuarios'		,'form_cambiar_password')
, ('usuarios'		,'form_login_email')
, ('usuarios'		,'form_login_email_validar')
, ('usuarios'		,'confirmar_alta')
, ('usuarios'		,'form_insertar_interno')
, ('usuarios'		,'form_insertar_externo')
, ('usuarios'		,'form_modificar')
, ('usuarios'		,'form_borrar')
, ('usuarios'		,'modificar_datos')

, ('usuarios_permisos'	,'*')
, ('usuarios_permisos'	,'index')
, ('usuarios_permisos'	,'form_modificar')

, ('usuarios_roles' ,'index')
, ('usuarios_roles' ,'form_modificar_validar')

, ('contacto'   ,'*')
, ('contacto'   ,'index')
, ('contacto'   ,'enviar_mail')

, ('articulos'	,'*')
, ('articulos'	,'index')
, ('articulos'	,'juego')
, ('articulos'	,'busqueda')
, ('articulos'	,'form_insertar')
, ('articulos'	,'form_modificar')
, ('articulos'	,'form_borrar')
, ('articulos'	,'form_comentario')
, ('articulos'	,'form_editar_comentario')
, ('articulos'	,'form_eliminar_comentario')

, ('carrito'	,'*')
, ('carrito'	,'comprar')
, ('carrito'	,'meter')
, ('carrito'	,'modificar')
, ('carrito'	,'pagar')
, ('carrito'	,'vaciar')
, ('carrito'	,'ver')

, ('download'	,'file')

, ('galeria'    ,'*')
, ('galeria'	,'index')
, ('galeria'	,'carpeta')

, ('enlaces'	,'*')
, ('enlaces'	,'index')
, ('enlaces'	,'form_anexar')
, ('enlaces'	,'form_modificar')
, ('enlaces'	,'form_borrar')

;

insert into 3da2_roles_permisos
  (rol                  ,controlador	,metodo) values
  ('administradores'	,'*'            ,'*')
, ('usuarios'		,'inicio'	,'*')
, ('usuarios'		,'mensajes'	,'*')
, ('usuarios'		,'contacto'	,'*')
, ('usuarios'          ,'enlaces'	,'index')
, ('usuarios'          ,'galeria'	,'*')

, ('usuarios'          ,'articulos'	,'index')
, ('usuarios'          ,'articulos'	,'juego')
, ('usuarios'          ,'articulos'	,'busqueda')

, ('usuarios_logueados' ,'usuarios'	,'desconectar')
, ('usuarios_logueados' ,'usuarios'	,'form_cambiar_password')
, ('usuarios_logueados'	,'usuarios'     ,'modificar_datos')
, ('usuarios_logueados' ,'carrito'	,'*')
, ('usuarios_logueados' ,'download'     ,'file')
, ('usuarios_logueados' ,'articulos'	,'form_comentario')
, ('usuarios_logueados' ,'articulos'	,'form_editar_comentario')

, ('empleados'          ,'articulos'	,'form_insertar')
, ('empleados'          ,'articulos'	,'form_modificar')
, ('empleados'          ,'articulos'	,'form_borrar')
, ('empleados'          ,'usuarios'	,'desconectar')
, ('empleados'          ,'usuarios'	,'form_cambiar_password')
, ('empleados'		,'usuarios'     ,'modificar_datos')
, ('empleados'          ,'usuarios'	,'index')
, ('empleados'          ,'download'	,'file')
, ('empleados'          ,'enlaces'	,'*')
, ('empleados'          ,'roles'        ,'index')
, ('empleados'          ,'usuarios_roles' ,'index')
, ('empleados'          ,'articulos'	,'form_eliminar_comentario')

;

insert into 3da2_usuarios_roles
  (login	,rol) values
  ('admin'	,'administradores')
, ('jorge'      ,'empleados')
, ('Beto'       ,'empleados')
, ('joseraulg'  ,'empleados')
-- , ('anonimo'	,'usuarios')
-- , ('juan'	,'usuarios')
-- , ('juan'	,'usuarios_logueados')
;

insert into 3da2_usuarios_permisos
  (login	,controlador	,metodo) values
  ('anonimo'	,'usuarios'	,'form_login')
, ('anonimo'	,'usuarios'	,'form_login_email')
, ('anonimo'	,'usuarios'	,'form_insertar_externo')
, ('anonimo'	,'usuarios'	,'confirmar_alta')
;

truncate table 3da2_menu;
insert into 3da2_menu
  (id, es_submenu_de_id	, nivel	, orden	, texto, accion_controlador, accion_metodo, title) values
  (1 , null	, 1	, null	, 'Inicio', 'inicio', 'index', null)
, (2 , null	, 1	, null	, 'Juegos de mesa', 'articulos', 'index', null)
, (3 , null	, 1	, null	, 'Accesrios', 'articulos', 'accesorios', null)
, (4 , null	, 1	, null	, 'Galeria', 'galeria', 'index', null)
, (5 , null	, 1	, null	, 'Usuarios', 'usuarios', 'index', null)
, (6 , null	, 1	, null	, 'Contacto', 'contacto', 'index', null)
, (7 , null	, 1	, null	, 'Enlaces', 'enlaces', null, null)
, (8 , 2	, 2	, null	, 'Juegos de Tablero', 'articulos', 'tablero', null)
, (9 , 2	, 2	, null	, 'Juegos de cartas', 'articulos', 'cartas', null)
, (10 , 2	, 2	, null	, '2 jugadores', 'articulos', '2jugadores', null)
;



/* VIEWS */

/*
 * @file: views.sql
 * @author: jequeto@gmail.com
 * @since: 2014 enero
*/


/* ******************************************* */
/* Para la aplicación esmvcphp (todos)         */
/* ******************************************* */

/*
Devuelve la relación de todos los métodos disponibles combinados con aquellas
filas de la tabla roles_permisos indicando a que rol han sido asignados como permiso.
El método no asignado a ningún rol tendrá como valor de rol NULL
*/
create or replace view 3da2_v_permisos_roles_permisos
as
select
	mt.controlador, mt.metodo, rp.rol
from 3da2_metodos mt left join 3da2_roles_permisos rp on mt.controlador=rp.controlador and mt.metodo = rp.metodo
order by mt.controlador,mt.metodo
;


/*
Vista que recuperará todos los permisos de los que disfruta un usuario,
recopilando los asignados directamente en la tabla usuarios_permisos,
y los asignados indirectamente en la tabla usuarios_roles.
*/
create or replace view 3da2_v_usuarios_permisos_roles
as
-- de usuarios_permisos
select
		 up.login
		,up.controlador
		,up.metodo
		,null as rol -- rol donante del permiso
from 3da2_usuarios_permisos up
union distinct
-- de usuarios_roles
select
		 ur.login
		,rp.controlador
		,rp.metodo
		,ur.rol -- rol donante del permiso
from 3da2_usuarios_roles ur inner join 3da2_roles_permisos rp on ur.rol=rp.rol
order by login, controlador, metodo, rol
;

/*
Vista que devolverá una relación única de los permisos que tiene asignados
un usuario, sumados los directos más los indirectos (a través de los roles que 
tiene asignados).
*/
create or replace view 3da2_v_usuarios_permisos
as
select distinct
		login
		,controlador
		,metodo
from 3da2_v_usuarios_permisos_roles
order by login, controlador, metodo
;



/*
create or replace view 3da2_v_menu_submenu
(orden_nivel_1, orden_nivel_2, texto_menu, texto_submenu, accion_controlador, accion_metodo, title)
as
-- Items de nivel 1
select
	nivel as orden_nivel_1, null, texto as texto_menu, null, accion_controlador, accion_metodo, title
from 3da2_menu
where nivel = 1
union
-- Items de nivel 2 o submenus
select
	m.nivel as orden_nivel_1, sm.orden as orden_nivel_2, m.texto as texto_menu, sm.texto as texto_submenu, sm.accion_controlador, sm.accion_metodo, sm.title
from 3da2_menu as sm inner join 3da2_menu as m on sm.es_submenu_de_id=m.id
where sm.nivel = 2
order by orden_nivel_1, orden_nivel_2, texto_menu, texto_submenu
;
*/

/* ******************************************* */
/* Para la aplicación tienda_carrito           */
/* ******************************************* */

create or replace view 3da2_v_categorias_articulos_recuento
as
select categoria_id, count(id) as cuenta_articulos
from 3da2_articulos
group by categoria_id
;


create or replace view 3da2_v_articulos
as
select a.*, c.categoria as nombre_categoria
from 3da2_articulos a inner join 3da2_categorias c on a.categoria_id = c.id
;