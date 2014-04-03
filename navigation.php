	<div id="navigation">
					<ul class="menu">
						<li><a href="index.php" >Home</a></li>
						<?php if(isset($_SESSION['valid']) && $_SESSION['valid']) {	?>					
							<li><a href='profile.php?myUser='.$username >My Profile</a></li>
						<?php } ?>
						<?php if(isset($_SESSION['userType']) && ($_SESSION['userType']  == 'Admin')) {	?>					
							<li><a href="register.php" >Admin Page</a></li>
						<?php } ?>
						<?php if(isset($_SESSION['valid']) && $_SESSION['valid']) {	?>	
						<li><a href="logout.php" >Log Out</a></li>
						<?php } ?>
					</ul>
	</div>
