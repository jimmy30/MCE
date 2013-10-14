<?php

require_once('ManageFile.php');
$objFileUpload=new ManageFile();
$intCounter=0;
while(list($key,$value) = each($_FILES[fileupload][name]))
{
	if(!empty($value))
	{
	   // this will check if any blank field is entered
		$strFileName = $value;    // filename stores the value
		$objFileUpload->setFileName($strFileName);
		$objFileUpload->setTempFileName($_FILES[fileupload][tmp_name]);
		//echo($objFileUpload->uploadFile($intCounter)."<br>");
		$arrResult=$objFileUpload->uploadFile($intCounter);
		echo($arrResult);
	}	
	$intCounter++;
}
$url="Location:FileDetail.php";
header($url); 
?>
