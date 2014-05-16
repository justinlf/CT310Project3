<?php 
$title = 'CT310 Social Networking Home';
$sessiName = "CT310ProFile_session";
session_name ( $sessiName );
session_start ();

include 'Head.php';
include 'user_fcn.php';
$users = readUsers();
include 'profile_fcn.php';
 ?>

	<body>
		<div id="body-container">
			<?php include 'proj3Header.php'; ?>		
			<?php include "navigation.php" ?>

			<div class="content">
		
				<?php
					$flag = false;
					$username = "";
					$passwd = "";
					$confirm = "";
					$email = "";	
					
					if ($_SERVER["REQUEST_METHOD"]=="POST"){		
						$username = $_POST['username'];
						$passwd = trim($_POST['passwd']);
						$confirm = trim($_POST['confirm']);
						$email = trim($_POST['email']);
						$ip = $_SERVER['REMOTE_ADDR'];
						$type = "Member";
					}		
				?>

			   <h2 align="center">Register New User</h2>

			   <form method="post" action="register.php">
						<table>										
							<tr>
								<td>User Name</td>    
								<td><input type="text" name="username" value="<?php echo $username; ?>"></td>
							</tr>
							<tr>
								<td>Password</td>    
								<td><input type="text" name="passwd" value="<?php echo $passwd; ?>"></td>
							</tr>
							<tr>
								<td>Confirm Password</td>    
								<td><input type="text" name="confirm" value="<?php echo $confirm; ?>"></td>
							</tr>
							<tr>
							<td>Email</td>
							<td><input type="text" name="email" value="<?php echo $email; ?>"></td>																								
							
						</table>
				 <input type="submit" value="Register">
				</form> 
				<?php  
					
					if ($_SERVER["REQUEST_METHOD"]=="POST"){
						if (!empty($username) && !empty($passwd) && !empty($confirm)){
							/* check if username exists */
							foreach ($users as $u) {
								if ($u->username == $username) {
								$flag=true;
								}
							}
							if ($flag) {
							echo "<br/>";
							  echo "User already exists. Please enter a new username. <br/>";
							  exit;
							}
							
							if ($passwd != $confirm)
							{
							  echo "<br/>";
							  echo "Please re-enter your password.  Your password is not the same as the confirmed password. <br/>";
							  exit;
							}
							newAuthUser($username, $passwd, $type, $email, $ip);	
							//$newuser = makeNewUser($username, $passwd, $type, $email, $ip);	
							//addUsers($newuser);
							//$newprofile = prepProfileForWrite($username, '', '', '', '', '', '');
							//writeProfile($newprofile);
							//echo "User Created. <br/>";
						}
						else
						{
							echo "<br/>";
							echo "Please enter informaiton in all the fields. <br/>";
						}
					}
				?>

		
			</div>
				<?php include 'proj3Footer.php'; ?>
			</div>
	</body>
</html>
