<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Consumer/EditConsumerService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

	$objReg = new EditConsumerService();
	NAJAX_Server::allowClasses("EditConsumerService");
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
<script language="JavaScript" type="text/javascript" src="../../IncludeFiles/Javascript/Admin/Consumer/EditConsumer.js"></script>

<script type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Tooltip.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script language="javascript">
var obj = <?= NAJAX_Client::register(new EditConsumerService()) ?>;

function getConsumer()
{
	obj.ConsumerGetById('<?php echo $_REQUEST["id"]?>',function(result){parseXMLResponse(result);});

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

		var intConsumerId;
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
			
					intConsumerId=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(0).text;
					intCountryId=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(1).text;
					intStateId=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(2).text;
					intAccountType=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(3).text;
					intQuestionId=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(4).text;
					strEmail=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(5).text;
					strPassword=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(6).text;
					strFirstName=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(7).text;
					strLastName=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(8).text;
					strAddress=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(9).text;
					strCity=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(10).text;
					strZipCode=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(11).text;
					strTelephone1=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(12).text;
					dtDateOfBirth=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(13).text;
					strAnswer=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(14).text;
					strActivationCode=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(15).text;
					intIsVarified=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(16).text;
					dtCreateDate=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(17).text;
					intIsActive=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(18).text;
					strCountryName=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(19).text;
					strStateName=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(20).text;
					strQuestion=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(21).text;
					strAccountType=rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(22).text;
				 	strMoblieNo= rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(23).text;
					strCellularProvider= rootNode.selectSingleNode("ConsumerList").childNodes.item(0).childNodes.item(24).text;

				}
			}

		}
		// For other browser eg. firefox.
		else
		{
			if(strResonse!=null)
			{

				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strConsumers = xmlDoc.getElementsByTagName('Consumers');
				var strConsumerList = xmlDoc.getElementsByTagName('Consumer');

				intConsumerId=strConsumerList[0].getElementsByTagName('ConsumerId')[0].textContent;
				intCountryId=strConsumerList[0].getElementsByTagName('ConsumerCountryId')[0].textContent;
				intStateId=strConsumerList[0].getElementsByTagName('ConsumerStateId')[0].textContent;
				intAccountType=strConsumerList[0].getElementsByTagName('ConsumerAccountType')[0].textContent;
				intQuestionId=strConsumerList[0].getElementsByTagName('ConsumerSecretQuestion')[0].textContent;
				strEmail=strConsumerList[0].getElementsByTagName('ConsumerEmail')[0].textContent;
				strPassword=strConsumerList[0].getElementsByTagName('ConsumerPassword')[0].textContent;
				strFirstName=strConsumerList[0].getElementsByTagName('ConsumerFristName')[0].textContent;
				strLastName=strConsumerList[0].getElementsByTagName('ConsumerLastName')[0].textContent;
				strAddress=strConsumerList[0].getElementsByTagName('ConsumerAddress')[0].textContent;
				strCity=strConsumerList[0].getElementsByTagName('ConsumerCity')[0].textContent;
				strZipCode=strConsumerList[0].getElementsByTagName('ConsumerZipCode')[0].textContent;
				strTelephone1=strConsumerList[0].getElementsByTagName('ConsumerTelephone1')[0].textContent;
				dtDateOfBirth=strConsumerList[0].getElementsByTagName('ConsumerDateOfBirth')[0].textContent;
				strAnswer=strConsumerList[0].getElementsByTagName('ConsumerAnswer')[0].textContent;
				strActivationCode=strConsumerList[0].getElementsByTagName('ConsumerActivationCode')[0].textContent;
				intIsVarified=strConsumerList[0].getElementsByTagName('ConsumerIsVerified')[0].textContent;
				dtCreateDate=strConsumerList[0].getElementsByTagName('ConsumerCreateDate')[0].textContent;
				intIsActive=strConsumerList[0].getElementsByTagName('ConsumerIsActive')[0].textContent;
				strCountryName=strConsumerList[0].getElementsByTagName('CountryName')[0].textContent;
				strStateName=strConsumerList[0].getElementsByTagName('StateName')[0].textContent;
				strQuestion=strConsumerList[0].getElementsByTagName('QuestionName')[0].textContent;
				strAccountType=strConsumerList[0].getElementsByTagName('AccountType')[0].textContent;
			 	strMoblieNo= strConsumerList[0].getElementsByTagName('ConsumerMobile')[0].textContent;
				strCellularProvider= strConsumerList[0].getElementsByTagName('ConsumerCellularProvider')[0].textContent;
				

			}	
		}	

		var arrayTelephone = new Array();
		arrayTelephone = strTelephone1.split("-");
		
		var arrayDOB =  new Array();
		arrayDOB = dtDateOfBirth.split("-");

		var arrayDateCreated =  new Array();
		arrayDateCreated = dtCreateDate.split("-");
		
		document.getElementById("ConsumerId").innerHTML = intConsumerId;
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
		document.getElementById("txtMobileNo").value = strMoblieNo;
		document.getElementById("cmbCellularProvider").value = strCellularProvider;

		intActiveStatus=intIsActive;
		intVarifyStatus=intIsVarified;
		
		if(intIsVarified==1)
			document.frmEditConsumer.rdoVarified[0].checked = true; 
		else
		document.frmEditConsumer.rdoVarified[1].checked = true; 		

		if(intIsActive==1)
			document.frmEditConsumer.rdoActive[0].checked = true; 
		else
			document.frmEditConsumer.rdoActive[1].checked = true; 		

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
		getCellularProviderList();		
	}

