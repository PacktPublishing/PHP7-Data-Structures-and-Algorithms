<?php
/**
 * Created by PhpStorm.
 * User: mizan
 * Date: 25/04/17
 * Time: 10:58 AM
 */

require __DIR__ . '/vendor/autoload.php';

use Tarsana\Functional as F;

$add = F\curry(function($x, $y, $z) {
    return $x + $y + $z;
});

echo $add(1, 2, 4)."\n";
$addFive = $add(5);
$addSix = $addFive(6);
echo $addSix(2);


$reduce = F\curry('array_reduce');
$sum = $reduce(F\__(), F\plus());
echo $sum([1, 2, 3, 4, 5], 0);

$square = function($x) { return $x * $x; };
$addThenSquare = F\pipe(F\plus(), $square);
echo $addThenSquare(2, 3);