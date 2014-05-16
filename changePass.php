<?php
$key = $_GET['key'];
$currIP = $_SERVER['REMOTE_ADDR'];
$db = new PDO("sqlite:./users.db");
echo $key;
$query = "SELECT * FROM passwordChange WHERE key='$key';";
$result = $db->query($query);
$user = $result->fetch();

if(strcmp($currIP, $user[2])==0){
$update = "UPDATE users SET hash='$user[3]' WHERE username='$user[0]';";
$db->exec($update);
$delete = "DELETE FROM passwordChange WHERE key='$key';";
$db->exec($delete);
}
?>