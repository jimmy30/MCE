<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ConsumerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Alert/SmsAlerts/EditSmsAlertsService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

try
{
	$objReg = new EditSmsAlertsService();
	NAJAX_Server::allowClasses("EditSmsAlertsService");
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
<title>MCE-Modify Waypoint</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script  language="javascript" type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js">
</script>

<script type="text/javascript" src="/IncludeFiles/Javascript/Alert/SmsAlerts/EditSmsAlerts.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>
<script language="javascript">

var obj = <?= NAJAX_Client::register(new EditSmsAlertsService()) ?>;

function createXml()
{
	if(ValidateForm())
	{
		try
		{
			var objDate = new Date();
			var currentDate='';
			var country;
			var add = 0;
			var modify = 0;
			var status;

			if(document.frmEditSmsAlert.rdoCountry[0].checked)
				country = document.frmEditSmsAlert.rdoCountry[0].value;
			else if(document.frmEditSmsAlert.rdoCountry[1].checked)
				country = document.frmEditSmsAlert.cmbCountryRegion.value;
			
			if(document.frmEditSmsAlert.chkAdd.checked)
				add = document.frmEditSmsAlert.chkAdd.value;
				
			if(document.frmEditSmsAlert.chkModify.checked)
				modify = document.frmEditSmsAlert.chkModify.value;
			
			if(document.frmEditSmsAlert.rdoStatus[0].checked)
				status = document.frmEditSmsAlert.rdoStatus[0].value;
			else if(document.frmEditSmsAlert.rdoStatus[1].checked)
				status = document.frmEditSmsAlert.rdoStatus[1].value;			

			document.getElementById("loading").style.display="inline";
			obj.UpdateAlert(
								'<?php echo $_REQUEST["id"]?>',
								'<?php echo $_SESSION[sessionKeys::USER_ID]?>',
								country,
								add,
								modify,
								status,
								function(result)
								{

									parseXMLResponse(result);
								});

			

		}
		catch(e)	
		{
			alert(e.message);
		}
	
	}
}

function parseXMLResponse(pResponse)
{
		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var intExceptionNo="";
		var strExceptionName="";
		var strResonse=pResponse;

		XMLDoc.async = "false";

		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(strResonse)==true)
			{
		
				rootNode=XMLDoc.documentElement;
				strStatus=rootNode.selectSingleNode("Status").text;
				
				if(strStatus=="ok")
				{
					document.getElementById("strip_image").src="/ImageFiles/common/done.gif";
					document.getElementById("divError").innerHTML=SMS_ALERT_SUCCUSSFULLY_UPDATED;
				}
				else if(strStatus==-1)
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=CONSUMER_ALL_COUNRY_ERROR;

				}
				else if(strStatus==0)
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=CONSUMER_SAME_COUNRY_ERROR;
				}
				document.getElementById("tr_id").style.display = 'inline';			
				document.getElementById("error").focus();			
	
			}
		}
		else
		{

			var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
			var strResponse = xmlDoc.getElementsByTagName('Response');
			var strStatus = strResponse[0].getElementsByTagName('Status')[0].textContent;
			
				if(strStatus=="ok")
				{
					document.getElementById("strip_image").src="/ImageFiles/common/done.gif";
					document.getElementById("divError").innerHTML=SMS_ALERT_SUCCUSSFULLY_UPDATED;
				}
				else if(strStatus==-1)
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=CONSUMER_ALL_COUNRY_ERROR;

				}
				else if(strStatus==0)
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=CONSUMER_SAME_COUNRY_ERROR;
				}
			document.getElementById("tr_id").style.display = 'inline';			
			document.getElementById("error").focus();	
			
		}	
	document.getElementById("loading").style.display="none";
}

function getConsumerAlert()
{

	var strResonse=obj.GetConsumerAlertById('<?php echo $_REQUEST["id"]?>',1,function(result)
	{

		parseXMLConsumerAlert(result);
	});

}

