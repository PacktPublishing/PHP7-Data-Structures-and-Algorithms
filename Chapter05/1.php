<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

function factorialx(int $n): int {
    if ($n == 1)
	return 1;

    return $n * factorial($n - 1);
}

function factorial(int $n): int {
    $result = 1;

    for ($i = $n; $i > 0; $i--) {
	$result *= $i;
    }

    return $result;
}
