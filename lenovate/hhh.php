<?php

    $mysqli = new mysql("localhost", "root", "w@d@cademy123!!", "zadmin_wnd");
	$result = $mysqli->query("SELECT * FROM category");
	
	while($row=mysqli_fetch_row($result)){
		print_r($row);
	}

?>