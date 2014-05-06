<?php
namespace controladores;

class articulos extends \core\Controlador{
    
    private static $tabla = 'articulos';
    private static $tabla2 = 'comentarios_articulo';
    private static $controlador = 'articulos';
    public static $num_arts_por_pag = 4;
    
    /**
     * Presenta una <table> con las filas de la tabla con igual nombre que la clase.
     * @param array $datos
     */
    public function index(array $datos=array()) {

        $clausulas['where'] = 'categoria_id <> 1';
        //$clausulas['where'] = isset($_REQUEST['categoria']) ? 'categoria_id like "%'.$_REQUEST['categoria'].'%"' : (isset($_REQUEST['p3']) ? 'categoria_id like "%'.$_REQUEST['p3'].'%"' : 'categoria_id <> 1' );
        if(isset($_REQUEST['p3'])){
            $sql = 'select id from 3da2_categorias where categoria like "%'.$_REQUEST['p3'].'%"';
            $categoria_id = \modelos\Modelo_SQL::execute($sql);
            if(count($categoria_id)) $clausulas['where'] = 'categoria_id = "'.$categoria_id[0]['id'].'"';
            //Categorias especiales:            
            if($_REQUEST['p3']=='2jugadores'){
                $clausulas['where']='(num_min_jug <= 2 and num_max_jug >= 2) or categoria_id = 2';
            }elseif($_REQUEST['p3']=='solitarios'){
                $clausulas['where']='num_min_jug = 1';
            }elseif($_REQUEST['p3']=='busqueda'){
                $busqueda = isset($_SESSION['busqueda'])?$_SESSION['busqueda']:'';
                $clausulas["where"] = "nombre like '%$busqueda%' ";
                /*
                $busqueda =array('nombre' => isset($_SESSION['busqueda'])?$_SESSION['busqueda']:'' );
                self::busqueda($busqueda);
                 */
            }
        }
        $next_grp = isset($_REQUEST['p4'])?$_REQUEST['p4']:0;
        $next_art = $next_grp * self::$num_arts_por_pag;
        $clausulas['order_by'] = 'nombre';
        
        //Ordenamos por lo que venga en $_REQUEST['ordenar_por']  mejorar No funciona al pasar a otra seccion
        $order_by = isset($_REQUEST['ordenar_por'])?$_REQUEST['ordenar_por']:'nombre';
        $order_by = isset($_REQUEST['p5'])?$_REQUEST['p5']:$order_by;
        $clausulas['order_by'] = $order_by;
        /*
        if(isset($_REQUEST['ordenar_por']) && $_REQUEST['ordenar_por'] != null){
            $clausulas['order_by'] = \core\Array_Datos::contenido("ordenar_por", $_REQUEST);
            $_SESSION['usuario']['order_by'] = $clausulas['order_by'];
        }
         */

        $clausulas['limit'] = $next_art.",".self::$num_arts_por_pag;
        //$datos["filas"] = \modelos\self::$tabla::select($clausulas, "self::$tabla"); // Recupera todas las filas ordenadas
        $datos["filas"] = \modelos\Modelo_SQL::table(self::$tabla)->select($clausulas); // Recupera todas las filas ordenadas        
        
        $_SESSION["expositor_actual"] = \core\URL::actual();
        
        $sql = "select count(*) as num_total_juegos from 3da2_articulos where ".$clausulas['where'];
        $datos["num_total_juegos"] = \modelos\Modelo_SQL::execute($sql);

        if($next_grp >= $datos["num_total_juegos"][0]['num_total_juegos']/self::$num_arts_por_pag){
            $datos['mensaje'] = '<b>Entrada incorrecta</b>';
            \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
        }
        //Mostramos los datos a modificar en formato europeo. Convertimos el formato de MySQL a europeo
        self::convertir_formato_mysql_a_ususario($datos['filas']);

        //var_dump($datos);
        
        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        $datos["carrito"] = $this->incluir("carrito", "ver");
        
        $http_body = \core\Vista_Plantilla::generar('DEFAULT', $datos);
        \core\HTTP_Respuesta::enviar($http_body);

    }
    
