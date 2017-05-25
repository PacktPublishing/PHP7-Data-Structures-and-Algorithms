<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

function bubbleSort(array $arr): array {
    $count = 0;
    $len = count($arr);

    for ($i = 0; $i < $len; $i++) {
	for ($j = 0; $j < $len - 1; $j++) {
	    $count++;
	    if ($arr[$j] > $arr[$j + 1]) {
		$tmp = $arr[$j + 1];
		$arr[$j + 1] = $arr[$j];
		$arr[$j] = $tmp;		
	    }
	}
    }   
    echo $count."\n";
    return $arr;
}

$arr = [20, 45, 93, 67, 10, 97, 52, 88, 33, 92];

$sortedArray = bubbleSort($arr);
echo implode(",", $sortedArray);

