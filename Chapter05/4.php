<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$dsn = "mysql:host=127.0.0.1;port=3306;dbname=packt;charset=UTF8;";
$username = "root";
$password = "";
$dbh = new PDO($dsn, $username, $password);

$result = $dbh->query("Select * from categories order by parentCategory asc, sortInd asc", PDO::FETCH_OBJ);

$categories = [];

foreach($result as $row) {
    $categories[$row->parentCategory][] = $row;
}


function showCategoryTree(Array $categories, int $n) {
    if(isset($categories[$n])) {
	
	foreach($categories[$n] as $category) {	    
	    echo str_repeat("-", $n)."".$category->categoryName."\n";
	    showCategoryTree($categories, $category->id);	    
	}	
    }    
    return;
}

showCategoryTree($categories, 0);