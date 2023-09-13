<?php

class D3LApiLinkBuilder{
    public function BasicLinkBuilder(string $link, array $options){
        $link = $link . "?";
        foreach($options as $key => $value){
            $link = $link . $key . "=" . $value . "&";
        }
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