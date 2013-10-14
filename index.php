<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/SignInService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

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

<script type="text/javascript" src="/IncludeFiles/Javascript/Tooltip.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/ClientChecks.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/CustomerSignIn.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script language="javascript">
check4CookieSupport();
var obj = <?= NAJAX_Client::register(new SignInService()) ?>;
function createXml()
{
	if(ValidateFormLogin())
	{
		document.getElementById("loading").style.display="inline";	

		if(document.getElementById("cmbCustomerType").value==1) // for consumer
		{
			var strResonse=obj.ConsumerSignIn(document.getElementById("txtEmail").value,document.getElementById("txtPassword").value,document.getElementById("chkRemeberMe").checked,function(result)
			{
				parseXMLResponse(result);
			});		
		}	
		else if(document.getElementById("cmbCustomerType").value==2) // for producer
		{
			var strResonse=obj.ProducerSignIn(document.getElementById("txtEmail").value,document.getElementById("txtPassword").value,document.getElementById("chkRemeberMe").checked,function(result)
			{
				parseXMLResponse(result);
			});	
		}	
	}
}

function parseXMLResponse(pResponse)
{
		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var strResonse=pResponse;
		
		XMLDoc.async = "false";
		// For Internet Explorer	  
		if (window.ActiveXObject)
		{		
			if(XMLDoc.loadXML(strResonse)==true)
			{
		
				rootNode=XMLDoc.documentElement;
				strStatus=rootNode.selectSingleNode("Status").text;
				
				if(strStatus=="ok")
				{
					document.getElementById("tr_id").style.display = 'none';
					location.href=document.getElementById("urlAfterLogin").value;
				}
				else if(strStatus=="EmailNotExists")
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=EMAIL_NOT_EXISTS;
					document.getElementById("tr_id").style.display = 'inline';			
					document.getElementById("error").focus();			
				}
				else  if(strStatus=="PasswordNotCorrect")
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=PASSWORD_NOT_CORRECT;
					document.getElementById("tr_id").style.display = 'inline';			
					document.getElementById("error").focus();			
				}
			
			}
		}
		else
		{
			
			var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
			var strResponse = xmlDoc.getElementsByTagName('Response');
			var strStatus = strResponse[0].getElementsByTagName('Status')[0].textContent;

			if(strStatus=="ok")
			{
				document.getElementById("tr_id").style.display = 'none';
				location.href=document.getElementById("urlAfterLogin").value;
			}
			else if(strStatus=="EmailNotExists")
			{
				document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
				document.getElementById("divError").innerHTML=EMAIL_NOT_EXISTS;
				document.getElementById("tr_id").style.display = 'inline';			
				document.getElementById("error").focus();			
			}
			else  if(strStatus=="PasswordNotCorrect")
			{
				document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
				document.getElementById("divError").innerHTML=PASSWORD_NOT_CORRECT;
				document.getElementById("tr_id").style.display = 'inline';			
				document.getElementById("error").focus();			
			}
			
		}	
		document.getElementById("loading").style.display="none";
}
function GetXmlHttpObject()
{ 
	var objXMLHttp=null;
	if (window.XMLHttpRequest)
	{
		objXMLHttp = new DOMParser();
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp=new ActiveXObject("Microsoft.XMLDOM");
	}
	return objXMLHttp;
} 
</script>

<script src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/Javascript/LeftMenu.js"></script>
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
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
  <tr  class="RegistrationCellBg">
    <td width="32"  height="27">&nbsp;</td>
    <td width="616" align="left" valign="middle"><p class="RegistrationTitleText">Welcome to MCE </p></td>
  </tr>
  <tr valign="top">
    <td height="417" colspan="2" class="RegistrationBodyText"><p>&nbsp;</p>
        <p align="center"><br>
            <br>
            <img src="/ImageFiles/common/warning.gif" width="15" height="15"> Under-Construction</p></td>
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
