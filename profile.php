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
				
if(isset($_SESSION['valid']) && $_SESSION['valid']){
	$loggedin = true;
}
else{
	$loggedin = false;
	header('Location: index.php');
    die();
}

$ipaddr = $_SERVER ['REMOTE_ADDR'];
list($first, $second, $third, $forth) = explode('.', $ipaddr);

$mode = "view";				
$viewuser = "";
$username = $_SESSION ['userName'];
$friends = readFriends();
if($_SERVER["REQUEST_METHOD"]=="GET" || $_SERVER["REQUEST_METHOD"]=="POST"){    
    $viewuser =  $_GET["myUser"];
    if(isset($_GET['acceptRequest'])){
		$pending = $_GET['pendingUser'];
		foreach ($friends as $f){
			if($f->user1 == $pending && $f->user2 == $username && $f->status == "Pending")
				$friend = $f;
		}
		/* friend request accepted, add friend */
		if($_GET['acceptRequest'] == 'true'){
			$friend->status = "Accept";
			updateStatus($pending, $username, "Accept");
		}
		/* friend request ignored, ignore request */
		else{
			$friend->status = "Ignore";
			updateStatus($pending, $username, "Ignore");
		}
	}
	if(isset($_POST["message"])){
		if($_POST["comment"] != ''){
			$message = $_POST["comment"];		
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

$filename = "";
if(isset($_FILES["file"])){
	$file = $_FILES["file"];
	//print_r("Upload".$file);
	if($file["error"]==0){
		$type = explode("/", $file["type"]);
		if($type[0] == "image"){
			if($file["size"]<1000000) {
				move_uploaded_file($file["tmp_name"], "./images/".$file["name"]);
				$filename =  $file["name"];
				chmod("./images/".$filename, 0705);
			}
			else{
				echo "File is too large";
			}
		}
		else{
			echo "</br>File must be an image</br>";
		}
	}
}	

$users = readUsers($username);
$messages = readMessages($username);
$profiles = readProfiles();
foreach ($profiles as $p) {
	if (trim($p->username) == trim($username)) {
		$userprofile=$p;
	}
}

if($_SERVER["REQUEST_METHOD"]=="POST"){   							
	$userprofile->fname = (isset($_POST['fname'])? $_POST['fname']:$userprofile->fname);
	$userprofile->lname = (isset($_POST['lname'])? $_POST['lname']:$userprofile->lname);
	$userprofile->gender = (isset($_POST['gender'])? $_POST['gender']:$userprofile->gender);
	$userprofile->mobile = (isset($_POST['mobile'])? $_POST['mobile']:$userprofile->mobile);
	$userprofile->email = (isset($_POST['email'])? $_POST['email']:$userprofile->email);
	$userprofile->image = (($filename != "")? $filename:$userprofile->image);
	if (isset($_POST['update'])) {
		updateProfile($userprofile);			
	}	
	$mode = $_POST["myMode"];
}
?>
	<body>
		<div id="body-container">
			<?php include 'proj3Header.php'; ?>		
			<?php include "navigation.php" ?>

			<div class="content">
				<div class="smallerContent">
					<h4 class="userListTitle">Current Members</h4>
					<hr />
					<?php 
					foreach ($profiles as $p) { 
						include 'userThumb.html';
					} 
					?>	
				</div>
				<?php if ($loggedin) { ?>
					<div class="biggerContent">
						<div class="myPicture">
							<img src="<?php echo './images/'.$userprofile->image ?>" alt="">
						</div>
						<div class="contentHeader">
							<h2>My name is <?php echo $userprofile->fname ?></h2>
						</div>
						
						<?php
						if($mode == "view")
							{
								echo
								'<div class="userContentBox">
									<ul>
										<li><strong>Name: </strong> ' .$userprofile->fname. ' '.$userprofile->lname. '</li>
										<li><strong>Gender: </strong> '.$userprofile->gender.'</li>
										<li><strong>Mobile number: </strong> '.$userprofile->mobile.'</li>
										<li><strong>e-mail address: </strong> '.$userprofile->email.'</li>
									</ul>';
									if ((strcmp($first,"129")==0 && strcmp($second,"82")==0)|| strcmp($first,"::1")==0 ||
										(strcmp($first,"67")==0 && strcmp($second,"174")==0 && strcmp($third,"106")==0 && strcmp($forth,"156")==0))
									{
										echo
										'<form method="post" action="profile.php?myUser=' .$userprofile->username. '">
										<input type="hidden" name="myMode" value="edit"/>
										<input type="hidden" name="mySummary" value=""/>
										<input class="formButton2" type="submit" value = "Edit" name+"edit"/>
										</form>';
									}										
								echo '</div>';
								
							}
						
						if($mode == "edit"){
														
							if ((strcmp($first,"129")==0 && strcmp($second,"82")==0)|| strcmp($first,"::1")==0 ||
								(strcmp($first,"67")==0 && strcmp($second,"174")==0 && strcmp($third,"106")==0 && strcmp($forth,"156")==0))
							{
							echo
								'<form class="userContentBox" id="inputForm" method="post" enctype="multipart/form-data" action="profile.php?myUser=' .$userprofile->username. '">
									<ul>
										<li><strong>First Name:</strong> <input type="text" name="fname" value= ' .$userprofile->fname. '></li>
										<li><strong>Last Name:</strong> <input type="text" name="lname" value= '.$userprofile->lname. '></li>
										<li><strong>Gender: </strong> <input type="text" name="gender" value= '.$userprofile->gender.'></li>
										<li><strong>Mobile number: </strong> <input type="text" name="mobile" value='.$userprofile->mobile.'></li>
										<li><strong>e-mail address: </strong> <input type="text" name="email" value='.$userprofile->email.'></li>
										<li><strong>Change image:</strong><input type="file" name="file"/></li>
									</ul>
									<input type="hidden" name="myMode" value="view"/>										
									<input class="formButton2" type="submit" value = "Submit" name="update"/>
								</form>';								
							}
						}
						if($username == $viewuser) {
							displayMessages($messages);
							echo 
							'<div class="userContentBox">
								<textarea rows="4" cols="50" name="comment" form="msgform"></textarea>
							</div>';
							if(isset($_GET["reply"])) {
								echo
								'<form id="msgform" method="post" action="profile.php?myUser='.$username.'">
										<input type="hidden" name="parentID" value="'.$_GET["reply"].'">
										<input class="messageBtn" type="submit" name="response" value="Reply" />
								</form>';
							}
							else {
								echo
								'<form id="msgform" method="post" action="profile.php?myUser='.$username.'">									
										<input class="messageBtn" type="submit" name="message" value="Post Message" />
								</form>';
							}
						}
						$userCompare = $userprofile->username;
						include 'listFriends.php';	
						$displayed = false;			
						foreach ($friends as $f) {		
							if (($f->user2 == $userCompare) && ($f->status == "Pending")){
								foreach ($users as $u) { 							
									if ($u->username == $f->user1) {
										foreach ($profiles as $p) {
											if ($p->username == $u->username) {
												if(!$displayed){
													echo '<br><h4 class="userListTitle">Pending</h4><hr />';
													$displayed = true;
												}
												include 'userThumb.html';
												echo 
													'<a class="accept" href="profile.php?myUser='.$p->username.'&acceptRequest=true&pendingUser='.$f->user1.'">accept</a> 
													<a class="ignore" href="profile.php?myUser='.$p->username.'&acceptRequest=false&pendingUser='.$f->user1.'">ignore</a>';												
											}									 
										}
									}									
								}
							}
						}?>						
					</div>	
				<?php } ?>
			</div>
				<?php include 'proj3Footer.php'; ?>
		</div>
	</body>
</html>
