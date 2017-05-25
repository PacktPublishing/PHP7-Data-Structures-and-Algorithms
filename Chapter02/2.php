<?php
/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */


$startMemory = memory_get_usage();
$array = new SplFixedArray(100);
for ($i = 0; $i < 100; $i++)
    $array[$i] = new SplFixedArray(100);




  echo memory_get_usage() - $startMemory, ' bytes';

  $startMemory = memory_get_usage();
  $array = range(1,100000);
  $endMemory = memory_get_usage();
  echo ($endMemory - $startMemory)." bytes";


  $items = 100000;
  $startTime = microtime();
  $startMemory = memory_get_usage();
  $array = new SplFixedArray($items);
  for ($i = 0; $i < $items; $i++) {
  $array[$i] = $i;
  }
  echo array_filter($array);
  $endMemory = memory_get_usage();
  $endTime = microtime();
  $memoryConsumed = ($endMemory - $startMemory) / (1024 * 1024);
  $memoryConsumed = ceil($memoryConsumed);
  echo "memory = {$memoryConsumed} MB\n";
  echo "time =".($endTime-$startTime)."\n";

  $array =[1 => 10, 2 => 100, 3 => 1000, 4 => 10000];
  $splArray = SplFixedArray::fromArray($array,false);
  unset($array);
  print_r($splArray);

  $keyArray = [1 => 10, 2 => 100, 3 => 1000, 4 => 10000];
  $splArray = SplFixedArray::fromArray($keyArray, $keyArray);
  unset($array);
  print_r($splArray);


  $items = 5;
  $array = new SplFixedArray($items);
  for ($i = 0; $i < $items; $i++) {
  $array[$i] = $i * 10;
  }

  $newArray = $array->toArray();
  print_r($newArray);


$items = 5;
$array = new SplFixedArray($items);
for ($i = 0; $i < $items; $i++) {
    $array[$i] = $i * 10;
}

$array->setSize(10);
$array[7] = 100;


$array = [];
$array['Germany'] = "Position 1";
$array['Argentina'] = "Position 2";
$array['Portugal'] = "Position 6";
$array['Fifa_World_Cup'] = "2018 Russia";


$ronaldo = [
    "name" => "Ronaldo",
    "country" => "Portugal",
    "age" => 31,
    "currentTeam" => "Real Madrid"
];

$messi = [
    "name" => "Messi",
    "country" => "Argentina",
    "age" => 27,
    "currentTeam" => "Barcelona"
];

$team = [
    "player1" => $ronaldo,
    "player2" => $messi
];



Class Player {

    public $name;
    public $country;
    public $age;
    public $currentTeam;

}

$ronaldo = new Player;
$ronaldo->name = "Ronaldo";
$ronaldo->country = "Portugal";
$ronaldo->age = 31;
$ronaldo->currentTeam = "Real Madrid";


$odd = [];
$odd[] = 1;
$odd[] = 3;
$odd[] = 5;
$odd[] = 7;
$odd[] = 9;

$prime = [];
$prime[] = 2;
$prime[] = 3;
$prime[] = 5;

if (in_array(2, $prime)) {
    echo "2 is a prime";
}

$union = array_merge($prime, $odd);
$intersection = array_intersect($prime, $odd);
$compliment = array_diff($prime, $odd);


$odd = [];
$odd[1] = true;
$odd[3] = true;
$odd[5] = true;
$odd[7] = true;
$odd[9] = true;

$prime = [];
$prime[2] = true;
$prime[3] = true;
$prime[5] = true;

if (isset($prime[2])) {
    echo "2 is a prime";
}

$union = $prime + $odd;
$intersection = array_intersect_key($prime, $odd);
$compliment = array_diff_key($prime, $odd);
