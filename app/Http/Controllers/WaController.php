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
}
