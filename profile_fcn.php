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
function getDelimeter() {
	return "P1VBTDCYDH1V2SYYAF84TK163TJ4I47N";
}

function getProfiles($file) {
	$delimeter = getDelimeter();
	$contents = '';
	$lines = array();
	$i = 0;
	
	if (file_exists($file)) { $contents = file_get_contents($file); }
	$pos = strpos($contents, $delimeter);	
	while ($pos !== false) {
		$line = substr($contents,0,$pos);
		$lines[$i] = $line;
		$contents = substr($contents,$pos+32);
		$pos = strpos($contents, $delimeter);
		$i++;
	}	
	return $lines;
}

function readProfiles() {
	$file = 'profiles.txt';
	$lines = getProfiles($file);
	$i        = 0;
	$keys     = explode("|", $lines[0]);				
	for ($j = 1; $j < count($lines); $j++) {
		$vals = explode("|", $lines[$j]);						
		if (count($vals) > 1) {
			$p = new userProfile();
			for ($k = 0; $k < count($vals); $k++) {
				$value = $vals[$k];
				$p->$keys[$k] = trim($value);
			}
			$profiles[$i] = $p;
			$i++;
		}
	}
	return $profiles;
}

function prepProfileForWrite($username, $fname, $lname, $image, $gender, $mobile, $email) {
	$delimeter = getDelimeter();
	
	$profile = " $username|$fname|$lname|$image|$gender|$mobile|$email \n";
	return $profile;
}

function makeNewProfile($username, $fname, $lname, $image, $gender, $mobile, $email) {
	$p = new profile();
	$p->username = $username;
	$p->fname = $fname;
	$p->lname = $lname;	
	$p->image = $image;
	$p->gender = $gender;
	$p->mobile = $mobile;
	$p->email = $email;
	return $p;
}

function writeProfile($profile) {
	$file = 'profiles.txt';
	$current = '';
	if (file_exists($file)) { $current = file_get_contents($file); }
	$delimeter = getDelimeter();
	file_put_contents($file,rtrim($current).$profile.$delimeter);
}

function updateProfile($profile) {
	$file = 'profiles.txt';
	$lines = getProfiles($file);
	$fh = fopen($file, 'w+') or die("Can't open file");
	$keys = $lines[0];
	fwrite($fh, $keys);
	$delimeter = getDelimeter();
	for ($j = 1; $j < count($lines); $j++) {
		$myline = $delimeter.$lines[$j];
		$vals = explode("|", $lines[$j]);	
		if ((trim($vals[0]) == trim($profile->username))){										
			$myline = $delimeter." ".$profile->username."|".$profile->fname."|".$profile->lname."|".$profile->image."|".$profile->gender."|".$profile->mobile."|".$profile->email." \n";
			$myline = strip_tags($myline);
		}
		fwrite($fh, $myline);
	}
	fwrite($fh, $delimeter."\n");

}

?>
