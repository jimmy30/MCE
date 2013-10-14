<?php 

require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/SignInService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

	$objReg = new SignInService();
	NAJAX_Server::allowClasses("SignInService");
	if (NAJAX_Server::runServer()) 
	{
		exit;
	}

?>

<?php 
	echo(NAJAX_Utilities::header('/IncludeFiles/PHP/Najax'));
	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/userTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>MCE-Customer Registration</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script  language="javascript" type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js">
</script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script language="javascript">
var obj = <?= NAJAX_Client::register(new SignInService()) ?>;

function createXml()
{

		document.getElementById("loading").style.display="inline";	

		if(<?php echo $_REQUEST["id"]?>==1) // for consumer
			var strResonse=obj.ConsumerSignIn('<?php echo $_SESSION[sessionKeys::USER_EMAIL]?>','<?php echo base64_decode($_SESSION[sessionKeys::USER_PASSWORD])?>',0,function(result){parseXMLResponse(result);});		
		else if(<?php echo $_REQUEST["id"]?>==2) // for producer
			var strResonse=obj.ProducerSignIn('<?php echo $_SESSION[sessionKeys::USER_EMAIL]?>','<?php echo base64_decode($_SESSION[sessionKeys::USER_PASSWORD])?>',0,function(result){parseXMLResponse(result);});	

}

function parseXMLResponse(pResponse)
{
		var XMLDoc=GetXmlHttpObject();
		if (window.ActiveXObject)
		{
			var rootNode = "";
			var strStatus="";
			var strResonse=pResponse;
			XMLDoc.async = "false";
			if(XMLDoc.loadXML(strResonse)==true)
			{
				rootNode=XMLDoc.documentElement;
				strStatus=rootNode.selectSingleNode("Status").text;
				if(strStatus=="ok")
				{
				if(<?php echo $_REQUEST["id"]?>==2) // for consumer					
					location.href='Placecast/Producer/viewPlaceCast.php';					
				else if(<?php echo $_REQUEST["id"]?>==1) // for Producer
					location.href='Placecast/Consumer/viewPlaceCast.php';					


				}
				else if(strStatus=="EmailNotExists")
				{
					document.getElementById("divError").innerHTML=PRODUCER_EMAIL_NOT_EXISTS;
					document.getElementById("error").focus();			
				}
				else  if(strStatus=="PasswordNotCorrect")
				{
					document.getElementById("divError").innerHTML=PASSWORD_NOT_CORRECT;
					document.getElementById("error").focus();			
				}
			}
		} 
		else
		{
			
			var xmlDoc = XMLDoc.parseFromString(pResponse, "application/xml");
	    	var strResponse = xmlDoc.getElementsByTagName('Response');
			var strStatus = strResponse[0].getElementsByTagName('Status')[0].textContent;

				if(strStatus=="ok")
				{
				if(<?php echo $_REQUEST["id"]?>==2) // for consumer					
					location.href='Placecast/Producer/viewPlaceCast.php';					
				else if(<?php echo $_REQUEST["id"]?>==1) // for Producer
					location.href='Placecast/Consumer/viewPlaceCast.php';					


				}
				else if(strStatus=="EmailNotExists")
				{
					document.getElementById("divError").innerHTML=PRODUCER_EMAIL_NOT_EXISTS;
					document.getElementById("error").focus();			
				}
				else  if(strStatus=="PasswordNotCorrect")
				{
					document.getElementById("divError").innerHTML=PASSWORD_NOT_CORRECT;
					document.getElementById("error").focus();			
				}
		}
		document.getElementById("loading").style.display="none";

}
		
function GetXmlHttpObject()
{ 
	var objXMLHttp=null
	if (window.XMLHttpRequest)
	{
		objXMLHttp = new DOMParser();
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp=new ActiveXObject("Microsoft.XMLDOM")
	}
	return objXMLHttp
} 
</script>
<!-- InstanceEndEditable -->
<script src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/Javascript/LeftMenu.js"></script>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="1001" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/header.php");?></td>
  </tr>
  <tr>
    <td width="149" rowspan="2" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/LeftMenu.php");?></td>
    <td width="670" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/tabs.php");?></td>
    <td width="175" rowspan="2" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/rightMenu.php");?></td>
  </tr>
  <tr>
    <td height="418" align="left" valign="top"><!-- InstanceBeginEditable name="body" -->
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder" height="100%">
  <tr  class="RegistrationCellBg">
    <td width="664" height="27"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Switching</p></td>
    </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr align="left" valign="top">
    <td><table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="126" align="center"><div id="loading" class="RegistrationBodyText" align="center">Please wait... <img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div><div align="left" id="divError"> </div></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
<!-- InstanceEndEditable --> </td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/footer.php");?></td>
  </tr>
</table>
<script language="JavaScript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/JavaScript/tmenu.js"></script>
</body>
<!-- InstanceEnd --></html>
<script language="javascript">createXml();</script>
