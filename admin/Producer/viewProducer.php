<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Producer/viewProducerService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

	$objReg = new viewProducerService();
	NAJAX_Server::allowClasses("viewProducerService");
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
var obj = <?= NAJAX_Client::register(new viewProducerService()) ?>;
var intPageNo=1;
var strSortingArrow='<?php echo $sort_arrow_image?>';
var intSortListBy='<?php echo $sort_list_by?>';
var altColor;
var i;

function getListProducer()
{
	var arrayPagingLimit = new Array();
	arrayPagingLimit = obj.getPagingLimit(intPageNo);

	obj.ProducerListByStatus(arrayPagingLimit[0],arrayPagingLimit[1],3,intSortListBy,function(result){parseXMLResponse(result);});
	obj.ProducerRecordCountByStatus(3,function(result){getPaging(result);});
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


			strHtml+='<table width="800" border="0" align="center" cellpadding="5" cellspacing="1">';
			strHtml+='<tr class="RegistrationCellBg">';
			  strHtml+='<td width="60" class="RegistrationTitleTextSmall" align="center"><strong>Producer#</strong></td>';
			  strHtml+='<td width="197" class="RegistrationTitleTextSmall"><strong>Producer Name&nbsp;<a href="#" class="RegistrationTitleText" onclick="javascript:SortListBy()"><img src="/ImageFiles/common/'+strSortingArrow+'" border=0 alt="Sort"></a></strong></td>';
			  strHtml+='<td width="220" class="RegistrationTitleTextSmall" ><strong>Email</strong></td>';
			  strHtml+='<td width="50" class="RegistrationTitleTextSmall" ><div align="center"><strong>Active</strong></div></td>';
			  strHtml+='<td width="50" class="RegistrationTitleTextSmall" ><div align="center"><strong>Detail</strong></div></td>';			  
			  strHtml+='<td width="50" class="RegistrationTitleTextSmall"><div align="center"><strong>Edit</strong></div></td>';
			  strHtml+='<td width="50" class="RegistrationTitleTextSmall" ><div align="center"><strong>Remove</strong></div></td>';
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
							
						intProducerId=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(0).text;
						strProducerName=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(7).text+" "+rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(8).text;				
						strProducerEmail=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(5).text;				
						isActive=rootNode.selectSingleNode("ProducerList").childNodes.item(i).childNodes.item(18).text;				
						if(isActive==1)
							var ActiveImg = 'done.gif';
						else
							var ActiveImg = 'error.gif';
						strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td  class="RegistrationBodyText" align="center">'+intProducerId+'</td><td class="RegistrationBodyText">'+strProducerName+'</td><td class="RegistrationBodyText">'+strProducerEmail+'</td><td class="RegistrationBodyText"><div align=center><img src="/ImageFiles/common/'+ActiveImg+'" border=0></div></td><td><div align="center" ><a href="ProducerDetail.php?id='+intProducerId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Detail"></a></div></td><td><div align="center"><a href="EditProducer.php?id='+intProducerId+'"><img src="/ImageFiles/common/edit.gif" border=0 alt="Edit"></a></div></td><td><div align="center"><a href="#" onClick="DeleteProducer('+intProducerId+')"><img src="/ImageFiles/common/remove.gif" border=0 alt="Remove"></a></div></td></tr>';
					}
					strHtml+='<table>';
					document.getElementById("ListContainer").innerHTML = strHtml;
		
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

			else
			{
				intPageNo=intPageNo-1;
				getListProducer();
			}
		}
		// For other browser eg. firefox.
		else
		{
			if(strResonse!=null)
			{
				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strProducers = xmlDoc.getElementsByTagName('Producers');
				var intNoOfRecord = strProducers[0].getElementsByTagName('NoOfRecords')[0].textContent;

				var strProducerList = xmlDoc.getElementsByTagName('Producer');

				for (var i = 0; i < intNoOfRecord; i++) 
				{

					 if((Math.round(i - (Math.floor(i/2)*2)))==0)
						altColor=ALTERNATE_COLOR_NORMAL;
					else
						altColor=ALTERNATE_COLOR;
						
					intProducerId= strProducerList[i].getElementsByTagName('ProducerId')[0].textContent;
					strProducerName=strProducerList[i].getElementsByTagName('ProducerFristName')[0].textContent+" "+strProducerList[i].getElementsByTagName('ProducerLastName')[0].textContent;
					
					strProducerEmail=strProducerList[i].getElementsByTagName('ProducerEmail')[0].textContent;
					isActive=strProducerList[i].getElementsByTagName('ProducerIsActive')[0].textContent;

					if(isActive==1)
						var ActiveImg = 'done.gif';
					else
						var ActiveImg = 'error.gif';
					
					strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td  class="RegistrationBodyText" align="center">'+intProducerId+'</td><td class="RegistrationBodyText">'+strProducerName+'</td><td class="RegistrationBodyText">'+strProducerEmail+'</td><td class="RegistrationBodyText"><div align=center><img src="/ImageFiles/common/'+ActiveImg+'" border=0></div></td><td><div align="center" ><a href="ProducerDetail.php?id='+intProducerId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Detail"></a></div></td><td><div align="center"><a href="EditProducer.php?id='+intProducerId+'"><img src="/ImageFiles/common/edit.gif" border=0 alt="Edit"></a></div></td><td><div align="center"><a href="#" onClick="DeleteProducer('+intProducerId+')"><img src="/ImageFiles/common/remove.gif" border=0 alt="Remove"></a></div></td></tr>';
				}
				strHtml+='<table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
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
	
function GoToPage(pPageNo)
{
	intPageNo=pPageNo;
	getListProducer();
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
	getListProducer();
}


	function DeleteProducer(pProducerId)
	{
		<?php 
		if(isset($_SESSION[sessionKeys::ADMIN_EMAIL]) && $_SESSION[sessionKeys::ADMIN_EMAIL]!="")
		{
			if($_SESSION[sessionKeys::ADMIN_TYPE]==3)
			{
		?>
				if(window.confirm("Are you sure, you want to delete Producer?"))
				{
					obj.ProducerDeleteById(pProducerId,function(result)
					{
						parseXMLDeleteResponse(result);
					});
				}	
		<?php
			}
		}
		else
		{
		?>

		location.href="/admin/AdminSignIn.php";
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
					document.getElementById("divError").innerHTML=PRODUCER_SUCCESSFULLY_DELETED;
					getListProducer();
				}
				else
				{
				intExceptionNo=rootNode.selectSingleNode("ExceptionNo").text;
					if(intExceptionNo=='1451')
					{
						document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
						document.getElementById("divError").innerHTML="<font color='red'>Cannot be Deleted</font>";
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
					document.getElementById("divError").innerHTML=PRODUCER_SUCCESSFULLY_DELETED;
					getListProducer();
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
    <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;View Producers </p></td>
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
    <td colspan="2"><div id="ListContainer"></div>
<div id="paging" align="center" class="RegistrationBodyText"></div></td>
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
<script language="javascript">getListProducer();</script>
