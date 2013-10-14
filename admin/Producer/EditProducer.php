<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Producer/EditProducerService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

	$objReg = new EditProducerService();
	NAJAX_Server::allowClasses("EditProducerService");
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
<html><!-- InstanceBegin template="/Templates/adminTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>MCE-Administration</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/IncludeFiles/Javascript/ClientChecks.js"></script>
<script language="JavaScript" type="text/javascript" src="../../IncludeFiles/Javascript/Admin/Producer/EditProducer.js"></script>

<script type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Tooltip.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script language="javascript">
var obj = <?= NAJAX_Client::register(new EditProducerService()) ?>;

function getProducer()
{
	obj.ProducerGetById('<?php echo $_REQUEST["id"]?>',function(result){parseXMLResponse(result);});

}

function parseXMLResponse(pResponse)
{

		var XMLDoc=GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var intExceptionNo="";
		var strExceptionName="";
		var strResonse=pResponse;
		var strHtml='';		

		var intProducerId;
		var intCountryId;
		var intStateId;
		var intAccountType;
		var intQuestionId;
		var strEmail;
		var strPassword;
		var strFirstName;
		var strLastName;
		var strAddress;
		var strCity;
		var strZipCode;
		var strTelephone1;
		var dtDateOfBirth;
		var strAnswer;
		var strActivationCode;
		var intIsVarified;
		var dtCreateDate;
		var intIsActive;
		var strCountryName;
		var strStateName;
		var strQuestion;
		var strAccountType;


		// For Internet Explorer	  
		if (window.ActiveXObject)
		{

			//var XMLDoc =new ActiveXObject("Microsoft.XMLDOM");
			if(strResonse!=null)
			{
				XMLDoc.async = "false";
				if(XMLDoc.loadXML(strResonse)==true)
				{

					rootNode=XMLDoc.documentElement;
			
					intProducerId=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(0).text;
					intCountryId=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(1).text;
					intStateId=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(2).text;
					intAccountType=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(3).text;
					intQuestionId=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(4).text;
					strEmail=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(5).text;
					strPassword=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(6).text;
					strFirstName=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(7).text;
					strLastName=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(8).text;
					strAddress=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(9).text;
					strCity=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(10).text;
					strZipCode=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(11).text;
					strTelephone1=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(12).text;
					dtDateOfBirth=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(13).text;
					strAnswer=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(14).text;
					strActivationCode=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(15).text;
					intIsVarified=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(16).text;
					dtCreateDate=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(17).text;
					intIsActive=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(18).text;
					strCountryName=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(19).text;
					strStateName=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(20).text;
					strQuestion=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(21).text;
					strAccountType=rootNode.selectSingleNode("ProducerList").childNodes.item(0).childNodes.item(22).text;


				}
			}
			else if(intPageNo==1)
			{
				strHtml+='<tr>';
				strHtml+='<td bgcolor="FFFFAE" height=26 colspan=6 class="RegistrationBodyText" align="center"><img src=/ImageFiles/common/warning.gif>&nbsp;'+PRODUCER_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			}

		}
		// For other browser eg. firefox.
		else
		{
			if(strResonse!=null)
			{

				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strProducers = xmlDoc.getElementsByTagName('Producers');
				var strProducerList = xmlDoc.getElementsByTagName('Producer');

				intProducerId=strProducerList[0].getElementsByTagName('ProducerId')[0].textContent;
				intCountryId=strProducerList[0].getElementsByTagName('ProducerCountryId')[0].textContent;
				intStateId=strProducerList[0].getElementsByTagName('ProducerStateId')[0].textContent;
				intAccountType=strProducerList[0].getElementsByTagName('ProducerAccountType')[0].textContent;
				intQuestionId=strProducerList[0].getElementsByTagName('ProducerSecretQuestion')[0].textContent;
				strEmail=strProducerList[0].getElementsByTagName('ProducerEmail')[0].textContent;
				strPassword=strProducerList[0].getElementsByTagName('ProducerPassword')[0].textContent;
				strFirstName=strProducerList[0].getElementsByTagName('ProducerFristName')[0].textContent;
				strLastName=strProducerList[0].getElementsByTagName('ProducerLastName')[0].textContent;
				strAddress=strProducerList[0].getElementsByTagName('ProducerAddress')[0].textContent;
				strCity=strProducerList[0].getElementsByTagName('ProducerCity')[0].textContent;
				strZipCode=strProducerList[0].getElementsByTagName('ProducerZipCode')[0].textContent;
				strTelephone1=strProducerList[0].getElementsByTagName('ProducerTelephone1')[0].textContent;
				dtDateOfBirth=strProducerList[0].getElementsByTagName('ProducerDateOfBirth')[0].textContent;
				strAnswer=strProducerList[0].getElementsByTagName('ProducerAnswer')[0].textContent;
				strActivationCode=strProducerList[0].getElementsByTagName('ProducerActivationCode')[0].textContent;
				intIsVarified=strProducerList[0].getElementsByTagName('ProducerIsVerified')[0].textContent;
				dtCreateDate=strProducerList[0].getElementsByTagName('ProducerCreateDate')[0].textContent;
				intIsActive=strProducerList[0].getElementsByTagName('ProducerIsActive')[0].textContent;
				strCountryName=strProducerList[0].getElementsByTagName('CountryName')[0].textContent;
				strStateName=strProducerList[0].getElementsByTagName('StateName')[0].textContent;
				strQuestion=strProducerList[0].getElementsByTagName('QuestionName')[0].textContent;
				strAccountType=strProducerList[0].getElementsByTagName('AccountType')[0].textContent;

			}	
		}	

		var arrayTelephone = new Array();
		arrayTelephone = strTelephone1.split("-");
		
		var arrayDOB =  new Array();
		arrayDOB = dtDateOfBirth.split("-");

		var arrayDateCreated =  new Array();
		arrayDateCreated = dtCreateDate.split("-");
		
		document.getElementById("ProducerId").innerHTML = intProducerId;
		document.getElementById("txtFirstName").value = strFirstName;
		document.getElementById("txtLastName").value = strLastName;				
		document.getElementById("txtAddress1").value = strAddress;
		document.getElementById("txtCity").value = strCity;
		document.getElementById("cmbCountryRegion").value = intCountryId;
		getListStates();		
		document.getElementById("cmbState").value = intStateId;
		document.getElementById("txtZipCode").value = strZipCode;
		document.getElementById("txtTelephone1").value = arrayTelephone[0];
		document.getElementById("txtExtension").value = arrayTelephone[1];
		document.getElementById("cmbDay").value = arrayDOB[2];
		document.getElementById("cmbMonth").value = arrayDOB[1];
		document.getElementById("txtYear").value = arrayDOB[0];
		document.getElementById("txtEmail").value = strEmail;
		document.getElementById("txtPassword").value = strPassword;
		document.getElementById("txtRePassword").value = strPassword;
		document.getElementById("cmbSecretQuestion").value = intQuestionId;
		document.getElementById("txtAnswer").value = strAnswer;
		document.getElementById("cmbAccountType").value = intAccountType;
		document.getElementById("txtActivationCode").value = strActivationCode;

		intActiveStatus=intIsActive;
		intVarifyStatus=intIsVarified;
		
		if(intIsVarified==1)
			document.frmEditProducer.rdoVarified[0].checked = true; 
		else
		document.frmEditProducer.rdoVarified[1].checked = true; 		

		if(intIsActive==1)
			document.frmEditProducer.rdoActive[0].checked = true; 
		else
			document.frmEditProducer.rdoActive[1].checked = true; 		

		document.getElementById("cmbDayDateCreated").value = arrayDateCreated[2];
		document.getElementById("cmbMonthDateCreated").value = arrayDateCreated[1];
		document.getElementById("txtYearDateCreated").value = arrayDateCreated[0];
}


	function getListStates()
	{
		resetZipCode();
		////// hide error strip /////
		document.getElementById("tr_id").style.display = 'none';
		///////////////////////////
		var xmlStateList=obj.FillCmbStateByCountryId(document.getElementById("cmbCountryRegion").value,1);
		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var intNoOfRecords="";
	
		var intStateId="";
		var strStateName="";
		var i;
	
		XMLDoc.async = "false";
		// For Internet Explorer	  
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(xmlStateList)==true)
			{
				rootNode=XMLDoc.documentElement;
				intNoOfRecords=rootNode.selectSingleNode("NoOfRecords").text;
				document.getElementById("cmbState").options.length=0;
				for(i=0;i< intNoOfRecords;i++)	
				{
					intStateId=rootNode.selectSingleNode("StateList").childNodes.item(i).childNodes.item(0).text;
					strStateName=rootNode.selectSingleNode("StateList").childNodes.item(i).childNodes.item(2).text;				
					document.getElementById("cmbState").options[i]=new Option(strStateName,intStateId);
				}
			}
		}
		else
		{
			
			var xmlDoc = XMLDoc.parseFromString(xmlStateList, "application/xml");
			var strState = xmlDoc.getElementsByTagName('States');
			intNoOfRecords=strState[0].getElementsByTagName('NoOfRecords')[0].textContent;	
			document.getElementById("cmbState").options.length=0;
			for(i=0;i< intNoOfRecords;i++)	
			{
				var strStateDetail = xmlDoc.getElementsByTagName('State');

				intStateId=strStateDetail[i].getElementsByTagName('StateId')[0].textContent;
				strStateName=strStateDetail[i].getElementsByTagName('StateName')[0].textContent;				
				
				document.getElementById("cmbState").options[i]=new Option(strStateName,intStateId);
	
			}	
			
		}
	}

