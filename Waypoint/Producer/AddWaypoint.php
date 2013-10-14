<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Waypoint/Producer/AddWaypointService.php");
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");
$objProperties=new Properties();
//Load property file
$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT']."/Properties/default.properties"));
$strGoogleMapKey=$objProperties->getProperty('google_map_key');
try
{
	$objReg = new AddWaypointService();
	NAJAX_Server::allowClasses("AddWaypointService");
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
<title>MCE-Add Waypoint</title
><!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script  language="javascript" type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js">
</script>

<script type="text/javascript" src="/IncludeFiles/Javascript/ClientChecks.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Waypoint/Producer/AddWaypoint.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Tooltip.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo($strGoogleMapKey); ?>" type="text/javascript"></script>
<script language="javascript" src="../../IncludeFiles/JavaScript/MapCircle.js"></script>
<script language="javascript" src="../../IncludeFiles/JavaScript/GoogleWayPointMap.js"></script>
<script src="../../IncludeFiles/Javascript/GxMagnifier2.js" type="text/javascript"></script>

<script language="javascript">
var intPlaceCastLatOne;
var	intPlaceCastLongOne;
var intPlaceCastLatTwo;
var	intPlaceCastLongTwo;
var intPlaceCastLatThree;
var	intPlaceCastLongThree;
var intPlaceCastLatFour;
var	intPlaceCastLongFour;

function GetLongLat(pIntPlaceCastId)
{
	
	var objLongLat = <?= NAJAX_Client::register(new AddWaypointService()) ?>;
	objLongLat.GetPlaceCastById(pIntPlaceCastId,3,
								function(result)
								{
									parseXMLPlaceCast(result);
								});
}

function parseXMLPlaceCast(pResponse)
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
						
						intPlaceCastLatOne=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(8).text;
						intPlaceCastLongOne=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(9).text;
						
						intPlaceCastLatTwo=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(10).text;
						intPlaceCastLongTwo=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(11).text;
						
						intPlaceCastLatThree=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(12).text;
						intPlaceCastLongThree=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(13).text;
						
						intPlaceCastLatFour=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(14).text;
						intPlaceCastLongFour=rootNode.selectSingleNode("PlaceCastList").childNodes.item(0).childNodes.item(15).text;
						
						
						
							
				}
			}
		}
		else
		{
			if(strResonse!=null)
			{
				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strPlaceCasts = xmlDoc.getElementsByTagName('PlaceCasts');
				var intNoOfRecords= strPlaceCasts[0].getElementsByTagName('NoOfRecords')[0].textContent;
				var strPlaceCastList = xmlDoc.getElementsByTagName('PlaceCast');
				
				
				intPlaceCastId=strPlaceCastList[0].getElementsByTagName('PlaceCastId')[0].textContent;
				strPlaceCastName=strPlaceCastList[0].getElementsByTagName('PlaceCastName')[0].textContent;
				strPlaceCastAddress=strPlaceCastList[0].getElementsByTagName('PlaceCastAddress')[0].textContent;
				strPlaceCastCity=strPlaceCastList[0].getElementsByTagName('PlaceCastCity')[0].textContent;
				strPlaceCastCountry=strPlaceCastList[0].getElementsByTagName('PlaceCastCountryName')[0].textContent;				
				strPlaceCastState=strPlaceCastList[0].getElementsByTagName('PlaceCastStateName')[0].textContent;				
				strPlaceCastZipCode=strPlaceCastList[0].getElementsByTagName('PlaceCastStateZipCode')[0].textContent;
				
				intPlaceCastLatOne=strPlaceCastList[0].getElementsByTagName('PlaceCastLatOne')[0].textContent;
				intPlaceCastLongOne=strPlaceCastList[0].getElementsByTagName('PlaceCastLongOne')[0].textContent;
				
				intPlaceCastLatTwo=strPlaceCastList[0].getElementsByTagName('PlaceCastLatTwo')[0].textContent;
				intPlaceCastLongTwo=strPlaceCastList[0].getElementsByTagName('PlaceCastLongTwo')[0].textContent;
				
				intPlaceCastLatThree=strPlaceCastList[0].getElementsByTagName('PlaceCastLatThree')[0].textContent;
				intPlaceCastLongThree=strPlaceCastList[0].getElementsByTagName('PlaceCastLongThree')[0].textContent;
				
				intPlaceCastLatFour=strPlaceCastList[0].getElementsByTagName('PlaceCastLatFour')[0].textContent;
				intPlaceCastLongFour=strPlaceCastList[0].getElementsByTagName('PlaceCastLongFour')[0].textContent;
				
	
			}	
		}
}