function createXml()
{

	if(ValidateForm())
	{
		var strTelNo=document.getElementById("txtTelephone1").value+"-"+document.getElementById("txtExtension").value;
		
		var dteBirthDate=document.getElementById("txtYear").value+"-"+document.getElementById("cmbMonth").value+"-"+document.getElementById("cmbDay").value;
		
		var currentDate=document.getElementById("txtYearDateCreated").value+"-"+document.getElementById("cmbMonthDateCreated").value+"-"+document.getElementById("cmbDayDateCreated").value;;

		document.getElementById("loading").style.display="inline";
		var strResonse=obj.UpdateConsumer(
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
			document.getElementById("txtMobileNo").value,
			document.getElementById("cmbCellularProvider").value,
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
					document.getElementById("divError").innerHTML=ADMIN_CONSUMER_PROFILE_SUCCUSSFULLY_UPDATED;
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
				document.getElementById("divError").innerHTML=ADMIN_CONSUMER_PROFILE_SUCCUSSFULLY_UPDATED;
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

function getCellularProviderList()
{
	////// hide error strip /////
	
	document.getElementById("tr_id").style.display = 'none';
	///////////////////////////
	var xmlCellularList=obj.FillCmbCellularByCountryId(document.getElementById("cmbCountryRegion").value,1);
	var XMLDoc =GetXmlHttpObject();
	var rootNode = "";
	var intNoOfRecords="";

	var intCellularProviderId="";
	var strCellularProviderName="";

	XMLDoc.async = "false";
	// For Internet Explorer	  
	if (window.ActiveXObject)
	{
		if(XMLDoc.loadXML(xmlCellularList)==true)
		{
			rootNode=XMLDoc.documentElement;
			intNoOfRecords=rootNode.selectSingleNode("NoOfRecords").text;
			document.frmEditConsumer.cmbCellularProvider.options.length=0;
			
			for(i=0;i< intNoOfRecords;i++)	
			{
				intCellularProviderId=rootNode.selectSingleNode("CellularList").childNodes.item(i).childNodes.item(0).text;
				strCellularProviderName=rootNode.selectSingleNode("CellularList").childNodes.item(i).childNodes.item(2).text;				
				document.frmEditConsumer.cmbCellularProvider.options[i]=new Option(strCellularProviderName,intCellularProviderId);
				
			}
			
		}
	}
	
	else
	{
		
		var xmlDoc = XMLDoc.parseFromString(xmlCellularList, "application/xml");
		var strCellular = xmlDoc.getElementsByTagName('CellularProviders');
		intNoOfRecords=strCellular[0].getElementsByTagName('NoOfRecords')[0].textContent;	
		for(i=0;i< intNoOfRecords;i++)	
		{
			var strCellularDetail = xmlDoc.getElementsByTagName('CellularProvider');
			intCellularProviderId=strCellularDetail[i].getElementsByTagName('CellularId')[0].textContent;
			strCellularProviderName=strCellularDetail[i].getElementsByTagName('CellularProviderName')[0].textContent;				
			document.frmEditConsumer.cmbCellularProvider.options[i]=new Option(strCellularProviderName,intCellularProviderId);

		}	
		
	}
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
<form action="" method="post" name="frmEditConsumer">
  <tr  class="RegistrationCellBg">
    <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Consumers Detail </p></td>
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
							  <td height="29" align="left" class="RegistrationBodyText"><strong>Consumer ID </strong></td>
							  <td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr valign="top">
							  <td height="19" align="left" class="RegistrationBodyText"><div id="ConsumerId"></div></td>
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
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_FIRSTNAME_TOOLTIP,190 )" onMouseout='hideddrivetip()'></td>
							  <td colspan="2" align="left" valign="middle" class="RegistrationBodyText"><input name="txtLastName" type="text" id="txtLastName" size="30">
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle"  onMouseover="ddrivetip(ADMIN_CONSUMER_LASTNAME_TOOLTIP,190 )" onMouseout='hideddrivetip()' ></td>
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
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_STREET_TOOLTIP,230 )" onMouseout='hideddrivetip()'> </td>
							</tr>
							<tr>
							  <td colspan="3" align="left">&nbsp;</td>
							</tr>
							<tr valign="top">
							  <td height="29" colspan="3" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>City:</strong></td>
							</tr>
							<tr valign="middle">
							  <td colspan="3" align="left" class="RegistrationBodyText"><input name="txtCity" type="text" id="txtCity" size="45" value="">
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_CITY_TOOLTIP,200 )" onMouseout='hideddrivetip()'> </td>
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
                                      <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_ZIP_TOOLTIP,250)" onMouseout='hideddrivetip()'> </td>
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
                                      <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_TELEPHONE_TOOLTIP,325)" onMouseout='hideddrivetip()'> </td>
                                  <td width="29" align="left" valign="middle" class="RegistrationBodyText">Ext: </td>
                                  <td width="168" align="left" valign="middle"><input name="txtExtension" type="text" id="txtExtension" size="10">
                                      <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_EXTENSION_TOOLTIP,175)" onMouseout='hideddrivetip()'></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td align="left" valign="middle" class="RegistrationBodyText">&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td height="29" align="left" valign="top" class="RegistrationBodyText"><strong>Mobile Number : </strong></td>
                                  <td colspan="2" height="29" align="left" valign="top" class="RegistrationBodyText"><strong>Cellular Provider </strong></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle"><input name="txtMobileNo" type="text" id="txtMobileNo" size="20">
                                      <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_MOBILENUMBER_TOOLTIP,325)" onMouseout='hideddrivetip()'> </td>
                                  <td colspan="2" align="left" valign="middle" class="RegistrationBodyText"><select name="cmbCellularProvider" id="cmbCellularProvider" style="width:170px">
                                      <?php //$objReg->FillCmbCellularProvider(1);?>
                                  </select></td>
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
<img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_YEAR_TOOLTIP,175)" onMouseout='hideddrivetip()'> </td>
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
                                <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_EMAIL_TOOLTIP,325)" onMouseout='hideddrivetip()'></td>
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
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_PASSWORD_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr valign="top">
            <td height="29" colspan="2" align="left"><strong class="RegistrationBodyText"><strong><font color="red" size="3">*</font></strong>Re-enter Password: </strong></td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle"> <input name="txtRePassword" type="password" size="30" id="txtRePassword">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_REPASSWORD_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
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
                                      <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_ANSWER_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
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
                                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_CONSUMER_ACTIVATION_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
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
<img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_YEAR_TOOLTIP,175)" onMouseout='hideddrivetip()'> </td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>
							</tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
						    </tr>
							<tr>
							  <td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText"><input name="Submit" type="Button" class="RegistrationButton" id="Submit" value="Edit Consumer" onClick="createXml()"> <input name="Submit2" type="Button" class="RegistrationButton" id="Submit2" onClick="location.href='/admin/Consumer/ViewConsumer.php'" value="View Consumer List"></td>
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
<script language="javascript">getConsumer();</script>
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