function createXml()
{

	if(ValidateForm())
	{
		var strTelNo=document.getElementById("txtTelephone1").value+"-"+document.getElementById("txtExtension").value;
		
		var dteBirthDate=document.getElementById("txtYear").value+"-"+document.getElementById("cmbMonth").value+"-"+document.getElementById("cmbDay").value;
		
		var currentDate=document.getElementById("txtYearDateCreated").value+"-"+document.getElementById("cmbMonthDateCreated").value+"-"+document.getElementById("cmbDayDateCreated").value;;


		document.getElementById("loading").style.display="inline";
		var strResonse=obj.UpdateProducer(
			'<?php echo $_REQUEST["id"]?>',
			document.getElementById("cmbCountryRegion").value,
			document.getElementById("cmbState").value,
			document.getElementById("cmbAccountType").value,
			document.getElementById("cmbSecretQuestion").value,
			document.getElementById("txtEmail").value,
			document.getElementById("txtPassword").value,
			document.getElementById("txtFirstName").value,
			document.getElementById("txtLastName").value,
			document.getElementById("txtAddress1").value,
			document.getElementById("txtCity").value,
			document.getElementById("txtZipCode").value,
			strTelNo,
			dteBirthDate,
			document.getElementById("txtAnswer").value,
			document.getElementById("txtActivationCode").value,
			intVarifyStatus,
			currentDate,
			intActiveStatus,
			function(result){parseXMLResponseUpdate(result);});
	}
}
function parseXMLResponseUpdate(pResponse)
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
					document.getElementById("divError").innerHTML=ADMIN_PRODUCER_PROFILE_SUCCUSSFULLY_UPDATED;
				}
				else
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";				
					intExceptionNo=rootNode.selectSingleNode("ExceptionNo").text;
					if(intExceptionNo=='1062')
						document.getElementById("divError").innerHTML=ADMIN_EMAIL_ALREADY_EXISTS;
					else
						document.getElementById("divError").innerHTML=UNKNOWN_EXCEPTION;

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
				document.getElementById("divError").innerHTML=ADMIN_PRODUCER_PROFILE_SUCCUSSFULLY_UPDATED;
			}
			else
			{
				document.getElementById("strip_image").src="/ImageFiles/common/error.gif";				
				intExceptionNo=strResponse[0].getElementsByTagName('ExceptionNo')[0].textContent;
				if(intExceptionNo=='1062')
					document.getElementById("divError").innerHTML=ADMIN_EMAIL_ALREADY_EXISTS;
				else
					document.getElementById("divError").innerHTML=UNKNOWN_EXCEPTION;
			
			}
			document.getElementById("tr_id").style.display = 'inline';			
			document.getElementById("error").focus();			
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
function resetZipCode()
{
	document.getElementById("txtZipCode").value="";
}

