<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$countries = [];
array_push($countries, 'Bangladesh', 'Bhutan');


$countries = ["Bangladesh", "Nepal", "Bhutan"];

$key = array_search("Bangladesh", $countries);
if ($key !== FALSE)
    echo "Found in: " . $key;
else
    echo "Not found";

$countries = ["bangladesh", "nepal", "bhutan"];
$newCountries = array_map(function($country) {
    return strtoupper($country);
}, $countries);

foreach ($newCountries as $country)
    echo $country . "\n";

$countries = ["bangladesh", "nepal", "bhutan"];
$newCountries = array_map('strtoupper', $countries);

foreach ($newCountries as $country)
    echo $country . "\n";


$countries = ["bangladesh", "nepal", "bhutan"];
$top = array_shift($countries);
echo $top;

$baseNumber = "123456754";
$newNumber = base_convert($baseNumber, 8, 16);
echo $newNumber;


