<?php 

require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Registration/ConsumerRegistration/ConsumerActivationService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

	$objReg = new ConsumerActivationService();
	NAJAX_Server::allowClasses("ConsumerActivationService");
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
<script type="text/javascript" src="/IncludeFiles/Javascript/Registration/ConsumerRegistration/ConsumerActivation.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script language="javascript">
var obj = <?= NAJAX_Client::register(new ConsumerActivationService()) ?>;

function createXml()
{

	if(ValidateForm())
	{
		document.getElementById("loading").style.display="inline";	
		var strResonse=obj.ConsumerActivation(document.getElementById("txtEmail").value,document.getElementById("txtCode").value,function(result){parseXMLResponse(result);});
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
					document.getElementById("bodyContatiner").innerHTML=REGISTRATION_ACTIVATION_SUCCESSFUL;
				}
				else
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=EMAIL_NOT_VERIFIED;
					document.getElementById("tr_id").style.display = 'inline';			
					document.getElementById("error").focus();			
					document.getElementById("loading").style.display="none";
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
				document.getElementById("bodyContatiner").innerHTML=REGISTRATION_ACTIVATION_SUCCESSFUL;
			}
			else
			{
				document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
				document.getElementById("divError").innerHTML=EMAIL_NOT_VERIFIED;
				document.getElementById("tr_id").style.display = 'inline';			
				document.getElementById("error").focus();			
				document.getElementById("loading").style.display="none";
			}
			
		}	
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
<table width="670" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
  <tr  class="RegistrationCellBg">
    <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Customer Activation</p></td>
    </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
<tr id="tr_id" style="display:none">
    <td width="47" bgcolor="FFFFAE" height="26">&nbsp;</td>
    <td width="677" bgcolor="FFFFAE" align="left" valign="middle">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="3%"><img src="" width="15" height="15" align="absmiddle" id="strip_image"></td>
          <td width="97%" class="RegistrationBodyText">
            <div align="left" id="divError"> </div></td>
        </tr>
    </table></td>
  </tr>    
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr align="left" valign="top">
    <td colspan="2"><div id="bodyContatiner">
        <table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr valign="top">
            <td height="29" colspan="2" align="left" class="RegistrationBodyText"><strong><font color="red" size="3">*</font>Email: </strong></td>
            <td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"><input name="txtEmail" type="text" id="txtEmail" size="30" value="<?php if(isset($_REQUEST["EMAIL"])) echo $_REQUEST["EMAIL"];?>">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_ACTIVATION_EMAIL_TOOLTIP,325)" onMouseout='hideddrivetip()'> </td>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td height="29" colspan="2" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Activation Code : </strong></td>
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr valign="middle">
            <td colspan="4" align="left"><input name="txtCode" type="text" id="txtCode" size="30" value="<?php if(isset($_REQUEST["id"])) echo $_REQUEST["id"]; ?>">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_ACTIVATION_CODE_TOOLTIP,325)" onMouseout='hideddrivetip()'></td>
          </tr>
          <tr>
            <td colspan="4" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td width="161" align="left"><input name="Submit" type="button" class="RegistrationButton" value="Activate" onClick="createXml()"></td>
            <td width="184" align="left"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
            <td width="127" align="left">&nbsp;</td>
            <td width="228" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="left">&nbsp;</td>
          </tr>
        </table>
    </div></td>
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
