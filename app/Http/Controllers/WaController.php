<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaController extends Controller
{
    //
    public function envia(){
        //TOKEN DE FACEBOOK
        $token = "EAAM6screhzwBOwVZC7AeZC4KBUdbyzWKhiSZCDVTpfqw6jesBaFgvcDhjBSSldTpFLqnW6l6elH7OR8SAKaQ4fGAFGRPKrrMZAUu57R3h9DOUFJzI1HqZAde7WAnA2yI5V6uk7HbDwTfBzeaOL3h04bXSxIJWm5l9HfevO075GUVQzOo0tZBS9wJIX09GXf2cCUeaHEcCUomeqNkEIRKoZD";
        //NUESTRO TELEFONO
        $telefono = "51901095698";
        //URL A DONDE SE MANDARA EL MENSAJE
        $url = "https://graph.facebook.com/v17.0/204015989451081/messages";
        //configurar el mensaje
        $mensaje = ''
        .'{'
            .'"messaging_product" : "whatsapp",'
            .'"to":"'.$telefono.'",'
            .'"type" : "template"'
            .'"template": '
            .'{'
                .'"name" : "hello_world'
                .'"language" : { "code" : "en_US"}'
                .'}'
            .'}';

        //DECLARAMOS LAS CABECERAS
        $header = array("Authorization: Bearer ".$token, "Content-Type: application/json");
        //INICIAMOS EL CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //OBTENER RESPUESTA DEL ENVIO DE INFORMACION
        $response = json_decode(curl_exec($curl), true);
        //IMPRIMIMOS LA RESPUESTA
        print_r($response);
        //OBTENEMOS EL CODIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //CERRAMOS EL CURL
        curl_close($curl);

    }

    public function webhook(){
        //TOQUEN QUE QUERRAMOS PONER
        $token = 'valorx';
        //RETO QUE RECIBIREMOS DE FACEBOOK
        $hub_challenge = isset($_GET['hub_challenge']) ? $_GET['hub_challenge'] : '';
        //TOQUEN DE VERIFICACION QUE RECIBIREMOS DE FACEBOOK
        $hub_verify_token = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : '';
        //SI EL TOKEN QUE GENERAMOS ES EL MISMO QUE NOS ENVIA FACEBOOK RETORNAMOS EL RETO PARA VALIDAR QUE SOMOS NOSOTROS
        if ($token === $hub_verify_token) {
            echo $hub_challenge;
            exit;
        }
    }

    public function recibe(){
        //LEEMOS LOS DATOS ENVIADOS POR WHATSAPP
        $respuesta = file_get_contents("php://input");
        //echo file_put_contents("text.txt", "Hola");
        //SI NO HAY DATOS NOS SALIMOS
        if($respuesta==null){
          exit;
        }
        //CONVERTIMOS EL JSON EN ARRAY DE PHP
        $respuesta = json_decode($respuesta, true);
        //EXTRAEMOS EL TELEFONO DEL ARRAY
        $mensaje="Telefono:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from']."\n";
        //EXTRAEMOS EL MENSAJE DEL ARRAY
        $mensaje.="Mensaje:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        //GUARDAMOS EL MENSAJE Y LA RESPUESTA EN EL ARCHIVO text.txt
        file_put_contents("text.txt", $mensaje);
    }
}
