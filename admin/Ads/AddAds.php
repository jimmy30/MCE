<?php 

require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/ManageFile.php');

include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");

require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Admin/Ads/AddAdsService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Admin/Ads/ViewAdsService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");


//Property class object
$objProperties=new Properties();
//Load property file
$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT']."/Properties/default.properties"));

/*$strFileName = $_FILES['txtAdsImgage']['name'];

$strDirPath=$_SERVER['DOCUMENT_ROOT']."/".$objProperties->getProperty('ads_upload_directory');
if(isset($_POST['txtAdsName']))
{
	$strFileName = $_FILES['txtAdsImgage']['name'];
	$objFileUpload=new ManageFile();
	$intCounter=0;
	$objFileUpload->setFileName($_FILES['txtAdsImgage']['name']);
	$objFileUpload->setTempFileName($_FILES['txtAdsImgage']['tmp_name']);
	$status=$objFileUpload->saveSingleFile($strDirPath);

}	
*/


try
{
	$objReg = new ViewAdsService();
	/*NAJAX_Server::allowClasses("ViewAdsService");*/
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
<title>MCE-Adds </title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script  language="javascript" type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Tooltip.js"></script>


<script type="text/javascript" src="/IncludeFiles/Javascript/Admin/Ads/Adds.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>
<script type="text/javascript" src="/IncludeFiles/Javascript/ClientChecks.js"></script>
<script language="javascript">
function InsertRecord()
{
	try
	{
			if(ValidateForm())
			{
				//var strFileUploadStatus='<?php //echo($status);?>';
				//if(strFileUploadStatus=='yes')
				//{
					
					var objAds = <?= NAJAX_Client::register(new AddAdsService()) ?>;
					var objDate = new Date();
					var currentDate='';
					var strName="";
					var dteExpiryDate="";
					var strDescription="";
					var strSize=document.frmAddAds.cbmAdSize.value;
					var strSniffet=document.frmAddAds.textSiffet.value;
					var strImage='';
					var status="";
					var intLength="";
					var arrGroup=new Array();
					var intCountArray=0;

					strName=document.frmAddAds.txtAdsName.value;
					dteExpiryDate=document.frmAddAds.cmbYear.value+'-'+document.frmAddAds.cmbMonth.value+'-'+document.frmAddAds.cmbDay.value
					strDescription=document.frmAddAds.txtAdsDescription.value;
					if(document.frmAddAds.rdoStatus[0].checked)
						status = document.frmAddAds.rdoStatus[0].value;
					else if(document.frmAddAds.rdoStatus[1].checked)
						status = document.frmAddAds.rdoStatus[1].value;	
					currentDate=objDate.getYear()+"-"+objDate.getMonth()+"-"+objDate.getDate();
					
					intLength=document.frmAddAds.chkPage.length;
					
					for(intCounter=0;intCounter<intLength;intCounter++)
					{
			
						if(document.frmAddAds.chkPage[intCounter].checked)
						{
								
							arrGroup[intCountArray]=document.frmAddAds.chkPage[intCounter].value;
							intCountArray++;
						}
					}	

					objAds.InsertAds(strName,strDescription,strImage,dteExpiryDate,currentDate,status,arrGroup,strSize,strSniffet,function(result)
					{

						//alert(arrGroup.length);
						
						parseInsertXMLResponse(result);
						
						
					});
				//}
				
				//else if (strFileUploadStatus=='no')
				//{
				//	document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
				//	document.getElementById("divError").innerHTML=ADDS_FILE_UPLOAD_ERROR;
				//}	
			}
			else
			{
				return false;
			}
		
	}
	catch(e)	
	{
		alert(e.message);
	}
}
function getPagesList() 
{
	var objPages = <?= NAJAX_Client::register(new ViewAdsService()) ?>;
	objPages.GetListPageGroup('',function(result)
	{
		parseXMLResponse(result);
		
	});


}

function parseXMLResponse(pResponse)
{
		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var strGroups="";
		var strGroupName="";
		var intExceptionNo="";
		var strExceptionName="";
		var strHtml="";
		var intNoOfRecords="";
		var intNoOfPages="";
		var intGroupId="";
		var strPageId="";
		var strPages="";
		var intGroupCounter=0;
		XMLDoc.async = "false";

		if (window.ActiveXObject)
		{
			if(XMLDoc.loadXML(pResponse)==true)
			{
		
				rootNode=XMLDoc.documentElement;
				intNoOfRecords=rootNode.selectSingleNode("NoOfGroups").text;
				strHtml+='<table border=0>';
				strHtml+='<tr >';
				for(i=0;i< intNoOfRecords;i++)	
				{
					intGroupCounter++;
					intGroupId=rootNode.selectSingleNode("GroupList").childNodes.item(i).childNodes.item(0).text;
					strGroupName=rootNode.selectSingleNode("GroupList").childNodes.item(i).childNodes.item(1).text;
					
					strHtml+='<td class="RegistrationBodyText" width=150><input id=chkPage name=chkPage type=checkbox value='+intGroupId+'>'+strGroupName+'</td>';
								
							
					if(intGroupCounter==3)
					{

						strHtml+='</tr><tr>';
						intGroupCounter=0;	
					}	
					//strHtml+='</td>';	
				
					/*
					intNoOfPages=rootNode.selectSingleNode("GroupList").childNodes.item(i).childNodes.item(3).text;
					for (j=0;j< intNoOfPages;j++)	
					{
						strPageName=rootNode.selectSingleNode("GroupList").childNodes.item(i).childNodes.item(2).childNodes.item(j).childNodes.item(1).text;
						
					}
					*/
					
				}
					strHtml+='</tr>';
				strHtml+='</table>';	
				document.getElementById("ListContainer").innerHTML = strHtml;
			}	
		}
		else
		{
			var xmlDoc = XMLDoc.parseFromString(pResponse, "application/xml");
			var strGroups = xmlDoc.getElementsByTagName('Groups');

			intNoOfRecords = strGroups[0].getElementsByTagName('NoOfGroups')[0].textContent;
		
			strHtml+='<table border=0>';
			for(i=0;i< intNoOfRecords;i++)	
			{

				intGroupId=strGroups[0].getElementsByTagName('GroupId')[i].textContent;
				strGroupName=strGroups[0].getElementsByTagName('GroupName')[i].textContent;
				strHtml+='<tr ><td class="RegistrationBodyText"><input id=chkPage name=chkPage type=checkbox value='+intGroupId+'>'+strGroupName+'</td></tr>';
			}
			strHtml+='</table>';	
			document.getElementById("ListContainer").innerHTML = strHtml;
		}
}			

function parseInsertXMLResponse(pResponse)
{
		alert(pResponse);
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
					document.getElementById("divError").innerHTML=ADDS_SUCCUSSFULLY_ADDED;
				}
				else if(strStatus==-1)
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=ADDS_ERROR;

				}
				else if(strStatus==0)
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=ADDS_ERROR;
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
					document.getElementById("divError").innerHTML=ADDS_SUCCUSSFULLY_ADDED;
				}
				else if(strStatus==-1)
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=ADDS_ERROR;

				}
				else if(strStatus==0)
				{
					document.getElementById("strip_image").src="/ImageFiles/common/error.gif";
					document.getElementById("divError").innerHTML=ADDS_ERROR;
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

</script><!-- InstanceEndEditable -->
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

<table width="845" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
  <form name="frmAddAds" method="post">
    <tr  class="RegistrationCellBg">
      <td align="left" colspan="2" valign="middle"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Add Adds  </p></td>
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
      <td colspan="2"><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="left" valign="middle">
          <td class="RegistrationBodyText">&nbsp;</td>
        </tr>
        <tr align="left" valign="middle">
          <td width="6548" height="27" class="RegistrationBodyText"><strong><font color="red" size="3">*</font>Name </strong></td>
        </tr>
        
        <tr>
          <td height="40" align="left" class="RegistrationBodyText"><input name="txtAdsName" type="text" id="txtAdsName" size="30"><img src="/ImageFiles/common/questionIcon.jpg" width="20" height="20" align="absmiddle" onMouseover="ddrivetip(ADMIN_ADD_ADDNAME_TOOLTIP,190 )" onMouseout='hideddrivetip()'></td>
        </tr>
        <tr>
          <td height="27" align="left" class="RegistrationBodyText"><strong><font color="red" size="3">*</font>Description</strong></td>
        </tr>
        <tr>
          <td height="89" align="left" class="RegistrationBodyText"><textarea name="txtAdsDescription" id="txtAdsDescription" cols="23" rows="5"></textarea></td>
        </tr>
		<tr>
          <td height="27" align="left" class="RegistrationBodyText"><strong>Advertisement Size </strong></td>
        </tr>
        <tr>
          <td height="37" align="left" class="RegistrationBodyText"><select name="cbmAdSize"><option value="400 x 60">400 x 60</option></select></td>
        </tr>
		<tr>
          <td height="27" align="left" class="RegistrationBodyText"><strong>Sniffet </strong></td>
        </tr>
        <tr>
          <td height="37" align="left" class="RegistrationBodyText"><textarea name="textSiffet" id="textSiffet" cols="50" rows="10"></textarea></td>
        </tr>
        

		<tr>
          <td height="34" align="left" class="RegistrationBodyText"><strong>Groups </strong>(Please select the Group(s)) </td>
        </tr>
		
		<tr>
		  <td class="RegistrationBodyText">&nbsp;</td>
		  </tr>
		<tr>
         
		  <td> <div id="ListContainer"></div></td>
        </tr>
		
		<tr>
          <td  height="27" align="left" class="RegistrationBodyText"><strong>Status</strong></td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">&nbsp;&nbsp; <input name="rdoStatus" id="radio" type="radio" value="1">
            Active </td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">&nbsp;&nbsp;
            <input name="rdoStatus" id="rdoStatus" type="radio" value="0" checked="checked"> 
            Inactive </td>
        </tr>
      </table></td>
    </tr>
    <tr align="left">
      <td colspan="2"> <table width="660" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="14" align="left" valign="top">&nbsp;</td>
            <td height="14" colspan="2" align="left" valign="top"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div>
              <span class="RegistrationBodyText">
              <input type="hidden" name="cmbDay" id="cmbDay" value='00'>
              <input type="hidden" name="cmbMonth" id="cmbMonth" value='00'>
              <input name="cmbYear" type="hidden" id="cmbYear" value="0000">
              </span></td>
          </tr>
          <tr>
            <td width="169" height="30" align="left" valign="top">&nbsp;</td>
            <td width="154" align="left" valign="top"><input name="Submit" type="button" class="RegistrationButton" id="Submit" value="Add Ads" onClick="InsertRecord()"></td>
            <td width="337" align="left" valign="top"><input name="Submit" type="Button" class="RegistrationButton" id="cancel" value="Cancel" onClick="javascript:location.href='ViewAds.php'"></td>
          </tr>
      </table></td>
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
<script language="javascript">getPagesList();</script>
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}

?>