    /**
     * Presenta solo los juegos de tablero
     * @param array $datos
     */
    public function juego(array $datos=array()) {
        
        if(isset($_GET['p3'])){
            $articulo_nombre = str_replace("-", " ", $_GET['p3']);
            //$articulo_nombre = mysql_escape_string($articulo_nombre);
            //printf("Escaped string: %s\n", $articulo_nombre);
            $clausulas['where'] = " nombre like '%$articulo_nombre%' ";
        }
        if ( ! $filas = \modelos\Datos_SQL::select( $clausulas, self::$tabla)) {
            $datos['mensaje'] = 'El articulo seleccionado no se encuentra en nuestro catálogo de productos';
            \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
            return;
        }else{   
            $datos['articulo'] = $filas[0];
            
            $clausulas['where'] = " articulo_nombre like '%$articulo_nombre%' ";
            $clausulas['order by'] = 'fecha_comentario desc';
            $datos["comentarios"] = \modelos\Modelo_SQL::table(self::$tabla2)->select($clausulas);
        }
        
        //Mostramos los datos a modificar en formato europeo. Convertimos el formato de MySQL a europeo para su visualización
        self::convertir_formato_mysql_a_ususario($datos['articulo']);
        self::convertir_formato_mysql_a_ususario($datos['comentarios']);

        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        $http_body = \core\Vista_Plantilla::generar('DEFAULT', $datos);
        \core\HTTP_Respuesta::enviar($http_body);

    }
    
