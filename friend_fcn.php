<?php

class friend {   
	public $user1 = ' ';       		/* Log in Name to link back to users.tsv*/
	public $user2 = ' ';          	/* First Name */
	public $status = ' ';          	/* Last Name */	
	
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

function setupBlankFriends() {
	$friend = array();
	$i = 0;
	$friend[$i++] = makeNewFriend('', '', '');
	writeFriends($friend);
}

function writeFriends($friends) {
	if (!file_exists('friends.tsv')) touch('friends.tsv');
	$fh = fopen('friends.tsv', 'w+') or die("Can't open file");
	fwrite($fh, $friends[0]->headings()."\n");
	for ($i = 0; $i < count($friends); $i++) {
		fwrite($fh, $friends[$i]->contents()."\n");
	}
	fclose($fh);
}

function readFriends() {
	if (! file_exists('friends.tsv')) { setupBlankFriends(); }
	$contents = file_get_contents('friends.tsv');
	$lines    = preg_split("/\r|\n/", $contents, -1, PREG_SPLIT_NO_EMPTY);
	$keys     = preg_split("/\t/", $lines[0]);
	$i        = 0;
	for ($j = 1; $j < count($lines); $j++) {
		$vals = preg_split("/\t/", $lines[$j]);
		if (count($vals) > 1) {
			$f = new friend();
			for ($k = 0; $k < count($vals); $k++) {
				$f->$keys[$k] = $vals[$k];
			}
			$friends[$i] = $f;
			$i++;
		}
	}
	return $friends;
}

function addFriend($friend) {
	$fh = fopen('friends.tsv', 'a+') or die("Can't open file");
	fwrite($fh, $friend->contents()."\n");
	fclose($fh);
}
?>
