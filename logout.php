
<?php
$sessiName = "CT310ProFile_session";
session_name ( $sessiName );
session_start(); //Start the current session
session_destroy(); //Destroy it! So we are logged out now
header('location:index.php');
?>