    public function busqueda(array $datos=array())	{	

        $validaciones = array(
            "buscar_nombre" => "errores_texto"
        );
        if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
            $datos["errores"]["errores_validacion"]="Corrige los errores.";
        }
        else {
            if ( ! strlen($datos["values"]["buscar_nombre"])) {
                header("Location: ".\core\URL::generar("inicio"));
                return;
            }

            $next_art = isset($_REQUEST['p4'])?$_REQUEST['p4']:0;
            $next_art *= self::$num_arts_por_pag;
            $clausulas['order_by'] = 'nombre';
            $clausulas['limit'] = $next_art.",".self::$num_arts_por_pag;
            //$datos["filas"] = \modelos\self::$tabla::select($clausulas, "self::$tabla"); // Recupera todas las filas ordenadas
            $datos["filas"] = \modelos\Modelo_SQL::table(self::$tabla)->select($clausulas); // Recupera todas las filas ordenadas

            $busqueda = isset($datos["values"]["buscar_nombre"])?$datos["values"]["buscar_nombre"]:'';
            $_SESSION['busqueda'] = $busqueda; 
            
            $clausulas["where"] = "nombre like '%$busqueda%' ";
            $datos["filas"] = \modelos\Modelo_SQL::table("articulos")->select($clausulas);

            $sql = "select count(*) as num_total_juegos from 3da2_articulos where ".$clausulas['where'];
            $datos["num_total_juegos"] = \modelos\Modelo_SQL::execute($sql);
            
            if($datos["num_total_juegos"][0]['num_total_juegos'] == 0){
                $datos['mensaje'] = '<b>No se encontraron articulos que coincidan con la busqueda especificada</b>';
                \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
            }

            //Mostramos los datos a modificar en formato europeo. Convertimos el formato de MySQL a europeo
            self::convertir_formato_mysql_a_ususario($datos['filas']);
            
            $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
            $http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
            \core\HTTP_Respuesta::enviar($http_body);
        }
    }
    
    public function validar_form_comentario(array $datos=array()) {
        
        self::request_come_by_post();   //Si viene por POST sigue adelante
        
        $validaciones = array(
            "articulo_nombre" =>"errores_requerido && errores_texto && errores_unicidad_modificar:id,articulo_nombre/articulos/id,articulo_nombre"
            ,"usuario_login" => "errores_requerido && errores_texto"
            ,"comentario" => "errores_requerido && errores_texto"
        );                                

        if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)){  //validaciones en PHP
            $datos["errores"]["errores_validacion"]="Corrige los errores.";
        }else{

            if ( ! $validacion = \modelos\Modelo_SQL::insert($datos["values"], self::$tabla2)) // Devuelve true o false
                $datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
        }
        if ( ! $validacion){ //Devolvemos el formulario para que lo intente corregir de nuevo
            \core\Distribuidor::cargar_controlador(self::$controlador, 'index', $datos);
        }else{
            // Se ha grabado la modificación. Devolvemos el control al la situacion anterior a la petición del form_modificar
            //$datos = array("alerta" => "Se han grabado correctamente los detalles");
            // Definir el controlador que responderá después de la inserción
            //\core\Distribuidor::cargar_controlador(self::$tabla, 'index', $datos);
            $_SESSION["alerta"] = "Su comentario ha sido enviado";
            //header("Location: ".\core\URL::generar("self::$controlador/index"));            
            $articulo_nombre = str_replace(" ", "-",$datos['values']['articulo_nombre']);
            \core\HTTP_Respuesta::set_header_line("location", \core\URL::generar(self::$controlador."/juego/".$articulo_nombre));
            \core\HTTP_Respuesta::enviar();
        }
    }

    /**
     * Presenta un formulario para insertar nuevas filas a la tabla
     * @param array $datos
     */
    public function form_insertar(array $datos=array()) {

        $datos["form_name"] = __FUNCTION__;
        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        $http_body = \core\Vista_Plantilla::generar('DEFAULT', $datos);
        \core\HTTP_Respuesta::enviar($http_body);

    }
    
    /**
     * Valida los datos insertados por el usuario. Si estos son correctos mostrará la tabla con 
     * la nueva inserción, sino mostrará los errores por los que nos se admitió los datos introducidos.
     * @param array $datos
     */
    public function validar_form_insertar(array $datos=array()) {

        $validaciones = \modelos\articulos::$validaciones_insert;
        
        if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)){  //validaciones en PHP
            $datos["errores"]["errores_validacion"]="Corrige los errores.";
        }else{
            $validacion = self::comprobar_files($datos);
            if ($validacion) {
                //Convertimos a formato MySQL
                self::convertir_a_formato_mysql($datos['values']);
                //if ( ! $validacion = \modelos\Modelo_SQL::insert($datos["values"], self::$tabla)) // Devuelve true o false
                if ( ! $validacion = \modelos\Datos_SQL::table(self::$tabla)->insert($datos["values"])) // Devuelve true o false
                    $datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
                else {
                    //var_dump($datos);
                    self::mover_files($datos);
                }
            }
        }
        if ( ! $validacion){ //Devolvemos el formulario para que lo intente corregir de nuevo
            \core\Distribuidor::cargar_controlador(self::$controlador, 'form_insertar', $datos);
        }else{
            // Se ha grabado la modificación. Devolvemos el control al la situacion anterior a la petición del form_modificar
            //$datos = array("alerta" => "Se han grabado correctamente los detalles");
            // Definir el controlador que responderá después de la inserción
            //\core\Distribuidor::cargar_controlador(self::$tabla, 'index', $datos);
            $_SESSION["alerta"] = "Se han grabado correctamente los detalles";
            //header("Location: ".\core\URL::generar("self::$controlador/index"));
            \core\HTTP_Respuesta::set_header_line("location", \core\URL::generar(self::$controlador."/index"));
            \core\HTTP_Respuesta::enviar();
        }
        
        if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
            $this->cargar_controlador(self::$controlador, 'form_insertar',$datos);
        else
        {
            // Se ha grabado la modificación. Devolvemos el control al la situacion anterior a la petición del form_modificar
            $_SESSION["alerta"] = "Se han grabado correctamente los datos";
            //header("Location: ".\core\URL::generar("categorias/index"));
            \core\HTTP_Respuesta::set_header_line("location", \core\URL::generar(\core\Distribuidor::get_controlador_instanciado()));
            \core\HTTP_Respuesta::enviar();
        }
    }



    public function form_modificar(array $datos = array()) {

        $datos["form_name"] = __FUNCTION__;

        //self::request_come_by_post();   //Si viene por POST sigue adelante
        
        if ( ! isset($datos["errores"])) { // Si no es un reenvío desde una validación fallida
            $validaciones=array(
                "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/".self::$tabla."/id"
            );
            if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
                $datos['mensaje'] = 'Datos erróneos para identificar el elemento a modificar';
                \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
                return;
            }else{
                $clausulas['where'] = " id = {$datos['values']['id']} ";
                if ( ! $filas = \modelos\Datos_SQL::select( $clausulas, self::$tabla)) {
                    $datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
                    \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
                    return;
                }else{   
                    $datos['values'] = $filas[0];

                }
            }
        }
        
        //Mostramos los datos a modificar en formato europeo. Convertimos el formato de MySQL a europeo
