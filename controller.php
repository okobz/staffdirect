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
		$to = "ofoefule.c@gmail.com";//staffdirectng@gmail.com
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