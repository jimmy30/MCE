<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/admin/AdminSessionCheck.php");
include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>MCE-Administration Area</title>
<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="711" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder" height="90%">
  <form name="frmReport" action="" method="post" onSubmit="">
    <tr>
      <td width="13" height="86"></td>
      <td width="686"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/header.php");?></td>
      <td width="12"></td>
    </tr>
    <tr class="RegistrationCellBg">
      <td height="27" colspan="3"><p class="RegistrationTitleText"> &nbsp;&nbsp; Report </p></td>
    </tr>
    <tr>
      <td height="5" colspan="3"></td>
    </tr>
    <tr>
      <td height="26" colspan="3"  class="RegistrationBodyText"><div align="right"><strong>Dated Careated:</strong> <?php echo date('d-m-Y')?>&nbsp;</div></td>
    </tr>
    <tr>
      <td height="54" colspan="3"  class="RegistrationBodyText">
        <div align="center"><strong>Report Type:</strong>
		<?php
		if(($_POST["hiddenFromDate"]=="" || $_POST["hiddenToDate"]=="") && $_POST["hiddenCountryId"]=="")
			echo "All Countries";
		else if($_POST["hiddenCountryId"]!="")
		{
			echo "Single Country";
		}
		else
		{	
		?>
				Date
          <br>
          <strong>          From:</strong>          <?php echo $_POST["hiddenFromDate"]?> 
          <strong>To:</strong>          <?php echo $_POST["hiddenToDate"]?>
		<?php 
		}
		?>
      </div></td>
    </tr>
    <tr valign="top">
      <td colspan="3"><div align="center"><?php echo $_POST["HiddenHtml"]?>        </div>
      <div id="cContainer"></div></td>
    </tr>
    <tr valign="top">
      <td colspan="3" ><div align="center"></div></td>
    </tr>
  </form>
  <form action="UserReportPrint.php" method="post" name="frmUserReportPrint" target="_blank">
    <input type="hidden" name="strHrmlConsumer" id="strHrmlConsumer">
    <input type="hidden" name="strHrmlProducer" id="strHrmlProducer">
  </form>
</table>
<p align="center">
  <input name="button3" type="button" class="RegistrationButton" onClick="window.print()" value="Print this Report">
  <input name="button32" type="button" class="RegistrationButton" onClick="window.close()" value="Close">
</p>
</body>
</html>
