<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/admin/Reports/UsersReportService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");

try
{
$objReg = new UsersReportService();
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
<script type="text/javascript" src="/IncludeFiles/Javascript/Admin/Reports/UsersReport.js"></script>


<script language="javascript">
var obj = <?= NAJAX_Client::register(new UsersReportService()) ?>;
/// Producer Variables
var ActiveFreeP;
var InActiveFreeP;
var ActivePremiumP;
var inactivePremiumP;
var sumFreeP;
var sumPremiumP;
var sumProducerP;

/// Consumer Variables
var ActiveFreeC;
var InActiveFreeC;
var ActivePremiumC;
var inactivePremiumC;
var sumFreeC;
var sumPremiumC;
var sumConsumerC;

function getReportByDate()
{
var FromDate = new Date();
var ToDate = new Date();
	if(ValidateForm())
	{
		
		FromDate=document.getElementById("txtFromYear").value+"-"+document.getElementById("cmbFromMonth").value+"-"+document.getElementById("cmbFromDay").value;

		ToDate=document.getElementById("txtToYear").value+"-"+document.getElementById("cmbToMonth").value+"-"+document.getElementById("cmbToDay").value;
		
		document.getElementById("hiddenFromDate").value=document.getElementById("cmbFromDay").value+"-"+document.getElementById("cmbFromMonth").value+"-"+document.getElementById("txtFromYear").value;

		document.getElementById("hiddenToDate").value=document.getElementById("cmbToDay").value+"-"+document.getElementById("cmbToMonth").value+"-"+document.getElementById("txtToYear").value;
				
		obj.GetUsersReport(FromDate,ToDate,function(result) { parseXMLResponse(result);});
	}
}
function getReportAll()
{
	document.getElementById("loading").style.display='inline';
	document.getElementById("hiddenFromDate").value='';
	document.getElementById("hiddenToDate").value='';
	obj.GetUsersReport(null,null,function(result) { parseXMLResponse(result);});
	
}


function parseXMLResponse(pResponse)
{
		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var strResonse=pResponse;		
		XMLDoc.async = "false";
		var strHtmlP='';
		var strHtmlC='';
		
		// For Internet Explorer	  
		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(strResonse)==true)
			{
		
				rootNode=XMLDoc.documentElement;
				
				ActiveFreeP=rootNode.selectSingleNode("Producer").childNodes.item(0).childNodes.item(0).text;
				InActiveFreeP=rootNode.selectSingleNode("Producer").childNodes.item(0).childNodes.item(1).text;
				sumFreeP=rootNode.selectSingleNode("Producer").childNodes.item(0).childNodes.item(2).text;
				
				ActivePremiumP=rootNode.selectSingleNode("Producer").childNodes.item(1).childNodes.item(0).text;
				InActivePremiumP=rootNode.selectSingleNode("Producer").childNodes.item(1).childNodes.item(1).text;
				sumPremiumP=rootNode.selectSingleNode("Producer").childNodes.item(1).childNodes.item(2).text;
				
				sumProducerP=rootNode.selectSingleNode("Producer").childNodes.item(2).text;

				ActiveFreeC=rootNode.selectSingleNode("Consumer").childNodes.item(0).childNodes.item(0).text;
				InActiveFreeC=rootNode.selectSingleNode("Consumer").childNodes.item(0).childNodes.item(1).text;
				sumFreeC=rootNode.selectSingleNode("Consumer").childNodes.item(0).childNodes.item(2).text;
				
				ActivePremiumC=rootNode.selectSingleNode("Consumer").childNodes.item(1).childNodes.item(0).text;
				InActivePremiumC=rootNode.selectSingleNode("Consumer").childNodes.item(1).childNodes.item(1).text;
				sumPremiumC=rootNode.selectSingleNode("Consumer").childNodes.item(1).childNodes.item(2).text;
				
				sumConsumerC=rootNode.selectSingleNode("Consumer").childNodes.item(2).text;
				
				
			}
		}
		else
		{

			var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
			var strProducer = xmlDoc.getElementsByTagName('Producer');

			ActiveFreeP=strProducer[0].getElementsByTagName('Free')[0].getElementsByTagName('Active')[0].textContent;
			InActiveFreeP=strProducer[0].getElementsByTagName('Free')[0].getElementsByTagName('InActive')[0].textContent;
			sumFreeP=strProducer[0].getElementsByTagName('Free')[0].getElementsByTagName('SumFree')[0].textContent;

			ActivePremiumP=strProducer[0].getElementsByTagName('Premium')[0].getElementsByTagName('Active')[0].textContent;
			InActivePremiumP=strProducer[0].getElementsByTagName('Premium')[0].getElementsByTagName('InActive')[0].textContent;
			sumPremiumP=strProducer[0].getElementsByTagName('Premium')[0].getElementsByTagName('SumPremium')[0].textContent;
			
			sumProducerP=strProducer[0].getElementsByTagName('Sum')[0].textContent;

			var strConsumer = xmlDoc.getElementsByTagName('Consumer');

			ActiveFreeC=strConsumer[0].getElementsByTagName('Free')[0].getElementsByTagName('Active')[0].textContent;
			InActiveFreeC=strConsumer[0].getElementsByTagName('Free')[0].getElementsByTagName('InActive')[0].textContent;
			sumFreeC=strConsumer[0].getElementsByTagName('Free')[0].getElementsByTagName('SumFree')[0].textContent;

			ActivePremiumC=strConsumer[0].getElementsByTagName('Premium')[0].getElementsByTagName('Active')[0].textContent;
			InActivePremiumC=strConsumer[0].getElementsByTagName('Premium')[0].getElementsByTagName('InActive')[0].textContent;
			sumPremiumC=strConsumer[0].getElementsByTagName('Premium')[0].getElementsByTagName('SumPremium')[0].textContent;
			
			sumConsumerC=strConsumer[0].getElementsByTagName('Sum')[0].textContent;

		}	
		
		strHtmlP+='<table width="96%" border="0" align="center" cellpadding="4" cellspacing="1" class="RegistrationTabBorder">';
          strHtmlP+='<tr class="RegistrationCellBg">';
            strHtmlP+='<td colspan="3" class="RegistrationTitleTextSmall">Producer</td>';
          strHtmlP+='</tr>';
          strHtmlP+='<tr class="RegistrationBodyText">';
            strHtmlP+='<td bgcolor="#eeeeee">&nbsp;</td>';
            strHtmlP+='<td bgcolor="#eeeeee"><strong>Free</strong></td>';
            strHtmlP+='<td bgcolor="#eeeeee"><strong>Premium</strong></td>';
            strHtmlP+='</tr>';
          strHtmlP+='<tr class="RegistrationBodyText">';
            strHtmlP+='<td width="16%" bgcolor="#eeeeee"><strong>Active</strong></td>';
            strHtmlP+='<td width="31%" bgcolor="#eeeeee">'+ActiveFreeP+'</td>';
            strHtmlP+='<td bgcolor="#eeeeee">'+ActivePremiumP+'</td>';
            strHtmlP+='</tr>';
          strHtmlP+='<tr class="RegistrationBodyText">';
            strHtmlP+='<td bgcolor="#eeeeee"><strong>Inactive</strong></td>';
            strHtmlP+='<td bgcolor="#eeeeee">'+InActiveFreeP+'</td>'
            strHtmlP+='<td bgcolor="#eeeeee">'+InActivePremiumP+'</td>';
            strHtmlP+='</tr>';
          strHtmlP+='<tr class="RegistrationBodyText">';
            strHtmlP+='<td bgcolor="#eeeeee"><strong>Total</strong></td>';
            strHtmlP+='<td bgcolor="#eeeeee"><strong>'+sumFreeP+'</strong></td>';
            strHtmlP+='<td bgcolor="#eeeeee"><strong>'+sumPremiumP+'</strong></td>';
            strHtmlP+='</tr>';
          strHtmlP+='<tr class="RegistrationBodyText">';
            strHtmlP+='<td colspan="3" bgcolor="#eeeeee"><div align="center"><strong>Grand Total = '+sumProducerP+'</strong></div></td>';
            strHtmlP+='</tr>';
            strHtmlP+='</table>';

		strHtmlC+='<table width="96%" border="0" align="center" cellpadding="4" cellspacing="1" class="RegistrationTabBorder">';
          strHtmlC+='<tr class="RegistrationCellBg">';
            strHtmlC+='<td colspan="3" class="RegistrationTitleTextSmall">Consumer</td>';
          strHtmlC+='</tr>';
          strHtmlC+='<tr class="RegistrationBodyText">';
            strHtmlC+='<td bgcolor="#eeeeee">&nbsp;</td>';
            strHtmlC+='<td bgcolor="#eeeeee"><strong>Free</strong></td>';
            strHtmlC+='<td bgcolor="#eeeeee"><strong>Premium</strong></td>';
            strHtmlC+='</tr>';
          strHtmlC+='<tr class="RegistrationBodyText">';
            strHtmlC+='<td width="16%" bgcolor="#eeeeee"><strong>Active</strong></td>';
            strHtmlC+='<td width="31%" bgcolor="#eeeeee">'+ActiveFreeC+'</td>';
            strHtmlC+='<td bgcolor="#eeeeee">'+ActivePremiumC+'</td>';
            strHtmlC+='</tr>';
          strHtmlC+='<tr class="RegistrationBodyText">';
            strHtmlC+='<td bgcolor="#eeeeee"><strong>Inactive</strong></td>';
            strHtmlC+='<td bgcolor="#eeeeee">'+InActiveFreeC+'</td>'
            strHtmlC+='<td bgcolor="#eeeeee">'+InActivePremiumC+'</td>';
            strHtmlC+='</tr>';
          strHtmlC+='<tr class="RegistrationBodyText">';
            strHtmlC+='<td bgcolor="#eeeeee"><strong>Total</strong></td>';
            strHtmlC+='<td bgcolor="#eeeeee"><strong>'+sumFreeC+'</strong></td>';
            strHtmlC+='<td bgcolor="#eeeeee"><strong>'+sumPremiumC+'</strong></td>';
            strHtmlC+='</tr>';
          strHtmlC+='<tr class="RegistrationBodyText">';
            strHtmlC+='<td colspan="3" bgcolor="#eeeeee"><div align="center"><strong>Grand Total = '+sumConsumerC+'</strong></div></td>';
            strHtmlC+='</tr>';
            strHtmlC+='</table>';

	document.getElementById("pContainer").innerHTML=strHtmlP;
	document.getElementById("cContainer").innerHTML=strHtmlC;

	document.getElementById("strHrmlProducer").value=strHtmlP;
	document.getElementById("strHrmlConsumer").value=strHtmlC;	
	
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
      <td height="27" colspan="2"><p class="RegistrationTitleText"> &nbsp;&nbsp;Users Report </p></td>
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
          <td class="RegistrationBodyText"><div align="center"><strong>From:</strong>
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
          <td class="RegistrationBodyText"><div align="center">
            <input name="button" type="button" class="RegistrationButton" onClick="getReportByDate()" value="Search By Date">
            <input name="button2" type="button" class="RegistrationButton" onClick="getReportAll()" value="Search All">
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
      <td height="19"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <td width="422"><div id="pContainer"></div></td>
      <td width="423"><div id="cContainer"></div></td>
    </tr>
    <tr align="left">
      <td height="44" colspan="2"><div align="center">
        <input name="button3" type="button" class="RegistrationButton" onClick="document.frmUserReportPrint.submit()" value="Print this Report">
      </div></td>
    </tr>
  </form>
  <form action="UsersReportPrint.php" method="post" name="frmUserReportPrint" target="_blank">
		<input type="hidden" name="hiddenFromDate" id="hiddenFromDate">
		<input type="hidden" name="hiddenToDate" id="hiddenToDate">		
		<input type="hidden" name="strHrmlConsumer" id="strHrmlConsumer">
		<input type="hidden" name="strHrmlProducer" id="strHrmlProducer">  
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
