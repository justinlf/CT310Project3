<?php

class User {   
	public $username = ' ';
	public $hash = '';
	public $type = '';

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

function makeNewUser($username, $hash, $type) {
	$u = new User();
	$u->username = $username;	
	$u->hash = $hash;
	$u->type = $type;
	return $u;
}

function newAuthUser($username, $pass, $type, $email, $ip){
	$db = new PDO('sqlite:./users.db');
	$hash = createSalt($username, $pass);
	$key = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,50 ) ,1 ) .substr( md5( time() ), 1);
	$insert = "INSERT INTO userAuth VALUES('$username', '$hash', '$type', '$email', '$key', '$ip', 0);";
	echo "Registration Pending: Must be approved by an admin.";
	$db->exec($insert);

}

function addUser($user) {
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "INSERT INTO users VALUES('".$user->username."','".$user->hash."','".$user->type."');";
	$db->exec($query);
}

function readUsers() {
	$users = array();
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "SELECT username, hash, type FROM users;";
	$ret = $db->query($query);
	foreach($ret as $row){
		$user = makeNewUser($row[0], $row[1], $row[2]);
		array_push($users, $user);
	}
	return $users;
}

function createSalt($user, $pass) {
	$salt = substr($user, 0, 3);
	return md5($salt.$pass);
}
?>