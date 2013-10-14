<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Reports/WebsiteHitsReportService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");

try
{
$objReg = new WebsiteHitsReportService();
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
<script type="text/javascript" src="/IncludeFiles/Javascript/Admin/Reports/WebsiteHitsReport.js"></script>


<script language="javascript">
var obj = <?= NAJAX_Client::register(new WebsiteHitsReportService()) ?>;

var checkAction=3; // set value for search All

function getReport()
{
	if(checkAction==1)
		getReportByDate();
	else if(checkAction==3)
		getReportAll();
}


function getReportByDate()
{
var FromDate = new Date();
var ToDate = new Date();
	if(ValidateForm())
	{
		document.getElementById("loading").style.display='inline';		
		FromDate=document.getElementById("txtFromYear").value+"-"+document.getElementById("cmbFromMonth").value+"-"+document.getElementById("cmbFromDay").value;

		ToDate=document.getElementById("txtToYear").value+"-"+document.getElementById("cmbToMonth").value+"-"+document.getElementById("cmbToDay").value;
		
		document.getElementById("hiddenFromDate").value=document.getElementById("cmbFromDay").value+"-"+document.getElementById("cmbFromMonth").value+"-"+document.getElementById("txtFromYear").value;

		document.getElementById("hiddenToDate").value=document.getElementById("cmbToDay").value+"-"+document.getElementById("cmbToMonth").value+"-"+document.getElementById("txtToYear").value;
		
		document.getElementById("hiddenCountryId").value='';
				
		obj.GetWebsiteHitsReport(FromDate,ToDate,function(result) { parseXMLResponse(result);});
	}
}

function getReportAll()
{
	document.getElementById("loading").style.display='inline';

	document.getElementById("hiddenFromDate").value='';
	document.getElementById("hiddenToDate").value='';
	document.getElementById("hiddenCountryId").value='';	
	obj.GetWebsiteHitsReport(null,null,function(result) { parseXMLResponse(result);});
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
            strHtml+='<td colspan="3" class="RegistrationTitleTextSmall">Website Hits Report</td>';
          strHtml+='</tr>';
          strHtml+='<tr class="RegistrationBodyText">';
            strHtml+='<td bgcolor="#eeeeee"><strong>Client IP</strong></td>';
            strHtml+='<td bgcolor="#eeeeee"><strong>No. of Hits</strong></td>';
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

					var HitsCount=rootNode.selectSingleNode("WebsiteHitsList").childNodes.item(i).childNodes.item(0).text;
					var ClientIP=rootNode.selectSingleNode("WebsiteHitsList").childNodes.item(i).childNodes.item(1).text;




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
	
				var strWebsiteHits = xmlDoc.getElementsByTagName('WebsiteHits');
				var intCount=strWebsiteHits[0].getElementsByTagName("NoOfRecord")[0].textContent;
	
				var strWebsiteHitsList = xmlDoc.getElementsByTagName('WebsiteHit');
				for(var i=0;i<intCount;i++)
				{
	
					var HitsCount=strWebsiteHitsList[i].getElementsByTagName("WebsiteHitCount")[0].textContent;
					var ClientIP=strWebsiteHitsList[i].getElementsByTagName("CleintIP")[0].textContent;
	
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
      <td height="27" colspan="2"><p class="RegistrationTitleText"> &nbsp;&nbsp;Report </p></td>
      </tr>
    <tr>
      <td height="5" colspan="2"></td>
    </tr>
    <tr>
      <td height="19" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="18" colspan="2"><table width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td width="17%" class="RegistrationBodyText">            <label>
            <div align="left">
              <input name="rdoSearchType" type="radio" value="1" onClick="setFields(1)">
              Serch By Date:            </div>
            </label></td>
          <td width="83%" class="RegistrationBodyText"><div align="left"><strong>From:</strong>
            <select name="cmbFromDay" id="cmbFromDay" style="width:60px">
              <option value="0">[Day]</option>
              <?php $objReg->FillCmbDay()?>
              </select>
            -
  <select name="cmbFromMonth" id="cmbFromMonth" style="width:90px">
      <option value="0">[Month]</option>
    <?php $objReg->FillCmbMonth()?>
  </select>
            -
  <input name="txtFromYear" type="text" id="txtFromYear" size="4" maxlength="6" value="[Year]" onFocus="if(document.frmReport.txtFromYear.value=='[Year]') document.frmReport.txtFromYear.value=''" onBlur="if(document.frmReport.txtFromYear.value=='') document.frmReport.txtFromYear.value='[Year]'">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>To:</strong>
            <select name="cmbToDay" id="cmbToDay" style="width:60px">
              <option value="0">[Day]</option>
              <?php $objReg->FillCmbDay()?>
            </select>
            -
  <select name="cmbToMonth" id="cmbToMonth" style="width:90px">
    <option value="0">[Month]</option>
    <?php $objReg->FillCmbMonth()?>
  </select>
            -
  <input name="txtToYear" type="text" id="txtToYear" size="4" maxlength="6" value="[Year]" onFocus="if(document.frmReport.txtToYear.value=='[Year]') document.frmReport.txtToYear.value=''" onBlur="if(document.frmReport.txtToYear.value=='') document.frmReport.txtToYear.value='[Year]'">
          </div></td>
        </tr>
        <tr>
          <td class="RegistrationBodyText"><div align="left">
            <input name="rdoSearchType" type="radio" onClick="setFields(3)" value="3" checked>
            All:</div></td>
          <td class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr>
          <td class="RegistrationBodyText">&nbsp;</td>
          <td class="RegistrationBodyText">
            <div align="left">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="button" type="button" class="RegistrationButton" onClick="getReport()" value="Search">
              </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2"></td>
    </tr>
    <tr valign="top">
      <td width="422" height="19"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
      <td width="423">&nbsp;</td>
    </tr>
    <tr valign="top">
      <td colspan="2"><div id="pContainer"></div>        <div id="cContainer"></div></td>
      </tr>
    <tr align="left">
      <td height="44" colspan="2"><div align="center">
        <input name="button3" type="button" class="RegistrationButton" onClick="document.frmUserReportPrint.submit()" value="Print this Report">
      </div></td>
    </tr>
  </form>
  <form action="WebsiteHitsReportPrint.php" method="post" name="frmUserReportPrint" target="_blank">
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
document.getElementById("cmbFromDay").disabled = true;
document.getElementById("cmbFromMonth").disabled = true;
document.getElementById("txtFromYear").disabled = true;
document.getElementById("cmbToDay").disabled = true;
document.getElementById("cmbToMonth").disabled = true;
document.getElementById("txtToYear").disabled = true;
</script>
