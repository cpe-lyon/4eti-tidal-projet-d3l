<?php

class D3LApiLinkBuilder{
    static function BasicLinkBuilder(string $link, array $options){
        $link = $link . "?";
        $car = '&';
        foreach($options as $key => $value){
            $link = $link . $key . "=" . $value . $car;
        }
        $link = substr($link, 0, -1);
        return $link;
    }
    

    static function AuthenticationLinkBuilder(string $link, array $options, string $apiKey){
        $link = $link . "?";
        foreach($options as $key => $value){
            $link = $link . $key . "=" . $value . '&';
        }
        $link = $link . "api_key=" . $apiKey;
        return $link;
    }

    static function AuthenticationLinkWithHash(string $link, array $options, string $apiKey, string $apiSecret){
        $link = $link . "?";
        foreach($options as $key => $value){
            $link = $link . $key . "=" . $value . '&';
        }
        $link = $link . "api_key=" . $apiKey . '&';
        $link = $link . "hash=" . hash_hmac('sha256', $link, $apiSecret);
        return $link;
    }
}