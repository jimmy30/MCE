<?php 
	require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/featurestat.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
?>
<?php
if(isset($_POST["txtEmail"]))
{
	header("location:CustomerActivation.php?msg=".urlencode("Congratulation! Your account has been successfully activated."));
	exit;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MCE-Customer Registration</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">
<script  language="javascript" type="text/javascript" src="/IncludeFiles/Javascript/ToolTipMessages.js">
</script>

<script type="text/javascript" src="/IncludeFiles/Javascript/Tooltip.js"></script>
<script language="javascript">
function checkchar(mystr,invalidChars1)
{
			
	for (i=0; i<invalidChars1.length; i++) // does it contain any invalid characters?
		{
			badChar1 = invalidChars1.charAt(i)
			if (mystr.indexOf(badChar1,0) > -1) 
				{
					return false;
				}
		}
return true;
}

function formvalidate()
{
// Email
	if(document.frmRegistration.txtEmail.value=='')
	{
		alert("Please enter Email Address");
		document.frmRegistration.txtEmail.focus();
		return false;
	}

	if(!checkchar(document.frmRegistration.txtEmail.value," ?/:,;=+'\"<>|\\`~{}#$%!^&*()"))
	{
		alert("Invalid Email Address");
		document.frmRegistration.txtEmail.focus();
		document.frmRegistration.txtEmail.select();
		return false;
	}

	if(document.frmRegistration.txtEmail.value!="")
	{
		var result="no"
		var theStr = new String(document.frmRegistration.txtEmail.value);
		var index = theStr.indexOf("@");
		
		if (index > 0)
		{
			var pindex = theStr.indexOf(".",index);
			if ((pindex > index+1) && (theStr.length > pindex+1))
				result="ok"
		 }
		if(result=="no")
		{
			alert("Invalid Email Address.");
			document.frmRegistration.txtEmail.focus();
			document.frmRegistration.txtEmail.select();			
			return (false);
		}
	}
// Email
	if(document.frmRegistration.txtCode.value=='')
	{
		alert("Please enter Activation Code");
		document.frmRegistration.txtCode.focus();
		return false;
	}

}
</script>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="780" height="112" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="38">&nbsp;</td>
        <td width="131"><img src="/ImageFiles/<?php echo($strSkin); ?>/LeftLogo.gif" width="131" height="66"></td>
        <td width="350">&nbsp;</td>
        <td width="214"><img src="/ImageFiles/<?php echo($strSkin); ?>/RightLogo.gif" width="214" height="42"></td>
        <td width="47">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="724" border="0" align="center" cellpadding="0" cellspacing="0">
	<form name="frmRegistration" action="" method="post" onSubmit="return formvalidate()">
      <tr  class="RegistrationCellBg">
        <td width="47" height="34">&nbsp;</td>
        <td width="677" align="left" valign="middle"><p class="RegistrationTitleText">Account Type Information </p></td>
      </tr>
      <tr>
        <td height="5" colspan="2"></td>
        </tr>
      <tr>
        <td colspan="2"><table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td height="29" align="left" class="RegistrationBodyText"><div align="center">
              <table width="657" border="0" cellpadding="2" cellspacing="1" class="RegistrationBodyText">
                <tbody>
                  <tr>
                    <td width="30%"> <span class="blackmedium">&nbsp;</span> </td>
                    <td width="35%" align="center"> <span class="blackmedium">Free</span> </td>
                    <td width="35%" align="center"> <span class="blackmedium">Premium</span> </td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3"> <b>&nbsp;Option 1 </b></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                    <td align="center" bgcolor="#F5F5F5"> <img src="/ImageFiles/common/check.gif" alt="yes"> </td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3"> <b>&nbsp;Option 2 </b></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3"><b>&nbsp;Option 3 </b></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3"><b>&nbsp;Option 4 </b></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 5 </td>
                    <td align="center" bgcolor="#F5F5F5">-</td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 6 </td>
                    <td align="center" bgcolor="#F5F5F5">-</td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 7 </td>
                    <td align="center" bgcolor="#F5F5F5">-</td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 8 </td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 9 </td>
                    <td align="center" bgcolor="#F5F5F5">-</td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 10 </td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 11 </td>
                    <td align="center" bgcolor="#F5F5F5">-</td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 12 </td>
                    <td align="center" bgcolor="#F5F5F5">-</td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 13 </td>
                    <td align="center" bgcolor="#F5F5F5"><span class="blackmedium">-</span></td>
                    <td align="center" bgcolor="#F5F5F5"><span class="blackmedium">-</span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3">&nbsp;Option 14 </td>
                    <td align="center" bgcolor="#F5F5F5"><span class="blackmedium">&nbsp;<a href="javascript:void(0);" onclick="window.open('/help.php?topic=bandwidth','Help','fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=no,resizable=yes,directories=no,location=no,width=200,height=250'); return false;"><img src="/ImageFiles/common/help.gif" alt="help" border="0"></a></span></td>
                    <td align="center" bgcolor="#F5F5F5"><span class="blackmedium">&nbsp;<a href="javascript:void(0);" onclick="window.open('/help.php?topic=bandwidth','Help','fullscreen=no,toolbar=no,status=no,menubar=no,scrollbars=no,resizable=yes,directories=no,location=no,width=200,height=250'); return false;"><img src="/ImageFiles/common/help.gif" alt="help" border="0"></a></span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#D3D3D3"><b>&nbsp;Option 15 </b></td>
                    <td align="center" bgcolor="#F5F5F5"><span class="blackmedium">-</span></td>
                    <td align="center" bgcolor="#F5F5F5"><img src="/ImageFiles/common/check.gif" alt="yes"></td>
                  </tr>
                </tbody>
              </table>
            </div></td>
            </tr>
        </table></td>
      </tr>
      <tr align="left">
        <td colspan="2">&nbsp;</td>
      </tr>
	  </form>
    </table></td>
  </tr>
  <tr>
    <td><table width="724" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="29" align="left" valign="top"><hr size="1" class="RegistrationLineColor"></td>
      </tr>
      <tr>
        <td align="left" valign="middle"><p class="RegistrationBodyText">Copyright C 1995-2006 Mobile Content Exchange Inc. All Rights Reserved. Designated trademarks and brands are property of their respective owners. Use of this Website constitutes acceptance of the Mobile Users Agreement and Privacy Policy. </p></td>
      </tr>
      <tr>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
