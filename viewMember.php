<?php
$title = 'CT310 Social Networking Home';
$sessiName = "CT310ProFile_session";
session_name ( $sessiName );
session_start ();

include 'Head.php';
include 'user_fcn.php';
include 'profile_fcn.php';
include 'friend_fcn.php';
				
if(isset($_SESSION['valid']) && $_SESSION['valid'])
{
	$loggedin = true;
}
else
{
	$loggedin = false;
}
$users = readUsers();
$username = $_SESSION ['userName'];		
$viewuser = "";
if($_SERVER["REQUEST_METHOD"]=="GET" || $_SERVER["REQUEST_METHOD"]=="POST"){
    $viewuser =  $_GET["myUser"];
	$userCompare = $viewuser;
    if($viewuser == $username)
		header( 'Location: profile.php?myUser='.$username ) ;
    if($_SERVER["REQUEST_METHOD"]=="POST"){
		$viewuser =  $_GET["myUser"];
		addFriend(makeNewFriend($username, $viewuser, 'Pending'));
	}
}
$profiles = readProfiles();
foreach ($profiles as $p) {
	if ($p->username == $viewuser) {
		$viewprofile=$p;
	}
}
$friends = readFriends();
?>
	<?php 
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	//echo $ipAddress;
	$explode = explode('.', $ipAddress);
		if($explode[0]=="10" || $explode[0]=="129"||$explode[0]=="127"||$explode[0]=="71"){
			if($explode[1]=="82"||$explode[1]=="84"||$explode[1]=="0"||$explode[1]=="237"){
				$access = true;
			}
		}
		else{
			echo die("<body></body></html>");			
		}
	 ?> 
	<body>
		<div id="body-container">
			<?php include 'proj2Header.php'; ?>		
			<?php include "navigation.php" ?>

			<div class="content">
				<div class="smallerContent">
					<h4 class="userListTitle">Current Members</h4>
					<hr />
					<?php 
					foreach ($profiles as $p) { 
						include "userThumb.html";
					} 
					?>	
				</div>
				<?php if ($loggedin) { ?>
					<div class="biggerContent">
						<div class="myPicture">
							<img src="<?php echo './images/'.$viewprofile->image ?>" alt="" />
						</div>
						<div class="contentHeader">
							<h2>My name is <?php echo $viewprofile->fname ?></h2>
						</div>					
							<div class="userContentBox">
									<ul>
										<li><strong>Name:</strong> <?php echo $viewprofile->fname." ".$viewprofile->lname ?></li>
										<li><strong>Gender:</strong> <?php echo $viewprofile->gender ?></li>
										<li><strong>Mobile number:</strong> <?php echo $viewprofile->mobile ?></li>
										<li><strong>e-mail address:</strong> <?php echo $viewprofile->email ?></li>
									</ul>
							</div>
							<?php 
								$friendStatus = "notfriends";
								foreach ($friends as $f) {
									if(($f->user1 == $username) && ($f->user2 == $viewprofile->username)){
										if($f->status == "Accept"){ 
											$friendStatus = "accepted";
										}
										else if($f->status == "Pending"){
											$friendStatus = "pending";
										}
										else{
											$friendStatus = "ignore";
										}
									}
								}
								if ($friendStatus == "notfriends"){?>
									<form method="post" action="viewMember.php?myUser=<?php echo $viewprofile->username ?>">
											<input class="socialBtn" type="submit" name='friend' value="Add Friend" />
									</form>
							<?php
								}
								else if ($friendStatus == "pending"){
									echo "<p class='waitingP' >Waiting for friend confirmation </p><br>";
								}
								include 'listFriends.php';
							?>
					</div>
				<?php } 
				else
				{ ?>
					<div class="biggerContent">
						<div class="myPicture">
							<img src="<?php echo './images/'.$viewprofile->image ?>" alt="" />
						</div>
						<div class="contentHeader">
							<h2>My name is <?php echo $viewprofile->fname ?></h2>
						</div>
						<?php include 'listFriends.php' ?>							
					</div>	
				<?php } ?>
			</div>
				<?php include 'proj2Footer.php'; ?>
			</div>
	</body>
</html>
