<?php
function displayMessages($messages){
	echo '<div class="userContentBox">
			<div class="contentHeader">
				<h4 class="userListTitle">Wall</h4>
				<hr />
			</div>';
	foreach ($messages as $message){
		if($message->type == 'new'){
			recurseMessages($messages, $message);
		}
	}
	echo '</div>';
}

function displayReplies($messages, $id){
	foreach ($messages as $message){
		if($message->parentid == $id){
			recurseMessages($messages, $message);
		}
	}
}

function recurseMessages($messages, $message){
	echo '<div class="messageBox">
		<strong>'.$message->sender.'</strong><p>'.$message->message.'</p>
		<div align="right" <sub>'.$message->time.'</sub></div>';
		displayReplies($messages, $message->id);
	echo '</div>';
}
?>
