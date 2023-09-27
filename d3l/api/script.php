#!/bin/php
<?php

include_once 'd3l/api/D3LApiLinkBuilder.php';
include_once 'd3l/api/D3LApiService.php';

echo "Testing : \n";

$link = D3LApiLinkBuilder::BasicLinkBuilder("https://www.themealdb.com/api/json/v1/1/search.php", array("s" => "Arrabiata"));
echo "Lien généré : " . $link . "\n";
$request = D3LApiService::GetRequest($link, "json");
echo "Result : " . $request . "\n";

