<?php

class User {   
	public $username = ' ';       	/* Log in Name */
	public $hash = '';            	/* Salted Hash of password */
	public $usertype = '';        	/* user Admin or Member */
	
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

function makeNewUser($username, $pass, $type) {
	$u = new User();
	$u->username = $username;	
	$salt = createSalt($username,$pass);
	$u->hash = $salt;
	$u->usertype = $type;
	return $u;
}

function setupDefaultUsers() {
	$users = array();
	$i = 0;
	$users[$i++] = makeNewUser('admin', 'password', 'Admin');
	writeUsers($users);
}

function writeUsers($users) {
	if (!file_exists('users.tsv')) touch('users.tsv');
	$fh = fopen('users.tsv', 'w+') or die("Can't open file");
	fwrite($fh, $users[0]->headings()."\n");
	for ($i = 0; $i < count($users); $i++) {
		fwrite($fh, $users[$i]->contents()."\n");
	}
	fclose($fh);
}

function addUsers($user) {
	$fh = fopen('users.tsv', 'a+') or die("Can't open file");
	fwrite($fh, $user->contents()."\n");
	fclose($fh);
}

function readUsers() {
	if (! file_exists('users.tsv')) { setupDefaultUsers(); }
	$contents = file_get_contents('users.tsv');
	$lines    = preg_split("/\r|\n/", $contents, -1, PREG_SPLIT_NO_EMPTY);
	$keys     = preg_split("/\t/", $lines[0]);
	$i        = 0;
	for ($j = 1; $j < count($lines); $j++) {
		$vals = preg_split("/\t/", $lines[$j]);
		if (count($vals) > 1) {
			$u = new User();
			for ($k = 0; $k < count($vals); $k++) {
				$u->$keys[$k] = $vals[$k];
			}
			$users[$i] = $u;
			$i++;
		}
	}

	return $users;
}
function createSalt($user, $pass) {
	$salt = substr($user, 0, 3);
	return md5($salt.$pass);
}
?>