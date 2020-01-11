<?php
	require_once("function.php");

	$action = $_REQUEST['action'];
	
	if($action == "load_divisions"){
		$sectorid = $_REQUEST['sectorid'];
		
		
		$mysqli=  connect();
		$stmt=$mysqli->prepare("SELECT * FROM divisions WHERE sectors_id=?");
		$stmt->bind_param('i', $sectorid);
		$stmt->execute();		
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			//echo '<option value="">Select A Division</option>';
			while($row = $result->fetch_assoc()) {
				echo "<option value='".$row['id']."'>".$row['caption']."</option>";
			}
		}
	}
?>
