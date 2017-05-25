<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

class TreeNode {

    public $data = NULL;
    public $children = [];

    public function __construct(string $data = NULL) {
	$this->data = $data;
    }

    public function addChildren(TreeNode $node) {
	$this->children[] = $node;
    }

}

class Tree {

    public $root = NULL;
    public function __construct(TreeNode $node) {
	$this->root = $node;
    }

    public function traverse(TreeNode $node, int $level = 0) {

	if ($node) {
	    echo str_repeat("-", $level);
	    echo $node->data . "\n";

	    foreach ($node->children as $childNode) {
		$this->traverse($childNode, $level + 1);
	    }
	}
    }

}

try {

    $ceo = new TreeNode("CEO");

    $tree = new Tree($ceo);

    $cto    = new TreeNode("CTO");
    $cfo    = new TreeNode("CFO");
    $cmo   = new TreeNode("CMO");
    $coo    = new TreeNode("COO");

    $ceo->addChildren($cto);
    $ceo->addChildren($cfo);
    $ceo->addChildren($cmo);
    $ceo->addChildren($coo);

    $seniorArchitect		= new TreeNode("Senior Architect");
    $softwareEngineer		= new TreeNode("Software Engineer");
    $userInterfaceDesigner	= new TreeNode("User Interface Designer");
    $qualityAssuranceEngineer	= new TreeNode("Quality Assurance Engineer");

    $cto->addChildren($seniorArchitect);
    $seniorArchitect->addChildren($softwareEngineer);
    $cto->addChildren($qualityAssuranceEngineer);
    $cto->addChildren($userInterfaceDesigner);

    $tree->traverse($tree->root);
    
} catch (Exception $e) {
    echo $e->getMessage();
}