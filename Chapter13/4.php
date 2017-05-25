<?php
/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

require __DIR__ . '/vendor/autoload.php';

use Tarsana\Functional as F;

$queue = [];

$enqueue = F\append(F\__(), F\__());
$head = F\head(F\__());
$dequeue = F\tail(F\__());

$queue = $enqueue(1, $queue);
$queue = $enqueue(2, $queue);
$queue = $enqueue(3, $queue);

echo "Queue is ".F\toString($queue)."\n";

$item = $head($queue);
$queue = $dequeue($queue);

echo "Dequeue-ed item: ".$item."\n";
echo "Queue is ".F\toString($queue)."\n";

$queue = $enqueue(4, $queue);

echo "Queue is ".F\toString($queue)."\n";
