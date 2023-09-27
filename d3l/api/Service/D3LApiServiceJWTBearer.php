<?php

class D3LApiServiceJWTBearer extends D3LApiService{

    static function SGet($link, $format, $login, $password, $authenticationLink){
        $jeton = self::getJeton($login, $password, $authenticationLink);

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
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $jeton)
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

    static function SPost($link, $object, $login, $password, $authenticationLink){
        $jeton = self::getJeton($login, $password, $authenticationLink);
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
        CURLOPT_POSTFIELDS => json_encode($object),
        CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $jeton)
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    static function SPut($link, $object, $login, $password, $authenticationLink){
        $jeton = self::getJeton($login, $password, $authenticationLink);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($object),
        CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $jeton)
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    static function SDelete($link, $object, $login, $password, $authenticationLink){
        $jeton = self::getJeton($login, $password, $authenticationLink);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_POSTFIELDS => json_encode($object),
        CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $jeton)
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    private static function getJeton($login, $password, $authenticationLink){
        $answer = self::Post($authenticationLink, array("login" => $login, "password" => $password));
        $parsedAnswer = json_decode((string)$answer, true);
        return $parsedAnswer["token"];
    }
}