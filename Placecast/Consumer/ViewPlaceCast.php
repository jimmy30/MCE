<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ConsumerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Placecast/Consumer/ViewPlaceCastService.php");
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
<html><!-- InstanceBegin template="/Templates/userTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>MCE-Add PlaceCast</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>
<script language="javascript">
var obj = <?= NAJAX_Client::register(new ViewPlaceCastService()) ?>;
var intPageNo=1;
var strSortingArrow='<?php echo $sort_arrow_image?>';
var intSortListBy='<?php echo $sort_list_by?>';
var altColor;
var i;
var intValue;
var arrayFolderContent = new Array();
var arrQueryChecks = new Array();
var strQuery;

	function getListPlaceCast()
	{

		////// hide error strip /////
		document.getElementById("tr_id").style.display = 'none';
		///////////////////////////
		
		document.getElementById("loading").style.display = 'inline';
		
		var arrayPagingLimit = new Array();
		arrayPagingLimit = obj.getPagingLimit(intPageNo);

		<?php 
		if(isset($_SESSION[sessionKeys::USER_ID]) && $_SESSION[sessionKeys::USER_ID]!="") 
		{
		?>
		if(toggleValue==1)
		{
			if(document.getElementById("checkCountry").checked)	arrQueryChecks[0]=1; else 	arrQueryChecks[0]=0;
			if(document.getElementById("checkState").checked) arrQueryChecks[1]=1; else arrQueryChecks[1]=0;
			if(document.getElementById("checkCity").checked) arrQueryChecks[2]=1; else arrQueryChecks[2]=0;
			if(document.getElementById("checkZipCode").checked) arrQueryChecks[3]=1; else arrQueryChecks[3]=0;
		}
		else
		{
			arrQueryChecks[0]=0; arrQueryChecks[1]=0; arrQueryChecks[2]=0; arrQueryChecks[3]=0;	
		}
	
		obj.AdvanceSearch(arrayPagingLimit[0],arrayPagingLimit[1],strQuery,arrQueryChecks,1,intSortListBy,function(result){parseXMLResponse(result);});
		obj.PlaceCastSearchRecordCount(strQuery,arrQueryChecks,1,function(result){getPaging(result);});
		<?php
		}
		else 
		{
		?>
// All place cast list with out depending on session value
//		obj.GetListActive(arrayPagingLimit[0],arrayPagingLimit[1],1,intSortListBy,function(result){parseXMLResponse(result);});
//		obj.PlaceCastRecordCount(1,function(result){getPaging(result);});
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
		var blnStatus=false;	
		var imgDownload;		

			strHtml+='<table width="650" border="0" align="center" cellpadding="5" cellspacing="1">';
			strHtml+='<tr class="RegistrationCellBg">';
			  strHtml+='<td width="60" class="RegistrationTitleTextSmall" align="center"><strong>ID#</strong></td>';
			  strHtml+='<td width="346" class="RegistrationTitleTextSmall"><strong>PlaceCast Detail&nbsp;<a href="#" class="RegistrationTitleText" onclick="javascript:SortListBy()"><img src="/ImageFiles/common/'+strSortingArrow+'" border=0 alt="Sort"></a></strong></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Waypoint</strong></div></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Detail</strong></div></td>';
			  strHtml+='<td width="71" class="RegistrationTitleTextSmall" ><div align="center"><strong>Download</strong></div></td>';
			  strHtml+='<td width="100" class="RegistrationTitleTextSmall" ><div align="center"><strong>Slide Show</strong></div></td>';
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
						strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td  class="RegistrationBodyText" align="center">'+intPlaceCastId+'</td><td class="RegistrationBodyText"><b>'+strPlaceCastName+'</b><br>'+strPlaceCastCity+','+strPlaceCastCountry+',<br>'+strPlaceCastState+', '+strPlaceCastZipCode+'</td><td><div align="center"><a href="/Waypoint/Consumer/ViewWaypoint.php?id='+intPlaceCastId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Waypoint"></a></div></td><td><div align="center" ><a href="PlaceCastDetail.php?id='+intPlaceCastId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Detail"></a></div></td><td><div align="center" >'+imgDownload+'</div></td><td><div align="center"><a href="#" onclick=\'window.open("/Waypoint/Consumer/ViewSlideShow.php?id='+intPlaceCastId+'","","width=800,height=550")\'><img src="/ImageFiles/common/detail.gif" border=0 alt="View Slide Show"></a></div></td></tr>';													
					
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
				 
				 //   var strPlaceCastName = strPlaceCastList[i].getElementsByTagName('PlaceCastName')[0].textContent;
					intPlaceCastId= strPlaceCastList[i].getElementsByTagName('PlaceCastId')[0].textContent;
					strPlaceCastName=strPlaceCastList[i].getElementsByTagName('PlaceCastName')[0].textContent;
					strPlaceCastAddress=strPlaceCastList[i].getElementsByTagName('PlaceCastAddress')[0].textContent;				
					strPlaceCastCity=strPlaceCastList[i].getElementsByTagName('PlaceCastCity')[0].textContent;				
					strPlaceCastCountry=strPlaceCastList[i].getElementsByTagName('PlaceCastCountryName')[0].textContent;			
					strPlaceCastState=strPlaceCastList[i].getElementsByTagName('PlaceCastStateName')[0].textContent;				
					strPlaceCastZipCode=strPlaceCastList[i].getElementsByTagName('PlaceCastStateZipCode')[0].textContent;				
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
					strHtml+='<tr onMouseOver=\'this.bgColor="'+MOUSE_OVER_COLOR+'"\' onMouseOut=\'this.bgColor="'+altColor+'"\' bgcolor='+altColor+'><td  class="RegistrationBodyText" align="center">'+intPlaceCastId+'</td><td class="RegistrationBodyText"><b>'+strPlaceCastName+'</b><br>'+strPlaceCastCity+','+strPlaceCastCountry+',<br>'+strPlaceCastState+', '+strPlaceCastZipCode+'</td><td><div align="center"><a href="/Waypoint/Consumer/ViewWaypoint.php?id='+intPlaceCastId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Waypoint"></a></div></td><td><div align="center" ><a href="PlaceCastDetail.php?id='+intPlaceCastId+'"><img src="/ImageFiles/common/detail.gif" border=0 alt="View Detail"></a></div></td><td><div align="center" >'+imgDownload+'</div></td><td><div align="center"><a href="#" onclick=\'window.open("/Waypoint/Consumer/ViewSlideShow.php?id='+intPlaceCastId+'","","width=800,height=550")\'><img src="/ImageFiles/common/detail.gif" border=0 alt="View Slide Show"></a></div></td></tr>';													
					
				}
				strHtml+='<table>';
				document.getElementById("ListContainer").innerHTML = strHtml;	
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
		
	document.getElementById("loading").style.display = 'none';
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
	
		if(strHtml==null)
		document.getElementById("paging").innerHTML='';
		else
		document.getElementById("paging").innerHTML = '<table width="650" border="0" align="center" cellpadding="5" cellspacing="1"><tr><td height=65 align=center bgcolor='+altColor+' class=RegistrationBodyText>'+strHtml+'</td></tr></table>';
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
function downloadPlaceCast(intPlaceCastId)
{
	var objDate = new Date();
	var currentDate='';
	currentDate=objDate.getYear()+"-"+objDate.getMonth()+"-"+objDate.getDate();

	obj.downloadPlaceCast(intPlaceCastId,'<?php echo $_SESSION[sessionKeys::USER_ID]?>',currentDate,1,function(result)
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
//-->//-->
var toggleValue=0;
function AdvanceSearchSettings()
{
	if(toggleValue==0)
	{
		document.getElementById("tr_advance_search").style.display='inline';
		toggleValue=1;
	}
	else
	{
		document.getElementById("tr_advance_search").style.display='none';
		toggleValue=0;
	}
}
function searchPlaceCast()
{
	if(document.getElementById("txtQuery").value=='')
	{
		alert("Please enter query first");
		document.getElementById("txtQuery").focus();
	}
	else
	{
	intPageNo=1;
	strQuery='%'+document.getElementById("txtQuery").value+'%';
	getListPlaceCast();
	}
}
function searchAll()
{
	intPageNo=1;
	strQuery='%%';
	getListPlaceCast();
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
<table width="670" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
  <form name="frmPlaceCast" action="" method="post" onSubmit="return false">
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
      <td height="27" colspan="2" valign="top"><div align="center"><a href="#" onClick="AdvanceSearchSettings()" class="RegistrationBodyText">Advance Search</a> </div></td>
    </tr>
    <tr id="tr_advance_search" style="display:none">
      <td height="30" colspan="2" valign="top" ><table width="643" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
        <tr>
          
          <td width="137" class="RegistrationBodyText"><input type="checkbox" name="checkCountry" id="checkCountry" value="1">
            Country </td>
          <td width="127" class="RegistrationBodyText"><input type="checkbox" name="checkState" id="checkState" value="1">
            State </td>
          <td width="115" class="RegistrationBodyText"><input type="checkbox" name="checkCity" id="checkCity" value="1">
            City </td>
          <td width="130" class="RegistrationBodyText"><input type="checkbox" name="checkZipCode" id="checkZipCode" value="1">
            Zip Code </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="43" colspan="2" align="center" valign="top">
	  <div align="center">
	  <span class="InputLabelSmall">Search
        <input id="txtQuery" name="txtQuery" type="text">
          <input name="button" type="button" class="Button" value="Search" width="120" onClick="searchPlaceCast()">
      </span><a href="#" onClick="searchAll()" class="RegistrationBodyText">Search All </a></div>
	  <div id="loading" style="display:none" class="RegistrationBodyText" align="center">&nbsp;Progress...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div>	  </td>
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
<div align="center">&nbsp;&nbsp;</div>	  </td>
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
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}
?>
