<?php
include 'user_fcn.php';
//header("Location: ./index.php");
$user = $_POST['user'];
$ip = $_SERVER['REMOTE_ADDR'];
$key = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,50 ) ,1 ) .substr( md5( time() ), 1);
$hash = createSalt($user, $_POST['pass']);
$db = new PDO("sqlite:./users.db");
$insert = "INSERT INTO passwordChange VALUES('$user', '$key', '$ip', '$hash');";
echo $insert;
$db->exec($insert);
$email=$_POST['email'];
$message = "Your password will be changed by following the link. www.cs.colostate.edu/~bendude/proj3/changePass.php?key=$key#";
mail($email, "bendude@cs.colostate.edu", $message);
?>