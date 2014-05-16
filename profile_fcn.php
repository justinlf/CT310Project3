<?php
class userProfile {   
	public $username = ' ';       	/* Log in Name to link back to users.tsv*/
	public $fname = ' ';          	/* First Name */
	public $lname = ' ';          	/* Last Name */
	public $image = '';        		/* User Profile picture */
	public $gender = '';            /* User Gender */
	public $mobile = '';        	/* User cell phone number */
	public $email = '';        	    /* User e-mail address */
	
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

function makeNewProfile($username, $fname, $lname, $image, $gender, $mobile, $email) {
	$p = new userProfile();
	$p->username = $username;
	$p->fname = $fname;
	$p->lname = $lname;	
	$p->image = $image;
	$p->gender = $gender;
	$p->mobile = $mobile;
	$p->email = $email;
	return $p;
}

function readProfiles() {
	$profiles = array();
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "SELECT username, fname, lname, image, gender, mobile, email FROM profiles;";
	$ret = $db->query($query);
	foreach($ret as $row){
		$profile = makeNewProfile($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		array_push($profiles, $profile);
	}
	return $profiles;
}

function addProfile($profile) {
	$username = $profile->username;
	$fname = $profile->fname;
	$lname = $profile->lname;	
	$image = $profile->image;
	$gender = $profile->gender;
	$mobile = $profile->mobile;
	$email = $profile->email;
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "INSERT INTO profiles VALUES('".$username."','".$fname."','".$lname."','".$image."','".$gender."','".$mobile."','".$email."');";
	$db->exec($query);
}

function updateProfile($profile) {
	$username = $profile->username;
	$fname = $profile->fname;
	$lname = $profile->lname;	
	$image = $profile->image;
	$gender = $profile->gender;
	$mobile = $profile->mobile;
	$email = $profile->email;
	try{
	$db = new PDO('sqlite:./users.db');
	}catch(PDOException $e){
		print "Error!: ".$e->getMessage();
		die();		
	}
	$query = "UPDATE profiles SET fname = '".$fname."', lname = '".$lname."', image = '".$image."', gender = '".$gender."', mobile = '".$mobile."', email = '".$email."' WHERE username = '".$username."';";
	$db->exec($query);
}

function listPending(){
	$db = new PDO("sqlite:./users.db");
	$pending = "SELECT * FROM userAuth;";
	$ret = $db->query($pending);
	foreach($ret as $user){
		if($user[6]==0){
			echo $user[0].":";
			echo "<a href='verify.php?user=$user[0]#'>Verify</a>";
			echo "<a href='deny.php?user=$user[0]#'> | Deny</a>";
		}
	}
}
?>
