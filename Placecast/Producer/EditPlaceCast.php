<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Placecast/Producer/EditPlaceCastService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

try
{
	$objReg = new EditPlaceCastService();
	NAJAX_Server::allowClasses("EditPlaceCastService");
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
<title>MCE-Add PlaceCast</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script  language="javascript" type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js">
</script>

<script type="text/javascript" src="/IncludeFiles/Javascript/ClientChecks.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/PlaceCast/Producer/UpdatePlaceCast.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Tooltip.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>

<script language="javascript">
var obj = <?= NAJAX_Client::register(new EditPlaceCastService()) ?>;

function createXml()
{
	if(ValidateForm())
	{
		try
		{

			document.getElementById("loading").style.display="inline";
			obj.UpdatePlaceCast(
								'<?php echo $_REQUEST["id"]?>',
								document.getElementById("cmbCountryRegion").value,
								document.getElementById("cmbState").value,
								document.getElementById("txtPlaceCastName").value,
								document.getElementById("txtAddress1").value,
								document.getElementById("txtCity").value,
								document.getElementById("txtZipCode").value,
								document.getElementById("txtLat1").value,
								document.getElementById("txtLong1").value,
								document.getElementById("txtLat2").value,
								document.getElementById("txtLong2").value,
								document.getElementById("txtLat3").value,
								document.getElementById("txtLong3").value,
								document.getElementById("txtLat4").value,
								document.getElementById("txtLong4").value,
								document.getElementById("txtArDescription").value,
								function(result){parseXMLResponse(result);});

			

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
					document.getElementById("divError").innerHTML=PLACECAST_SUCCUSSFULLY_UPDATED;
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
				document.getElementById("divError").innerHTML=PLACECAST_SUCCUSSFULLY_UPDATED;
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
		//  For Internet Explorer
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(xmlStateList)==true)
			{
				rootNode=XMLDoc.documentElement;
				intNoOfRecords=rootNode.selectSingleNode("NoOfRecords").text;
				document.frmPlaceCast.cmbState.options.length=0;
				for(i=0;i< intNoOfRecords;i++)	
				{
					intStateId=rootNode.selectSingleNode("StateList").childNodes.item(i).childNodes.item(0).text;
					strStateName=rootNode.selectSingleNode("StateList").childNodes.item(i).childNodes.item(2).text;				
					document.frmPlaceCast.cmbState.options[i]=new Option(strStateName,intStateId);
				}
			}
		}
		else
		{
			var xmlDoc = XMLDoc.parseFromString(xmlStateList, "application/xml");
			var strState = xmlDoc.getElementsByTagName('States');
			intNoOfRecords=strState[0].getElementsByTagName('NoOfRecords')[0].textContent;	

			document.frmPlaceCast.cmbState.options.length=0;
			for(i=0;i< intNoOfRecords;i++)	
			{
		
				var strStateDetail = xmlDoc.getElementsByTagName('State');
				intStateId=strStateDetail[i].getElementsByTagName('StateId')[0].textContent;
	
				strStateName=strStateDetail[i].getElementsByTagName('StateName')[0].textContent;				
				document.frmPlaceCast.cmbState.options[i]=new Option(strStateName,intStateId);

			}	
		}	
	}

function getPlaceCast()
{

	var strResonse=obj.GetPlaceCastById('<?php echo $_REQUEST["id"]?>',3,function(result){parseXMLPalceCast(result);});

}

function parseXMLPalceCast(pResponse)
{
		
		var XMLDoc =GetXmlHttpObject();
		var strResonse=pResponse;
		XMLDoc.async = "false";
		//  For Internet Explorer
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(strResonse)==true)
			{
				rootNode=XMLDoc.documentElement;
				document.getElementById("txtPlaceCastName").value =rootNode.selectSingleNode("PlaceCastName").text;
				document.getElementById("txtAddress1").value = rootNode.selectSingleNode("PlaceCastAddress").text;
				document.getElementById("txtCity").value = rootNode.selectSingleNode("PlaceCastCity").text;			
				document.getElementById("cmbCountryRegion").value = rootNode.selectSingleNode("PlaceCastCountryId").text;
				getListStates();
				document.getElementById("cmbState").value = rootNode.selectSingleNode("PlaceCastStateId").text;
				document.getElementById("txtZipCode").value = rootNode.selectSingleNode("PlaceCastZipCode").text;									
				document.getElementById("txtArDescription").value = rootNode.selectSingleNode("PlaceCastDescription").text;									
				document.getElementById("txtLat1").value = rootNode.selectSingleNode("PlaceCastLat1").text;									
				document.getElementById("txtLong1").value = rootNode.selectSingleNode("PlaceCastLong1").text;
				document.getElementById("txtLat2").value = rootNode.selectSingleNode("PlaceCastLat2").text;									
				document.getElementById("txtLong2").value = rootNode.selectSingleNode("PlaceCastLong2").text;
				document.getElementById("txtLat3").value = rootNode.selectSingleNode("PlaceCastLat3").text;									
				document.getElementById("txtLong3").value = rootNode.selectSingleNode("PlaceCastLong3").text;
				document.getElementById("txtLat4").value = rootNode.selectSingleNode("PlaceCastLat4").text;									
				document.getElementById("txtLong4").value = rootNode.selectSingleNode("PlaceCastLong4").text;
			}
		}	
		// For other browser eg. FireFox
		else
		{
			var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
			var strPlaceCast = xmlDoc.getElementsByTagName('PlaceCast');
			document.getElementById("txtPlaceCastName").value =strPlaceCast[0].getElementsByTagName('PlaceCastName')[0].textContent;
			document.getElementById("txtAddress1").value =strPlaceCast[0].getElementsByTagName('PlaceCastAddress')[0].textContent;
			document.getElementById("txtCity").value = strPlaceCast[0].getElementsByTagName('PlaceCastCity')[0].textContent;
			document.getElementById("cmbCountryRegion").value = strPlaceCast[0].getElementsByTagName('PlaceCastCountryId')[0].textContent;
			getListStates();
			document.getElementById("cmbState").value = strPlaceCast[0].getElementsByTagName('PlaceCastStateId')[0].textContent;
			document.getElementById("txtZipCode").value = strPlaceCast[0].getElementsByTagName('PlaceCastZipCode')[0].textContent;									
			document.getElementById("txtArDescription").value = strPlaceCast[0].getElementsByTagName('PlaceCastDescription')[0].textContent;								
			document.getElementById("txtLat1").value = strPlaceCast[0].getElementsByTagName('PlaceCastLat1')[0].textContent;
			document.getElementById("txtLong1").value = strPlaceCast[0].getElementsByTagName('PlaceCastLong1')[0].textContent;
			document.getElementById("txtLat2").value = strPlaceCast[0].getElementsByTagName('PlaceCastLat2')[0].textContent;								
			document.getElementById("txtLong2").value =strPlaceCast[0].getElementsByTagName('PlaceCastLong2')[0].textContent;								
			document.getElementById("txtLat3").value = strPlaceCast[0].getElementsByTagName('PlaceCastLat3')[0].textContent;								
			document.getElementById("txtLong3").value =strPlaceCast[0].getElementsByTagName('PlaceCastLong3')[0].textContent;								
			document.getElementById("txtLat4").value =strPlaceCast[0].getElementsByTagName('PlaceCastLat4')[0].textContent;							
			document.getElementById("txtLong4").value = strPlaceCast[0].getElementsByTagName('PlaceCastLong4')[0].textContent;							
		
			//alert(strPlaceCast);
		}	
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
function resetZipCode()
{
	document.getElementById("txtZipCode").value="";
}

