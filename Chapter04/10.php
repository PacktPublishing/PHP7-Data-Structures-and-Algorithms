<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

interface Queue {

    public function enqueue(string $item);

    public function dequeue();

    public function peek();

    public function isEmpty();
}

class CircularQueue implements Queue {

    private $queue;
    private $limit;
    private $front = 0;
    private $rear = 0;

    public function __construct(int $limit = 5) {
	$this->limit = $limit;
	$this->queue = [];
    }

    public function size() {
	if ($this->rear > $this->front)
	    return $this->rear - $this->front;
	return $this->limit - $this->front + $this->rear;
    }

    public function isEmpty() {
	return $this->rear == $this->front;
    }

    public function isFull() {
	$diff = $this->rear - $this->front;
	if ($diff == -1 || $diff == ($this->limit - 1))
	    return true;
	return false;
    }

    public function enqueue(string $item) {
	if ($this->isFull()) {
	    throw new OverflowException("Queue is Full.");
	} else {
	    $this->queue[$this->rear] = $item;
	    $this->rear = ($this->rear + 1) % $this->limit;
	}
    }

    public function dequeue() {
	$item = "";
	if ($this->isEmpty()) {
	    throw new UnderflowException("Queue is empty");
	} else {
	    $item = $this->queue[$this->front];
	    $this->queue[$this->front] = NULL;
	    $this->front = ($this->front + 1) % $this->limit;
	}
	return $item;
    }

    public function peek() {
	return $this->queue[$this->front];
    }

}

try {
    $cq = new CircularQueue;
    $cq->enqueue("One");
    $cq->enqueue("Two");
    $cq->enqueue("Three");
    $cq->enqueue("Four");
    $cq->dequeue();
    $cq->enqueue("Five");
    echo $cq->size();
} catch (Exception $e) {
    echo $e->getMessage();
}