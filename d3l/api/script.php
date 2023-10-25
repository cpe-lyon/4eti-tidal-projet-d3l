#!/bin/php
<?php

include_once 'd3l/api/D3LApiLinkBuilder.php';
include_once 'd3l/api/service/D3LApiService.php';

echo "Testing : \n";

//$link = D3LApiLinkBuilder::BasicLinkBuilder("https://www.themealdb.com/api/json/v1/1/search.php", array("s" => "Arrabiata"));
$link = D3LApiLinkBuilder::BasicLinkBuilder("https://api.open-meteo.com/v1/meteofrance", 
                                                    array("latitude" => "45.7485",
                                                    "longitude" => "4.8467",
                                                    "current_weather" => "true"));
echo "Lien généré : " . $link . "\n";
$request = D3LApiService::GetRequest($link, "json");
echo "Result : " . $request . "\n";