function parseXMLConsumerAlert(pResponse)
{
		var XMLDoc =GetXmlHttpObject();
		var strResonse=pResponse;
		XMLDoc.async = "false";
		//  For Internet Explorer
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(strResonse)==true)
			{
				rootNode=XMLDoc.documentElement;
				if(rootNode.selectSingleNode("CountryId").text==-1)
				{

					document.frmEditSmsAlert.cmbCountryRegion.disabled = true;
					document.frmEditSmsAlert.rdoCountry[0].checked = true;
				}
				else
				{

					document.frmEditSmsAlert.rdoCountry[1].checked = true;
					document.frmEditSmsAlert.cmbCountryRegion.value = rootNode.selectSingleNode("CountryId").text
				}
				
				if(rootNode.selectSingleNode("Add").text==1)
					document.frmEditSmsAlert.chkAdd.checked = true;

				if(rootNode.selectSingleNode("Modify").text==1)
					document.frmEditSmsAlert.chkModify.checked = true;

				if(rootNode.selectSingleNode("IsActive").text==1)
					document.frmEditSmsAlert.rdoStatus[0].checked = true;
				else if(rootNode.selectSingleNode("IsActive").text==0)
					document.frmEditSmsAlert.rdoStatus[1].checked = true;

			}
		}	
		// For other browser eg. FireFox
		else
		{
			var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
			var strConsumerAlert = xmlDoc.getElementsByTagName('SmsAlert');
		
				intCountryId = strConsumerAlert[0].getElementsByTagName('CountryId')[0].textContent;
				intAdd = strConsumerAlert[0].getElementsByTagName('Add')[0].textContent;
				intModify = strConsumerAlert[0].getElementsByTagName('Modify')[0].textContent;
				intIsActive = strConsumerAlert[0].getElementsByTagName('IsActive')[0].textContent;
				
				if(intCountryId==-1)
				{
					document.frmEditSmsAlert.cmbCountryRegion.disabled = true;
					document.frmEditSmsAlert.rdoCountry[0].checked = true;
				}
				else
				{
					document.frmEditSmsAlert.rdoCountry[1].checked = true;
					document.frmEditSmsAlert.cmbCountryRegion.value = intCountryId;
				}
			
			
				if(intAdd==1)
					document.frmEditSmsAlert.chkAdd.checked = true;

				if(intModify==1)
					document.frmEditSmsAlert.chkModify.checked = true;

				if(intIsActive==1)
					document.frmEditSmsAlert.rdoStatus[0].checked = true;
				else if(intIsActive==0)
					document.frmEditSmsAlert.rdoStatus[1].checked = true;
			
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

<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
  <form name="frmEditSmsAlert" action="" method="post" onSubmit="">
    <tr  class="RegistrationCellBg">
      <td align="left" colspan="2" valign="middle"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Edit Sms Alert  </p></td>
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
  </tr>    <tr>
      <td height="5" colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2"><table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="left" valign="middle">
          <td class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr align="left" valign="middle">
          <td width="6548" class="RegistrationBodyText"><strong>Country </strong></td>
        </tr>
        
        <tr>
          <td height="40" align="left" class="RegistrationBodyText">Please identify the country agianst which you want to receive the alerts or you can select all  countries.</td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">&nbsp;&nbsp;
            <input name="rdoCountry" type="radio" value="-1" onClick="chhCountry(-1)">
            All</td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">&nbsp;&nbsp;
            <input name="rdoCountry" type="radio" value="0" onClick="chhCountry(0)"> 
            Select Country:&nbsp;<select name="cmbCountryRegion" id="cmbCountryRegion" style="width:250px">
                    <?php $objReg->FillCmbCountry(1);?>
                </select></td>
        </tr>
        <tr>
          <td height="34" align="left" class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText"><strong>Action  </strong></td>
        </tr>
        <tr>
          <td height="40" align="left" class="RegistrationBodyText">Please identify, on which actions you want to receive alerts or you can select both option. </td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">&nbsp;&nbsp;
            <input name="chkAdd" type="checkbox" id="chkAdd" value="1">
            Add</td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">&nbsp;&nbsp;
            <input name="chkModify" type="checkbox" id="chkModify" value="1">
            Modify</td>
        </tr>
        <tr>
          <td height="29" align="left" class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText"><strong>Status</strong></td>
        </tr>
        <tr>
          <td height="34" align="left" class="RegistrationBodyText">Please select the status of this alert, this will work only in case of Active status </td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">&nbsp;&nbsp;
            <input name="rdoStatus" id="rdoStatus" type="radio" value="1">
            Active              </td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">&nbsp;&nbsp;
            <input name="rdoStatus" id="rdoStatus" type="radio" value="0"> 
            Inactive </td>
        </tr>
      </table></td>
    </tr>
    <tr align="left">
      <td colspan="2"> <table width="660" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="14" align="left" valign="top">&nbsp;</td>
            <td height="14" colspan="2" align="left" valign="top"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
          </tr>
          <tr>
            <td width="169" height="30" align="left" valign="top">&nbsp;</td>
            <td width="154" align="left" valign="top"><input name="Submit" type="Button" class="RegistrationButton" id="Submit" value="Update Sms Alert" onClick="createXml()"></td>
            <td width="337" align="left" valign="top"><input name="Submit" type="Button" class="RegistrationButton" id="cancel" value="Cancel" onClick="javascript:location.href='ViewSmsAlerts.php'"></td>
          </tr>
      </table></td>
    </tr>
  </form>
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
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}

?>
<script language="javascript">getConsumerAlert();</script>