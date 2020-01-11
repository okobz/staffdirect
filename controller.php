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
    $myresponse = "login";
	$_SESSION['error'] = array();

	if($user_action == 'contact-us')
	{
	
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
	}//end contact us
	else if($action == "job-application")
	{
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
			INSERT INTO job_applications (division_id, firstname, lastname, gender, phone, location, email, nysc, cv, picture, video) 
				VALUES 
				(?,?,?,?,?,?,?,?,?,?,?);
		");
		$stmt->bind_param('sssssssssss', $divisions, $firstname, $lastname, $gender, $phone, $location, $email, $nysc, $cv_directory, $picture_directory, $video_directory);
		$stmt->execute();
		$stmt->close();
		
		
		header('Location: job-application.php?success=true');
		exit;
	}  
   	else if($user_action == 'login')
	{
		
	}//end login
       //$myresponse = login();

   	header('Location: ' . $myresponse);//   
	exit;
}
else
{
	die("Action Parameter Must be Set to Continue.");
	exit;
}
   
 
?>