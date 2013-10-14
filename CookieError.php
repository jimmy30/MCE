<?php 	

	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php"); 
	//// Include Other Classes
	require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
	
	/// Loading property file
	$objProperties=new Properties();
	$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));

	/// Get Site URL from the property file
	$strSiteURL= $objProperties->getProperty('site_url');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MCE-Customer Registration</title>


<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/IncludeFiles/Javascript/ClientChecks.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/Javascript/LeftMenu.js"></script>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="1001" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/header.php");?></td>
  </tr>
  <tr>
    <td width="149" rowspan="2" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/LeftMenu1.php");?></td>
    <td width="670" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/tabs.php");?></td>
    <td width="175" rowspan="2" align="left" valign="top"><?php if(!isset($_SESSION[sessionKeys::USER_ID]) || $_SESSION[sessionKeys::USER_ID]=="") include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CustomerSignInInclude.php"); else include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/rightMenu.php"); ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">      <table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder">
    <tr  class="RegistrationCellBg">
      <td width="32"  height="27">&nbsp;</td>
      <td width="616" align="left" valign="middle"><p class="RegistrationTitleText">Cookie Error </p></td>
    </tr>
    <tr valign="top">
      <td height="410" colspan="2" class="RegistrationBodyText"><table cellSpacing="0" cellPadding="0" border="0">
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td width=30></td>
          <td align="left">
            <div align=justify class="RegistrationBodyText">
              <p> Unfortunately your browser does not support cookies, which is required to use the full functionality of <span style='color:#003366'><?php echo $strSiteURL?></span>. If you are browser does not support cookies, you must upgrade to a newer version. We recommend you <a href="http://www.microsoft.com/windows/ie/" class="LinkSmall">Internet Explorer 5</a> or later. Once you have enabled support for cookies in your browser you will be able to view all webpages for <span style='color:#003366'><?php echo $strSiteURL?></span> <br>
                                                                                          <br>
          To enable support for cookies in internet explorer 6 or later follow these steps <br>
          <br>
              </p>
              <!--<p class=MsoNormal align=center style='text-align:center'><span
																			style='font-size:10.0pt;font-family:Arial'><a href="http://www.xyzcar.com/">click
																			here</a> <o:p></o:p></span></p>-->
          </div></td>
          <td width=30></td>
        </tr>
        <tr>
          <td></td>
          <td  align=left class="RegistrationBodyText">
            <table cellspacing=0 cellpadding=0 border=0>
              <tr>
                <td>
                  <div align= justify class="RegistrationBodyText">
                    <p align=justify class="RegistrationBodyText">
                    <ul  type=disc>
                      <li  >Select the "Internet Options..." menu item in the "Tools" menu.<BR>
                          <BR>
                      </li>
                      <li>Click on the "Privacy" tab at the top of the Internet Options window that pops up.<BR>
                          <BR>
                      </li>
                      <li>Click advance button. <BR>
                          <BR>
                      </li>
                      <li>In the new window that pops up, uncheck override automatic cookie handling.<BR>
                          <BR>
                      </li>
                      <li>Click on the "Ok" button at the bottom of the Advanced Privacy Settings window.<BR>
                          <BR>
                      </li>
                      <li>Click on the "Ok" button at the bottom of the Internet Options window.</li>
                    </ul>
                    <p></p>
                </div></td>
                <td width=40></td>
                <td> <img src="/ImageFiles/common/IEcookie.gif" width="379" height="296"> </td>
              </tr>
              <tr>
                <td colspan=3>
                  <div >
                    <p align=justify class=RegistrationBodyText> Please consult your browser's help section for further information concerning cookie settings. </p>
                </div></td>
              </tr>
          </table></td>
          <td></td>
        </tr>
        <tr>
          <td colspan=3 height=20> </td>
        </tr>
      </table></td>
    </tr>
      </table> </td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/footer.php");?></td>
  </tr>
</table>
<script language="JavaScript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/JavaScript/tmenu.js"></script>
</body>
</html>
