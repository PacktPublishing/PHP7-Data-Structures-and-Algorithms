<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

function search(array $numbers, int $neeedle): bool {
    $totalItems = count($numbers);

    for ($i = 0; $i < $totalItems; $i++) {
	if($numbers[$i] === $neeedle){
	    return TRUE;
	}
    }
    return FALSE;
}

$numbers = range(1, 200, 5);

if (search($numbers, 31)) {
    echo "Found";
} else {
    echo "Not found";
}