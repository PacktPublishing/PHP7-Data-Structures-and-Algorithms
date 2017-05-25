<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$arr = [];
$count = rand(10, 30);

for($i = 0; $i<$count;$i++) {    
    $val = rand(1,500);    
    $arr[$val] = $val;    
}

$number = 100;

if(isset($arr[$number])) {
    echo "$number found ";
} else {
    echo "$number not found";
}
