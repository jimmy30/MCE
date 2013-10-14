<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Reports/AdsReportService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");

try
{
$objReg = new AdsReportService();
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
<title>MCE-Administration Area</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../IncludeFiles/Javascript/ClientChecks.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Admin/Reports/AdsReport.js"></script>


<script language="javascript">
var obj = <?= NAJAX_Client::register(new AdsReportService()) ?>;

function getReportAll()
{

	document.getElementById("hiddenFromDate").value='';
	document.getElementById("hiddenToDate").value='';
	document.getElementById("hiddenCountryId").value='';	
	obj.GetAdsReport('',function(result) { parseXMLResponse(result);});
}


function parseXMLResponse(pResponse)
{
		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var strResonse=pResponse;		
		XMLDoc.async = "false";
		var TotalHitsCount=0;

		var strHtml='';
		strHtml+='<table width="90%" border="0" align="center" cellpadding="4" cellspacing="1" class="RegistrationTabBorder">';
          strHtml+='<tr class="RegistrationCellBg">';
            strHtml+='<td colspan="3" class="RegistrationTitleTextSmall">Ads Report</td>';
          strHtml+='</tr>';
          strHtml+='<tr class="RegistrationBodyText">';
            strHtml+='<td bgcolor="#eeeeee"><strong>Groups Name</strong></td>';
            strHtml+='<td bgcolor="#eeeeee"><strong>No. of Ads</strong></td>';
            strHtml+='</tr>';

		
		// For Internet Explorer	  
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(strResonse)==true)
			{
		
				rootNode=XMLDoc.documentElement;
				var intCount=rootNode.selectSingleNode("NoOfRecord").text;
				for(var i=0;i<intCount;i++)
				{

					var HitsCount=rootNode.selectSingleNode("AdsList").childNodes.item(i).childNodes.item(0).text;
					var ClientIP=rootNode.selectSingleNode("AdsList").childNodes.item(i).childNodes.item(1).text;




				strHtml+='<tr class="RegistrationBodyText">';
				strHtml+='<td width="30%" bgcolor="#eeeeee">'+ClientIP+'</td>';
				strHtml+='<td width="30%" bgcolor="#eeeeee">'+HitsCount+'</td>';
				strHtml+='</tr>';
					
				TotalHitsCount+=parseInt(HitsCount);

				
				}
	
			}
		}
		else
		{

			if(strResonse!="")
			{

				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
	
				var strAds = xmlDoc.getElementsByTagName('Ads');
				var intCount=strAds[0].getElementsByTagName("NoOfRecord")[0].textContent;
	
				var strAdsList = xmlDoc.getElementsByTagName('WebsiteHit');
				for(var i=0;i<intCount;i++)
				{
	
					var HitsCount=strAdsList[i].getElementsByTagName("WebsiteHitCount")[0].textContent;
					var ClientIP=strAdsList[i].getElementsByTagName("CleintIP")[0].textContent;
	
					strHtml+='<tr class="RegistrationBodyText">';
					strHtml+='<td width="30%" bgcolor="#eeeeee">'+ClientIP+'</td>';
					strHtml+='<td width="30%" bgcolor="#eeeeee">'+HitsCount+'</td>';
					strHtml+='</tr>';
	
					TotalHitsCount+=parseInt(HitsCount);
				}
			}
		}	
		

	        strHtml+='<tr class="RegistrationBodyText">';
            strHtml+='<td bgcolor="#eeeeee"><strong>Total</strong></td>';
            strHtml+='<td bgcolor="#eeeeee"><strong>'+TotalHitsCount+'</strong></td>';
            strHtml+='</tr>';
            strHtml+='</table>';

	document.getElementById("pContainer").innerHTML=strHtml;

	document.getElementById("HiddenHtml").value=strHtml;
	
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

function setFields(intAction)
{
	document.getElementById("cmbFromDay").disabled = true;
	document.getElementById("cmbFromMonth").disabled = true;
	document.getElementById("txtFromYear").disabled = true;
	document.getElementById("cmbToDay").disabled = true;
	document.getElementById("cmbToMonth").disabled = true;
	document.getElementById("txtToYear").disabled = true;

	
	checkAction=intAction;
	
	if(intAction==1)
	{
		document.getElementById("cmbFromDay").disabled = false;
		document.getElementById("cmbFromMonth").disabled = false;
		document.getElementById("txtFromYear").disabled = false;
		document.getElementById("cmbToDay").disabled = false;
		document.getElementById("cmbToMonth").disabled = false;
		document.getElementById("txtToYear").disabled = false;
	}
	else if(intAction==3)
	{
	}
	
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
  <form name="frmReport" action="" method="post" onSubmit="">
    <tr class="RegistrationCellBg">
      <td width="845" height="27"><p class="RegistrationTitleText"> &nbsp;&nbsp;Report </p></td>
      </tr>
    <tr>
      <td height="5"></td>
    </tr>
    <tr>
      <td height="19">&nbsp;</td>
    </tr>
    <tr valign="top">
      <td><div id="pContainer"></div>        <div id="cContainer"></div></td>
      </tr>
    <tr align="left">
      <td height="44"><div align="center">
        <input name="button3" type="button" class="RegistrationButton" onClick="document.frmUserReportPrint.submit()" value="Print this Report">
      </div></td>
    </tr>
  </form>
  <form action="AdsReportPrint.php" method="post" name="frmUserReportPrint" target="_blank">
		<input type="hidden" name="hiddenFromDate" id="hiddenFromDate">
		<input type="hidden" name="hiddenToDate" id="hiddenToDate">		
		<input type="hidden" name="hiddenCountryId" id="hiddenCountryId">		
		<input type="hidden" name="HiddenHtml" id="HiddenHtml">
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
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}

?>
<script language="javascript">
getReportAll();
</script>