//        var_dump($fila['masa_atomica']);
//        $datos['values']['masa_atomica']=  \core\Conversiones::decimal_punto_a_coma($datos['values']['masa_atomica']);
//        if(preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])){
//            $datos['values']['fecha_salida']=  \core\Conversiones::fecha_mysql_a_es($datos['values']['fecha_salida']);
//        }
        self::convertir_formato_mysql_a_ususario($datos['values']);
                
        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        $http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
        \core\HTTP_Respuesta::enviar($http_body);
    }


    public function validar_form_modificar(array $datos=array()) {
        
        //self::request_come_by_post();

        $validaciones = \modelos\articulos::$validaciones_update;

        if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)){  //validaciones en PHP
            $datos["errores"]["errores_validacion"]="Corrige los errores.";
        }else{
            $validacion = self::comprobar_files($datos);
            if ($validacion) {
                //Convertimos a formato MySQL
                self::convertir_a_formato_mysql($datos['values']);
                //if ( ! $validacion = \modelos\Modelo_SQL::insert($datos["values"], self::$tabla)) // Devuelve true o false
                if ( ! $validacion = \modelos\Datos_SQL::table("articulos")->update($datos["values"])) // Devuelve true o false
                    $datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
                else {
                    self::mover_files($datos);
                }
            }
        }
