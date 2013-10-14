<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/ManageFile.php');
	
	include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
	
	require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Admin/Ads/EditAdsService.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Admin/Ads/ViewAdsService.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");


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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script language="javascript">
var intAddId='';
var strImagePath='';
function getAddInfo()
{
	objAds = <?= NAJAX_Client::register(new EditAdsService()) ?>;
	objAds.GetAddsById(<?php echo($_GET['AddId']);?>,function(result)
	{
	
		parseXMLResponse(result);
		
	});
	
	
	
	
}

function parseXMLResponse(pStrResponse)
{
	var XMLDoc =GetXmlHttpObject();
	XMLDoc.async = "false";

	if (window.ActiveXObject)
	{
		if(XMLDoc.loadXML(pStrResponse)==true)
		{
			rootNode=XMLDoc.documentElement;
			intAddId=rootNode.selectSingleNode("AddId").text;
			strAddName=rootNode.selectSingleNode("AddName").text;
			dteExpiryDate=rootNode.selectSingleNode("AddExpiryDate").text;
			dteExpiryDate=dteExpiryDate.split("-");

			strImagePath=rootNode.selectSingleNode("AddImage").text;
			
			strDescription=rootNode.selectSingleNode("AddDescription").text;

			
			var strSize=rootNode.selectSingleNode("AddSize").text;

			var strSniffet=rootNode.selectSingleNode("AddSniffet").text;
			document.write(strSniffet);
			
		}
	}
	else
	{
			var xmlDoc = XMLDoc.parseFromString(pStrResponse, "application/xml");
			var strAdd = xmlDoc.getElementsByTagName('Adds');
			intAddId = strAdd[0].getElementsByTagName('AddId')[0].textContent;
			strAddName= strAdd[0].getElementsByTagName('AddName')[0].textContent;
			dteExpiryDate= strAdd[0].getElementsByTagName('AddExpiryDate')[0].textContent;
			dteExpiryDate=dteExpiryDate.split("-");

		
			strDescription=strAdd[0].getElementsByTagName('AddDescription')[0].textContent;
			
			var strSize=strAdd[0].getElementsByTagName('AddSize')[0].textContent;
			var strSniffet=strAdd[0].getElementsByTagName('AddSniffet')[0].textContent; 
			
			
			blnStatus=strAdd[0].getElementsByTagName('AddStatus')[0].textContent;
			
		
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
</script>	
</head>

<body>
<div id="ListContainer"></div>
</body>
</html>
<script language="javascript">getAddInfo();</script>
<?php

}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}

?>