</script>
<!-- InstanceEndEditable -->
<script src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/Javascript/LeftMenu.js"></script>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="1001" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Admin/header.php");?></td>
  </tr>
  <tr>
    <td width="149" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Admin/LeftMenu.php");?></td>
    <td align="left" valign="top" height="470"><!-- InstanceBeginEditable name="body" -->
<table width="845" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder" height="100%">
<form action="" method="post" name="frmEditProducer">
  <tr  class="RegistrationCellBg">
    <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Producers Detail </p></td>
    </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr id="tr_id" style="display:none">
    <td width="32" bgcolor="FFFFAE" height="26">&nbsp;</td>
    <td width="805" bgcolor="FFFFAE" align="left" valign="middle">
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
    <td colspan="2">

					<table width="820" border="0" align="center" cellpadding="0" cellspacing="0" >
					   <tr  class="RegistrationCellBg">
						  <td width="731" height="27"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Your personal information  All fields are required</p></td>
						</tr>
						<tr>
						  <td><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td colspan="3">&nbsp;</td>
							</tr>
							<tr valign="top">
							  <td height="29" align="left" class="RegistrationBodyText"><strong>Producer ID </strong></td>
							  <td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr valign="top">
							  <td height="19" align="left" class="RegistrationBodyText"><div id="ProducerId"></div></td>
							  <td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr valign="top">
							  <td height="19" align="left" class="RegistrationBodyText">&nbsp;</td>
							  <td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr valign="top">
							  <td width="244" height="29" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>First Name: </strong></td>
							  <td width="394" colspan="2" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Last Name: </strong></td>
							</tr>
							<tr>
							  <td align="left" valign="middle" class="RegistrationBodyText"><input name="txtFirstName" type="text" id="txtFirstName" size="30">
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_FIRSTNAME_TOOLTIP,190 )" onMouseout='hideddrivetip()'></td>
							  <td colspan="2" align="left" valign="middle" class="RegistrationBodyText"><input name="txtLastName" type="text" id="txtLastName" size="30">
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle"  onMouseover="ddrivetip(ADMIN_PRODUCER_LASTNAME_TOOLTIP,190 )" onMouseout='hideddrivetip()' ></td>
							</tr>
							<tr>
							  <td align="left">&nbsp;</td>
							  <td colspan="2" align="left">&nbsp;</td>
							</tr>
							<tr>
							  <td height="29" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Street Address: </strong></td>
							  <td colspan="2" align="left">&nbsp;</td>
							</tr>
							<tr valign="middle">
							  <td colspan="3" align="left" class="RegistrationBodyText"><input name="txtAddress1" type="text" id="txtAddress1" size="45">
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_STREET_TOOLTIP,230 )" onMouseout='hideddrivetip()'> </td>
							</tr>
							<tr>
							  <td colspan="3" align="left">&nbsp;</td>
							</tr>
							<tr valign="top">
							  <td height="29" colspan="3" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>City:</strong></td>
							</tr>
							<tr valign="middle">
							  <td colspan="3" align="left" class="RegistrationBodyText"><input name="txtCity" type="text" id="txtCity" size="45" value="">
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_CITY_TOOLTIP,200 )" onMouseout='hideddrivetip()'> </td>
							</tr>
							<tr>
							  <td colspan="3" align="left">&nbsp;</td>
							</tr>
							<tr>
							  <td colspan="3" align="left"><table width="614" border="0" cellspacing="0" cellpadding="0">
								<tr valign="top">
								  <td width="270" height="29" align="left" class="RegistrationBodyText"><strong> <strong><strong><strong><font color="red" size="3">*</font></strong>Country / Region:</strong></strong> </strong></td>
								  <td width="189" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>State / Province: </strong></td>
								  <td width="241" align="left" class="RegistrationBodyText"><strong><strong><strong><font color="red" size="3">*</font></strong>Zip / Postal Code:</strong></strong></td>
								</tr>
								<tr>
                                  <td align="left" valign="middle"><select name="cmbCountryRegion" id="cmbCountryRegion" style="width:250px" onChange="getListStates()">
                                      <?php $objReg->FillCmbCountry(1);?>
                                  </select></td>
								  <td align="left" valign="middle"><select name="cmbState" id="cmbState" style="width:170px" onChange="resetZipCode()">
                                  </select></td>
								  <td align="left" valign="middle"><input name="txtZipCode" type="text" id="txtZipCode" size="10">
                                      <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_ZIP_TOOLTIP,250)" onMouseout='hideddrivetip()'> </td>
							    </tr>

							  </table></td>
							</tr>
							<tr>
							  <td colspan="3" align="left">&nbsp;</td>
							</tr>
							<tr>
							  <td colspan="3" align="left"><table width="370" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="173" height="29" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Primary Telephone: </strong></td>
                                  <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle"><input name="txtTelephone1" type="text" id="txtTelephone1" size="20">
                                      <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_TELEPHONE_TOOLTIP,325)" onMouseout='hideddrivetip()'> </td>
                                  <td width="29" align="left" valign="middle" class="RegistrationBodyText">Ext: </td>
                                  <td width="168" align="left" valign="middle"><input name="txtExtension" type="text" id="txtExtension" size="10">
                                      <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_EXTENSION_TOOLTIP,175)" onMouseout='hideddrivetip()'></td>
                                </tr>
                              </table></td>
							</tr>
							<tr>
							  <td colspan="3" align="left">&nbsp;</td>
							</tr>
							<tr>
							  <td colspan="3" align="left"><table width="617" border="0" cellspacing="0" cellpadding="0">
								<tr>
								  <td height="29" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Date of Birth:</strong></td>
								</tr>
								<tr>
								  <td align="left" valign="middle" class="RegistrationBodyText"><select name="cmbDay" id="cmbDay" style="width:50px">
                                    <?php $objReg->FillCmbDay()?>
                                  </select>
