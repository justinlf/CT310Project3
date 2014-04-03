<h4 class="userListTitle">Friend List</h4>
<hr />
<?php 								
foreach ($friends as $f) {
	if (($f->user1 == $userCompare) && ($f->status == "Accept")){
		foreach ($users as $u) { 
			if ($u->username == $f->user2) {
				foreach ($profiles as $p) {									
					if ($p->username == $u->username) {
						include "userThumb.html";
					}
				}			
			}									
		}
	}
}
?>		
