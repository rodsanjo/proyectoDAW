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

drop table if exists 3da2_usuarios_permisos;
drop table if exists 3da2_usuarios_roles;
drop table if exists 3da2_roles_permisos;
drop table if exists 3da2_roles;
drop table if exists 3da2_metodos;
drop table if exists 3da2_datos_usuarios;
drop table if exists 3da2_usuarios;

create table 3da2_usuarios
(id integer unsigned not null auto_increment primary key,
,login varchar(10) not null
,password char(20) not null
,email varchar(45) unique not null
)
engine=innodb
;

create table if not exists 3da2_datos_usuarios
(usuario_login varchar(10)
,fecha_alta timestamp not null default now() /*current_timestamp()*/
,fecha_confirmacion_alta datetime default null
,clave_confirmacion char(30) null
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
    insert into 3da2_datos_usuarios (usuario_login, usuario_login)
    values ( new.login, new.usuario_login);	
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

