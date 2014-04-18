	<div id="footer">
		<?php include "about.html" ?>
		<p>User <?php echo $_SESSION['userName'] ?> 
		   logged in for <?php echo time() - $_SESSION['startTime']?> seconds. </p>
	</div>