</script>

<!--------------------------------------------------Yahoo Map ---------------------------------------->
<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAk8dPRHlV_kG_hFvgb_jPdhQcaM2NFj5ByKgrIExaYbRca0LkLBSV33nxT9M1kkKL3DiSaf1cI-ZMiA" type="text/javascript"></script>
<script language="javascript" src="../../IncludeFiles/JavaScript/MapCircle.js"></script>
<script language="javascript" src="../../IncludeFiles/JavaScript/GooglePlaceCast.js"></script>
<script src="/IncludeFiles/Javascript/GxMagnifier2.js" type="text/javascript"></script>
<script language="javascript"  >
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
		loadMap();
	}
</script>
<!-----------------------End Yahoo Maps------------------------------------------>


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
  <form name="frmPlaceCast" action="" method="post" onSubmit="">
    <tr  class="RegistrationCellBg">
      <td colspan="2" align="left" valign="middle"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Edit PlaceCast </p></td>
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
          <td colspan="3" class="RegistrationBodyText">&nbsp; </td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td width="244" height="29" align="left" class="RegistrationBodyText"><strong><font color="red" size="3">*</font>PlaceCast Name: </strong></td>
          <td width="394" colspan="2" align="left" class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"><input name="txtPlaceCastName" type="text" id="txtPlaceCastName" size="30">
              <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(PLACECAST_NAME_TOOLTIP,250 )" onMouseout='hideddrivetip()'></td>
          <td colspan="2" align="left" valign="middle">&nbsp;              </td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td height="29" colspan="3" align="left" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>City:</strong></td>
        </tr>
        <tr valign="middle">
          <td colspan="3" align="left"><input name="txtCity" type="text" id="txtCity" size="45" value="">
              <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(PLACECAST_CITY_TOOLTIP,200 )" onMouseout='hideddrivetip()'> </td>
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
                <td align="left" valign="middle">
                  <select name="cmbState" id="cmbState" style="width:170px" onChange="resetZipCode()">
                </select></td>
                <td align="left" valign="middle">
                  <input name="txtZipCode" type="text" id="txtZipCode" size="10">
                  <img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(PLACECAST_ZIP_TOOLTIP,250)" onMouseout='hideddrivetip()'> </td>
              </tr>
          </table></td>
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
          <td colspan="3" align="left" class="RegistrationBodyText">Please specify area by entering four coordinates </td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left"><table width="637" border="0" cellspacing="0" cellpadding="0">

            <tr valign="top">
              <td align="left" class="RegistrationBodyText" height="30">&nbsp;</td>
              <td align="center" class="RegistrationBodyText" colspan="2"><input name="button" type="button" class="GPSTaggingButton" id="btnBrowse" onClick="javascript:openYahooMapDialog();" value="Get Map">
