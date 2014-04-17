<?php

class friend {   
	public $user1 = ' ';
	public $user2 = ' ';
	public $status = ' ';
	
	/* This function provides a complete tab delimeted dump of the contents/values of an object */
	public function contents() {
		$vals = array_values(get_object_vars($this));
		return( array_reduce($vals, create_function('$a,$b','return is_null($a) ? "$b" : "$a"."\t"."$b";')));
	}
	/* Companion to contents, dumps heading/member names in tab delimeted format */
	public function headings() {
		$vals = array_keys(get_object_vars($this));
		return( array_reduce($vals, create_function('$a,$b','return is_null($a) ? "$b" : "$a"."\t"."$b";')));
	}
}

function makeNewFriend($user1, $user2, $status) {
	$f = new friend();
	$f->user1 = $user1;
	$f->user2 = $user2;
	$f->status = $status;	
	return $f;
}

function readFriends() {
	$friends= array();
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "SELECT user1, user2, status FROM friends;";
	$ret = $db->query($query);
	foreach($ret as $row){
		$friend = makeNewFriend($row[0], $row[1], $row[2]);
		array_push($friends, $friend);
	}
		
	return $friends;
}

function addFriend($friend) {
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "INSERT INTO friends VALUES('".$friend->user1."','".$friend->user2."','".$friend->status."');";
	$db->exec($query);
}

function updateStatus($user1, $user2, $status) {
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "UPDATE friends SET status = '".$status."' WHERE user1 = '".$user1."' AND user2 = '".$user2."';";
	$db->exec($query);
}

?>
