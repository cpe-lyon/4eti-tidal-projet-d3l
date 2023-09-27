<?php

class D3LApiServiceJWTBearer {

    static function GetRequest($link, $format, $key){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',,
            CURLOPT_HTTPHEADER => array(
              'XApiKey: pgH7QzFHJx4w46fI~5Uzi4RvtTwlEXp'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
        if($format == "json"){
            return json_decode($response, true);
        }if($format == "xml"){
            return simplexml_load_string($response);
        }
        else{
            return $response;
        }
    }

    static function Post($link, $object){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($object)
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    static function Put($link, $object){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($object)
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    static function Delete($link, $object){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_POSTFIELDS => json_encode($object)
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    
}