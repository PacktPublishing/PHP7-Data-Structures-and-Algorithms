<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$agents = new SplQueue();
$agents->enqueue("Fred");
$agents->enqueue("John");
$agents->enqueue("Keith");
$agents->enqueue("Adiyan");
$agents->enqueue("Mikhael");
echo $agents->dequeue()."\n";
echo $agents->dequeue()."\n";
echo $agents->bottom()."\n";