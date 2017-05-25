<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */



function topologicalSortKahnV2(array $matrix): array {
    $sorted = [];
    $nodes = [];

    $size = count($matrix);

    // finding all nodes where indegree = 0
    for ($i = 0; $i < $size; $i++) {
	$sum = 0;
	for ($j = 0; $j < $size; $j++)
	    $sum += $matrix[$j][$i];

	if ($sum == 0)
	    array_push($nodes, $i);
    }

    while ($nodes) {

	$node = array_shift($nodes);
	array_push($sorted, $node);

	foreach ($matrix[$node] as $index => $hasEdge) {
	    if ($hasEdge) {
		$matrix[$node][$index] = 0;

		$sum = 0;
		for ($i = 0; $i < $size; $i++) {
		    $sum += $matrix[$i][$index];
		}

		if (!$sum) {
		    array_push($nodes, $index);
		}
	    }
	}
    }

    return $sorted;
}

function topologicalSort(array $matrix): SplQueue {
    $order = new SplQueue;
    $queue = new SplQueue;
    $size = count($matrix);
    $incoming = array_fill(0, $size, 0);


    for ($i = 0; $i < $size; $i++) {
	for ($j = 0; $j < $size; $j++) {
	    if ($matrix[$j][$i]) {
		$incoming[$i] ++;
	    }
	}
	if ($incoming[$i] == 0) {
	    $queue->enqueue($i);
	}
    }

    while (!$queue->isEmpty()) {
	$node = $queue->dequeue();

	for ($i = 0; $i < $size; $i++) {
	    if ($matrix[$node][$i] == 1) {
		$matrix[$node][$i] = 0;
		$incoming[$i] --;
		if ($incoming[$i] == 0) {
		    $queue->enqueue($i);
		}
	    }
	}
	$order->enqueue($node);
    }

    if ($order->count() != $size) // cycle detected
	return new SplQueue;

    return $order;
}

/*
  $arr = [
  [0, 1, 1, 0, 0, 0, 0],
  [0, 0, 0, 1, 0, 0, 0],
  [0, 0, 0, 0, 1, 0, 0],
  [0, 0, 0, 0, 1, 0, 0],
  [0, 0, 0, 0, 0, 0, 1],
  [0, 0, 0, 0, 0, 0, 1],
  [0, 0, 0, 0, 0, 0, 0],
  ];

  $count = 5;
  $arr = [];

  for($i = 0;$i<$count;$i++)
  {
  $arr[] = array_fill(0, $count, 0);
  }

  $arr[0][4] = 1;
  $arr[1][0] = 1;
  $arr[2][1] = 1;
  $arr[2][3] = 1;
  $arr[1][3] = 1;
 */

$graph = [
    [0, 0, 0, 0, 1],
    [1, 0, 0, 1, 0],
    [0, 1, 0, 1, 0],
    [0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0],
];

$sorted = topologicalSort($graph);

while (!$sorted->isEmpty()) {
    echo $sorted->dequeue() . "\t";
}
