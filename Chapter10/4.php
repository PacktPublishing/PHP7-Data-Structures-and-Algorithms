<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$numbers = [37, 44, 34, 65, 26, 86, 143, 129, 9];

$heap = new SplMaxHeap;

foreach ($numbers as $number) {
    $heap->insert($number);
}

while (!$heap->isEmpty()) {
    echo $heap->extract() . "\t";
}


