<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$a = new \Ds\Vector([1, 2, 3]);
$b = $a->copy();

$b->push(4);

print_r($a);
print_r($b);

$vector = new \Ds\Vector(["a", "b", "c"]);
echo $vector->get(1)."\n";
$vector[1] = "d";
echo $vector->get(1)."\n";
$vector->push('f');
echo "Size of vector: ".$vector->count()."\n";


$set = new \Ds\Set();
$set->add(1);
$set->add(1);
$set->add("test");
$set->add(3);
echo $set->get(1);

