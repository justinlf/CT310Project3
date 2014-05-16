<?php
	header("Location: ./index.php");
	$db = new PDO("sqlite:./users.db");
	$user = $_GET['user'];
	$query = "SELECT * FROM userAuth";
	$ret = $db->query($query);
	
	$email="";
	foreach($ret as $row){
		if(strcmp($row[0], $user)==0){
			$email=$row[3];
			break;
		}
	}
	$message = "Please verify your account by clicking on this link. www.cs.colostate.edu/~bendude/proj3/auth.php?key=$row[4]#";
	mail($email, "bendude@cs.colostate.edu", $message);

	$update = "UPDATE userAuth SET approved=1 WHERE username='$user';";
	$db->exec($update);
	?>