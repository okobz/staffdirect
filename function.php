<?php
session_start();
/*

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

*/

function connect(){
    $mysqli = new mysqli("localhost", "root", "server.cloud", "staffdirect");
    //$mysqli = new mysqli("localhost", "staffdir_user01", "keBLyUJjr-2r", "staffdir_database");
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

function getSectors(){
    $mysqli=  connect();
    $query="SELECT * FROM sectors ORDER BY id ASC";
    
    $stmt=$mysqli->prepare($query);
    $stmt->execute();
	
	return $stmt->get_result();
	
	/*
	$results = array();
	
	if($stmt->get_result()->num_rows > 0){
		$results = $stmt->get_result();
	}
	
	return $results;
	*/
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
	$mail->From = "info@staffdirect.ng";
	$mail->FromName = "Admin@StaffDirect";
	$mail->AddAddress($to);
	
	$mail->WordWrap = 50;                                 // set word wrap to 50 characters

	$mail->IsHTML(true);                                  // set email format to HTML
	$message = $message."
	<br /><br />Best Regards,
	<br />Staff Direct
	<br /> +234 811 084 0316 ";
	
	$mail->Subject = $subject;
	$mail->Body    = "
<table align='center' style='width:70%;' cellpadding='10' cellspacing='10'>
   <tr>
	  <td style='background:#ffffff;'>	  
		<img src='http://staffdirect.ng/img/logo2.png' /> Staff Direct
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







function uploadFile($varname,$fileformat,$directory){
	$file_name = $_FILES[$varname]['name'];				 
	$upload="false";
	$uerr = checkUploadedFile($varname,$fileformat);
	
	if($uerr==""||$uerr==NULL||empty($uerr)){
		
		$file_name = date("Ymd").'_'.time().".".strtolower(getExtension($file_name));

		$picturename = $directory."/" . $file_name;
		
		if(!is_dir($directory)){
			if(!mkdir($directory, 0777, TRUE)){
			}
		} 
		
		move_uploaded_file ($_FILES[$varname]['tmp_name'], $picturename);
		
		/*
		if($width==""&&$height==""){
			
		}else{			
			$resizewidth = $width;
			$resizeheight = $height;
			uploadImageResize($resizewidth,$resizeheight,$picturename,$type);
		}
		*/
		//echo $picturename;exit;			
		$return['upload']="true";			 
		$return['picturename']=$picturename;			 
	}
	return($return);
}
function checkUploadedFile($varname,$fileformat){
 	$uerr = NULL;
    try {
		
        if (!array_key_exists($varname, $_FILES)) {
			$uerr ="FILENOTFOUND";
            throw new Exception('File not found in uploaded data');
        }
 
        $image = $_FILES[$varname];
		$file_name = $_FILES[$varname]['name'];
 
        // ensure the file was successfully uploaded
        assertValidUpload($image['error']);
 
        if (!is_uploaded_file($image['tmp_name'])) {
			$uerr ="FILENOTUPLOADED";
            throw new Exception('File is not an uploaded file');
        }
 
        $allowable = $fileformat;// CHECK FILE FORMAT	
		$mytype = end(explode('.',strtolower($file_name)));//becos in_array is case sensitive
 		//echo "<pre>".print_r($allowable)."</pre>"; exit;
        if (!in_array($mytype,$allowable)) {
			$uerr ="FILEFORMATNOTALLOWED";
            throw new Exception('Uploaded file format not supported');
        }
        if ($image['size'] > (5*1024*1024)) {
			$uerr ="FILESIZETOOBIG";
            throw new Exception('Maximum file upload of 5MB exceeded');
        }

    }
    catch (Exception $ex) {
        $_SESSION['imageerrors'][] = $ex->getMessage();
		$_SESSION['alerterror'] = "true";
    }
	return $uerr;
}
function assertValidUpload($code)
{
	if ($code == UPLOAD_ERR_OK) {
		return;
	}

	switch ($code) {
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			$msg = 'Image is too large';
			break;

		case UPLOAD_ERR_PARTIAL:
			$msg = 'Image was only partially uploaded';
			break;

		case UPLOAD_ERR_NO_FILE:
			$msg = 'No image was uploaded';
			break;

		case UPLOAD_ERR_NO_TMP_DIR:
			$msg = 'Upload folder not found';
			break;

		case UPLOAD_ERR_CANT_WRITE:
			$msg = 'Unable to write uploaded file';
			break;

		case UPLOAD_ERR_EXTENSION:
			$msg = 'Upload failed due to extension';
			break;

		default:
			$msg = 'Unknown error';
	}

	throw new Exception($msg);
}
function getExtension($str) {

	 $i = strrpos($str,".");
	 if (!$i) { return ""; } 

	 $l = strlen($str) - $i;
	 $ext = substr($str,$i+1,$l);
	 return $ext;
}
?>