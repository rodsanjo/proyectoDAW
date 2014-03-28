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
