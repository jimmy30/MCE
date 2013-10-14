<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Waypoint/Producer/ViewWaypointService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");

try
{

	$objReg = new ViewWaypointService();
	NAJAX_Server::allowClasses("ViewWaypointService");
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
<title>MCE-Add Waypoint</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>
<script language="javascript">
var obj = <?= NAJAX_Client::register(new ViewWaypointService()) ?>;
var intPageNo=1;
var strSortingArrow='<?php echo $sort_arrow_image?>';
var intSortListBy='<?php echo $sort_list_by?>';
var altColor;
var i;
var intPlaceCastCountryId;

var intLat1;
var intLong1;
var intLat2;
var intLong2;
var intLat3;
var intLong3;
var intLat4;
var intLong4;
var intCounter;
function getPlaceCast()
{

obj.GetPlaceCastById(<?php echo $_REQUEST["id"]?>,3,function(result){parsePlaceCastXMLResponse(result);});
}

function parsePlaceCastXMLResponse(pResponse)
{

		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var intExceptionNo="";
		var strExceptionName="";
		var strResonse=pResponse;
		var strHtml='';
			  
		XMLDoc.async = "false";	  

		// For Internet Explorer	  
		if (window.ActiveXObject)
		{	  
			if(strResonse!=null)
			{				
				if(XMLDoc.loadXML(strResonse)==true)
				{
					rootNode=XMLDoc.documentElement;
	
						intPlaceCastId=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(0).text;
						strPlaceCastName=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(1).text;				
						strPlaceCastAddress=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(2).text;				
						strPlaceCastCity=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(3).text;				
						strPlaceCastCountry=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(4).text;				
						strPlaceCastState=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(5).text;				
						strPlaceCastZipCode=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(6).text;
						intPlaceCastCountryId=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(7).text;
						intLat1=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(8).text;
						intLong1=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(9).text;
						intLat2=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(10).text;
						intLong2=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(11).text;
						intLat3=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(12).text;
						intLong3=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(13).text;
						intLat4=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(14).text;
						intLong4=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(15).text;
				}
			}
		}
		// For other browser eg. FireFox
		else
		{
			if(strResonse!=null)
			{
				
				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strPlaceCastList = xmlDoc.getElementsByTagName('PlaceCast');
					intPlaceCastId=strPlaceCastList[0].getElementsByTagName('PlaceCastId')[0].textContent;
					strPlaceCastName=strPlaceCastList[0].getElementsByTagName('PlaceCastName')[0].textContent;				
					strPlaceCastAddress=strPlaceCastList[0].getElementsByTagName('PlaceCastAddress')[0].textContent;
					strPlaceCastCity=strPlaceCastList[0].getElementsByTagName('PlaceCastCity')[0].textContent;
					strPlaceCastCountry=strPlaceCastList[0].getElementsByTagName('PlaceCastCountryName')[0].textContent;
					strPlaceCastState=strPlaceCastList[0].getElementsByTagName('PlaceCastStateName')[0].textContent;
					strPlaceCastZipCode=strPlaceCastList[0].getElementsByTagName('PlaceCastStateZipCode')[0].textContent;
					intPlaceCastCountryId=strPlaceCastList[0].getElementsByTagName('PlaceCastCountryId')[0].textContent;
					intLat1=strPlaceCastList[0].getElementsByTagName('PlaceCastLat1')[0].textContent;
					intLong1=strPlaceCastList[0].getElementsByTagName('PlaceCastLong1')[0].textContent;
					intLat2=strPlaceCastList[0].getElementsByTagName('PlaceCastLat2')[0].textContent;
					intLong2=strPlaceCastList[0].getElementsByTagName('PlaceCastLong2')[0].textContent;
					intLat3=strPlaceCastList[0].getElementsByTagName('PlaceCastLat3')[0].textContent;
					intLong3=strPlaceCastList[0].getElementsByTagName('PlaceCastLong3')[0].textContent;
					intLat4=strPlaceCastList[0].getElementsByTagName('PlaceCastLat4')[0].textContent;
					intLong4=strPlaceCastList[0].getElementsByTagName('PlaceCastLong4')[0].textContent;

				
			}
		}
			   strHtml+='<table width="650" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">';
        strHtml+='<tr>';
          strHtml+='<td class=RegistrationCellBg width="135" align="center"><div align="left" class="TabTopTextHightLight"><strong>PlaceCast Name:</strong></div></td>';
          strHtml+='<td bgcolor="#EEEEEE" colspan="2" width="515" class="RegistrationBodyText">'+strPlaceCastName+'</td>';
        strHtml+='</tr>';
        strHtml+='<tr>';
          strHtml+='<td class=RegistrationCellBg align="center" valign="top"><div align="left" class="TabTopTextHightLight"><strong>Location:</strong></div></td>';
          strHtml+='<td bgcolor="#EEEEEE"  colspan="2" align="center" class="RegistrationBodyText"><div align="left">'+strPlaceCastAddress+'<br>'+strPlaceCastCity+','+strPlaceCastCountry+',<br>'+strPlaceCastState+','+strPlaceCastZipCode+'</div></td>';
      strHtml+='</table>';
document.getElementById("headContainer").innerHTML = strHtml;
}

var arrayFolderContent = new Array();
	function getListWaypoint()
	{
		////// hide error strip /////
		document.getElementById("tr_id").style.display = 'none';
		///////////////////////////
		var intPlaceCastId=<?php echo $_REQUEST["id"]?>;
		/////// Get Waypoint Folder condent //////////
		obj.getListWaypointFolder(intPlaceCastId,function(result)
		{
				arrayFolderContent=result;
				
		});		
		//////////////////////////////////////////////

		var arrayPagingLimit = new Array();
		arrayPagingLimit = obj.getPagingLimit(intPageNo);

		obj.GetListByPlaceCastId(<?php echo $_REQUEST["id"]?>,arrayPagingLimit[0],arrayPagingLimit[1],3,intSortListBy,function(result){parseXMLResponse(result);});
		obj.WaypointRecordCountByPlaceCast(<?php echo $_REQUEST["id"]?>,3,function(result){getPaging(result);});		
	}

	function parseXMLResponse(pResponse)
	{

		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var intExceptionNo="";
		var strExceptionName="";
		var strResonse=pResponse;
		var strHtml='';
			//	alert(pResponse);
			  strHtml+='<table width="650" border="0" align="center" cellpadding="5" cellspacing="1">';
			  strHtml+='<tr class="RegistrationCellBg">';
			  strHtml+='<td width="60" class="RegistrationTitleTextSmall" align="center"><strong>ID#</strong></td>';
			  strHtml+='<td width="346" class="RegistrationTitleTextSmall"><strong>Waypoint Detail&nbsp;<a href="#" class="RegistrationTitleText" onclick="javascript:SortListBy()"><img src="/ImageFiles/common/'+strSortingArrow+'" border=0 alt="Sort"></a></strong></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Content</strong></div></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Detail</strong></div></td>';
			  strHtml+='<td width="50" class="RegistrationTitleTextSmall"><div align="center"><strong>Edit</strong></div></td>';
			  strHtml+='<td width="59" class="RegistrationTitleTextSmall" ><div align="center"><strong>Remove</strong></div></td>';
			  strHtml+='</tr>';
		XMLDoc.async = "false";	  
		// For Internet Explorer	  

		if (window.ActiveXObject)
		{	  
			if(strResonse!=null)
			{

				if(XMLDoc.loadXML(strResonse)==true)
				{
					rootNode=XMLDoc.documentElement;
					intNoOfRecords=rootNode.selectSingleNode("NoOfRecords").text;
					intCounter=0;
					for(i=0;i< intNoOfRecords;i++)	
					{
						if((Math.round(i - (Math.floor(i/2)*2)))==0)
						{
								altColor=ALTERNATE_COLOR_NORMAL;
						}		
						else
						{
							altColor=ALTERNATE_COLOR;
						}	
						intCounter=intCounter+1;	
						intWaypointId=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(0).text;
						strWaypointName=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(1).text;				
						strWaypointAddress=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(2).text;				
						strWaypointCity=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(3).text;				

						imgFile='add.gif';						
						alt='Add Content';							
	
						if(arrayFolderContent!=null)	
						{
							for(var j=0;j<arrayFolderContent.length;j++)
							{
								if(arrayFolderContent[j]==intWaypointId)
								{
									imgFile='edit.gif';
									alt='Edit Content';
								}
							}
						}
						strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td class="RegistrationBodyText" align="center">'+intCounter+'</td><td class="RegistrationBodyText" ><b>'+strWaypointName+'</b><br>'+strWaypointAddress+',<br>'+strWaypointCity+'</td><td><div align="center" ><a href="/mce.php?id='+intWaypointId+'&pid=<?php echo $_REQUEST["id"]?>&cid='+intPlaceCastCountryId+'&waypointname='+strWaypointName+'"><img src="/ImageFiles/common/'+imgFile+'" border=0 alt="'+alt+'"></a></div></td><td><div align="center" ><a href="WaypointDetail.php?id='+intWaypointId+'&pid=<?php echo $_REQUEST["id"]?>&lat1='+intLat1+'&long1='+intLong1+'&lat2='+intLat2+'&long2='+intLong2+'&lat3='+intLat3+'&long3='+intLong3+'&lat4='+intLat4+'&long4='+intLong4+'&counterId='+intCounter+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Detail"></a></div></td><td><div align="center"><a href="EditWaypoint.php?id='+intWaypointId+'&pid=<?php echo $_REQUEST["id"]?>&cid='+intPlaceCastCountryId+'&counterId='+intCounter+'"><img src="/ImageFiles/common/edit.gif" border=0 alt="Edit"></a></div></td><td><div align="center"><a href="#" onClick="DelteWaypoint('+intWaypointId+',<?php echo $_REQUEST["id"]?>)"><img src="/ImageFiles/common/remove.gif" border=0 alt="Remove"></a></div></td></tr>';
					}
					strHtml+='<table>';
					document.getElementById("ListContainer").innerHTML = strHtml;
		
				}
			}
			else if(intPageNo==1)
			{
				strHtml+='<tr>';
				strHtml+='<td bgcolor="FFFFAE" height=26 colspan=6 class="RegistrationBodyText" align="center"><img src=/ImageFiles/common/warning.gif>&nbsp;'+WAYPOINT_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			
			}
			else
			{
			intPageNo=intPageNo-1;
			getListWaypoint();
			}
		}
		// For other browser eg. FireFox
		else
		{
			if(strResonse!=null)
			{
				

				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strWayPoints = xmlDoc.getElementsByTagName('Waypoints');
				var intNoOfRecords= strWayPoints[0].getElementsByTagName('NoOfRecords')[0].textContent;
	
				var strWayPointList = xmlDoc.getElementsByTagName('Waypoint');
				for(i=0;i< intNoOfRecords;i++)	
				{
					if((Math.round(i - (Math.floor(i/2)*2)))==0)
					{
							altColor=ALTERNATE_COLOR_NORMAL;
					}		
					else
					{
						altColor=ALTERNATE_COLOR;
					}
					intCounter=intCounter+1;	
					intWaypointId=strWayPointList[i].getElementsByTagName('WaypointId')[0].textContent;
					strWaypointName=strWayPointList[i].getElementsByTagName('WaypointName')[0].textContent;				
					strWaypointAddress=strWayPointList[i].getElementsByTagName('WaypointAddress')[0].textContent;
					strWaypointCity=strWayPointList[i].getElementsByTagName('WaypointCity')[0].textContent;
					imgFile='add.gif';						
					alt='Add Content';							

						if(arrayFolderContent!=null)	
						{
							for(var j=0;j<arrayFolderContent.length;j++)
							{
								if(arrayFolderContent[j]==intWaypointId)
								{
									imgFile='edit.gif';
									alt='Edit Content';
								}
							}
						}

									
					strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td class="RegistrationBodyText" align="center">'+intWaypointId+'</td><td class="RegistrationBodyText" ><b>'+strWaypointName+'</b><br>'+strWaypointAddress+',<br>'+strWaypointCity+'</td><td><div align="center" ><a href="/mce.php?id='+intWaypointId+'&pid=<?php echo $_REQUEST["id"]?>&cid='+intPlaceCastCountryId+'"><img src="/ImageFiles/common/'+imgFile+'" border=0 alt="'+alt+'"></a></div></td><td><div align="center" ><a href="WaypointDetail.php?id='+intWaypointId+'&pid=<?php echo $_REQUEST["id"]?>&lat1='+intLat1+'&long1='+intLong1+'&lat2='+intLat2+'&long2='+intLong2+'&lat3='+intLat3+'&long3='+intLong3+'&lat4='+intLat4+'&long4='+intLong4+'&counterId='+intCounter+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Detail"></a></div></td><td><div align="center"><a href="EditWaypoint.php?id='+intWaypointId+'&pid=<?php echo $_REQUEST["id"]?>&cid='+intPlaceCastCountryId+'&counterId='+intCounter+'"><img src="/ImageFiles/common/edit.gif" border=0 alt="Edit"></a></div></td><td><div align="center"><a href="#" onClick="DelteWaypoint('+intWaypointId+',<?php echo $_REQUEST["id"]?>)"><img src="/ImageFiles/common/remove.gif" border=0 alt="Remove"></a></div></td></tr>';
				}
				strHtml+='<table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			}
			else if(intPageNo==1)
			{
				strHtml+='<tr>';
				strHtml+='<td bgcolor="FFFFAE" height=26 colspan=6 class="RegistrationBodyText" align="center"><img src=/ImageFiles/common/warning.gif>&nbsp;'+WAYPOINT_NO_RECORD_EXIST+'</td>';
				strHtml+='</tr>';
				strHtml+='</table>';
				document.getElementById("ListContainer").innerHTML = strHtml;
			
			}
			else
			{
			intPageNo=intPageNo-1;
			getListWaypoint();
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
	
	function DelteWaypoint(WaypointId,PlaceCastId)
	{
		<?php 
		if(isset($_SESSION[sessionKeys::USER_ID]) && $_SESSION[sessionKeys::USER_ID]!="") 
		{
		?>
			if(window.confirm("Are you sure, you want to delete Waypoint?"))
			obj.WaypointDeleteById(WaypointId,PlaceCastId,function(result)
			{

				parseXMLDeleteResponse(result);
			});
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
		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var intExceptionNo="";
		var strExceptionName="";
		var strResonse=pResponse;

		XMLDoc.async = "false";
		// For Internet Explorer	  
		if (window.ActiveXObject)
		{	
			if(XMLDoc.loadXML(strResonse)==true)
			{
			
				rootNode=XMLDoc.documentElement;
				strStatus=rootNode.selectSingleNode("Status").text;
				
				if(strStatus=="ok")
				{
					if(intCounter==1)
					 getInactivePlaceCast();

					document.getElementById("strip_image").src="/ImageFiles/common/done.gif";
					document.getElementById("divError").innerHTML=WAYPOINT_SUCCESSFULLY_DELETED;
					getListWaypoint();
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
		else
		{
			var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
			var strResponse = xmlDoc.getElementsByTagName('Response');
    	    var strStatus = strResponse[0].getElementsByTagName('Status')[0].textContent;
			if(strStatus=="ok")
			{
					document.getElementById("strip_image").src="/ImageFiles/common/done.gif";
					document.getElementById("divError").innerHTML=WAYPOINT_SUCCESSFULLY_DELETED;
					getListWaypoint();
			}
			else
			{
				intExceptionNo= strResponse[0].getElementsByTagName("ExceptionNo")[0];
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
	function GoToPage(pPageNo)
	{
	intPageNo=pPageNo;
	getListWaypoint();
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
	getListWaypoint();
}

function getInactivePlaceCast()
{
obj.GetPlaceCastInactive(<?php echo $_REQUEST["id"]?>,0,function(result){parsePlaceCastXMLResponse(result);});
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
function submitFrmAddnew()
{
	intCounter=parseInt(intCounter)+1;
	document.frmAddNew.method='POST';
	document.frmAddNew.action='AddWaypoint.php?id=<?php echo $_REQUEST["id"]?>&cid='+intPlaceCastCountryId+'&counterId='+intCounter;
	document.frmAddNew.submit();
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
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder" height="100%">
  <form name="frmWaypoint" action="" method="post" onSubmit="">
    <tr  class="RegistrationCellBg">
      <td height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;View Waypoints</p></td>
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
<div id="headContainer"></div>	  	
<div id="ListContainer"></div>
<div id="paging" align="center" class="RegistrationBodyText"></div>	  </td>
    </tr>
    <tr>
      <td height="10" colspan="2" valign="top">	  </td>
    </tr>

    <tr>
      <td height="26" colspan="2" valign="top">		
<div align="center">
<input type="button" class="RegistrationButton" onClick="submitFrmAddnew()" value="Add New">&nbsp;<input type="button" class="RegistrationButton" onClick="location.href='/Placecast/Producer/ViewPlaceCast.php'" value="Back to PlaceCast">&nbsp;&nbsp;</div>	  </td>
    </tr>
    <tr align="left">
      <td colspan="2">&nbsp;</td>
    </tr>
  </form>
  <form name="frmAddNew" action=""></form>
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
<script language="javascript">
getPlaceCast();
getListWaypoint();</script>
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}
?>