</td>
              <td align="left" class="RegistrationBodyText">&nbsp;</td>

            </tr>

            <tr valign="top">
              <td width="94" height="29" align="left" class="RegistrationBodyText"><strong> </strong></td>
              <td width="150" align="left" class="RegistrationBodyText"><strong><strong><strong><strong><font color="red" size="3">*</font></strong>Latitute:</strong></strong> </strong></td>
              <td align="left" class="RegistrationBodyText"><strong><strong><strong><strong><font color="red" size="3">*</font></strong>Longitute:</strong></strong> </strong></td>
              <td align="left" class="RegistrationBodyText"><strong>Exmple: </strong>(Way to select points)</td>
            </tr>
            <tr>
              <td align="left" valign="middle" class="RegistrationBodyText">Left-Top:</td>
              <td align="left" valign="middle"><input name="txtLat1" type="text" id="txtLat1" size="20" readonly></td>
              <td width="172" align="left" valign="middle"><input name="txtLong1" type="text" id="txtLong1" size="20" readonly>                </td>
              <td width="221" rowspan="5" align="left" valign="middle"><img src="/ImageFiles/common/MapHelpMarker.gif"></td>
            </tr>
            <tr>
              <td align="left" valign="middle" class="RegistrationBodyText">Right:-Top</td>
              <td align="left" valign="middle"><input name="txtLat2" type="text" id="txtLat2" size="20" readonly></td>
              <td align="left" valign="middle"><input name="txtLong2" type="text" id="txtLong2" size="20" readonly></td>
              </tr>
            <tr>
              <td align="left" valign="middle" class="RegistrationBodyText">Left-Bottom:</td>
              <td align="left" valign="middle"><input name="txtLat3" type="text" id="txtLat3" size="20" readonly></td>
              <td align="left" valign="middle"><input name="txtLong3" type="text" id="txtLong3" size="20" readonly></td>
              </tr>
            <tr>
              <td align="left" valign="middle" class="RegistrationBodyText">Right:-buttom</td>
              <td align="left" valign="middle"><input name="txtLat4" type="text" id="txtLat4" size="20" readonly></td>
              <td align="left" valign="middle"><input name="txtLong4" type="text" id="txtLong4" size="20" readonly></td>
              </tr>
            <tr>
              <td height="40" align="left" valign="middle" class="RegistrationBodyText">&nbsp;</td>
              <td colspan="2" align="left" valign="middle"><div align="center">
               &nbsp;
              </div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
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
            <td width="154" align="left" valign="top"><input name="txtAddress1" type="hidden" id="txtAddress1" size="45"><input name="Submit" type="Button" class="RegistrationButton" id="Submit" value="Update PlaceCast" onClick="createXml()"></td>
            <td width="337" align="left" valign="top"><input name="Submit" type="Button" class="RegistrationButton" id="cancel" value="Cancel" onClick="javascript:location.href='ViewPlaceCast.php'"></td>
          </tr>
      </table></td>
    </tr>
  </form>
