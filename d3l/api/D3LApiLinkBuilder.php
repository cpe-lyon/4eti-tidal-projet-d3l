<?php

class D3LApiLinkBuilder{
    static function BasicLinkBuilder(string $link, array $options){
        $link = $link . "?";
        foreach($options as $key => $value){
            $link = $link . $key . "=" . $value . "&";
        }
        $link = substr($link, 0, -1);
        return $link;
    }

    public function AuthenticationLinkBuilder(string $link, array $options, string $apiKey){
        $link = $link . "?";
        foreach($options as $key => $value){
            $link = $link . $key . "=" . $value . "&";
        }
        $link = $link . "api_key=" . $apiKey;
        return $link;
    }
}