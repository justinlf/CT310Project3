<?php
	//header("Location: ./index.php");
	include 'user_fcn.php';
	include 'profile_fcn.php';
	header("Refresh: 3, index.php");
	$currIP = $_SERVER['REMOTE_ADDR'];

	$key = $_GET['key'];
	$db = new PDO("sqlite:./users.db");
	$query = "SELECT * FROM userAuth WHERE key='$key'";
	$ret = $db->query($query);
	$user = $ret->fetch();
	$ip = $user[5];
	if($ip==$currIP){
	$delete = "DELETE FROM userAuth WHERE username='$user[0]'";
	$newUser= "INSERT INTO users VALUES('$user[0]', '$user[1]', '$user[2]');";
	$newProfile = "INSERT INTO profiles VALUES('$user[0]', '', '', 'default.jpg', '', '', '$user[3]');";
	
	$db->exec($delete);
	$db->exec($newUser);
	$db->exec($newProfile);
	echo "$user[0] Created. <br/>";
	}else{
		echo "IP does not match";
	}

	?>