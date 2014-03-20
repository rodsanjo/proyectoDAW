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