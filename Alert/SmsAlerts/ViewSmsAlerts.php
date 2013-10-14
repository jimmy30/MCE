<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ConsumerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Alert/SmsAlerts/ViewSmsAlertsService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");

try
{
	
	$objReg = new ViewSmsAlertsService();
	
	
	NAJAX_Server::allowClasses("ViewSmsAlertsService");
	if (NAJAX_Server::runServer()) 
	{
		exit;
	}

	
	$objProperties=new Properties();
	$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
	
	/// Get Sorting variable from property file
	$sort_list_by = $objProperties->getProperty('sort_list_by');
	$sort_arrow_image = $objProperties->getProperty('sort_arrow_image');
	if($sort_list_by=="ascending") $sort_list_by=0; else $sort_list_by=1;
	
?>

<?php 
	echo(NAJAX_Utilities::header('/IncludeFiles/PHP/Najax'));
	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/userTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>MCE-Add Sms Alert</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>
<script language="javascript">
var obj = <?= NAJAX_Client::register(new ViewSmsAlertsService()) ?>;
var intPageNo=1;
var strSortingArrow='<?php echo $sort_arrow_image?>';
var intSortListBy='<?php echo $sort_list_by?>';
var altColor;
var i;

	function getListConsumerAlerts()
	{
		////// hide error strip /////


		
		document.getElementById("tr_id").style.display = 'none';
		///////////////////////////

		var arrayPagingLimit = new Array();
		arrayPagingLimit = obj.getPagingLimit(intPageNo);

		<?php 
		if(isset($_SESSION[sessionKeys::USER_ID]) && $_SESSION[sessionKeys::USER_ID]!="") 
		{
		?>

		obj.GetListByConsumerId(<?php echo $_SESSION[sessionKeys::USER_ID]?>,arrayPagingLimit[0],arrayPagingLimit[1],1,intSortListBy,function(result)
		{

			parseXMLResponse(result);
		});
		obj.AlertRecordCountByConsumer(<?php echo $_SESSION[sessionKeys::USER_ID]?>,function(result){getPaging(result);});		
		<?php
		}
		else 
		{
		?>
		// All place cast list with out depending on session value
		obj.GetListActive(arrayPagingLimit[0],arrayPagingLimit[1],1,intSortListBy,function(result){parseXMLResponse(result);});
		obj.AlertRecordCount(1,function(result){getPaging(result);});
		<?php
		}
		?>
		
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

			strHtml+='<table width="650" border="0" align="center" cellpadding="5" cellspacing="1">';
			strHtml+='<tr class="RegistrationCellBg">';
			  strHtml+='<td width="60" class="RegistrationTitleTextSmall" align="center"><strong>ID#</strong></td>';
			  strHtml+='<td width="346" class="RegistrationTitleTextSmall"><strong>Alert Detail&nbsp;<a href="#" class="RegistrationTitleText" onclick="javascript:SortListBy()"><img src="/ImageFiles/common/'+strSortingArrow+'" border=0 alt="Sort"></a></strong></td>';
			  strHtml+='<td width="100" class="RegistrationTitleTextSmall" ><div align="center"><strong>Add Action</strong></div></td>';
			  strHtml+='<td width="100" class="RegistrationTitleTextSmall" ><div align="center"><strong>Edit Action</strong></div></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Active</strong></div></td>';			  
			  strHtml+='<td width="50" class="RegistrationTitleTextSmall"><div align="center"><strong>Edit</strong></div></td>';
			  strHtml+='<td width="59" class="RegistrationTitleTextSmall" ><div align="center"><strong>Remove</strong></div></td>';
			  strHtml+='</tr>';
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
					intNoOfRecords=rootNode.selectSingleNode("NoOfRecords").text;
					for(i=0;i< intNoOfRecords;i++)	
					{
						if((Math.round(i - (Math.floor(i/2)*2)))==0)
								altColor=ALTERNATE_COLOR_NORMAL;
						else
							altColor=ALTERNATE_COLOR;
							
						intConsumerAlertId=rootNode.selectSingleNode("SmsAlertList").childNodes.item(i).childNodes.item(0).text;
						strCountryName=rootNode.selectSingleNode("SmsAlertList").childNodes.item(i).childNodes.item(2).text;				
						intAdd=rootNode.selectSingleNode("SmsAlertList").childNodes.item(i).childNodes.item(3).text;				
						intModify=rootNode.selectSingleNode("SmsAlertList").childNodes.item(i).childNodes.item(4).text;				
						intIsActive=rootNode.selectSingleNode("SmsAlertList").childNodes.item(i).childNodes.item(5).text;				

						if(intAdd==1)
							strAdd = '<img src="/ImageFiles/common/done.gif" border=0>';
						else
							strAdd = '<img src="/ImageFiles/common/error.gif" border=0>';

						if(intModify==1)
							strModify = '<img src="/ImageFiles/common/done.gif" border=0>';
						else
							strModify = '<img src="/ImageFiles/common/error.gif" border=0>';						

						if(intIsActive==1)
							strIsActive = '<img src="/ImageFiles/common/done.gif" border=0>';
						else
							strIsActive = '<img src="/ImageFiles/common/error.gif" border=0>';
						
						strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td  class="RegistrationBodyText" align="center">'+intConsumerAlertId+'</td><td class="RegistrationBodyText"><b>'+strCountryName+'</b></td><td><div align="center">'+strAdd+'</div></td><td><div align="center" >'+strModify+'</div></td><td><div align="center" >'+strIsActive+'</div></td><td><div align="center"><a href="EditSmsAlerts.php?id='+intConsumerAlertId+'"><img src="/ImageFiles/common/edit.gif" border=0 alt="Edit"></a></div></td><td><div align="center"><a href="#" onClick="DelteConsumerAlert('+intConsumerAlertId+')"><img src="/ImageFiles/common/remove.gif" border=0 alt="Remove"></a></div></td></tr>';

					}
					strHtml+='<table>';
					document.getElementById("ListContainer").innerHTML = strHtml;
		
				}
			}
			else if(intPageNo==1)
			{
				strHtml+='<tr>';
				strHtml+='<td bgcolor="FFFFAE" height=26 colspan=7 class="RegistrationBodyText" align="center"><img src=/ImageFiles/common/warning.gif>&nbsp;'+SMS_ALERT_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			
			}
			else
			{
				intPageNo=intPageNo-1;
				getListConsumerAlert();
			}
		}
		// For other browser eg. firefox.
		else
		{
			if(strResonse!=null)
			{

				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strConsumerAlerts = xmlDoc.getElementsByTagName('SmsAlerts');
				var intNoOfRecord = strConsumerAlerts[0].getElementsByTagName('NoOfRecords')[0].textContent;
				var strConsumerAlertList = xmlDoc.getElementsByTagName('SmsAlert');

				for (var i = 0; i < intNoOfRecord; i++) 
				{
				
					if((Math.round(i - (Math.floor(i/2)*2)))==0)
						altColor=ALTERNATE_COLOR_NORMAL;
					else
						altColor=ALTERNATE_COLOR;
				
				 	intConsumerAlertId= strConsumerAlertList[i].getElementsByTagName('SmsAlertId')[0].textContent;
					strCountryName= strConsumerAlertList[i].getElementsByTagName('CountryName')[0].textContent;
					intAdd= strConsumerAlertList[i].getElementsByTagName('Add')[0].textContent;
					intModify= strConsumerAlertList[i].getElementsByTagName('Modify')[0].textContent;
					intIsActive= strConsumerAlertList[i].getElementsByTagName('IsActive')[0].textContent;					
															
					if(intAdd==1)
						strAdd = '<img src="/ImageFiles/common/done.gif" border=0>';
					else
						strAdd = '<img src="/ImageFiles/common/error.gif" border=0>';

					if(intModify==1)
						strModify = '<img src="/ImageFiles/common/done.gif" border=0>';
					else
						strModify = '<img src="/ImageFiles/common/error.gif" border=0>';						

					if(intIsActive==1)
						strIsActive = '<img src="/ImageFiles/common/done.gif" border=0>';
					else
						strIsActive = '<img src="/ImageFiles/common/error.gif" border=0>';
			
					strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td  class="RegistrationBodyText" align="center">'+intConsumerAlertId+'</td><td class="RegistrationBodyText"><b>'+strCountryName+'</b></td><td><div align="center">'+strAdd+'</div></td><td><div align="center" >'+strModify+'</div></td><td><div align="center" >'+strIsActive+'</div></td><td><div align="center"><a href="EditSmsAlerts.php?id='+intConsumerAlertId+'"><img src="/ImageFiles/common/edit.gif" border=0 alt="Edit"></a></div></td><td><div align="center"><a href="#" onClick="DelteConsumerAlert('+intConsumerAlertId+')"><img src="/ImageFiles/common/remove.gif" border=0 alt="Remove"></a></div></td></tr>';
				}
				strHtml+='<table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			}	
			else if(intPageNo==1)
			{
				strHtml+='<tr>';
				strHtml+='<td bgcolor="FFFFAE" height=26 colspan=7 class="RegistrationBodyText" align="center"><img src=/ImageFiles/common/warning.gif>&nbsp;'+SMS_ALERT_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			}
			else
			{
				intPageNo=intPageNo-1;
				getListConsumerAlert();
			}
		}	
		

	}
	
	function getPaging(numRows)
	{
		obj.paging(intPageNo,numRows,function(result){parseXMLResponsePaging(result);});	
	}
	
	function parseXMLResponsePaging(strHtml)
	{

		
		if((Math.round(i - (Math.floor(i/2)*2)))==0)
			altColor=ALTERNATE_COLOR_NORMAL;
		else
			altColor=ALTERNATE_COLOR;
	
		if(strHtml!=null)
		document.getElementById("paging").innerHTML = '<table width="650" border="0" align="center" cellpadding="5" cellspacing="1"><tr><td height=65 align=center bgcolor='+altColor+' class=RegistrationBodyText>'+strHtml+'</td></tr></table>';
		
	}
	
	function DelteConsumerAlert(SmsAlertId)
	{

		<?php 
		if(isset($_SESSION[sessionKeys::USER_ID]) && $_SESSION[sessionKeys::USER_ID]!="") 
		{
		?>
		
			if(window.confirm("Are you sure, you want to delete SmsAlert?"))
			{
				obj.ConsumerAlertDeleteById(SmsAlertId,function(result)
				{

					parseXMLDeleteResponse(result);
				});
			}
		
		<?php
		}
		else
		{
		?>
		
		location.href="/CustomerSignIn.php";
		<?php
		}		
		?>
	}

	function parseXMLDeleteResponse(pResponse)
	{
		
		var XMLDoc=GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var intExceptionNo="";
		var strExceptionName="";
		var strResonse=pResponse;

		XMLDoc.async = "false";
		//  For Internet Explorer
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(strResonse)==true)
			{
			
				rootNode=XMLDoc.documentElement;
				strStatus=rootNode.selectSingleNode("Status").text;
				
				if(strStatus=="ok")
				{
					document.getElementById("strip_image").src="/ImageFiles/common/done.gif";
					document.getElementById("divError").innerHTML=SMS_ALERT_SUCCESSFULLY_DELETED;
					getListConsumerAlerts();
				}
				else
				{
				intExceptionNo=rootNode.selectSingleNode("ExceptionNo").text;
					if(intExceptionNo=='1451')
					{
						document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
						document.getElementById("divError").innerHTML="Cannot be Deleted";
					}
				}
				document.getElementById("tr_id").style.display = 'inline';			
				document.getElementById("error").focus();			
		
			}
		}
		// For other browser eg. firefox
		else
		{
			var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
			var entries = xmlDoc.getElementsByTagName('Response');
			var strStatus;
        	for (var i = 0; i < entries.length; i++) 
			{
				strStatus = entries[i].getElementsByTagName('Status')[0].textContent;
				if(strStatus=="ok")
				{
					document.getElementById("strip_image").src="/ImageFiles/common/done.gif";
					document.getElementById("divError").innerHTML=SMS_ALERT_SUCCESSFULLY_DELETED;
					getListConsumerAlerts();
				}
				else
				{

				intExceptionNo=entries[i].getElementsByTagName("ExceptionNo")[0].textContent;
					if(intExceptionNo=='1451')
					{
						document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
						document.getElementById("divError").innerHTML="Cannot be Deleted";
					}
				}
				document.getElementById("tr_id").style.display = 'inline';			
				document.getElementById("error").focus();			

			}	
		}	
		
}
function GoToPage(pPageNo)
{
	intPageNo=pPageNo;
	getListConsumerAlerts();
}

function SortListBy()
{
	if(intSortListBy==0)
	{
		intSortListBy=1;
		strSortingArrow="arrow_up.gif";
	}
	else 
	{
		intSortListBy=0;
		strSortingArrow="arrow_down.gif";		
	}
	getListConsumerAlerts();
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
//-->//-->
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
  <form name="frmSmsAlert" action="" method="post" onSubmit="">
    <tr  class="RegistrationCellBg">
      <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;View Consumer Sms Alerts</p></td>
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
      <td height="21" colspan="2" valign="top">		
<div id="ListContainer"></div>
<div id="paging" align="center" class="RegistrationBodyText"></div>	  </td>
    </tr>
    <tr>
      <td height="10" colspan="2" valign="top">	  </td>
    </tr>

    <tr>
      <td height="26" colspan="2" valign="top">		
<div align="center"><input type="button" class="RegistrationButton" onClick="location.href='AddSmsAlerts.php'" value="Add New">&nbsp;&nbsp;</div>	  </td>
    </tr>
    <tr align="left">
      <td colspan="2">&nbsp;</td>
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
<script language="javascript">getListConsumerAlerts();</script>
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}
?>
