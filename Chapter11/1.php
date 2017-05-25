<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$startTime = microtime();
$count = 0;

function fibonacci(int $n): int {
    global $count;
    $count++;
    if ($n == 0) {
	return 1;
    } else if ($n == 1) {
	return 1;
    } else {
	return fibonacci($n - 1) + fibonacci($n - 2);
    }
}

echo fibonacci(30) . "\n";
echo "Function called: " . $count . "\n";
$endTime = microtime();
echo "time =" . ($endTime - $startTime) . "\n";


$startTime = microtime();
$fibCache = [];
$count = 0;

function fibonacciMemoized(int $n): int {
    global $fibCache;
    global $count;
    $count++;
    if ($n == 0) {
	return 1;
    } else if ($n == 1) {
	return 1;
    } else {

	if (isset($fibCache[$n - 1])) {
	    $tmp = $fibCache[$n - 1];
	} else {
	    $tmp = fibonacciMemoized($n - 1);
	    $fibCache[$n - 1] = $tmp;
	}

	if (isset($fibCache[$n - 2])) {
	    $tmp1 = $fibCache[$n - 2];
	} else {
	    $tmp1 = fibonacciMemoized($n - 2);
	    $fibCache[$n - 2] = $tmp1;
	}

	return $tmp + $tmp1;
    }
}

echo fibonacciMemoized(30) . "\n";
echo "Function called: " . $count . "\n";
$endTime = microtime();
echo "time =" . ($endTime - $startTime) . "\n";

