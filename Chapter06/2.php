<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

class BinaryNode {

    public $data;
    public $left;
    public $right;

    public function __construct(string $data = NULL) {
	$this->data = $data;
	$this->left = NULL;
	$this->right = NULL;
    }

    public function addChildren(BinaryNode $left, BinaryNode $right) {
	$this->left = $left;
	$this->right = $right;
    }

}

class BinaryTree {

    public $root = NULL;

    public function __construct(BinaryNode $node) {
	$this->root = $node;
    }

    public function isEmpty(): bool {
	return $this->root === NULL;
    }

    public function traverse(BinaryNode $node, int $level = 0) {

	if ($node) {
	    echo str_repeat("-", $level);
	    echo $node->data . "\n";

	    if ($node->left)
		$this->traverse($node->left, $level + 1);

	    if ($node->right)
		$this->traverse($node->right, $level + 1);
	}
    }

}

try {

    $final = new BinaryNode("Final");

    $tree = new BinaryTree($final);

    $semiFinal1 = new BinaryNode("Semi Final 1");
    $semiFinal2 = new BinaryNode("Semi Final 2");
    $quarterFinal1 = new BinaryNode("Quarter Final 1");
    $quarterFinal2 = new BinaryNode("Quarter Final 2");
    $quarterFinal3 = new BinaryNode("Quarter Final 3");
    $quarterFinal4 = new BinaryNode("Quarter Final 4");

    $semiFinal1->addChildren($quarterFinal1, $quarterFinal2);
    $semiFinal2->addChildren($quarterFinal3, $quarterFinal4);

    $final->addChildren($semiFinal1, $semiFinal2);

    $tree->traverse($tree->root);
} catch (Exception $e) {
    echo $e->getMessage();
}