</table>



<!------------------------------------------Start Yahoo Map Div---------------------------------------------------------------->
<div  dojoType="dialog" id="DialogContent" bgColor="white" bgOpacity="0.7" toggle="fade" toggleDuration="200">

  <table border="0" align="center" cellspacing="0" cellpadding="0">
    <form  onsubmit="return false;">
      <tr valign="top">
        <td height="30" colspan="5" valign="middle" bgcolor=<?php echo($strColor);?> class="HeadingText" >&nbsp;&nbsp; GPS Information</td>
      </tr>
      <tr>
        <td height="10" colspan="5"></td>
      </tr>
      <tr>
        <td width="100"></td>
        <td colspan="4" align="center"><table cellspacing="0" cellpadding="0" border="0">
            <tr>
              <td class="InputLabel">Location</td>
              <td width="5"></td>
              <td><input name="txtLocation" type="text" class="TextBox" /></td>
              <td width="5"></td>
              <td colspan= align="right"><input type="button" name="search" value="Search" class="Button" onclick="searchLocation();" />              </td>
              <td width="5"></td>
              <td><a href="#" class="LinkSmall" onclick="return openMapSearchSettingBox()">Advance</a></td>
              <td width="10"></td>
              <td width="150"><div id="divSearchStatus"></div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="4" align="center"><div id="d2" style="display:none;">
          <div  class="SearchSettings">
             
            <table border=0  cellpadding=0 cellspacing=0>
                <tr valign='top'>
                  <td colspan='5' valign='middle'  height='30' class='HeadingText' >&nbsp;&nbsp; Adnavce Search</td>
                </tr>
                <tr>
                  <td width=10></td>
                  <td align="right" class="SearchSettingText">Street:</td>
                  <td width="10">&nbsp;</td>
                  <td><input name='txtStreet' type='text' class="TextBox" /></td>
                  <td width=10></td>
                </tr>
                <tr>
                  <td></td>
                  <td  align="right" class="SearchSettingText">City:</td>
                  <td></td>
                  <td><input name='txtCity' type='text' class="TextBox" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td align="right" class="SearchSettingText">State:</td>
                  <td></td>
                  <td><input name='txtState' type='text' class="TextBox" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td align="right" class="SearchSettingText">Zip:</td>
                  <td></td>
                  <td><input name='txtZipCode' type='text' class="TextBox" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="5" height='10'></td>
                </tr>
              <td colspan='5' align='center'><a href="#" class="SearchSettingLink" onclick="return closeMapSearchSettingBox();">Close</a></td>
              </tr>
              <tr>
                <td colspan="5" height='10'></td>
              </tr>
              </table>
          </div>
        </div></td>
      </tr>
      <tr>
        <td height="10" colspan="5"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="4" valign="top"><div id="divMapErrorBox" style="Visibility:hidden"></div></td>
      </tr>
      <tr>
        <td valign="top"><table width="100" align="center" cellpadding="3" cellspacing="1" class="RegistrationTabBorder">
            <tr>
              <td width="90" bgcolor="#333333" class="HeadingText" align="center">Tool Box</td>
            </tr>
            <tr>
              <td height="55" align="center" class="RegistrationBodyText"><input class="Button" type="button" name="btnRemove3" onclick="RemoveAllMarker()" value="Clear All" /></td>
            </tr>
        </table></td>
        <td colspan="4"><div id="mapContainer" style="width:800px;height:500px;"></div></td>
        <td width="1"></td>
      </tr>
      <tr>
        <td height="10" colspan="5"></td>
      </tr>
      <tr>
        <td colspan="5"  align="center"><input name="button" type="button" class="Button" id="hider" value="Close" />        </td>
      </tr>
      <tr>
        <td height="10" colspan="5"></td>
      </tr>
    </form>
  </table>
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
<script language="javascript">getPlaceCast();</script>