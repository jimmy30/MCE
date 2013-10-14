<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Placecast/Producer/PlaceCastDetailService.php");

try
{
$objReg = new PlaceCastDetailService();
?>

<?php 
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
<!--------------------------------------------------Yahoo Map ---------------------------------------->
<script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.4&appid=yahoomapapi1234"></script>
<script language="javascript" src="../../IncludeFiles/JavaScript/MapCircle.js"></script>
<script language="javascript" src="../../IncludeFiles/JavaScript/YahooPlaceCastDetail.js"></script>

<!-----------------------End Yahoo Maps------------------------------------------>

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
  <form name="frmPlaceCast" action="" method="post" onSubmit="">
    <tr class="RegistrationCellBg">
      <td width="47" height="27">&nbsp;</td>
      <td width="677" align="left" valign="middle"><p class="RegistrationTitleText"> PlaceCast Detail </p></td>
    </tr>
    <tr>
      <td height="5" colspan="2"></td>
    </tr>
    <tr>
      <td height="19" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="18" colspan="2"><table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td rowspan="2" width="380"><?php $objReg->GetPlaceCastById($_REQUEST["id"],3)?></td>
          <td class="RegistrationCellBg" height="23"><p class="TabTopTextHightLight">&nbsp;Map Representation</p></td>
        </tr>
        <tr>
          <td valign="top"><div id="mapContainer" style="width:240px;height:225px;"></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2">       
          
</td>
    </tr>
    <tr align="left">
      <td height="44" colspan="2"><table width="660" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10" colspan="3" align="left" valign="top"></td>
          </tr>
          <tr>
            <td height="24" colspan="3" align="left" valign="top"><div align="center"><a href="ViewPlaceCast.php" class="LinkSmall">
              <input name="button" type="button" class="RegistrationButton" onClick="location.href='/Placecast/Producer/ViewPlaceCast.php'" value="Back to PlaceCast">
            </a></div></td>
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
<script language="javascript">
loadmap(document.getElementById('txtLong1').value,document.getElementById('txtLat1').value,document.getElementById('txtLong2').value,document.getElementById('txtLat2').value,document.getElementById('txtLong3').value,document.getElementById('txtLat3').value,document.getElementById('txtLong4').value,document.getElementById('txtLat4').value);
</script>