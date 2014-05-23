/* VISTAS */
create or replace view 3da2_v_articulos_con_comentarios
as
select *
from 3da2_articulos as a left join 3da2_comentarios_articulos as c
on a.id = c.articulo_id
;