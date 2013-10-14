<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");
include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
if(isset($_POST['btnNext']) && $_POST['btnNext']=="Next")
{
	require_once("../Utilities/xmlEncode.php");
	$objXmlEncode=new xmlEncode();

	if(isset($_REQUEST["maxCount"])) // edit record
	{
		$strFileName=$_SESSION["strFileName"];
		$handle = fopen($strFileName, "r");
		$contents = fread($handle, filesize($strFileName));
		fclose($handle);
	
		$arrWayPoints=explode("<WayPoints>",$contents);
		
		$strXml="<Tour>";
		$strXml.="<Tourname>".$objXmlEncode->xmlCdataEncode($_POST["txtName"])."</Tourname>";
		$strXml.="<Description>".$objXmlEncode->xmlCdataEncode($_POST["txtTourDescription"])."</Description>";
		$strXml.="<WayPoints>";
		$strXml.=$arrWayPoints[1];
	
		$FileHandle = fopen($strFileName, 'w') or die("can't open file");
		fwrite($FileHandle,$strXml);
		fclose($FileHandle);
		header("location:WayPointForm.php?counter=1&maxCount=".$_REQUEST["maxCount"]);
		exit;
	}
	else // add recorde
	{
		$strXml="<Tour>";
		$strXml.="<Tourname>".$objXmlEncode->xmlCdataEncode($_POST["txtName"])."</Tourname>";
		$strXml.="<Description>".$objXmlEncode->xmlCdataEncode($_POST["txtTourDescription"])."</Description>";
		$strXml.="<WayPoints>";
		$strXml.="</WayPoints>";
		$strXml.="</Tour>";
	
		$strFileName="xmlFiles/GPSTagging_".session_id().".xml";	
		session_start();
		$_SESSION["strFileName"]=$strFileName;
		$FileHandle = fopen($strFileName, 'w') or die("can't open file");
		fwrite($FileHandle,$strXml);
		fclose($FileHandle);
		header("location:WayPointForm.php?counter=1&maxCount=0");
		exit;
	}
}

if(isset($_REQUEST["maxCount"]))
{
	$strFileName=$_SESSION["strFileName"];
	$strXml = simplexml_load_file($strFileName) or die(errorFunc()); 
	foreach($strXml as $strTour=>$strTourValue) 
	{
		if ($strTour=="Tourname")
		{
		$txtName=$strTourValue;
		}
		elseif ($strTour=="Description")
		{
		$txtDesc=$strTourValue;
		}
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>GPS Tagging Wizard</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="/IncludeFiles/<?php echo($strSkin); ?>/CSS/Default.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
function validateForm()
{
	if (document.getElementById("txtName").value=="")
	{
		alert("Please specify tour name");
		return false;
	}
	if (document.getElementById("txtTourDescription").value=="")
	{
		alert("Please specify tour description");
		return false;
	}
	return true;
}
</script>
</head>

<body topmargin="0"  leftmargin="0" rightmargin="0" bottommargin="0" >
<form name="frmTourForm" action="" method="post">
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="55" class="GPSTaggingTitleCellBg">
	<table width="778" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="47">&nbsp;</td>
        <td width="731" class="GPSTaggingTitleText">GPS Tagging Wizard</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="7" background="/ImageFiles/<?php echo($strSkin); ?>/GPSTagging/image_02.jpg"></td>
  </tr>
  <tr>
    <td height="56" class="GPSTaggingBodyCellBg"><table width="778" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="48">&nbsp;</td>
        <td width="67" class="style3"><strong class="GPSTaggingBodyTextWhite">Step 1 </strong></td>
        <td width="62"><span class="GPSTaggingBodyText"><strong>Step 2 </strong></span></td>
        <td width="601" class="style3"><strong class="GPSTaggingBodyText">Step 3</strong></td>
      </tr>
      <tr>
        <td height="27">&nbsp;</td>
        <td colspan="3" class="style3"><img src="/ImageFiles/<?php echo($strSkin); ?>/GPSTagging/bullet.gif" width="13" height="15" align="middle"> <span class="GPSTaggingBodyText"><strong>PlaceCast Information</strong></span> </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="778" border="0" cellspacing="0" cellpadding="0" class="GPSTaggingBodyCellBg">
      <tr>
        <td width="289"><img src="/ImageFiles/<?php echo($strSkin); ?>/GPSTagging/image_05.jpg" width="289" height="441"></td>
        <td width="778" valign="top"><table width="446" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="79">&nbsp;</td>
            <td width="134"><span class="GPSTaggingBodyText">Name</span></td>
            <td width="233"><input name="txtName" type="text" id="txtName" value="<?=$txtName;?>"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top" class="GPSTaggingBodyText">Description</td>
            <td><textarea name="txtTourDescription" cols="30" rows="5"><?=$txtDesc;?></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="style3">&nbsp;</td>
            <td>                <input name="Submit2" type="submit" class="GPSTaggingButton" value=" Back " disabled>
              <input name="btnNext" type="submit" class="GPSTaggingButton" value="Next" onClick="return validateForm();"></td></tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="GPSTaggingBodyCellBg">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