/*
        if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
                \core\Distribuidor::cargar_controlador(self::$controlador, 'form_modificar', $datos);
        else {
                $datos = array("alerta" => "Se han modificado correctamente.");
                // Definir el controlador que responderá después de la inserción
                \core\Distribuidor::cargar_controlador(self::$controlador, 'index', $datos);		
        }
 */       
        
        if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
                $this->cargar_controlador(self::$controlador, 'form_modificar',$datos);
        else 		{
                $_SESSION["alerta"] = "Se han modificado correctamente los datos";
                \core\HTTP_Respuesta::set_header_line("location", \core\URL::generar(\core\Distribuidor::get_controlador_instanciado()));
                \core\HTTP_Respuesta::enviar();
        }  
        

    }



    public function form_borrar(array $datos=array()) {
        
        $datos["form_name"] = __FUNCTION__;

        //self::request_come_by_post();

        $validaciones= \modelos\articulos::$validaciones_delete;
        
        if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
            $datos['mensaje'] = 'Datos erróneos para identificar el artículo a borrar';
            $datos['url_continuar'] = \core\URL::http('?menu='.self::$tabla.'');
            \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
            return;
        }
        else {
            $clausulas['where'] = " id = {$datos['values']['id']} ";
            if ( ! $filas = \modelos\Datos_SQL::select( $clausulas, self::$tabla)) {
                $datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
                \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
                return;
            }else {
                $datos['values'] = $filas[0];
            }
        }

        //Mostramos los datos a modificar en formato europeo. Convertimos el formato de MySQL a europeo
        self::convertir_formato_mysql_a_ususario($datos['values']);

        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        $http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
        \core\HTTP_Respuesta::enviar($http_body);
    }






    public function validar_form_borrar(array $datos=array()) {	
        
        self::request_come_by_post();

        $validaciones=array(
            "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/".self::$tabla."/id"
        );
        if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
            $datos['mensaje'] = 'Datos erróneos para identificar el artículo a borrar';
            $datos['url_continuar'] = \core\URL::http('?menu='.self::$tabla.'');
            \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
            return;
        }else{
            if ( ! $validacion = \modelos\Datos_SQL::delete($datos["values"], self::$tabla)) {// Devuelve true o false
                $datos['mensaje'] = 'Error al borrar en la bd';
                $datos['url_continuar'] = \core\URL::http('?menu='.self::$tabla.'');
                \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
                return;
            }else{
                $datos = array("alerta" => "Se ha borrado correctamente.");
                \core\Distribuidor::cargar_controlador(self::$controlador, 'index', $datos);		
            }
        }

    }
    
    /**
     * Fución que realiza las conversiones de los campos usados en está aplicación al formato utilizado por MySQL.
     * Convertimos a formato MySQL
     * @author Jorge Rodriguez Sanz
     * @param array $param Se corresponderá por regla general con datos['values'] y lo pasamos por referencia, para que modificque el valor
     */
    private static function convertir_a_formato_mysql(array &$param) {  //$param = datos['values'] y lo pasamos por referencia, para que modificque el valor        
        $param['precio'] = \core\Conversiones::decimal_puntoOcoma_a_punto($param['precio']);
    }
    
    private static function comprobar_files(array &$datos){
        $validacion = true;
        if ($_FILES["foto"]["size"]) {
                if ($_FILES["foto"]["error"] > 0 ) {
                    $datos["errores"]["foto"] = $_FILES["foto"]["error"];
                }
                elseif ( ! preg_match("/image/", $_FILES["foto"]["type"])) {
                    $datos["errores"]["foto"] = "El fichero no es una imagen.";
                }
                elseif ($_FILES["foto"]["size"] > 1024*1024) {
                    $datos["errores"]["foto"] = "El tamaño de la foto debe ser menor que 1MB.";
                }
                if (isset($datos["errores"]["foto"])) {
                    $validacion = false;
                }
        }
        if ($_FILES["manual"]["size"]) {
            if ($_FILES["manual"]["error"] > 0 ) {
                $datos["errores"]["manual"] = $_FILES["manual"]["error"];
            }
            elseif ( ! preg_match("/pdf/", $_FILES["manual"]["type"])) {
                $datos["errores"]["manual"] = "El fichero no es un pdf.";
            }
            elseif ($_FILES["manual"]["size"] > 1024*1024) {
                $datos["errores"]["manual"] = "El tamaño del archivo no puede superar 1MB.";
            }
            if (isset($datos["errores"]["manual"])) {
                $validacion = false;
            }
        }
        return $validacion;
    }

    /**
     * Fución que realiza las conversiones de los campos que muestran las tablas del formato utilizado por MySQL al formato europeo.
     * Convertimos a formato MySQL
     * @author Jorge Rodriguez Sanz <jergo23@gmail.com>
     * @param array $param Se corresponderá por regla general con datos['values'] y lo pasamos por referencia, para que modificque el valor
     */
    private static function convertir_formato_mysql_a_ususario(array &$param) {  //$param = datos['values'] o $param = datos['filas'] si enviamos toda la tabla, y lo pasamos por referencia, para que modifique el valor
        
        //var_dump($param);
        if(!isset($param['id'])){   //Si existe $param['id'], es que vienen varias filas 0,1,2...,n, es decir no viene de intentar modificar o borrar ua única fila
            foreach ($param as $key => $fila) {
                if(isset($param[$key]['precio']))
                    $param[$key]['precio']=  \core\Conversiones::decimal_punto_a_coma_y_miles($fila['precio']);
                if(isset($param[$key]['fecha_comentario']))
                        $param[$key]['fecha_comentario'] = \core\Conversiones::fecha_hora_mysql_a_es($param[$key]['fecha_comentario']);
                if(isset($param[$key]['fecha_edicion']))
                    $param[$key]['fecha_edicion'] = \core\Conversiones::fecha_hora_mysql_a_es($param[$key]['fecha_edicion']);
            }
        }else{
            if(isset($param['precio']))
                $param['precio']=  \core\Conversiones::decimal_punto_a_coma_y_miles($param['precio']);
            if(isset($param['fecha_comentario']))
                $param['fecha_comentario'] = \core\Conversiones::fecha_hora_mysql_a_es($param[$key]['fecha_comentario']);
            if(isset($param['fecha_edicion']))
                $param['fecha_edicion'] = \core\Conversiones::fecha_hora_mysql_a_es($param[$key]['fecha_edicion']);
            //Si hubiera fechas
            /*
            if(preg_match("/MSIE|Firefox|Trident/", $_SERVER['HTTP_USER_AGENT'])){  //Para IE7
                $param['fecha']=  \core\Conversiones::fecha_mysql_a_es($param['fecha']);
            }
             */
            //fecha_entrada es readOnly en los formularios, por lo que no es necesario realizar la conversión.
        }
        
    }
    
    /**
     * Si el requerimiento viene por GET nos mostrará un mensaje indicando que en esa sección
     * no está permitida la entrada de datos de forma manual, y cargará el controlador mensajes.
     * Si viene por POST, no devuelve nada, simplemente deja continuar la ejecución.
     * @author Jorge Rodríguez <jergo23@gmail.com>
     */
    private static function request_come_by_post(){
        If ( \core\HTTP_Requerimiento::method()!= 'POST'){
            $datos['mensaje']="No se permiten añadir datos en la URL manualmanete para realizar la operación";
            \core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
        }
    }

    public function listado_pdf(array $datos=array()) {

        $validaciones = array(
            "nombre" => "errores_texto"
        );
        \core\Validaciones::errores_validacion_request($validaciones, $datos);
        if (isset($datos['values']['nombre'])) 
            $select['where'] = " nombre like '%{$datos['values']['nombre']}%'";
        $select['order_by'] = 'nombre';
        $datos['filas'] = \modelos\Datos_SQL::select( $select, self::$tabla);		

        $datos['html_para_pdf'] = \core\Vista::generar(__FUNCTION__, $datos);

        require_once(PATH_APP."lib/php/dompdf/dompdf_config.inc.php");

        $html =
          '<html><body>'.
          '<p>Put your html here, or generate it with your favourite '.
          'templating system.</p>'.
          '</body></html>';

        $dompdf = new \DOMPDF();
        $dompdf->load_html($datos['html_para_pdf']);
        $dompdf->render();
        $dompdf->stream("sample.pdf", array("Attachment" => 0));

        // \core\HTTP_Respuesta::set_mime_type('application/pdf');
        // $http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
        // \core\HTTP_Respuesta::enviar($datos, 'plantilla_pdf');

    }


    /**
     * Genera una respuesta json.
     * 
     * @param array $datos
     */
    public function listado_js(array $datos=array()) {

            $validaciones = array(
                    "nombre" => "errores_texto"
            );
            \core\Validaciones::errores_validacion_request($validaciones, $datos);
            if (isset($datos['values']['nombre'])) 
                    $select['where'] = " nombre like '%{$datos['values']['nombre']}%'";
            $select['order_by'] = 'nombre';
            $datos['filas'] = \modelos\Datos_SQL::select($select, self::$tabla);

            $datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);

            \core\HTTP_Respuesta::set_mime_type('text/json');
            $http_body = \core\Vista_Plantilla::generar('plantilla_json', $datos);
            \core\HTTP_Respuesta::enviar($http_body);

    }

    /**
     * Genera una respuesta json con un array que contiene objetos, siendo cada objeto una fila.
     * @param array $datos
     */
    public function listado_js_array(array $datos=array()) {

            $validaciones = array(
                    "nombre" => "errores_texto"
            );
            \core\Validaciones::errores_validacion_request($validaciones, $datos);
            if (isset($datos['values']['nombre'])) 
                    $select['where'] = " nombre like '%{$datos['values']['nombre']}%'";
            $select['order_by'] = 'nombre';
            $datos['filas'] = \modelos\Datos_SQL::select( $select, self::$tabla);

            $datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);

            \core\HTTP_Respuesta::set_mime_type('text/json');
            $http_body = \core\Vista_Plantilla::generar('plantilla_json', $datos);
            \core\HTTP_Respuesta::enviar($http_body);

    }


    /**
     * Genera una respuesta xml.
     * 
     * @param array $datos
     */
    public function listado_xml(array $datos=array()) {

            $validaciones = array(
                    "nombre" => "errores_texto"
            );
            \core\Validaciones::errores_validacion_request($validaciones, $datos);
            if (isset($_datos['values']['nombre'])) 
                    $select['where'] = " nombre like '%{$_datos['values']['nombre']}%'";
            $select['order_by'] = 'nombre';
            $datos['filas'] = \modelos\Datos_SQL::select( $select, self::$tabla);

            $datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);

            \core\HTTP_Respuesta::set_mime_type('text/xml');
            $http_body = \core\Vista_Plantilla::generar('plantilla_xml', $datos);
            \core\HTTP_Respuesta::enviar($http_body);

    }




    /**
     * Genera una respuesta excel.
     * @param array $datos
     */
    public function listado_xls(array $datos=array()) {

            $validaciones = array(
                    "nombre" => "errores_texto"
            );
            \core\Validaciones::errores_validacion_request($validaciones, $datos);
            if (isset($_datos['values']['nombre'])) 
                    $select['where'] = " nombre like '%{$_datos['values']['nombre']}%'";
            $select['order_by'] = 'nombre';
            $datos['filas'] = \modelos\Datos_SQL::select( $select, self::$tabla);

            $datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);

            \core\HTTP_Respuesta::set_mime_type('application/excel');
            $http_body = \core\Vista_Plantilla::generar('plantilla_xls', $datos);
            \core\HTTP_Respuesta::enviar($http_body);

    }
    
    private static function mover_files(array $datos){
        $id = $datos["values"]['id'];
        if ($_FILES["foto"]["size"]) {
            if ($datos["values"]["foto"] = self::mover_foto($id)) {
                $validacion = \modelos\Modelo_SQL::tabla(self::$tabla)->update($datos["values"]);
            }
        }
        if ($_FILES["manual"]["size"]) {
            if ($datos["values"]["manual"] = self::mover_manual($id)) {
                $validacion = \modelos\Modelo_SQL::tabla(self::$tabla)->update($datos["values"]);
            }
        }
    }

    private static function mover_foto($id) {

        // Ahora hay que añadir la foto
        $extension = substr($_FILES["foto"]["type"], stripos($_FILES["foto"]["type"], "/")+1);
        $nombre = (string)$id;
        $nombre = "art".str_repeat("0", 5 - strlen($nombre)).$nombre;
        $foto_path = PATH_APPLICATION."recursos".DS."imagenes".DS."articulos".DS.$nombre.".".$extension;
//					echo __METHOD__;echo $_FILES["foto"]["tmp_name"];  echo $foto_path; exit;
        // Si existe el fichero lo borramos
        if (is_file($foto_path)) {
            unlink($foto_path);
        }
        $validacion = move_uploaded_file($_FILES["foto"]["tmp_name"], $foto_path);
        return ($validacion ? $nombre.".".$extension : false);

    }


    private static function borrar_foto($foto) {

            $foto_path = PATH_APPLICATION."recursos".DS."imagenes".DS."articulos".DS.$foto;
            // Si existe el fichero lo borramos
            if (is_file($foto_path)) {
                    return unlink($foto_path);
            }
            else {
                    return null;
            }

    }
    
    /**
     * Guarda un archivo pdf en nuestros recursos
     * @param type $id
     * @param type $articulo_nombre = null
     * @return type
     */
    private static function mover_manual($id, $articulo_nombre = null) {

        // Ahora hay que añadir la manual
        $extension = substr($_FILES["manual"]["type"], stripos($_FILES["manual"]["type"], "/")+1);
        if($articulo_nombre){
            $nombre = str_replace(" ", "-", $articulo_nombre);
        }else{
            $nombre = (string)$id;
            $nombre = "art".str_repeat("0", 5 - strlen($nombre)).$nombre;
        }
        $manual_path = PATH_APPLICATION."recursos".DS."ficheros".DS."manuales".DS.$nombre.".".$extension;
//					echo __METHOD__;echo $_FILES["manual"]["tmp_name"];  echo $manual_path; exit;
        // Si existe el fichero lo borramos
        if (is_file($manual_path)) {
            unlink($manual_path);
        }
        $validacion = move_uploaded_file($_FILES["manual"]["tmp_name"], $manual_path);

        return ($validacion ? $nombre.".".$extension : false);

    }
	
} // Fin de la clase
?>
