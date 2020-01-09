<?php

$mysqli = connect();

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

function connect(){
    //$mysqli = new mysqli("localhost", "root", "server.cloud", "kingskid_database");
    $mysqli = new mysqli("localhost", "staffdir_user01", "keBLyUJjr-2r", "staffdir_database");
	if ($mysqli->connect_errno) {
		die("Connection failed: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        return false;
	}
    return $mysqli;
}
function fetchAssocStatement($stmt)
{
    if($stmt->num_rows>0)
    {
        $result = array();
        $md = $stmt->result_metadata();
        $params = array();
        while($field = $md->fetch_field()) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if($stmt->fetch())
            return $result;
    }

    return null;
}

function schoolinfo($id){
    $mysqli=  connect();
    $stmt=$mysqli->prepare("SELECT * FROM schools WHERE school_id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $row= fetchAssocStatement($stmt);
    $stmt->close();
            return $row;
}

function useraccess($uid, $sid){
     $mysqli=  connect();
    $stmt=$mysqli->prepare("SELECT * FROM uac WHERE user_id=? AND school_id=?");
    $stmt->bind_param('ii', $uid, $sid);
    $stmt->execute();
    $stmt->store_result();
    $row= fetchAssocStatement($stmt);
    $stmt->close();
            return $row;
}

function getuser(){
    $mysqli=  connect();
    $query="SELECT * FROM adminupdate ORDER BY id DESC LIMIT 7";
    
    $stmt=$mysqli->prepare($query);
    $stmt->execute();
	
    //$stmt->store_result();
	
	$result = $stmt->get_result();
	if($result->num_rows > 1){
		
		while($row = $result->fetch_assoc()) {
			echo $row['updatetype']."<br>";
		}

	}
	
	
    //$row = fetchAssocStatement($stmt);
    //return $row;
}

function sendEmailNotice($to,$subject,$message){
	require_once("mailer/class.phpmailer.php");	
	$mail = new PHPMailer();
	
	//$mail->IsSMTP();                                      // set mailer to use SMTP
	$mail->Host = "localhost";  // specify main and backup server
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	//password: info_pass_01
	$mail->From = "careers.staffdirect@gmail.com";
	$mail->FromName = "Admin@StaffDirect";
	$mail->AddAddress($to);
	
	$mail->WordWrap = 50;                                 // set word wrap to 50 characters

	$mail->IsHTML(true);                                  // set email format to HTML
	$message = $message."
	<br /><br />Best Regards,
	<br />The Director
	<br />Staff Direct
	<br /> +234 811 084 0316 ";
	
	$mail->Subject = $subject;
	$mail->Body    = "
<table align='center' style='width:70%;' cellpadding='10' cellspacing='10'>
   <tr>
	  <td style='background: #3993ba;background: -moz-linear-gradient(top, #3993ba 0%, #3993ba 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3993ba), color-stop(100%,#3993ba));background: -webkit-linear-gradient(top, #3993ba 0%,#067ead 100%);background: -o-linear-gradient(top, #3993ba 0%,#3993ba 100%);background: -ms-linear-gradient(top, #3993ba 0%,#067ead 100%);background: linear-gradient(top, #067ead 0%,#3993ba 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#067ead', endColorstr='#3993ba',GradientType=0 );color:#FFFFFF;'>	  
		<img alt='Staff Direct Logo' src='img/logo3.png'> Staff Direct
	  </td>
	</tr>
	<tr>
	  <td align='left' style='font-family:Tahoma, Geneva, sans-serif;font-size:13px;color:#414141'>".$message."</td>
	</tr>
	<tr>
	  <td align='left'><hr></hr></td>
	</tr>
	<tr>
	  <td align='left' style='font-family:Tahoma, Geneva, sans-serif;font-size:11px;color:grey'>
	  	This message was sent to ".$to." courtesy of Staff Direct.<br>
		<a style='color:#4c7cbd' href='http://staffdirect.ng/'>Staff Direct</a>
		&copy; ".date('Y')."	  
	  </td>
	</tr>
</table>		
	";
	//echo $mail->Body; exit;
	@$mail->Send();//send email	
	
}
?>
