<?php

/* 
 * Example code for: PHP 7 Data Structures and Algorithms
 * 
 * Author: Mizanur rahman <mizanur.rahman@gmail.com>
 * 
 */

$inputStr = 'Bingo';
$fruites = ['Apple', 'Orange', 'Grapes', 'Banana', 'Water melon', 'Mango'];

$matchScore = -1;
$matchedStr = '';

foreach ($fruites as $fruit) {
    $tmpScore = levenshtein($inputStr, $fruit);

    if ($tmpScore == 0 || ($matchScore < 0 || $matchScore > $tmpScore)) {
	$matchScore = $tmpScore;
	$matchedStr = $fruit;
    }
}

echo $matchScore == 0 ? 'Exact match found : ' . $matchedStr : 'Did you mean: ' . $matchedStr . '?\n';


$str1 = "Mango";
$str2 = "Tango";

echo "Match length: " . similar_text($str1, $str2) . "\n";
similar_text($str1, $str2, $percent);
echo "Percentile match: " . $percent . "%";


$word1 = "Pray";
$word2 = "Prey";
echo $word1 . " = " . soundex($word1) . "\n";
echo $word2 . " = " . soundex($word2) . "\n";

$word3 = "There";
$word4 = "Their";
echo $word3 . " = " . soundex($word3) . "\n";
echo $word4 . " = " . soundex($word4) . "\n";


$word1 = "Pray";
$word2 = "Prey";
echo $word1 . " = " . metaphone($word1) . "\n";
echo $word2 . " = " . metaphone($word2) . "\n";

$word3 = "There";
$word4 = "Their";
echo $word3 . " = " . metaphone($word3) . "\n";
echo $word4 . " = " . metaphone($word4) . "\n";


$arr = ['file1', 'file2', 'file10', 'file11', 'file3', 'file15', 'file21'];
sort($arr);
echo "Regular Sorting: " . implode(",", $arr)."\n";
natsort($arr);
echo "Natural Sorting: " . implode(",", $arr);


$data = "hello"; 

foreach (hash_algos() as $v) { 
        $r = hash($v, $data, false); 
        printf("%-12s %3d %s\n", $v, strlen($r), $r); 
}