function createXml()
{

	if(ValidateForm())
	{
		try
		{
			var obj = <?= NAJAX_Client::register(new AddWaypointService()) ?>;
			var objDate = new Date();
			var currentDate='';
			currentDate=objDate.getYear()+"-"+objDate.getMonth()+"-"+objDate.getDate();
	
			document.getElementById("loading").style.display="inline";
			obj.InsertWaypoint(
								'<?php echo $_REQUEST["id"]?>',
								document.getElementById("txtWaypointName").value,
								document.getElementById("txtAddress1").value,
								document.getElementById("txtCity").value,
								document.getElementById("txtLat1").value,
								document.getElementById("txtLong1").value,
								document.getElementById("txtArDescription").value,
								currentDate,
								0,
								'<?php echo $_REQUEST["cid"]?>',
								document.getElementById("txtRadius").value,
								function(result)
								{
									parseXMLResponse(result);
								});

		}
		catch(e)	
		{
			alert(e.message);
		}
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
					document.getElementById("divError").innerHTML=WAYPOINT_SUCCUSSFULLY_ADDED;
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
				document.getElementById("divError").innerHTML=WAYPOINT_SUCCUSSFULLY_ADDED;
			}
			document.getElementById("tr_id").style.display = 'inline';			
			document.getElementById("error").focus();	
		}	
	document.getElementById("loading").style.display="none";
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


<!--------------------------------------------------Yahoo Map ---------------------------------------->

	function openMapSearchSettingBox()
	{
		alert('This functionlity is still under development');
		//openAlertDialog();
		//effect_1 = Effect.SlideDown('d2',{duration:1.0}); 
		//return false;
	}

	function closeMapSearchSettingBox()
	{
		//loadMap();
		//effect_1 = Effect.SlideUp('d2',{duration:1.0}); 
		//loadMap();
		return false;
	}

	function openYahooMapDialog()
	{
		javascript:dlg.show();
		/*
		
		var	intPlaceCastLongOne;
		var intPlaceCastLatTwo;
		var	intPlaceCastLongTwo;
		var intPlaceCastLatThree;
		var	intPlaceCastLongThree;
		var intPlaceCastLatFour;
		var	intPlaceCastLongFour;*/
		intCounter='<?php echo($_GET['counterId']);?>';
		loadMap(intPlaceCastLatOne,intPlaceCastLongOne,intPlaceCastLatTwo,intPlaceCastLongTwo,intPlaceCastLatThree,intPlaceCastLongThree,intPlaceCastLatFour,intPlaceCastLongFour);
	}
</script>
<!-----------------------End Yahoo Maps------------------------------------------>


<!-------------Start Dialog ----------------->
<!-------------Start Dialog ----------------->
<?php if(isset($_SESSION[sessionKeys::USER_EMAIL]) || $_SESSION[sessionKeys::USER_EMAIL]!="")
{
?>
	<script type="text/javascript"> djConfig = { isDebug: true }; </script>
	<script type="text/javascript" src="/IncludeFiles/Javascript/dojo/dojo.js"></script>
	<script type="text/javascript">
		dojo.require("dojo.widget.Dialog");
	</script>
<?php }?>

	<script type="text/javascript">
		var dlg;
		function init(e) 
		{
			dlg = dojo.widget.byId("DialogContent");
			var btn = document.getElementById("hider");
			dlg.setCloseControl(btn);
			
		}
		dojo.addOnLoad(init);

	</script>
	
