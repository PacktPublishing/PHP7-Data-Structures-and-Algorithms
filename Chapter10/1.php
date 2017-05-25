<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

class MinHeap {

    public $heap;
    public $count;

    public function __construct(int $size) {
	$this->heap = array_fill(0, $size + 1, 0);
	$this->count = 0;
    }

    public function create(array $arr = []) {
	if ($arr) {
	    foreach ($arr as $val) {
		$this->insert($val);
	    }
	}
    }

    public function display() {
	echo implode("\t", array_slice($this->heap, 1)) . "\n";
    }

    public function insert(int $i) {
	if ($this->count == 0) {
	    $this->heap[1] = $i;
	    $this->count = 2;
	} else {
	    $this->heap[$this->count++] = $i;
	    $this->siftUp();
	}
    }

    public function siftUp() {
	$tmpPos = $this->count - 1;
	$tmp = intval($tmpPos / 2);

	while ($tmpPos > 0 && $this->heap[$tmp] > $this->heap[$tmpPos]) {
	    $this->swap($tmpPos, $tmp);
	    $tmpPos = intval($tmpPos / 2);
	    $tmp = intval($tmpPos / 2);
	}
    }

    public function swap(int $a, int $b) {
	$tmp = $this->heap[$a];
	$this->heap[$a] = $this->heap[$b];
	$this->heap[$b] = $tmp;
    }

    public function extractMin() {
	$min = $this->heap[1];
	$this->heap[1] = $this->heap[$this->count - 1];
	$this->heap[--$this->count] = 0;
	$this->siftDown(1);
	return $min;
    }

    public function siftDown(int $k) {
	$smallest = $k;
	$left = 2 * $k;
	$right = 2 * $k + 1;
	if ($left < $this->count && $this->heap[$smallest] > $this->heap[$left]) {
	    $smallest = $left;
	}
	if ($right < $this->count && $this->heap[$smallest] > $this->heap[$right]) {
	    $smallest = $right;
	}
	if ($smallest != $k) {
	    $this->swap($k, $smallest);
	    $this->siftDown($smallest);
	}
    }

}

$numbers = [37, 44, 34, 65, 26, 86, 129, 83, 9];
echo "Initial array \n" . implode("\t", $numbers) . "\n";
$heap = new MinHeap(count($numbers));
$heap->create($numbers);
echo "Constructed Heap\n";
$heap->display();
echo "Min Extract: " . $heap->extractMin() . "\n";
$heap->display();
echo "Min Extract: " . $heap->extractMin() . "\n";
$heap->display();
echo "Min Extract: " . $heap->extractMin() . "\n";
$heap->display();
echo "Min Extract: " . $heap->extractMin() . "\n";
$heap->display();
echo "Min Extract: " . $heap->extractMin() . "\n";
$heap->display();
echo "Min Extract: " . $heap->extractMin() . "\n";
$heap->display();
