<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Producer/ProducerDetailService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

	$objReg = new ProducerDetailService();
	NAJAX_Server::allowClasses("ProducerDetailService");
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
var obj = <?= NAJAX_Client::register(new ProducerDetailService()) ?>;

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
		var i=0;
		
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
			
					intProducerId=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(0).text;
					intCountryId=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(1).text;
					intStateId=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(2).text;
					intAccountType=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(3).text;
					intQuestionId=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(4).text;
					strEmail=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(5).text;
					strPassword=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(6).text;
					strFirstName=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(7).text;
					strLastName=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(8).text;
					strAddress=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(9).text;
					strCity=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(10).text;
					strZipCode=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(11).text;
					strTelephone1=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(12).text;
					dtDateOfBirth=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(13).text;
					strAnswer=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(14).text;
					strActivationCode=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(15).text;
					intIsVarified=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(16).text;
					dtCreateDate=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(17).text;
					intIsActive=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(18).text;
					strCountryName=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(19).text;
					strStateName=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(20).text;
					strQuestion=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(21).text;
					strAccountType=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(22).text;


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
			else if(intPageNo==1)
			{
				var strHtml='<table width="650" border="0" align="center" cellpadding="5" cellspacing="1">';
				strHtml+='<tr>';
				strHtml+='<td class="RegistrationBodyText" align="center">'+PRODUCER_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			}
			else
			{
				intPageNo=intPageNo-1;
				getListProducer();
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
							  strHtml+='<td height="29" align="left" class="RegistrationBodyText"><strong>Producer ID </strong></td>';
							  strHtml+='<td colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>';
							strHtml+='</tr>';
							strHtml+='<tr valign="top">';
							  strHtml+='<td height="19" align="left" class="RegistrationBodyText">'+intProducerId+'</td>';
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
    <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Producers Detail </p></td>
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
      <input name="Submit" type="Button" class="RegistrationButton" id="Submit" value="Edit Producer" onClick="location.href='/admin/Producer/EditProducer.php?id=<?php echo $_REQUEST["id"]?>'">
      <input name="Submit2" type="Button" class="RegistrationButton" id="Submit2" onClick="location.href='/admin/Producer/ViewProducer.php'" value="View Producer List">
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
<script language="javascript">getProducer();</script>
