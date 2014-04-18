<?php  echo '<?xml version="1.0" encoding="utf-8"?>' ?>
<?php  echo "\n"?>
<?php  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-style-type" content="text/css" />
    <meta name="author" content="Justin Fritzler" />
    <meta name="description" content="CT-310 Project 3: Social Networking Site" />
    <meta name="keywords" content="HTML,CSS,PHP,CT310,Social,Networking" />
	
	<?php echo "<title> $title </title>\n" ?>	

	<link rel="stylesheet" href="normalize.css" />
	<link rel="stylesheet" href="proj3Style.css" />
	<link href="http://fonts.googleapis.com/css?family=Abel|Medula+One" rel="stylesheet" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600,700' rel='stylesheet' type='text/css' />
	
<?php 
   if (! isset ( $_SESSION ['startTime'] )) {
	$_SESSION ['startTime'] = time ();
}
if (! isset ( $_SESSION ['userName'] )) {
	$_SESSION ['userName'] = "Guest";
}
?>
</head>