-
<select name="cmbMonth" id="cmbMonth" style="width:90px">
  <?php $objReg->FillCmbMonth()?>
</select>
-
<input name="txtYear" type="text" id="txtYear" size="8" maxlength="4">
<img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_YEAR_TOOLTIP,175)" onMouseout='hideddrivetip()'> </td>
								</tr>
							  </table></td>
							</tr>
							<tr>
							  <td colspan="3" align="left"><p class="RegistrationBodyText">&nbsp;</p></td>
							</tr>
							<tr>
							  <td colspan="3" align="left">&nbsp;</td>
							</tr>
						  </table></td>
						</tr>
						<tr class="RegistrationCellBg">
						  <td height="27"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;User Information </p></td>
						</tr>
						<tr>
						  <td><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td colspan="2" align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr>
							  <td height="29" colspan="2" align="left" valign="top"><strong><strong><font color="red" size="3">*</font></strong></strong><strong class="RegistrationBodyText">E-mail:</strong></td>
							</tr>
							<tr>
							  <td width="325" align="left" valign="middle" class="RegistrationBodyText"><input name="txtEmail" type="text" id="txtEmail" size="30">
                                <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_EMAIL_TOOLTIP,325)" onMouseout='hideddrivetip()'></td>
							  <td width="375" align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr>
							  <td colspan="2" align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr valign="top">
            <td height="29" colspan="2" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Create Password:</strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"><input name="txtPassword" type="password" id="txtPassword" size="30">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_PASSWORD_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr valign="top">
            <td height="29" colspan="2" align="left"><strong class="RegistrationBodyText"><strong><font color="red" size="3">*</font></strong>Re-enter Password: </strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"> <input name="txtRePassword" type="password" size="30" id="txtRePassword">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_REPASSWORD_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
          </tr>
							<tr>
							  <td colspan="2" align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr>
							  <td colspan="2" align="left" valign="middle"><table width="629" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="255" height="29" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Secret Question:</strong></td>
                                  <td width="445" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Secret Answer: </strong></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle"><select name="cmbSecretQuestion" id="cmbSecretQuestion" style="width:225px">
                                      <?php $objReg->FillCmbSecretQuestion(1);?>
                                    </select>                                  </td>
                                  <td align="left" valign="middle"><input name="txtAnswer" type="text" id="txtAnswer" size="30">
                                      <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_ANSWER_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
                                </tr>
                              </table></td>
							</tr>'
							<tr>
							  <td colspan="2" align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr valign="top">
							  <td height="29" colspan="2" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Accounty Type: </strong></td>
							</tr>
							<tr>
							  <td colspan="2" align="left" valign="middle" class="RegistrationBodyText"><select name="cmbAccountType" id="cmbAccountType" style="width:120px">
                                <?php $objReg->FillCmbAccountType(1);?>
                              </select></td>
							</tr>
							<tr>
							  <td colspan="2" align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr>
							  <td height="29" colspan="2" align="left" valign="top"class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Activation Code:</strong></td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText"><input name="txtActivationCode" type="text" size="30" id="txtActivationCode">
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_PRODUCER_ACTIVATION_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr>
							  <td height="29" colspan="2" align="left" valign="top"class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Is Varified:</strong></td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText"><input name="rdoVarified" id="rdoVarified" type="radio" value="1" onChange="setRdoIsVarify(1)">
						      <img src="/ImageFiles/common/done.gif" width="18" height="17">
						      <input name="rdoVarified" id="rdoVarified" type="radio" value="0" onChange="setRdoIsVarify(0)">
                              <img src="/ImageFiles/common/error.gif" width="18" height="17"></td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr>
							  <td height=29 colspan="2" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Is Active</strong></td>
							</tr>
							<tr>
							  <td colspan="2" align="left" valign="middle"><span class="RegistrationBodyText">
							    <input name="rdoActive" id="rdoActive" type="radio" value="1" onChange="setRdoIsActive(1)">
                                <img src="/ImageFiles/common/done.gif" width="18" height="17">
                                <input name="rdoActive" id="rdoActive" type="radio" value="0" onChange="setRdoIsActive(0)">
                                <img src="/ImageFiles/common/error.gif" width="18" height="17"></span></td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr>
							  <td height=29 colspan="2" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Date Created</strong></td>
							</tr>
							<tr>
							  <td colspan="2" align="left" valign="middle" class="RegistrationBodyText"><select name="cmbDayDateCreated" id="cmbDayDateCreated" style="width:50px">
                                <?php $objReg->FillCmbDay()?>
                                                            </select>