<!-------------End Dialog --------------------->


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
  <form name="frmWaypoint" action="" method="post" onSubmit="">
    <tr  class="RegistrationCellBg">
      <td align="left" colspan="2" valign="middle"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Add Waypoint </p></td>
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
  </tr>    <tr>
      <td height="5" colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2"><table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="left" valign="middle">
          <td colspan="3" class="RegistrationBodyText">&nbsp; </td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td width="244" height="29" align="left" class="RegistrationBodyText"><strong><font color="red" size="3">*</font>Waypoint Name: </strong></td>
          <td width="394" colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"><input name="txtWaypointName" type="text" id="txtWaypointName" size="30">
              <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(WAYPOINT_NAME_TOOLTIP,250 )" onMouseout='hideddrivetip()'></td>
          <td colspan="2" align="left" valign="middle">&nbsp;              </td>
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
              <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(WAYPOINT_STREET_TOOLTIP,230 )" onMouseout='hideddrivetip()'> </td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td height="29" colspan="3" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>City:</strong></td>
        </tr>
        <tr valign="middle">
          <td colspan="3" align="left"><input name="txtCity" type="text" id="txtCity" size="45" value="">
              <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(WAYPOINT_CITY_TOOLTIP,200 )" onMouseout='hideddrivetip()'> </td>
        </tr>
		
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td height="29" colspan="3" align="left"><span class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Description:</strong></span></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><textarea name="txtArDescription" cols="40" rows="5" id="txtArDescription"></textarea></td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left"><table border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
             <td width="160" align="left" class="RegistrationBodyText"><strong><strong><strong><strong><font color="red" size="3">*</font></strong>Latitute:</strong></strong> </strong></td>
              <td width="160" align="left" class="RegistrationBodyText"><strong><strong><strong><strong><font color="red" size="3">*</font></strong>Longitute:</strong></strong> </strong></td>
              <td width="160" align="left" class="RegistrationBodyText">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="middle"><input name="txtLat1" type="text" id="txtLat1" size="20" readonly></td>
              <td align="left" valign="middle"><input name="txtLong1" type="text" id="txtLong1" size="20" readonly>                </td>
              <td align="left" valign="middle"><input name="button" type="button" class="GPSTaggingButton" id="btnBrowse" onClick="javascript:openYahooMapDialog();" value="Get Map"></td>
            </tr>
            <tr>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="middle" height="29"><span class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Radius:</strong></span></td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="middle"><input name="txtRadius" type="text" id="txtRadius" size="20">
			  <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(WAYPOINT_RADIUS_TOOLTIP,200 )" onMouseout='hideddrivetip()'></td>
              <td align="left" valign="middle" class="RegistrationBodyText">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>

            <tr>
              <td height="40" align="left" valign="middle" class="RegistrationBodyText">&nbsp;</td>
              <td colspan="2" align="left" valign="middle"><div align="center">
                &nbsp;
              </div></td>
              </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr align="left">
      <td colspan="2"><table width="660" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="14" align="left" valign="top">&nbsp;</td>
            <td height="14" colspan="2" align="left" valign="top"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
          </tr>
          <tr>
            <td width="169" height="30" align="left" valign="top">&nbsp;</td>
            <td width="154" align="left" valign="top"><input name="Submit" type="Button" class="RegistrationButton" id="Submit" value="Add Waypoint" onClick="createXml()"></td>
            <td width="337" align="left" valign="top"><input name="Submit" type="Button" class="RegistrationButton" id="cancel" value="Cancel" onClick="javascript:location.href='ViewWaypoint.php?id=<?php echo $_REQUEST['id']?>'"></td>
          </tr>
      </table></td>
    </tr>
  </form>
</table>


<!------------------------------------------Start Yahoo Map Div---------------------------------------------------------------->
<div  dojoType="dialog" id="DialogContent" bgColor="white" bgOpacity="0.7" toggle="fade" toggleDuration="200">
	<form name="frmMap" id="frmMap" onsubmit="return false;">
		<table border="0" align="center" cellspacing="0" cellpadding="0">
			<tr valign="top">
				<td  colspan="6" valign="middle" bgcolor=<?php echo($strColor);?> height="30" class="HeadingText" >&nbsp;&nbsp; GPS Information</td>
			</tr>
			<tr>
				<td colspan="6" height="10"></td>
			
			</tr>
			<tr>
				<td width="1"></td>
				<td colspan="4" align="center">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td class="InputLabel">Location</td>
							<td width="5"></td>
							<td><input name="txtLocation" type="text" class="TextBox" id="txtLocation"></td>
							<td width="5"></td>
							<td colspan= align="right"><input type="button" name="search" id="search" value="Search" class="Button" onClick="searchLocation();"> </td>
							<td width="5"></td>
							
							<td width="10"></td>
							<td width="150"><div id="divSearchStatus"></div></td>
						</tr>
					</table>
				</td>	
				<td width="1"></td>
			</tr>
			<tr>
				
			</tr>
		    <tr>
				<td colspan="6" height="10"></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="4" valign="top"><div id="divMapErrorBox" style="Visibility:hidden"></div></td>
				<td>
					
				</td>
			</tr>
			<tr>
					<td valign="top">
						<table width="100" align="center" cellpadding="3" cellspacing="1" class="RegistrationTabBorder">
							<tr>
								<td width="90" bgcolor="#333333" class="HeadingText" align="center">Tool Box</td>
							</tr>
							<tr>
							  <td height="55" align="center" class="RegistrationBodyText"><input class="Button" type="button" name="btnRemove3" id="btnRemove3" onClick="RemoveAllMarker()" value="Clear All"></td>
						    </tr>
						</table>
					</td>
					<td colspan="4">
						<div id="mapContainer" style="width:800px;height:500px;"></div>
					</td>	

			</tr>
			<tr>
				<td colspan="6" height="10"></td>
			</tr>
			<tr>
				<td colspan="6"  align="center">
					<input type="button" id="hider" class="Button" value="Close">
				</td>
			</tr>
			<tr>
				<td colspan="6" height="10"></td>
			</tr>
		</table>	
	</form>
</div>

<!----------------------------------------End Yahoo Map ---------------------------------------->

<div class="notes" id="notesSection"></div>





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
<script language="javascript">GetLongLat(<?php echo $_REQUEST["id"]?>);</script>