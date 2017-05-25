<?php
/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$languages = ["php", "python", "java", "c", "erlang"];

foreach ($languages as $ind => $language) {
    $languages[$ind] = ucfirst($language);
}


$languages = array_map('ucfirst', $languages);

function sum($a, $b, $c) {
    return $a + $b + $c;
}

function currySum($a) {
    return function($b) use ($a) {
	return function ($c) use ($a, $b) {
	    return $a + $b + $c;
	};
    };
}

$sum = currySum(10)(20)(30);

echo $sum;


function partial($funcName, ...$args) {
    return function(...$innerArgs) use ($funcName, $args) {
	$allArgs = array_merge($args, $innerArgs);
	return call_user_func_array($funcName, $allArgs);
    };
}

$sum = partial("sum", 10, 20);
$sum = $sum(30);

echo $sum;
