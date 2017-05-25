<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */


function gcd(int $a, int $b): int {
    if ($b == 0) {
	return $a;
    } else {
	return gcd($b, $a % $b);
    }
}

echo gcd(259,111);