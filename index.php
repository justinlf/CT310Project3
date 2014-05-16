<?php
$title = 'CT310 Social Networking Home';
$sessiName = "CT310ProFile_session";
session_name ( $sessiName );
session_start ();
include 'Head.php';
include 'user_fcn.php';
include 'profile_fcn.php';

$users = readUsers();
$profiles = readProfiles();
?>
	<body>
		<div id="body-container">
			<?php include 'proj3Header.php'; ?>	
			<div class="content">
				<div class="biggerContent">
					<h4 class="userListTitle">Current Members</h4>
					<hr />

					<?php 
					foreach ($profiles as $p) { 
						include 'userThumb.html';
					}
					?>	
				</div>
				
				<div class="smallerContent">				
					<div class="contentHeader">
						<h2>Log In</h2>						
					</div>		
					<form method="post" action="index.php">
						<div class="formLogin">
							<table>
								<tr>
									<td>Name: </td>    
									<td><input class="resizedTextbox" type="text" name="username" /></td>
								</tr>
								<tr>
									<td>Password: </td>
									<td><input class="resizedTextbox" type="password" name="passwd" /></td>
								</tr>
							</table>
						</div>
						<input class="formButton" type="submit" value="Log In" />
					</form>
					<center><a href='register.php'>Register</a></center>

					<?php  
						$username = "";
						$passwd = "";
						if ($_SERVER["REQUEST_METHOD"]=="POST"){
						
							$username = $_POST['username'];
							$passwd = $_POST['passwd'];
							foreach ($users as $u) {
								if ($u->username == $username) {
									if ($u->hash == createSalt($username,$passwd)){
										$_SESSION ['startTime'] = time ();
										$_SESSION ['userName'] = $username;
										$_SESSION['valid'] = 1;
										$_SESSION['userType'] = $u->type;
										header( 'Location: profile.php?myUser='.$username ) ;
									}
									else
									{
										header( 'Location: index.php' ) ;
									}
									
								}
							}
						}
					?>
				</div>
				
			</div>
			<?php include 'proj3Footer.php'; ?>	
		</div>	
		
	</body>
</html>
