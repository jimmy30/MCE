<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Admin/Waypoint/WaypointDetailService.php");

try
{
$objReg = new WaypointDetailService();
?>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/adminTemplate.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>MCE-Add Waypoint</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
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
  <form name="frmWaypoint" action="" method="post" onSubmit="">
    <tr class="RegistrationCellBg">
      <td width="47" height="27">&nbsp;</td>
      <td width="677" align="left" valign="middle"><p class="RegistrationTitleText">View Waypoints</p></td>
    </tr>
    <tr>
      <td height="5" colspan="2"></td>
    </tr>
    <tr>
      <td height="19" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="18" colspan="2"><?php $objReg->GetWaypointById($_REQUEST["id"],3)?></td>
    </tr>
    <tr>
      <td colspan="2">       
          
</td>
    </tr>
    <tr align="left">
      <td height="44" colspan="2"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="24" colspan="3" align="left" valign="top"><div align="center"><a href="" class="LinkSmall">
              <input name="button" type="button" class="RegistrationButton" onClick="location.href='ViewWaypoint.php?id=<?php echo $_REQUEST["pid"]?>'" value="Back to Waypoint">
            </a> </div></td>
          </tr>
          <tr>
            <td width="35" height="19" align="left" valign="top">&nbsp;</td>
            <td width="132" align="left" valign="top"></td>
            <td width="533" align="left" valign="top"><div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
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
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}

?>
