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
		<strong>'.$message->sender.'</strong><hr /><p>'.$message->message.'</p>
		<div class="messageFoot" align="right" <sub>'.$message->time.'</sub>
		<A href="?myUser='.$message->receiver.'&replyUser='.$message->sender.'&reply='.$message->id.'#msgform">Reply</A></div>';
		displayReplies($messages, $message->id);
	echo '</div>';
}
?>
