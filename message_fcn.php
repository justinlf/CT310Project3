<?php
class message {   
	public $id = '';        	    /* Auto incrmented id, leave null for new message*/
	public $type = ' ';       		/* Message type (new/response)*/
	public $sender = ' ';          	/* Sender username */
	public $receiver = ' ';         /* Receiver username */
	public $time = '';        		/* TimeStamp */
	public $message = '';           /* Message Text*/
	public $parentid = '';        	/* id of parent message */
	
	
	/* This function provides a complete tab delimeted dump of the contents/values of an object */
	public function contents() {
		$vals = array_values(get_object_vars($this));
		return( array_reduce($vals, create_function('$a,$b','return is_null($a) ? "$b" : "$a"."|"."$b";')));
	}
	/* Companion to contents, dumps heading/member names in tab delimeted format */
	public function headings() {
		$vals = array_keys(get_object_vars($this));
		return( array_reduce($vals, create_function('$a,$b','return is_null($a) ? "$b" : "$a"."|"."$b";')));
	}
}

function makeNewMessage($id, $type, $sender, $receiver, $time, $message, $parentid) {
	$m = new message();
	$m->id = $id;
	$m->type = $type;
	$m->sender = $sender;	
	$m->receiver = $receiver;
	$m->time = $time;
	$m->message = $message;
	$m->parentid = $parentid;
	return $m;
}

function readMessages($username) {
	$messages = array();
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "SELECT mid, type, sender, receiver, DATETIME(time, 'localtime'), message, parent 
				FROM messages
				WHERE receiver = '".$username."';";
	$ret = $db->query($query);
	foreach($ret as $row){
		$message = makeNewMessage($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		array_push($messages, $message);
	}
	return $messages;
}

function addMessage($message) {
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "INSERT INTO messages VALUES(
				NULL,
				'".$message->type."',
				'".$message->sender."',
				'".$message->receiver."',
				CURRENT_TIMESTAMP,
				'".$message->message."',
				".$message->parentid.");";
	$db->exec($query);
}
?>
