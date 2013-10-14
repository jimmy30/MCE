<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MCE - Search Spider</title>
<script language="javascript" src="IncludeFiles/JavaScript/YahooSearch.js" type="text/javascript"></script>	
<script language="javascript" src="IncludeFiles/JavaScript/querystring.js" type="text/javascript"></script>	
<script language="javascript" src="IncludeFiles/JavaScript/Utilities.js" type="text/javascript"></script>
<script language="javascript">
function createCookie(name,value,days) {
	if(readCookie(name)==null || days==-1)
	{
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	else
	{
		var preVal=readCookie(name);
		var values=preVal.split('||');
		var chkExist=0;
		for(var ii=0;ii<values.length;ii++)
		{
			if(value==values[ii])
			chkExist=1;
		}

		if(chkExist==0)
		{
			value=preVal+"||"+value;
			
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
			}
			else var expires = "";
			document.cookie = name+"="+value+expires+"; path=/";
		}
	}
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name) {
	createCookie(name,"",-1);
}

function setValue()
{
document.getElementById("txtSearch").value=opener.document.getElementById("txtQuery").value;
createCookie('SearchTxtQuery',document.getElementById("txtSearch").value,1000);
//eraseCookie('SearchTxtQuery');
getTextResults(1);
}
</script>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");?>
<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
</head>

<body onload="setValue()">
  <table width="100%" border="0" cellspacing="2" cellpadding="2" class='RegistrationTabBorder'>
    <tr>
      <td class="RegistrationCellBg"><p class="RegistrationTitleText"><a href="#" id="focus"></a>Search Spider </p></td>
    </tr>
    <tr>
      <td><div id="loading" class="RegistrationBodyText">Searching...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
    </tr>
    <tr>
      <td><input name="txtSearch" id="txtSearch" size="30" type="hidden" />
<input type="hidden" id="hdnImageStartIndex" name="hdnStartIndex" value="1">
<input type="hidden" id="hdnTextStartIndex" name="hdnTextStartIndex" value="1">
<div id='divResults' style="overflow:scroll;height:200"></div></td>
    </tr>
  </table>
	
</body>
</html>
