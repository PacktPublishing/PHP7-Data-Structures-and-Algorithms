<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

function maxDepth() {
    static $i = 0;
    print ++$i . "\n";
    return 1+maxDepth();
}

maxDepth();
