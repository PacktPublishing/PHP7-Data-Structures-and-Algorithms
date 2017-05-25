<head>
    <style>
	ul {
	    list-style: none;
	    clear: both;
	}

	li ul {
	    margin: 0px 0px 0px 50px;
	}

	.pic {
	    display: block;
	    width: 50px;
	    height: 50px;
	    float: left;
	    color: #000;
	    background: #ADDFEE;
	    padding: 15px 10px;
	    text-align: center;
	    margin-right: 20px;
	}

	.comment {
	    float: left;
	    clear: both;
	    margin: 20px;
	    width: 500px;
	}

	.datetime {
	    clear: right;
	    width: 400px;
	    margin-bottom: 10px;
	    float: left;
	}
    </style>
</head>
<body>
    


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


$sql = "Select * from comments where postID = :postID order by parentID asc, datetime asc";
$stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$stmt->setFetchMode(PDO::FETCH_OBJ);
$stmt->execute(array(':postID' => 1));
$result = $stmt->fetchAll();

$comments = [];

foreach ($result as $row) {
    $comments[$row->parentID][] = $row;
}

function displayComment(Array $comments, int $n) {
    if (isset($comments[$n])) {
	$str = "<ul>";
	foreach ($comments[$n] as $comment) {
	    $str .= "<li><div class='comment'><span class='pic'>{$comment->username}</span>";
	    $str .= "<span class='datetime'>{$comment->datetime}</span>";
	    $str .= "<span class='commenttext'>" . $comment->comment . "</span></div>";

	    $str .= displayComment($comments, $comment->id);

	    $str .= "</li>";
	}

	$str .= "</ul>";

	return $str;
    }
    return "";
}

echo displayComment($comments, 0);
?>

    </body>