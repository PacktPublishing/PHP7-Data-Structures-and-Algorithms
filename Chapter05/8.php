<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$path = realpath('.');

$files = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
foreach ($files as $name => $file) {
    echo "$name\n";
}
