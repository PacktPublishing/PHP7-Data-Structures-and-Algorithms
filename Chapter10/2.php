<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

class MaxHeap {

    public $heap;
    public $count;

    public function __construct(int $size) {
	$this->heap = array_fill(0, $size, 0);
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
	echo implode("\t", array_slice($this->heap, 0)) . "\n";
    }

    public function insert(int $i) {
	if ($this->count == 0) {
	    $this->heap[0] = $i;
	    $this->count = 1;
	} else {
	    $this->heap[$this->count++] = $i;
	    $this->siftUp();
	}
    }

    public function siftUp() {
	$tmpPos = $this->count - 1;
	$tmp = intval($tmpPos / 2);

	while ($tmpPos > 0 && $this->heap[$tmp] < $this->heap[$tmpPos]) {
	    $this->swap($tmpPos, $tmp);

	    $tmpPos = intval($tmpPos / 2);
	    $tmp = intval($tmpPos / 2);
	}
    }

    public function extractMax() {
	$min = $this->heap[0];
	$this->heap[0] = $this->heap[$this->count - 1];
	$this->heap[$this->count - 1] = 0;
	$this->count--;
	$this->siftDown(0);
	return $min;
    }

    public function siftDown(int $k) {
	$largest = $k;
	$left = 2 * $k + 1;
	$right = 2 * $k + 2;
	if ($left < $this->count && $this->heap[$largest] < $this->heap[$left]) {
	    $largest = $left;
	}
	if ($right < $this->count && $this->heap[$largest] < $this->heap[$right]) {
	    $largest = $right;
	}
	if ($largest != $k) {
	    $this->swap($k, $largest);
	    $this->siftDown($largest);
	}
    }

    public function swap(int $a, int $b) {
	$temp = $this->heap[$a];
	$this->heap[$a] = $this->heap[$b];
	$this->heap[$b] = $temp;
    }
}

class PriorityQ extends MaxHeap {

    public function __construct(int $size) {
	parent::__construct($size);
    }

    public function enqueue(int $val) {
	parent::insert($val);
    }

    public function dequeue() {
	return parent::extractMax();
    }

}

$numbers = [37, 44, 34, 65, 26, 86, 129, 83, 9];
$pq = new PriorityQ(count($numbers));
foreach ($numbers as $number) {
    $pq->enqueue($number);
}
echo "Constructed Heap\n";
$pq->display();
echo "DeQueued: " . $pq->dequeue() . "\n";
$pq->display();
echo "DeQueued: " . $pq->dequeue() . "\n";
$pq->display();
echo "DeQueued: " . $pq->dequeue() . "\n";
$pq->display();
echo "DeQueued: " . $pq->dequeue() . "\n";
$pq->display();
echo "DeQueued: " . $pq->dequeue() . "\n";
$pq->display();
echo "DeQueued: " . $pq->dequeue() . "\n";
$pq->display();
