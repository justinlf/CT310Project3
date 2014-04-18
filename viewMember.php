<?php
$title = 'CT310 Social Networking Home';
$sessiName = "CT310ProFile_session";
session_name ( $sessiName );
session_start ();

include 'Head.php';
include 'user_fcn.php';
include 'profile_fcn.php';
include 'friend_fcn.php';
include 'message_fcn.php';
include 'displayMessages.php';
				
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
		if(isset($_POST["friend"])){	
			addFriend(makeNewFriend($username, $viewuser, 'Pending'));
		}
		if(isset($_POST["message"])){
			if($_POST["comment"] != ''){
				$message = $_POST["comment"];
				print_r($_POST);		
				addMessage(makeNewMessage('NULL','new',$username, $viewuser, 'NULL', $message,'NULL'));
			}
		}
		else if(isset($_POST["response"])){
			if($_POST["comment"] != ''){
				$message = $_POST["comment"];
				$parentID = $_POST["parentID"];
				print_r($_POST);		
				addMessage(makeNewMessage('NULL','response',$username, $viewuser, 'NULL', $message, $parentID));
			}
		}
	}
}
$profiles = readProfiles();
foreach ($profiles as $p) {
	if ($p->username == $viewuser) {
		$viewprofile=$p;
	}
}
$messages = readMessages($viewuser);
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
			<?php include 'proj3Header.php'; ?>		
			<?php include 'navigation.php' ?>

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
									if((($f->user1 == $username) && ($f->user2 == $viewprofile->username)) ||
										(($f->user2 == $username) && ($f->user1 == $viewprofile->username))){
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
								if ($friendStatus == "notfriends"){
									echo
									'<form method="post" action="viewMember.php?myUser='.$viewprofile->username.'">
											<input class="socialBtn" type="submit" name="friend" value="Add Friend" />
									</form>';
								}
								else if ($friendStatus == "pending"){
									echo "<p class='waitingP' >Waiting for friend confirmation </p><br>";
								}
								else if ($friendStatus == "accepted"){
									displayMessages($messages);
									echo 
									'<div class="userContentBox">
										<textarea rows="4" cols="50" name="comment" form="msgform"></textarea>
									</div>';
									if(isset($_GET["reply"])) {
										echo
										'<form id="msgform" method="post" action="viewMember.php?myUser='.$viewuser.'">
												<input type="hidden" name="parentID" value="'.$_GET["reply"].'">
												<input class="messageBtn" type="submit" name="response" value="Reply" />
										</form>';
									}
									else {
										echo
										'<form id="msgform" method="post" action="viewMember.php?myUser='.$viewuser.'">									
												<input class="messageBtn" type="submit" name="message" value="Post Message" />
										</form>';
									}
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
				<?php include 'proj3Footer.php'; ?>
			</div>
	</body>
</html>
