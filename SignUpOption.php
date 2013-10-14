<?php 
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
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
  <form name="frmRegistration" action="" method="post" onSubmit="return formvalidate()">
    <tr  class="RegistrationCellBg">
      <td width="47" height="27">&nbsp;</td>
      <td width="677" align="left" valign="middle"><p class="RegistrationTitleText">SignUp Option </p></td>
    </tr>
    <tr>
      <td height="5" colspan="2"></td>
    </tr>
    <tr align="left" valign="top">
      <td height="415" colspan="2"><table width="643" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr valign="top">
            <td width="321" height="248" align="left" valign="middle" class="RegistrationBodyText"><p>&nbsp;</p>
              <table width="252" border="0" align="center" cellpadding="5" cellspacing="1" class="RegistrationTabBorder">
                <tr class="RegistrationCellBG">
                  <td height="25" class="RegistrationTitleTextSmall">SignUp as Producer </td>
                </tr>
                <tr>
                  <td height="10"></td>
                </tr>
                <tr>
                  <td height="63" class="RegistrationBodyText"><p>If you register as a Producer you will have the following access:</p>
                    <ul>
                      <li> Creating a new PlaceCast / Waypoints</li>
                      <li>Viewing a previously created PlaceCast / Waypoints </li>
                      <li>
                        Editing a PlaceCast / Waypoints</li>
                      <li>Deleting a PlaceCast / Waypoints</li>
                      <li>Content Association</li>
                      <li>Download PlaceCasts </li>
                    </ul></td>
                </tr>
                <tr>
                  <td height="10"></td>
                </tr>
                <tr>
                  <td height="52"><div align="center">
                    <input name="button" type="button" class="RegistrationButton" onClick="location.href='/Registration/ProducerRegistration/registration.php'" value="Register Now">
                  </div></td>
                </tr>
              </table>
              </td>
            <td width="322" align="left" valign="middle" class="RegistrationBodyText"><p>&nbsp;</p>
              <table width="252" border="0" align="center" cellpadding="5" cellspacing="1" class="RegistrationTabBorder">
              <tr class="RegistrationCellBG">
                <td height="25" class="RegistrationTitleTextSmall">SignUp as Consumer </td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td height="63" class="RegistrationBodyText"><p>If you register as Consumer you will have the limited access and it will consist of:</p>
                  <ul>
                    <li>Viewing PlaceCast / Waypoints</li>
                    <li>Subscribe to PlaceCast</li>
                    <li>Download PlaceCasts  </li>
                  </ul></td>
              </tr>
              <tr>
                <td height="80"></td>
              </tr>
              <tr>
                <td height="55"><div align="center">
                    <input name="button2" type="button" class="RegistrationButton" onClick="location.href='/Registration/ConsumerRegistration/registration.php'" value="Register Now">
                </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td height="19" colspan="2" align="left">&nbsp;</td>
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
