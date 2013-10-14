<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Profile/ConsumerProfile/ConsumerProfileService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ConsumerSessionCheck.php");

try
{
	$objReg = new ConsumerProfileService();
	NAJAX_Server::allowClasses("ConsumerProfileService");
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

<script type="text/javascript" src="/IncludeFiles/Javascript/ClientChecks.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Profile/ConsumerProfile/ConsumerProfile.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Tooltip.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>
<script language="javascript">

var obj = <?= NAJAX_Client::register(new ConsumerProfileService()) ?>;

function createXml()
{
	if(ValidateForm())
	{
		var strTelNo=document.getElementById("txtTelephone1").value+"-"+document.getElementById("txtExtension").value;
		var dteBirthDate=document.getElementById("cmbYear").value+"-"+document.getElementById("cmbMonth").value+"-"+document.getElementById("cmbDay").value;
		var objDate = new Date();
		var currentDate='';
		currentDate=objDate.getYear()+"-"+objDate.getMonth()+"-"+objDate.getDate();

		document.getElementById("loading").style.display="inline";

		var strResonse=obj.UpdateConsumer('<?php echo $_SESSION[sessionKeys::USER_EMAIL]?>',document.getElementById("cmbCountryRegion").value,document.getElementById("cmbState").value,document.getElementById("cmbAccountType").value,document.getElementById("txtFirstName").value,document.getElementById("txtLastName").value,document.getElementById("txtAddress1").value,document.getElementById("txtCity").value,	document.getElementById("txtZipCode").value,strTelNo,dteBirthDate,document.getElementById("cmbSecretQuestion").value,document.getElementById("txtAnswer").value,document.getElementById("txtMobileNo").value,document.getElementById("cmbCellularProvider").value,function(result)
		{
			parseXMLResponse(result);
		});
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
					document.getElementById("divError").innerHTML=CONSUMER_PROFILE_SUCCUSSFULLY_UPDATED;
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
				document.getElementById("divError").innerHTML=CONSUMER_PROFILE_SUCCUSSFULLY_UPDATED;
			}
			document.getElementById("tr_id").style.display = 'inline';			
			document.getElementById("error").focus();			
			
		}	
	document.getElementById("loading").style.display="none";
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
	
		XMLDoc.async = "false";
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(xmlStateList)==true)
			{
				rootNode=XMLDoc.documentElement;
				intNoOfRecords=rootNode.selectSingleNode("NoOfRecords").text;
		
				document.frmRegistration.cmbState.options.length=0;
	
				
				for(i=0;i< intNoOfRecords;i++)	
				{
					intStateId=rootNode.selectSingleNode("StateList").childNodes.item(i).childNodes.item(0).text;
					strStateName=rootNode.selectSingleNode("StateList").childNodes.item(i).childNodes.item(2).text;				
					document.frmRegistration.cmbState.options[i]=new Option(strStateName,intStateId);
					
				}
			}
		}
		else
		{
			var xmlDoc = XMLDoc.parseFromString(xmlStateList, "application/xml");
			var strState = xmlDoc.getElementsByTagName('States');
			intNoOfRecords=strState[0].getElementsByTagName('NoOfRecords')[0].textContent;	

			document.frmRegistration.cmbState.options.length=0;
			for(i=0;i< intNoOfRecords;i++)	
			{
				var strStateDetail = xmlDoc.getElementsByTagName('State');
				intStateId=strStateDetail[i].getElementsByTagName('StateId')[0].textContent;
				strStateName=strStateDetail[i].getElementsByTagName('StateName')[0].textContent;				
				document.frmRegistration.cmbState.options[i]=new Option(strStateName,intStateId);
	
			}	
			
		}
		getCellularProviderList();
	}


//-->

function getListConsumer()
{
	var strResonse=obj.GetConsumerListByEmail('<?php echo $_SESSION[sessionKeys::USER_EMAIL]?>',function(result){parseXMLConsumerList(result);});
}

