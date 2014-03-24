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

drop table if exists 3da2_menu;
drop table if exists 3da2_usuarios_permisos;
drop table if exists 3da2_usuarios_roles;
drop table if exists 3da2_roles_permisos;
drop table if exists 3da2_roles;
drop table if exists 3da2_metodos;
drop table if exists 3da2_datos_usuarios;
drop table if exists 3da2_usuarios;

create table 3da2_usuarios
(id integer unsigned not null auto_increment primary key,
,login varchar(20) not null
,password char(20) not null
,email varchar(45) unique not null
)
engine=innodb
;

create table if not exists 3da2_datos_usuarios
(usuario_login varchar(20)
,fecha_alta timestamp not null default now() /*current_timestamp()*/
,fecha_confirmacion_alta timestamp
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
engine=innodb
character set utf8 collate utf8_general_ci
;

drop trigger if exists 3da2_t_registrar_datos_usuario_ai;
delimiter //
create trigger 3da2_t_registrar_datos_usuario_ai
after insert on 3da2_usuarios for each row
begin
    insert into 3da2_datos_usuarios (usuario_login, fecha_confirmacion_alta)
    values ( new.login, now());
end;

//
delimiter ;


-- Recursos almacena la colección de funcionalidades que es posible desarrollar en la aplicación.

create table if not exists 3da2_metodos
( id integer unsigned auto_increment not null
, controlador varchar(50) not null comment 'Si vale * equivale a todos los controladores'
, metodo varchar(50) null comment 'Si vale * equivale a todos los métodos de un controlador. Si nulo equivale a una sección sin submenú.'
, primary key (id)
, unique (controlador, metodo)
)
engine=innodb
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
engine=innodb
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
engine=innodb
character set utf8 collate utf8_general_ci
;


create table 3da2_usuarios_roles
( id integer unsigned auto_increment not null
, login varchar(20) not null
, rol varchar(50) not null
, primary key (id)
, unique (login, rol) -- Evita que a un usuario se le asigne más de una vez el mismo rol
, foreign key (login) references 3da2_usuarios(login) on delete cascade on update cascade
, foreign key (rol) references 3da2_roles(rol) on delete cascade on update cascade
)
engine=innodb
character set utf8 collate utf8_general_ci
;


-- Algunos hosting no dan el permiso de trigger por lo que habrá que implementarlo en programación php.
drop trigger if exists 3da2_t_usuarios_ai;
delimiter //
create trigger 3da2_t_usuarios_ai after insert on 3da2_usuarios
for each row
begin
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
engine=innodb
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
engine=innodb
character set utf8 collate utf8_general_ci
;


/* ************** */
/*  inserts HOME  */
/* ************** */

insert into 3da2_roles
  (rol			, descripcion) values
  ('administradores'	,'Administradores de la aplicación')
, ('usuarios'		,'Todos los usuarios incluido anónimo')
, ('usuarios_logueados'	,'Todos los usuarios excluido anónimo')
;


insert into 3da2_usuarios 
  (login, email, password) values
  ('admin', 'admin@3da2.com', md5('admin00'))
, ('anonimo', 'anonimo@email.com', md5(''))
, ('jorge', 'jergo23@gmail.com', md5('jorge00'))
, ('juan', 'juan@email.com', md5('juan00'))
, ('anais', 'anais@email.com', md5('anais00'))
;

insert into 3da2_metodos
  (controlador          ,metodo) values
  ('*'			,'*')
, ('inicio'		,'*')
, ('inicio'		,'index')
, ('mensajes'		, '*')
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
, ('usuarios_permisos'	,'*')
, ('usuarios_permisos'	,'index')
, ('usuarios_permisos'	,'form_modificar')

;

insert into 3da2_roles_permisos
  (rol                  ,controlador	,metodo) values
  ('administradores'	,'*'            ,'*')
, ('usuarios'		,'inicio'	,'*')
, ('usuarios'		,'mensajes'	,'*')
, ('usuarios_logueados' ,'usuarios'	,'desconectar')
, ('usuarios_logueados' ,'usuarios'	,'form_cambiar_password')
;

insert into 3da2_usuarios_roles
  (login	,rol) values
  ('admin'	,'administradores')
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