-
<select name="cmbMonthDateCreated" id="cmbMonthDateCreated" style="width:90px">
  <?php $objReg->FillCmbMonth()?>
</select>
-
<input name="txtYearDateCreated" type="text" id="txtYearDateCreated" size="8" maxlength="4">
<img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(PRODUCER_REGISTRATION_YEAR_TOOLTIP,175)" onMouseout='hideddrivetip()'> </td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
						    </tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText"><input name="Submit" type="Button" class="RegistrationButton" id="Submit" value="Edit Producer" onClick="createXml()"> <input name="Submit2" type="Button" class="RegistrationButton" id="Submit2" onClick="location.href='/admin/Producer/ViewProducer.php'" value="View Producer List"></td>
						    </tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>
						    </tr>

						  </table></td>
						</tr>
					</table>


</td>
  </tr>
  </form>
</table>
<!-- InstanceEndEditable --> </td>
  </tr>
  
  <tr>
    <td colspan="2" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Admin/footer.php");?></td>
  </tr>
</table>
<script language="JavaScript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/JavaScript/tmenu.js"></script>
</body>
<!-- InstanceEnd --></html>
<script language="javascript">getProducer();</script>
<script language="javascript">
var intVarifyStatus;
var intActiveStatus;
function setRdoIsVarify(status)
{
	intVarifyStatus=status;
}
function setRdoIsActive(status)
{
	intActiveStatus=status;
}

</script>