function parseXMLConsumerList(pResponse)
{

		var XMLDoc =GetXmlHttpObject();
		var strResonse=pResponse;
		XMLDoc.async = "false";
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(strResonse)==true)
			{
		
				rootNode=XMLDoc.documentElement;
				document.getElementById("txtFirstName").value =rootNode.selectSingleNode("ConsumerFristName").text;
				document.getElementById("txtLastName").value = rootNode.selectSingleNode("ConsumerLastName").text;
				document.getElementById("txtAddress1").value = rootNode.selectSingleNode("ConsumerAddress").text;			
				document.getElementById("txtCity").value = rootNode.selectSingleNode("ConsumerCity").text;						
				document.getElementById("cmbCountryRegion").value = rootNode.selectSingleNode("ConsumerCountryId").text;
				getListStates();			
				document.getElementById("cmbState").value = rootNode.selectSingleNode("ConsumerStateId").text;
				document.getElementById("txtZipCode").value = rootNode.selectSingleNode("ConsumerZipCode").text;									
	
				var arrTelephone = new Array();
				arrTelephone = rootNode.selectSingleNode("ConsumerTelephone1").text.split("-");
				document.getElementById("txtTelephone1").value = arrTelephone[0];												
				document.getElementById("txtExtension").value = arrTelephone[1];
	
				var arrDOB = new Array();
				arrDOB = rootNode.selectSingleNode("ConsumerDateOfBirth").text.split("-");
				document.getElementById("cmbDay").value = arrDOB[2];
				document.getElementById("cmbMonth").value = arrDOB[1];			
				document.getElementById("cmbYear").value = arrDOB[0];						
	
				document.getElementById("cmbSecretQuestion").value = rootNode.selectSingleNode("ConsumerSecretQuestion").text;									
				document.getElementById("txtAnswer").value = rootNode.selectSingleNode("ConsumerAnswer").text;									
				document.getElementById("cmbAccountType").value = rootNode.selectSingleNode("ConsumerAccountType").text;									
				document.getElementById("txtMobileNo").value = rootNode.selectSingleNode("ConsumerMobile").text;
				document.getElementById("cmbCellularProvider").value = rootNode.selectSingleNode("ConsumerCellularProvider").text;									

			}
		}
		else
		{
			var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
			var ConsumerList = xmlDoc.getElementsByTagName('ConsumerList');
			document.getElementById("txtFirstName").value =ConsumerList[0].getElementsByTagName("ConsumerFristName")[0].textContent;
			document.getElementById("txtLastName").value = ConsumerList[0].getElementsByTagName("ConsumerLastName")[0].textContent;
			document.getElementById("txtAddress1").value = ConsumerList[0].getElementsByTagName("ConsumerAddress")[0].textContent;
			document.getElementById("txtCity").value = ConsumerList[0].getElementsByTagName("ConsumerCity")[0].textContent;
			document.getElementById("cmbCountryRegion").value = ConsumerList[0].getElementsByTagName("ConsumerCountryId")[0].textContent;
			getListStates();
			document.getElementById("cmbState").value =ConsumerList[0].getElementsByTagName("ConsumerStateId")[0].textContent;
			document.getElementById("txtZipCode").value = ConsumerList[0].getElementsByTagName("ConsumerZipCode")[0].textContent;
			var arrTelephone = new Array();
			arrTelephone = ConsumerList[0].getElementsByTagName("ConsumerTelephone1")[0].textContent.split("-");
			document.getElementById("txtTelephone1").value = arrTelephone[0];												
			document.getElementById("txtExtension").value = arrTelephone[1];
			var arrDOB = new Array();
			arrDOB = ConsumerList[0].getElementsByTagName("ConsumerDateOfBirth")[0].textContent.split("-");
			document.getElementById("cmbDay").value = arrDOB[2];
			document.getElementById("cmbMonth").value = arrDOB[1];			
			document.getElementById("cmbYear").value = arrDOB[0];						
			document.getElementById("cmbSecretQuestion").value = ConsumerList[0].getElementsByTagName("ConsumerSecretQuestion")[0].textContent;									
			document.getElementById("txtAnswer").value = ConsumerList[0].getElementsByTagName("ConsumerAnswer")[0].textContent;									
			document.getElementById("cmbAccountType").value =ConsumerList[0].getElementsByTagName("ConsumerAccountType")[0].textContent;						
			document.getElementById("txtMobileNo").value =ConsumerList[0].getElementsByTagName("ConsumerMobile")[0].textContent;
			document.getElementById("cmbCellularProvider").value =ConsumerList[0].getElementsByTagName("ConsumerCellularProvider")[0].textContent;						
		}	
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
			document.frmRegistration.cmbCellularProvider.options.length=0;
			
			for(i=0;i< intNoOfRecords;i++)	
			{
				intCellularProviderId=rootNode.selectSingleNode("CellularList").childNodes.item(i).childNodes.item(0).text;
				strCellularProviderName=rootNode.selectSingleNode("CellularList").childNodes.item(i).childNodes.item(2).text;				
				document.frmRegistration.cmbCellularProvider.options[i]=new Option(strCellularProviderName,intCellularProviderId);
				
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
			document.frmRegistration.cmbCellularProvider.options[i]=new Option(strCellularProviderName,intCellularProviderId);

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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
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
  <form name="frmRegistration" action="" method="post" onSubmit="">
    <tr  class="RegistrationCellBg">
      <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Your personal information  All fields are required</p></td>
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
    <tr>
      <td colspan="2"><table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr align="left" valign="middle">
            <td colspan="3" class="RegistrationBodyText"> Want to register as a business? </td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr valign="top">
            <td width="244" height="29" align="left" class="RegistrationBodyText"><strong><font color="red" size="3">*</font>First Name: </strong></td>
            <td width="456" colspan="2" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Last Name: </strong></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><input name="txtFirstName" type="text" id="txtFirstName" size="30">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_LASTNAME_TOOLTIP,190 )" onMouseout='hideddrivetip()'></td>
            <td colspan="2" align="left" valign="middle"><input name="txtLastName" type="text" id="txtLastName" size="30">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle"  onMouseover="ddrivetip(CONSUMER_REGISTRATION_FIRSTNAME_TOOLTIP,190 )" onMouseout='hideddrivetip()' ></td>
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
            <td colspan="3" align="left"><input name="txtAddress1" type="text" id="txtAddress1" size="45">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_STREET_TOOLTIP,230 )" onMouseout='hideddrivetip()'> </td>
          </tr>
          <tr>
            <td colspan="3" align="left">&nbsp;</td>
          </tr>
          <tr valign="top">
            <td height="29" colspan="3" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>City:</strong></td>
          </tr>
          <tr valign="middle">
            <td colspan="3" align="left"><input name="txtCity" type="text" id="txtCity" size="45" value="">
                <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_CITY_TOOLTIP,200 )" onMouseout='hideddrivetip()'> </td>
          </tr>
          <tr>
            <td colspan="3" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="left"><table width="629" border="0" cellspacing="0" cellpadding="0">
                <tr valign="top">
                  <td width="270" height="29" align="left" class="RegistrationBodyText"><strong> <strong><strong><strong><font color="red" size="3">*</font></strong>Country / Region:</strong></strong> </strong></td>
                  <td width="189" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>State / Province: </strong></td>
                  <td width="241" align="left" class="RegistrationBodyText"><strong><strong><strong><font color="red" size="3">*</font></strong>Zip / Postal Code:</strong></strong></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><select name="cmbCountryRegion" id="cmbCountryRegion" style="width:250px" onChange="getListStates()">
                      <?php $objReg->FillCmbCountry(1);?>
                  </select></td>
                  <td align="left" valign="middle">
                    <select name="cmbState" id="cmbState" style="width:170px" onChange="resetZipCode()">
                  </select></td>
                  <td align="left" valign="middle">
                    <input name="txtZipCode" type="text" id="txtZipCode" size="10">
                    <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_ZIP_TOOLTIP,250)" onMouseout='hideddrivetip()'> </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3" align="left">&nbsp;</td>
          </tr>
		  
          <tr>
            <td colspan="3" align="left"><table width="370" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="171" height="29" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Primary Telephone: </strong></td>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><input name="txtTelephone1" type="text" id="txtTelephone1" size="20">
                      <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_TELEPHONE_TOOLTIP,325)" onMouseout='hideddrivetip()'> </td>
                  <td width="30" align="left" valign="middle" class="RegistrationBodyText">Ext: </td>
                  <td width="169" align="left" valign="middle"><input name="txtExtension" type="text" id="txtExtension" size="10">
                      <img src="../../ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_EXTENSION_TOOLTIP,175)" onMouseout='hideddrivetip()'></td>
                </tr>
					 <tr>
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
				 <tr>
                  <td width="171" height="29" align="left" valign="top" class="RegistrationBodyText"><strong>Mobile Number : </strong></td>
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
            <td colspan="3" align="left"><table width="629" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="29" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Date of Birth:</strong></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><select name="cmbDay" id="cmbDay" style="width:50px">
                      <?php $objReg->FillCmbDay()?>
                    </select>
                    -
                    <select name="cmbMonth" id="cmbMonth" style="width:90px">
                      <?php $objReg->FillCmbMonth()?>
                    </select>
                    -
                    <input name="cmbYear" type="text" id="cmbYear" size="8" maxlength="4">
                    <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_YEAR_TOOLTIP,175)" onMouseout='hideddrivetip()'> </td>
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
      <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Your Secret Information  All fields are required </p></td>
      </tr>
    <tr>
      <td colspan="2"><table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle"><table width="631" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="255" height="29" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Secret Question:</strong></td>
                  <td width="445" align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Secret Answer: </strong></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><select name="cmbSecretQuestion" id="cmbSecretQuestion" style="width:225px">
                      <?php $objReg->FillCmbSecretQuestion(1);?>
                    </select>                  </td>
                  <td align="left" valign="middle"><input name="txtAnswer" type="text" id="txtAnswer" size="30">
                      <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(CONSUMER_REGISTRATION_ANSWER_TOOLTIP,300)" onMouseout='hideddrivetip()'></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr valign="top">
            <td height="29" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Accounty Type: </strong></td>
          </tr>
          <tr>
            <td align="left" valign="middle">
              <select name="cmbAccountType" id="cmbAccountType" style="width:120px">
                <?php $objReg->FillCmbAccountType(1);?>
              </select>
              <a href="#" class="LinkSmall" onClick="MM_openBrWindow('/Registration/ConsumerRegistration/AccountTypeInformation.php','AccountType','status=yes,scrollbars=yes,resizable=yes,width=800,height=580')">Learn More </a> </td>
          </tr>
          <tr>
            <td align="left" valign="middle">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr align="left">
      <td colspan="2"><table width="660" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="14" colspan="3" align="left" valign="top"></td>
          </tr>
          <tr>
            <td width="35" height="30" align="left" valign="top">&nbsp;</td>
            <td width="132" align="left" valign="top"><input name="Submit" type="Button" class="RegistrationButton" id="Submit" value="Update" onClick="createXml()"></td>
            <td width="533" align="left" valign="top"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
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
<script language="javascript">getListConsumer();</script>