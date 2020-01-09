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
		$to = "ofoefule.c@gmail.com";
		$subject = "New Message From Website";
		$message = "Hello, You have 1 New Message.
From: $name
Email: $email
Subject: $subject
Message: $message
		";
		@sendEmailNotice($to,$subject,$message);

		//next send email to visitor
		$subject_v = "New Contact Message";
		$message_v = "Hello
		$name just sent you a message via the school website:
		$message";
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