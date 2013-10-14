<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");

$objProperties=new Properties();
$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
$strImgeDirectory = $objProperties->getProperty('ads_upload_directory');
//$strImagePath=$strImgeDirectory."/".$_GET['path'];
$strImagePath="Image/".$_GET['path'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ads Image View</title>
</head>

<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign="top" >
		<img src="<?php echo($strImagePath);?>" width="350" height="250" />
	</td>
</tr>		
</body>
</html>
