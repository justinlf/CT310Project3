<h4 class="userListTitle">Friend List</h4>
<hr />
<?php 								
foreach ($friends as $f) {
	if (($f->user1 == $userCompare || $f->user2 == $userCompare ) && ($f->status == "Accept")){
		foreach ($users as $u) { 
			if ($f->user1 == $userCompare && $u->username == $f->user2) {
				foreach ($profiles as $p) {									
					if ($p->username == $u->username) {
						include "userThumb.html";
					}
				}			
			}	
			else if ($f->user2 == $userCompare && $u->username == $f->user1) {
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
