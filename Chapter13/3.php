<?php
/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

require __DIR__ . '/vendor/autoload.php';

use Tarsana\Functional as F;

$stack = [];

$push = F\append(F\__(), F\__());
$top = F\last(F\__());
$pop = F\init(F\__());

$stack = $push(1, $stack);
$stack = $push(2, $stack);
$stack = $push(3, $stack);

echo "Stack is ".F\toString($stack)."\n";

$item = $top($stack);
$stack = $pop($stack);

echo "Pop-ed item: ".$item."\n";
echo "Stack is ".F\toString($stack)."\n";

$stack = $push(4, $stack);

echo "Stack is ".F\toString($stack)."\n";
