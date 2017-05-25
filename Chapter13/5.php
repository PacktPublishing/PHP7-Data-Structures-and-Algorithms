<?php
/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */


function treeTraverse(array &$tree, int $index = 0, int $level = 0, &$outputStr = "")  : ?bool {

    if(isset($tree[$index])) {
        $outputStr .= str_repeat("-", $level);
        $outputStr .= $tree[$index] . "\n";

        treeTraverse($tree, 2 * $index + 1, $level+1,$outputStr);
        treeTraverse($tree, 2 * ($index + 1), $level+1,$outputStr);
    } else {
        return false;
    }

    return null;
}


$nodes = [];
$nodes[] = "Final";
$nodes[] = "Semi Final 1";
$nodes[] = "Semi Final 2";
$nodes[] = "Quarter Final 1";
$nodes[] = "Quarter Final 2";
$nodes[] = "Quarter Final 3";
$nodes[] = "Quarter Final 4";

$treeStr = "";
treeTraverse($nodes,0,0,$treeStr);
echo $treeStr;

