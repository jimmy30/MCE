<?php 
if($_REQUEST["id"]==1)
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ConsumerSessionCheck.php");
else if($_REQUEST["id"]==2)
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");

require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/SignInService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");

	$objReg = new SignInService();
	NAJAX_Server::allowClasses("SignInService");
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
<title>MCE-Customer Registration</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script  language="javascript" type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js">
</script>
<script type="text/javascript" src="/IncludeFiles/Javascript/Messages.js"></script>
<script language="javascript">
function showSkin(skin)
{
	var strHtml='';
	strHtml+='<table border="0" cellspacing="0" cellpadding="0">';
	strHtml+='<tr>';
	strHtml+='<td height="145" align="center">';
	strHtml+='<img src="/ImageFiles/common/Skins/'+skin+'.jpg" border="1"></td>';
	strHtml+='</tr>';
	strHtml+='<tr>';
	strHtml+='<td height="19" align="center">&nbsp;</td>';
	strHtml+='</tr>';
	strHtml+='<tr>';
	strHtml+='<td height="19" align="center">';
	strHtml+='<input name="Submit" type="button" class="RegistrationButton" value="Apply" onClick="location.href=\'<?php echo $_SERVER['PHP_SELF'];?>?skin='+skin+'&id=<?php echo $_REQUEST["id"]?>\'">';
	strHtml+='</td>';
	strHtml+='</tr></table>';

	document.getElementById("htmlContainer").innerHTML=strHtml;
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
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder" height="100%">
  <tr  class="RegistrationCellBg">
    <td width="664" height="27"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Preferrence </p></td>
    </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr align="left" valign="top">
    <td><table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="RegistrationBodyText"><div align="center">Please select skin to view
            <select name="cmbSkin" id="cmbSkin" onChange="showSkin(this.value)">
                <option value="skin1" <?php if($strSkin=="skin1") echo "selected";?>>Skin 1</option>
                <option value="skin2" <?php if($strSkin=="skin2") echo "selected";?>>Skin 2</option>
                <option value="skin3" <?php if($strSkin=="skin3") echo "selected";?>>Skin 3</option>
                <option value="skin4" <?php if($strSkin=="skin4") echo "selected";?>>Skin 4</option>
                <option value="skin5" <?php if($strSkin=="skin5") echo "selected";?>>Skin 5</option>
                </select>
          </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center"><div id="htmlContainer">
            <table border="0" cellspacing="0" cellpadding="0">
<tr>
          <td height="145" align="center"><img src="/ImageFiles/common/Skins/<?php echo $strSkin?>.jpg" border="1"></td>
          </tr>
        <tr>
          <td height="19" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center"><input name="Submit" type="button" class="RegistrationButton" value="Apply" onClick="location.href='<?php echo $_SERVER['PHP_SELF'];?>?skin=<?php echo $strSkin?>&id=<?php echo $_REQUEST["id"]?>'"></td>
          </tr>            </table>
		  
		  </div></td>
        </tr>
        <tr>
          <td height="19" align="center">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
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