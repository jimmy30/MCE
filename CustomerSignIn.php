<?php 

require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/SignInService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");

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
var obj = <?= NAJAX_Client::register(new SignInService()) ?>;
function createXml()
{
	if(ValidateFormLogin())
	{
		document.getElementById("loading").style.display="inline";	

		if(document.getElementById("cmbCustomerType").value==1) // for consumer
			var strResonse=obj.ConsumerSignIn(document.getElementById("txtEmail").value,document.getElementById("txtPassword").value,document.getElementById("chkRemeberMe").checked,function(result){parseXMLResponse(result);});		
		else if(document.getElementById("cmbCustomerType").value==2) // for producer
			var strResonse=obj.ProducerSignIn(document.getElementById("txtEmail").value,document.getElementById("txtPassword").value,document.getElementById("chkRemeberMe").checked,function(result){parseXMLResponse(result);});	
	}
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
					document.getElementById("tr_id").style.display = 'none';
				if(document.getElementById("cmbCustomerType").value==1) // for consumer					
					location.href=document.getElementById("urlAfterLoginConsumer").value;					
				else if(document.getElementById("cmbCustomerType").value==2) // for Producer
					location.href=document.getElementById("urlAfterLoginProducer").value;					


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
			
			var xmlDoc = XMLDoc.parseFromString(pResponse, "application/xml");
	    	var strResponse = xmlDoc.getElementsByTagName('Response');
			var strStatus = strResponse[0].getElementsByTagName('Status')[0].textContent;

			if(strStatus=="ok")
			{
				document.getElementById("tr_id").style.display = 'none';
				if(document.getElementById("cmbCustomerType").value==1) // for consumer
					location.href=document.getElementById("urlAfterLoginConsumer").value;

				if(document.getElementById("cmbCustomerType").value==2) // for Producer
					location.href=document.getElementById("urlAfterLoginProducer").value;
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
	<form id="frmCustomerSignIn" action="" method="post">
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder" height="100%">
  <tr  class="RegistrationCellBg">
    <td  height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;C<span class="RegistrationTitleText">ustomer Sign In </span></p>      </td>
    </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr id="tr_id" style="display:none">
    <td width="32" bgcolor="FFFFAE" height="26">&nbsp;</td>
    <td width="632" bgcolor="FFFFAE" align="left" valign="middle">
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
  <tr valign="top">
    <td colspan="2"><table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td height="29" colspan="2" align="left" class="RegistrationBodyText"><strong><font color="red" size="3">*</font>Email: </strong></td>
          <td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left" valign="middle"><input name="txtEmail" type="text" id="txtEmail" size="30" <?php if(isset($_COOKIE['RemeberMeEmail']) && $_COOKIE['RemeberMeEmail']!="") echo "value=".$_COOKIE['RemeberMeEmail']."";?>>
              <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CUSTOMER_SIGNIN_EMAIL_TOOLTIP,325)" onMouseout='hideddrivetip()'> </td>
        </tr>
        <tr>
          <td colspan="2" align="left">&nbsp;</td>
          <td colspan="2" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td height="29" colspan="2" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Password : </strong></td>
          <td colspan="2" align="left">&nbsp;</td>
        </tr>
        <tr valign="middle">
          <td colspan="4" align="left"><input name="txtPassword" type="password" id="txtPassword" size="30" <?php if(isset($_COOKIE['RemeberMePassword']) && $_COOKIE['RemeberMePassword']!="") echo "value=".$_COOKIE['RemeberMePassword']."";?>>
              <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CUSTOMER_SIGNIN_PASSWORD_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left" class="RegistrationBodyText"><strong>as: 
              <label>              </label>
          </strong>
            <label><select name="cmbCustomerType" id="cmbCustomerType">
              <option value="1" <?php if(isset($_COOKIE['SignInAs']) && $_COOKIE['SignInAs']=="1") echo "selected"?>>Consumer</option>
              <option value="2" <?php if(isset($_COOKIE['SignInAs']) && $_COOKIE['SignInAs']=="2") echo "selected"?>>Producer</option>
            </select>
            </label></td>
        </tr>
        <tr>
          <td colspan="4" align="left" class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left" class="RegistrationBodyText"><input name="chkRemeberMe" type="checkbox" id="chkRemeberMe" value="1" <? if(isset($_COOKIE['RemeberMeEmail']) && $_COOKIE['RemeberMeEmail']!="") echo "checked";?>>
            Remember me on this computer </td>
        </tr>
        <tr>
          <td colspan="4" align="left">
		 

            <input type="hidden" id="urlAfterLoginConsumer" name="urlAfterLoginConsumer" value="<?php if(isset($_POST["urlAfterLoginConsumer"]) && $_POST["urlAfterLoginConsumer"]!="") echo $_POST["urlAfterLoginConsumer"]; else echo "/placecast/consumer/viewPlaceCast.php";?>">
            <input type="hidden" id="urlAfterLoginProducer" name="urlAfterLoginProducer" value="<?php if(isset($_POST["urlAfterLoginProducer"]) && $_POST["urlAfterLoginProducer"]!="") echo $_POST["urlAfterLoginProducer"]; else echo "/placecast/producer/viewPlaceCast.php";?>">			
			            <input id = "IsMsg" type="hidden" name="IsMsg" value="<?php if(isset($_POST["IsMsg"]) && $_POST["IsMsg"]!="") echo $_POST["IsMsg"]; ?>">
&nbsp; </td>
        </tr>
        <tr>
          <td width="132" align="left"><input name="Submit" type="Button" class="RegistrationButton" value="Sign In" onClick="createXml()"></td>
          <td colspan="2" align="left"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="left"><div align="right"><a href="ForgetPassword.php" class="LinkSmall">Forget Password </a></div></td>
          <td width="199" align="left">&nbsp;</td>
          <td width="312" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left"><span class="RegistrationBodyText">If you are not a Member <a href="/SignUpOption.php" class="LinkSmall">SignUp Now!</a></span></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
    <!-- InstanceEndEditable --> </td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/footer.php");?></td>
  </tr>
</table>
<script language="JavaScript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/JavaScript/tmenu.js"></script>
</body>
<!-- InstanceEnd --></html>
<script language="javascript">
if(document.getElementById("IsMsg").value==1)
{
	document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
	document.getElementById("divError").innerHTML=PRODUCER_SIGNIN_AUTHENTICATION_REQUIRE;
	document.getElementById("tr_id").style.display = 'inline';			
	document.getElementById("error").focus();		
}	

</script>