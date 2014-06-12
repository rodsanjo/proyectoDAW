<?php
namespace controladores;

class contacto extends \core\Controlador {
	
    public function index(array $datos = array()) {

        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos, true);
        $http_body = \core\Vista_Plantilla::generar('plantilla_principal',$datos);
        \core\HTTP_Respuesta::enviar($http_body);
    }
    
    /**
     * Función que envía un correo electrónico
     * @param array $datos
     */
    public function enviar_mail(array $datos = array()) {

        $validacion_catcha = true; // Iniciamos la variable.

        if ( \core\Configuracion::$form_insertar_externo_catcha) {
            require_once(PATH_APP.'lib/php/recaptcha-php-1.11/recaptchalib.php');
            $privatekey = "6Lem1-sSAAAAAPfnSmYe5wyruyuj1B7001AJ3CBh";
            $resp = recaptcha_check_answer ($privatekey,
                $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"],
                $_POST["recaptcha_response_field"]);

            if (!$resp->is_valid) {
                $validacion_catcha = false;
                $datos['errores']['validacion'] = 'Error de intruducción del captcha.';
//                        \core\Distribuidor::cargar_controlador("usuarios", "form_login", $datos);
            }

        }

        if (self::enviar_mail_validar($datos) && $validacion_catcha) {

            $_SESSION["mensaje"] = "Su mensaje ha sido enviado.";

            // Envío del email
            $to = \core\Configuracion::$email_info;
            $subject = \core\Array_Datos::contenido("asunto", $_REQUEST);
            $from = \core\Configuracion::$email_noreply;
            
            $mensaje = \core\Array_Datos::contenido("mensaje", $_REQUEST);
            $nombre = $datos["values"]["nombre"];
            $responder_a = $datos["values"]["email"];
            $login = \core\Usuario::$login;
            if($login != 'anonimo'){
                $tabla_users = \core\Modelo_SQL::get_prefix_tabla('usuarios');
                $sql = 'select * from '.$tabla_users.' where login = "'.$login.'"';
                $email_BD = \core\Modelo_SQL::execute($sql);
                $email_BD = $email_BD[0]['email'];
            }else{
                $email_BD = 'No disponible';
            }
            $message = "
<html>
<head>
<title>$subject</title>
</head>
<body>
<div style='text-align:left;'>
<h4>Mensaje de:</h4>
<ul>
    <li>Nombre: $nombre</li>
    <li>Email de contacto dado: $responder_a</li>
    <li>Mensaje enviado por usuario: $login</li>
    <li>Email que figura en la base de datos: $email_BD</li>
</ul>
<h4><span style='text-decoration:underline;'/>Asunto:</span> $subject</h4>
<p>$mensaje</p>
</div>
</body>
</html>";
            $additional_headers = "From: ".  \core\Configuracion::$email_noreply . "\r\n";
            $additional_headers .= 'MIME-Version: 1.0' . "\r\n";
            $additional_headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $additional_headers .= 'X-Mailer: PHP/' . phpversion();

            if ( $envio_email = mail($to, $subject, $message, $additional_headers))  {
                $datos["mensaje"] = "Su mensaje ha sido enviado con el siguiente texto:<br/>$message";
            }
            else {
                // Si falla el envío del email
                $datos["mensaje"] .= "No se ha podido enviar el mensaje.";
            }

            $this->cargar_controlador('mensajes', 'mensaje', $datos);

        }
        else {
            if ( ! $validacion_catcha) {
                    usset($datos["errores"]);
                    $datos["errores"]["validacion"] = "Errores en el código catcha.";
            }
            \core\Distribuidor::cargar_controlador("contacto", "index",$datos);
        }
		
    }
        
    private function enviar_mail_validar(array &$datos = array()) {

        $validaciones = \modelos\contacto::$validaciones_insert;

        $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos);

        return $validacion;
    }
	
	
} // Fin de la clase
