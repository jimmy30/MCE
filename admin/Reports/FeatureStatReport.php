<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Reports/FeatureStatReportService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");

try
{
$objReg = new FeatureStatReportService();
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
<script language="javascript">
var obj = <?= NAJAX_Client::register(new FeatureStatReportService()) ?>;

function getReport()
{
	document.getElementById("loading").style.display='inline';
	obj.GetFeatureStatReport(document.getElementById("cmbUserType").value,function(result) { parseXMLResponse(result);});
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
            strHtml+='<td colspan="4" class="RegistrationTitleTextSmall">Feature Stat Report</td>';
          strHtml+='</tr>';
          strHtml+='<tr class="RegistrationBodyText">';
            strHtml+='<td bgcolor="#eeeeee"><strong>Sr# </strong></td>';
            strHtml+='<td bgcolor="#eeeeee"><strong>Page Title</strong></td>';
            strHtml+='<td bgcolor="#eeeeee"><strong>User Type</strong></td>';
            strHtml+='<td bgcolor="#eeeeee"><strong>Hits</strong></td>';
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

					var UserType=rootNode.selectSingleNode("FeatureStatList").childNodes.item(i).childNodes.item(1).text;
					var PageTitle=rootNode.selectSingleNode("FeatureStatList").childNodes.item(i).childNodes.item(2).text;
					var Hits=rootNode.selectSingleNode("FeatureStatList").childNodes.item(i).childNodes.item(4).text;

					if(UserType==1)
						var User='Consumer';
					else if(UserType==2)
						var User='Producer';
					else
						var User='General';
					
					strHtml+='<tr class="RegistrationBodyText">';
					strHtml+='<td width="10%" bgcolor="#eeeeee">'+(i+1)+'</td>';
					strHtml+='<td width="30%" bgcolor="#eeeeee">'+PageTitle+'</td>';
					strHtml+='<td width="30%" bgcolor="#eeeeee">'+User+'</td>';
					strHtml+='<td width="20%" bgcolor="#eeeeee">'+Hits+'</td>';
					strHtml+='</tr>';
						
				}
	
			}
		}
		else
		{

			if(strResonse!="")
			{

				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
	
				var strFeatureStat = xmlDoc.getElementsByTagName('FeatureStats');
				var intCount=strFeatureStat[0].getElementsByTagName("NoOfRecord")[0].textContent;
	
				var strFeatureStatList = xmlDoc.getElementsByTagName('FeatureStat');
				for(var i=0;i<intCount;i++)
				{
	
					
					var UserType=strFeatureStatList[i].getElementsByTagName("UserType")[0].textContent;
					var PageTitle=strFeatureStatList[i].getElementsByTagName("PageTitle")[0].textContent;
					var Hits=strFeatureStatList[i].getElementsByTagName("Hits")[0].textContent;

					if(UserType==1)
						var User='Consumer';
					else if(UserType==2)
						var User='Producer';
					else
						var User='General';
	
					strHtml+='<tr class="RegistrationBodyText">';
					strHtml+='<td width="10%" bgcolor="#eeeeee">'+(i+1)+'</td>';
					strHtml+='<td width="30%" bgcolor="#eeeeee">'+PageTitle+'</td>';
					strHtml+='<td width="30%" bgcolor="#eeeeee">'+User+'</td>';
					strHtml+='<td width="20%" bgcolor="#eeeeee">'+Hits+'</td>';
					strHtml+='</tr>';
	
				}
			}
		}	
		

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
          <td class="RegistrationBodyText">            <label>
            
              <div align="center">Serch By User Type:            
                <select name="cmbUserType" id="cmbUserType">
                  <option value="-2">Top 5</option>
                  <option value="-1">All</option>
                  <option value="1">Consumer</option>
                  <option value="2">Producer</option>
                  <option value="0">General</option>
                </select>
                &nbsp;
                <input name="button" type="button" class="RegistrationButton" onClick="getReport()" value="Search">
              </div>
              </label>            <div align="left"></div></td>
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
  <form action="FeatureStatReportPrint.php" method="post" name="frmUserReportPrint" target="_blank">
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
