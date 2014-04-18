<?php
function displayMessages($messages){
	echo '<div class="userContentBox">
			<div class="contentHeader">
				<h4 class="userListTitle">Wall</h4>
				<hr />
			</div>';
	foreach ($messages as $message){
		echo '<div class="messageBox">
					<strong>'.$message->sender.'</strong><p>'.$message->message.'</p>
					<sub>'.$message->time.'</sub>
				</div>';
	}
	echo '</div>';
}
?>
