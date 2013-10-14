<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Placecast/viewPlaceCastService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");

try
{
	$objReg = new ViewPlaceCastService();
	NAJAX_Server::allowClasses("ViewPlaceCastService");
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
<title>MCE-Add PlaceCast</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css"><script language="JavaScript" type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script language="javascript">
var obj = <?= NAJAX_Client::register(new ViewPlaceCastService()) ?>;
var intPageNo=1;
var strSortingArrow='<?php echo $sort_arrow_image?>';
var intSortListBy='<?php echo $sort_list_by?>';
var altColor;
var i;
	function getListPlaceCast()
	{

		document.getElementById("loading").style.display="inline";	
		
		var arrayPagingLimit = new Array();
		arrayPagingLimit = obj.getPagingLimit(intPageNo);
		obj.GetListActive(arrayPagingLimit[0],arrayPagingLimit[1],3,intSortListBy,function(result){parseXMLResponse(result);});
		obj.PlaceCastRecordCount(3,function(result){getPaging(result);});
		document.getElementById("loading").style.display="none";
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
			  strHtml+='<td width="60" class="RegistrationTitleTextSmall" align="center"><strong>ID#</strong></td>';
			  strHtml+='<td width="346" class="RegistrationTitleTextSmall"><strong>PlaceCast Detail&nbsp;<a href="#" class="RegistrationTitleText" onclick="javascript:SortListBy()"><img src="/ImageFiles/common/'+strSortingArrow+'" border=0 alt="Sort"></a></strong></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Active</strong></div></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Waypoint</strong></div></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Detail</strong></div></td>';
			  strHtml+='<td width="59" class="RegistrationTitleTextSmall" ><div align="center"><strong>Remove</strong></div></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Download</strong></div></td>';			  
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
							
						intPlaceCastId=rootNode.selectSingleNode("PlaceCastList").childNodes.item(i).childNodes.item(0).text;
						strPlaceCastName=rootNode.selectSingleNode("PlaceCastList").childNodes.item(i).childNodes.item(1).text;				
						strPlaceCastAddress=rootNode.selectSingleNode("PlaceCastList").childNodes.item(i).childNodes.item(2).text;				
						strPlaceCastCity=rootNode.selectSingleNode("PlaceCastList").childNodes.item(i).childNodes.item(3).text;				
						strPlaceCastCountry=rootNode.selectSingleNode("PlaceCastList").childNodes.item(i).childNodes.item(4).text;				
						strPlaceCastState=rootNode.selectSingleNode("PlaceCastList").childNodes.item(i).childNodes.item(5).text;				
						strPlaceCastZipCode=rootNode.selectSingleNode("PlaceCastList").childNodes.item(i).childNodes.item(6).text;				
						isActive=rootNode.selectSingleNode("PlaceCastList").childNodes.item(i).childNodes.item(7).text;				

						if(isActive==1)
						{
							var ActiveValue = 0;
							var ActiveImg = 'done.gif';
						}
						else
						{
							var ActiveValue = 1;						
							var ActiveImg = 'error.gif';
						}
						
						 var result=obj.getListPlaceCastFolder(intPlaceCastId);
						 if(result!=null)
						 {
							alt='Download';
							imgDownload='<a href="javascript:downloadPlaceCast('+result+')"><img src="/ImageFiles/common/download.gif" border=0 alt="Download"></a>';							
						}
						else
						{
							alt='Not Exists';	
							imgDownload='<img src="/ImageFiles/common/error.gif" border=0 alt="'+alt+'">';
						}
						

						strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td  class="RegistrationBodyText" align="center">'+intPlaceCastId+'</td><td class="RegistrationBodyText"><b>'+strPlaceCastName+'</b><br>'+strPlaceCastCity+','+strPlaceCastCountry+',<br>'+strPlaceCastState+', '+strPlaceCastZipCode+'</td><td><div id="'+intPlaceCastId+'" align=center><img src="/ImageFiles/common/'+ActiveImg+'" border=0 onclick="ToggleIsActive('+intPlaceCastId+','+ActiveValue+')" style="cursor:hand"></div></td><td><div align="center"><a href="/admin/Waypoint/ViewWaypoint.php?id='+intPlaceCastId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Waypoint"></a></div></td><td><div align="center" ><a href="PlaceCastDetail.php?id='+intPlaceCastId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Detail"></a></div></td><td><div align="center"><a href="#" onClick="DeltePlaceCast('+intPlaceCastId+')"><img src="/ImageFiles/common/remove.gif" border=0 alt="Remove"></a></div></td><td><div align="center" >'+imgDownload+'</div></td></tr>';
					}
					strHtml+='<table>';
					document.getElementById("ListContainer").innerHTML = strHtml;
		
				}
			}
			else if(intPageNo==1)
			{
				strHtml+='<tr>';
				strHtml+='<td bgcolor="FFFFAE" height=26 colspan=6 class="RegistrationBodyText" align="center"><img src=/ImageFiles/common/warning.gif>&nbsp;'+PLACECAST_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			
			}
			else
			{
				intPageNo=intPageNo-1;
				getListPlaceCast();
			}
		}
		// For other browser eg. firefox.
		else
		{
			if(strResonse!=null)
			{

				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strPlaceCasts = xmlDoc.getElementsByTagName('PlaceCasts');
				var intNoOfRecord = strPlaceCasts[0].getElementsByTagName('NoOfRecords')[0].textContent;
				var strPlaceCastList = xmlDoc.getElementsByTagName('PlaceCast');

				for (var i = 0; i < intNoOfRecord; i++) 
				{

					 if((Math.round(i - (Math.floor(i/2)*2)))==0)
						altColor=ALTERNATE_COLOR_NORMAL;
					else
						altColor=ALTERNATE_COLOR;
						
					intPlaceCastId= strPlaceCastList[i].getElementsByTagName('PlaceCastId')[0].textContent;
					strPlaceCastName=strPlaceCastList[i].getElementsByTagName('PlaceCastName')[0].textContent;
					strPlaceCastAddress=strPlaceCastList[i].getElementsByTagName('PlaceCastAddress')[0].textContent;				
					strPlaceCastCity=strPlaceCastList[i].getElementsByTagName('PlaceCastCity')[0].textContent;				
					strPlaceCastCountry=strPlaceCastList[i].getElementsByTagName('PlaceCastCountryName')[0].textContent;			
					strPlaceCastState=strPlaceCastList[i].getElementsByTagName('PlaceCastStateName')[0].textContent;				
					strPlaceCastZipCode=strPlaceCastList[i].getElementsByTagName('PlaceCastStateZipCode')[0].textContent;
					isActive=strPlaceCastList[i].getElementsByTagName('PlaceCastIsActive')[0].textContent;
	
					if(isActive==1)
					{
						var ActiveValue = 0;
						var ActiveImg = 'done.gif';
					}
					else
					{
						var ActiveValue = 1;						
						var ActiveImg = 'error.gif';
					}

						 var result=obj.getListPlaceCastFolder(intPlaceCastId);
						 if(result!=null)
						 {
							alt='Download';
							imgDownload='<a href="javascript:downloadPlaceCast('+result+')"><img src="/ImageFiles/common/download.gif" border=0 alt="Download"></a>';							
						}
						else
						{
							alt='Not Exists';	
							imgDownload='<img src="/ImageFiles/common/error.gif" border=0 alt="'+alt+'">';
						}

									
					strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td class="RegistrationBodyText" align="center">'+intPlaceCastId+'</td><td class="RegistrationBodyText" ><b>'+strPlaceCastName+'</b><br>'+strPlaceCastCity+','+strPlaceCastCountry+',<br>'+strPlaceCastState+', '+strPlaceCastZipCode+'</td><td><div id="'+intPlaceCastId+'" align=center><img src="/ImageFiles/common/'+ActiveImg+'" border=0 onclick="ToggleIsActive('+intPlaceCastId+','+ActiveValue+')" style="cursor:hand"></div></td><td><div align="center" ><a href="/admin/Waypoint/ViewWaypoint.php?id='+intPlaceCastId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Waypoint"></a></div></td><td><div align="center" ><a href="PlaceCastDetail.php?id='+intPlaceCastId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Detail"></a></div></td><td ><div align="center"><a href="#" onClick="DeltePlaceCast('+intPlaceCastId+')"><img src="/ImageFiles/common/remove.gif" border=0 alt="Remove"></a></div></td><td><div align="center" >'+imgDownload+'</div></td></tr>';
				}
				strHtml+='<table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			}	
			else if(intPageNo==1)
			{
				var strHtml='<table width="650" border="0" align="center" cellpadding="5" cellspacing="1">';
				strHtml+='<tr>';
				strHtml+='<td class="RegistrationBodyText" align="center">'+PLACECAST_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			}
			else
			{
				intPageNo=intPageNo-1;
				getListPlaceCast();
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
	
	function DeltePlaceCast(PlaceCastId)
	{
		<?php 
		if(isset($_SESSION[sessionKeys::ADMIN_TYPE]) && $_SESSION[sessionKeys::ADMIN_TYPE]==3) 
		{
		?>
			if(window.confirm("Are you sure, you want to delete PlaceCast?"))
			{
				obj.PlaceCastDeleteById(PlaceCastId,function(result)
				{
					parseXMLDeleteResponse(result);
				});
			}	
		<?php
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
					document.getElementById("divError").innerHTML=PLACECAST_SUCCESSFULLY_DELETED;
					getListPlaceCast();
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
					document.getElementById("divError").innerHTML=PLACECAST_SUCCESSFULLY_DELETED;
					getListPlaceCast();
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
	getListPlaceCast();
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
	getListPlaceCast();
}

function ToggleIsActive(pIntPlaceCastId,intIsActive)
{
	if(window.confirm('Are you sure, you want to change its status'))
	{
		obj.ToggleIsActive(pIntPlaceCastId,intIsActive,function(result){
		//	alert(pIntPlaceCastId);
		if(result==1)
		{
			var ActiveValue = 0;
			var ActiveImg = 'done.gif';
		}
		else
		{
			var ActiveValue = 1;						
			var ActiveImg = 'error.gif';
		}
	
			document.getElementById(pIntPlaceCastId).innerHTML='<img src="/ImageFiles/common/'+ActiveImg+'" border=0 onclick="ToggleIsActive('+pIntPlaceCastId+','+ActiveValue+')" style="cursor:hand">';

	});
	}
}

function downloadPlaceCast(intPlaceCastId)
{
	obj.downloadPlaceCast(intPlaceCastId,function(result)
								{
									if(result=='ok')
									{
										location.href='/Contents/PlaceCasts/'+intPlaceCastId+'.zip';;
									}
									else
									{
										document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
										document.getElementById("divError").innerHTML=ERROR_DOWNLOADING_PLACECAST;
										getListPlaceCast();
										document.getElementById("tr_id").style.display = 'inline';			
										document.getElementById("error").focus();			
										
									}
								}
								);
	
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
    <td colspan="2" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Admin/header.php");?></td>
  </tr>
  <tr>
    <td width="149" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Admin/LeftMenu.php");?></td>
    <td align="left" valign="top" height="470"><!-- InstanceBeginEditable name="body" -->
<table width="845" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
  <form name="frmPlaceCast" action="" method="post" onSubmit="">
    <tr  class="RegistrationCellBg">
      <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;View PlaceCasts</p></td>
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
      <td height="21" colspan="2" valign="top" align="center">		
<div id="ListContainer"></div>
<div id="paging" align="center" class="RegistrationBodyText"></div>	 
<div id="loading" style="display:none" class="RegistrationBodyText" align="center">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16" align="absmiddle"></div>
 </td>
    </tr>
    <tr>
      <td height="10" colspan="2" valign="top">	  </td>
    </tr>
    <tr align="left">
      <td colspan="2">&nbsp;</td>
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
<script language="javascript">getListPlaceCast();</script>
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}
?>
