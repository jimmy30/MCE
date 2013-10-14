<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Consumer/ConsumerDetailService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

	$objReg = new ConsumerDetailService();
	NAJAX_Server::allowClasses("ConsumerDetailService");
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

<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script language="javascript">
var obj = <?= NAJAX_Client::register(new ConsumerDetailService()) ?>;

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
		var i=0;
		
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
		var strMoblieNo;
		var strCellularProvider;

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
			
					intConsumerId=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(0).text;
					intCountryId=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(1).text;
					intStateId=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(2).text;
					intAccountType=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(3).text;
					intQuestionId=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(4).text;
					strEmail=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(5).text;
					strPassword=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(6).text;
					strFirstName=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(7).text;
					strLastName=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(8).text;
					strAddress=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(9).text;
					strCity=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(10).text;
					strZipCode=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(11).text;
					strTelephone1=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(12).text;
					dtDateOfBirth=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(13).text;
					strAnswer=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(14).text;
					strActivationCode=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(15).text;
					intIsVarified=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(16).text;
					dtCreateDate=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(17).text;
					intIsActive=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(18).text;
					strCountryName=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(19).text;
					strStateName=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(20).text;
					strQuestion=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(21).text;
					strAccountType=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(22).text;
					strMoblieNo=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(23).text;
					strCellularProvider=rootNode.selectSingleNode("ConsumerList").childNodes.item(i).childNodes.item(24).text;					


				}
			}
			else if(intPageNo==1)
			{
				strHtml+='<tr>';
				strHtml+='<td bgcolor="FFFFAE" height=26 colspan=6 class="RegistrationBodyText" align="center"><img src=/ImageFiles/common/warning.gif>&nbsp;'+CONSUMER_NO_RECORD_EXIST+'</td>';
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
			else if(intPageNo==1)
			{
				var strHtml='<table width="650" border="0" align="center" cellpadding="5" cellspacing="1">';
				strHtml+='<tr>';
				strHtml+='<td class="RegistrationBodyText" align="center">'+CONSUMER_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			}
			else
			{
				intPageNo=intPageNo-1;
				getListConsumer();
			}
		}	

					var ArrayTelephone = new Array();
					ArrayTelephone=strTelephone1.split("-");
				
					if(intIsActive==1)
						var ActiveImg = 'done.gif';
					else
						var ActiveImg = 'error.gif';

					if(intIsVarified==1)
						var VarifyImg = 'done.gif';
					else
						var VarifyImg = 'error.gif';

					strHtml+='<table width="820" border="0" align="center" cellpadding="0" cellspacing="0" >';
					   strHtml+='<tr  class="RegistrationCellBg">';
						  strHtml+='<td width="731" height="27"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Your personal information  All fields are required</p></td>';
						strHtml+='</tr>';
						strHtml+='<tr>';
						  strHtml+='<td><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="top">';
							  strHtml+='<td height="29" align="left" class="RegistrationBodyText"><strong>Consumer ID </strong></td>';
							  strHtml+='<td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="top">';
							  strHtml+='<td height="19" align="left" class="RegistrationBodyText">'+intConsumerId+'</td>';
							  strHtml+='<td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="top">';
							  strHtml+='<td height="19" align="left" class="RegistrationBodyText">&nbsp;</td>';
							  strHtml+='<td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="top">';
							  strHtml+='<td width="244" height="29" align="left" class="RegistrationBodyText"><strong>First Name: </strong></td>';
							  strHtml+='<td width="394" colspan="2" align="left" class="RegistrationBodyText"><strong>Last Name: </strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+strFirstName+'</td>';
							  strHtml+='<td colspan="2" align="left" valign="middle" class="RegistrationBodyText">'+strLastName+'</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td align="left">&nbsp;</td>';
							  strHtml+='<td colspan="2" align="left">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="29" align="left" valign="top" class="RegistrationBodyText"><strong>Street Address: </strong></td>';
							  strHtml+='<td colspan="2" align="left">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="middle">';
							  strHtml+='<td colspan="3" align="left" class="RegistrationBodyText">'+strAddress+' </td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="top">';
							  strHtml+='<td height="29" colspan="3" align="left" class="RegistrationBodyText"><strong>City:</strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="middle">';
							  strHtml+='<td colspan="3" align="left" class="RegistrationBodyText">'+strCity+'</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left"><table width="614" border="0" cellspacing="0" cellpadding="0">';
								strHtml+='<tr valign="top">';
								  strHtml+='<td width="270" height="29" align="left" class="RegistrationBodyText"><strong> <strong><strong>Country / Region:</strong></strong> </strong></td>';
								  strHtml+='<td width="189" align="left" class="RegistrationBodyText"><strong>State / Province: </strong></td>';
								  strHtml+='<td width="241" align="left" class="RegistrationBodyText"><strong><strong>Zip / Postal Code:</strong></strong></td>';
								strHtml+='</tr>';
								strHtml+='<tr>';
								  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+strCountryName+'</td>';
								  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+strStateName+'</td>';
								  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+strZipCode+'</td>';
								strHtml+='</tr>';
							  strHtml+='</table></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left"><table width="370" border="0" cellspacing="0" cellpadding="0">';
								strHtml+='<tr>';
								  strHtml+='<td width="173" height="29" align="left" valign="top" class="RegistrationBodyText"><strong>Primary Telephone: </strong></td>';
								  strHtml+='<td colspan="2">&nbsp;</td>';
								strHtml+='</tr>';
								strHtml+='<tr>';
								  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+ArrayTelephone[0]+'</td>';
								  strHtml+='<td width="29" align="left" valign="middle" class="RegistrationBodyText">Ext: </td>';
								  strHtml+='<td width="168" align="left" valign="middle" class="RegistrationBodyText">'+ArrayTelephone[1]+'</td>';
								strHtml+='</tr>';

								strHtml+='<tr>';
								strHtml+='<tr>';
								  strHtml+='<td colspan="3" align="left">&nbsp;</td>';
								strHtml+='</tr>';
								  strHtml+='<td width="173" height="29" align="left" valign="top" class="RegistrationBodyText"><strong>Mobile No: </strong></td>';
								  strHtml+='<td colspan="2" class="RegistrationBodyText" valign="top"><strong>Cellular Provider</strong></td>';
								strHtml+='</tr>';
								strHtml+='<tr>';
								  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+strMoblieNo+'</td>';
								  strHtml+='<td width="168" align="left" valign="middle" class="RegistrationBodyText" colspan="2">'+strCellularProvider+'</td>';
								strHtml+='</tr>';


							  strHtml+='</table></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left"><table width="617" border="0" cellspacing="0" cellpadding="0">';
								strHtml+='<tr>';
								  strHtml+='<td height="29" align="left" valign="top" class="RegistrationBodyText"><strong>Date of Birth:</strong></td>';
								strHtml+='</tr>';
								strHtml+='<tr>';
								  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+dtDateOfBirth+'</td>';
								strHtml+='</tr>';
							  strHtml+='</table></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left"><p class="RegistrationBodyText">&nbsp;</p></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="3" align="left">&nbsp;</td>';
							strHtml+='</tr>';
						  strHtml+='</table></td>';
						strHtml+='</tr>';
						strHtml+='<tr class="RegistrationCellBg">';
						  strHtml+='<td height="27"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;User Information </p></td>';
						strHtml+='</tr>';
						strHtml+='<tr>';
						  strHtml+='<td><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="29" colspan="2" align="left" valign="top"><strong class="RegistrationBodyText">E-mail:</strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td width="325" align="left" valign="middle" class="RegistrationBodyText">'+strEmail+'</td>';
							  strHtml+='<td width="375" align="left" valign="middle">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="top">';
							  strHtml+='<td height="29" colspan="2" align="left" class="RegistrationBodyText"><strong>Create Password:</strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle" class="RegistrationBodyText">'+strPassword+'</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle"><table width="629" border="0" cellspacing="0" cellpadding="0">';
								strHtml+='<tr>';
								  strHtml+='<td width="255" height="29" align="left" valign="top" class="RegistrationBodyText"><strong>Secret Question:</strong></td>';
								  strHtml+='<td width="445" align="left" valign="top" class="RegistrationBodyText"><strong>Secret Answer: </strong></td>';
								strHtml+='</tr>';
								strHtml+='<tr>';
								  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+strQuestion+'</td>';
								  strHtml+='<td align="left" valign="middle" class="RegistrationBodyText">'+strAnswer+'</td>';
								strHtml+='</tr>';
							  strHtml+='</table></td>';
							strHtml+='</tr>'
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="top">';
							  strHtml+='<td height="29" colspan="2" align="left" class="RegistrationBodyText"><strong>Accounty Type: </strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle" class="RegistrationBodyText">'+strAccountType+'</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="29" colspan="2" align="left" valign="top"class="RegistrationBodyText"><strong>Activation Code:</strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">'+strActivationCode+'</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="29" colspan="2" align="left" valign="top"class="RegistrationBodyText"><strong>Is Varified:</strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText"><img src="/ImageFiles/common/'+VarifyImg+'"></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height=29 colspan="2" align="left" valign="top" class="RegistrationBodyText"><strong>Is Active</strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle"><img src="/ImageFiles/common/'+ActiveImg+'"></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height=29 colspan="2" align="left" valign="top" class="RegistrationBodyText"><strong>Date Created</strong></td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td colspan="2" align="left" valign="middle" class="RegistrationBodyText">'+dtCreateDate+'</td>';
							strHtml+='</tr>';
							strHtml+='<tr>';
							  strHtml+='<td height="19" colspan="2" align="left" valign="middle"class="RegistrationBodyText">&nbsp;</td>';
							strHtml+='</tr>';

						  strHtml+='</table></td>';
						strHtml+='</tr>';
					strHtml+='</table>';
					document.getElementById("ListContainer").innerHTML = strHtml;

		
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
  <tr  class="RegistrationCellBg">
    <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Consumers Detail </p></td>
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
  <tr align="left" valign="top">
    <td height="19" colspan="2"><div id="ListContainer"></div>
<div id="paging" align="center" class="RegistrationBodyText"></div></td>
  </tr>
  <tr align="left" valign="top">
    <td colspan="2"><span class="RegistrationBodyText">&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="Submit" type="Button" class="RegistrationButton" id="Submit" value="Edit Consumer" onClick="location.href='/admin/Consumer/EditConsumer.php?id=<?php echo $_REQUEST["id"]?>'">
      <input name="Submit2" type="Button" class="RegistrationButton" id="Submit2" onClick="location.href='/admin/Consumer/ViewConsumer.php'" value="View Consumer List">
      <br>
    </span><br></td>
  </tr>
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
