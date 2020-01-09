<html>
	<head>
		<title>Test Form</title>
	</head>

	<body>
	
		<form method="post" action="function.php">
		
			<input type="text" name="email" value="" /><br>
			<input type="text" name="phone" value="" /><br>
			
			<input type="hidden" name="cmd" value="login" /><br>
		
			<input type="submit" name="form-submit" value="submit" /><br>
		</form>
	
	</body>
	
</html>


<?

$resultarray=array("status"=>"success", "message"=>"Student details retrieved", "StudentFirstName"=>"Ifeanyi", "StudentLastName"=>"Ofoefule chris", "StudentAdmissionNumber"=>"2005/127922", "StudentPhoto"=>"https://salemcare.en-trance.com/assets/images/1/1567848990Picture1.jpg", "StudentCurrentStatus"=>"Active", "StudentClass"=>"Pri 5A", "Guardians"=>"Mr Ofoefule", "TotalGuardians"=>"90");
$output =json_encode($resultarray, JSON_UNESCAPED_SLASHES);
    echo $output;
	
?>