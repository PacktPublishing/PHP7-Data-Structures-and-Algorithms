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

class AgentQueue implements Queue {

    private $limit;
    private $queue;

    public function __construct(int $limit = 20) {
	$this->limit = $limit;
	$this->queue = [];
    }

    public function dequeue(): string {

	if ($this->isEmpty()) {
	    throw new UnderflowException('Queue is empty');
	} else {
	    return array_shift($this->queue);
	}
    }

    public function enqueue(string $newItem) {

	if (count($this->queue) < $this->limit) {
	    array_push($this->queue, $newItem);
	} else {
	    throw new OverflowException('Queue is full');
	}
    }

    public function peek(): string {
	return current($this->queue);
    }

    public function isEmpty(): bool {
	return empty($this->queue);
    }

}

try {
    $agents = new AgentQueue(10);
    $agents->enqueue("Fred");
    $agents->enqueue("John");
    $agents->enqueue("Keith");
    $agents->enqueue("Adiyan");
    $agents->enqueue("Mikhael");
    echo $agents->dequeue()."\n";
    echo $agents->dequeue()."\n";
    echo $agents->peek()."\n";
} catch (Exception $e) {
    echo $e->getMessage();
}