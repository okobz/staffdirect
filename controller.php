<?php
require_once("function.php");

//get a instance of database connection
$mysqli = connect();

//clean every user inputs
foreach($_REQUEST as $key=>$value)
{
	if(is_string($value))
		$value = mysqli_real_escape_string($mysqli,$value);
	else
	{
		foreach($value as $key2=>$value2)
		{
			if(is_string($value2))
				$value[$key2] = mysqli_real_escape_string($mysqli,$value2);
			else
			{
				foreach($value2 as $key3=>$value3)
					$value[$key2][$key3] = mysqli_real_escape_string($mysqli,$value3);
			}
		}
	}
	$$key = $value;	
}

//
if(isset($action)) 
{
    $user_action = $action;
    $_SESSION['error'] = array();

	if($user_action == 'contact-us')
	{
		
		$response = verifyreCAPTCHA($_POST['g-recaptcha-response']);
		
		if($response == 1){
			//first send email to staff direct
		$to = "staffdirectng@gmail.com";
		$subject = "New Message From Website";
		$message = "Hello, You have 1 New Message.
<br/>
From: $name
<br/>
Email: $email
<br/>
Subject: $subject
<br/>
Message: $message
<br/>
		";
		@sendEmailNotice($to,$subject,$message);

		//next send email to visitor
		$subject_v = "info@staffdirect.ng";
		$message_v = "Thank you for contacting us.<br>We would get back to you soon";
		@sendEmailNotice($email,$subject_v,$message_v);
		
		echo "OK";
		exit;
		}else{
			echo "Google Verification Failed";
		}
	
		
	}//end contact us
	else if($action == "new-sector")
	{	
		$countcaption = count($caption);
		$info="";
		if($countcaption > 0){
			$insert;
			for($e=0;$e<$countcaption;$e++){
				$stmt=$mysqli->prepare("SELECT * FROM sectors WHERE caption = ? LIMIT 1");
				$stmt->bind_param('s', $caption[$e]);
				$stmt->execute();
				if($stmt->get_result()->num_rows == 0){
					$insert=$mysqli->prepare("INSERT INTO sectors (caption, description) VALUES (?,?)");
					$insert->bind_param('ss', $caption[$e], $description[$e]);
					$insert->execute();
				}
			}
			if($insert){
				$insert->close();
				$_SESSION['divborder'] = "success";
				$_SESSION['error'][] = 'Records added successfully.';			
			}else{
				$_SESSION['error'][] = 'Some records could not be added.';
				$_SESSION['alertstyle'] = "alert";				
			}
		}else{
			$_SESSION['error'][] = 'Please enter at least one record.';
			$_SESSION['alertstyle'] = "alert";
		
		}		
		header('Location: sectors.php');
		exit;
	}
	else if($action == "new-division")
	{
		$countcaption = count($caption);
		$info="";
		if($countcaption > 0){
			$insert;
			for($e=0;$e<$countcaption;$e++){
				$stmt=$mysqli->prepare("SELECT * FROM divisions WHERE caption = ? AND sectors_id = ? LIMIT 1");
				$stmt->bind_param('si', $caption[$e],$sectors[$e]);
				$stmt->execute();
				if($stmt->get_result()->num_rows == 0){
					$insert=$mysqli->prepare("INSERT INTO divisions (caption, description, sectors_id) VALUES (?,?,?)");
					$insert->bind_param('ssi', $caption[$e], $description[$e], $sectors[$e]);
					$insert->execute();
				}
			}
			if($insert){
				$insert->close();
				$_SESSION['divborder'] = "success";
				$_SESSION['error'][] = 'Records added successfully.';			
			}else{
				$_SESSION['error'][] = 'Some records could not be added.';
				$_SESSION['alertstyle'] = "alert";				
			}		
		}else{
			$_SESSION['error'][] = 'Please enter at least one record.';
			$_SESSION['alertstyle'] = "alert";
		
		}		
		header('Location: divisions.php');
		exit;
	}
	else if($action == "job-application")
	{
		$response = verifyreCAPTCHA($_POST['g-recaptcha-response']);
		$datetime = date("Y-m-d H:i:s");
		if($response == 1){
			
		//check if cv was uploaded
		$cv_directory = "";
		if($_FILES['cv']['name'] != ""){//cv file was uploaded
			$fileformat = array('doc','pdf');
			$directory = "uploads/cvs";
			$upload = uploadFile("cv",$fileformat,$directory);
			$cv_directory = $upload['picturename'];
		}
		
		//check if picture was uploaded
		$picture_directory = "";
		if($_FILES['picture']['name'] != ""){//picture file was uploaded
			$fileformat = array('jpg','jpeg','png');
			$directory = "uploads/pictures";
			$upload = uploadFile("picture",$fileformat,$directory);
			$picture_directory = $upload['picturename'];
		}
		
		//check if video was uploaded
		$video_directory = "";
		if($_FILES['video']['name'] != ""){//video file was uploaded
			$fileformat = array('mp4');
			$directory = "uploads/videos";
			$upload = uploadFile("video",$fileformat,$directory);
			$video_directory = $upload['picturename'];
		}
		
		//insert values into database
		$stmt=$mysqli->prepare("
			INSERT INTO job_applications (division_id, firstname, lastname, gender, phone, location, email, nysc, cv, picture, video, record_date) 
				VALUES 
				(?,?,?,?,?,?,?,?,?,?,?,?);
		");
		$stmt->bind_param('ssssssssssss', $divisions, $firstname, $lastname, $gender, $phone, $location, $email, $nysc, $cv_directory, $picture_directory, $video_directory, $datetime);
		$stmt->execute();
		$stmt->close();
		
		$_SESSION['divborder'] = "success";
		$_SESSION['error'][] = 'Your Application Submitted successfully. Thank you!';

		}else{
			$_SESSION['error'][] = 'Google Verification Failed.';
		}
		
		header('Location: job-application.php?success=true');
		exit;
	} 
	else if($action == 'get-staff')
	{
		$response = verifyreCAPTCHA($_POST['g-recaptcha-response']);
		$datetime = date("Y-m-d H:i:s");
		if($response == 1){
		//insert values into database
		$stmt=$mysqli->prepare("
			INSERT INTO job_postings (organization, position, job_type, salary_budget, contact_person, phone_number, record_date) 
				VALUES 
				(?,?,?,?,?,?,?);
		");
		$stmt->bind_param('sssssss', $organization, $position, $job_type, $salary_budget, $contact_person, $phone_number, $datetime);
		$stmt->execute();
		$stmt->close();
		
		//next send email to staff direct
		$email = "staffdirectng@gmail.com";
		$subject = "New Job Posting";
		$message = "Hello, You have a New Job Posting
<br/><br/>
<b>Organization:</b> $organization
<br/>
<b>Position:</b> $position
<br/>
<b>Job Type:</b> $job_type
<br/>
<b>Salary Budget:</b> $salary_budget
<br/>
<b>Contact Person:</b> $contact_person
<br/>
<b>Phone Number:</b> $phone_number
<br/>";
		@sendEmailNotice($email,$subject,$message);
		
		$_SESSION['divborder'] = "success";
		$_SESSION['error'][] = 'Your Job Posting has been Submitted successfully. Thank you!';

		}else{
			$_SESSION['error'][] = 'Google Verification Failed.';
		}
		
		header('Location: get-staff.php?success=true');
		exit;
	}
   	else if($action == 'login')
	{
		$nextPage = "login.php";
		$pass = sha1($password);
		$query="SELECT * FROM adminuser WHERE userid = ? AND password = ? LIMIT 1";
		$stmt=$mysqli->prepare($query);
		$stmt->bind_param('ss', $userid, $pass);
		$stmt->execute();
		
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			
			@$u->id = $row['id'];
			@$u->usernames = $row['usernames'];
			@$u->userid = $row['userid'];
			@$u->role = $row['role'];
			
			$_SESSION['sdsession']=$u;
			
			$nextPage = "cpanel.php";
			//$_SESSION['divborder'] = "success";
			//$_SESSION['error'][] = 'Your password updated successfully.';
			
		}else{
			$_SESSION['error'][] = 'Invalid Login Details.';
		}
		
		//$_SESSION['error'][] = '&nbsp;You are not authorized to update this password.';
		//$_SESSION['alertstyle'] = "alert";
		
		
		$stmt->close();
			
		header('Location: ' . $nextPage);//   
		exit;
	}//end login
	else if($action == 'download-excel-posting')
	{
		$csv_output = '';

		$csv_output .= "Organization,,, Position,,, Job Type,,, Salary Budget,,, Contact Person,,, Phone Number,,, Date,,, ";
		$csv_output .= "\n";	
		
		$results = getJobPostings();
		if($results->num_rows > 0){
			$i=0;
			while($c = $results->fetch_assoc()) {
				$csv_output .= $c['organization'].",,, ".$c['position'].",,, ".$c['job_type'].",,, ".$c['salary_budget'].",,, ".$c['contact_person'].",,, ".$c['phone_number'].",,, ".system_date($c['record_date']).",,, ";			
				$csv_output .= "\n";
			}
		}
		
		$filename = "Staff_Direct_Job_Posting".rand(0,20000).'_'.time();

		header("Content-type: application/vnd.ms-excel");
		header("Content-disposition: csv" . date("Y-m-d") . ".csv");
		header( "Content-disposition: filename=".$filename.".csv");
		print $csv_output;
		exit;
	}
	else if($action == 'download-excel-applicants')
	{
		$csv_output = '';

		$csv_output .= "Section,,, Division,,, Lastname,,, Firstname,,, Gender,,, Phone ,,, Location,,, Email,,, NYSC,,, Date,,, ";
		$csv_output .= "\n";	
		
		$results = getJobApplications();
		if($results->num_rows > 0){
			$i=0;
			while($c = $results->fetch_assoc()) {
				$csv_output .= $c['sector'].",,, ".$c['division'].",,, ".$c['lastname'].",,, ".$c['firstname'].",,, ".$c['gender'].",,, ".$c['phone'].",,, ".$c['location'].",,, ".$c['email'].",,, ".$c['nysc'].",,, ".system_date($c['record_date']).",,, ";			
				$csv_output .= "\n";
			}
		}
		
		$filename = "Staff_Direct_Job_Applicants".rand(0,20000).'_'.time();

		header("Content-type: application/vnd.ms-excel");
		header("Content-disposition: csv" . date("Y-m-d") . ".csv");
		header( "Content-disposition: filename=".$filename.".csv");
		print $csv_output;
		exit;
	}
    
}
else
{
	die("Action Parameter Must be Set to Continue.");
	exit;
}
   
 
?>