<?php
	header("Location: ./index.php");
	$db = new PDO("sqlite:./users.db");
	$user = $_GET['user'];
	$delete = "DELETE FROM userAuth WHERE username='$user';";
	$db->exec($delete);
	?>