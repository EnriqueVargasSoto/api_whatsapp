<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaController extends Controller
{
    //
    public function envia(){
        //TOKEN DE FACEBOOK
        $token = "EAAQXjZBBiEiIBO1jCquZCsopujzJP4ftOeIIGGbt7Os6b0xOY6ZAPv9hNE4QWpE71T4zJi4tvw4ZAq4XuAtpHNBQIr5spD3hC53zgXH3TsOfCtQ165AEBfwhnkLDmvpbxgaF0su0wPpkiUwBzcaBgwkVU4lUGFersOJu9LKKs1QYjVygF7rZBC6oiG1Eu8HlPcL3jJ6L5SUXc9pddeJcZD";
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
