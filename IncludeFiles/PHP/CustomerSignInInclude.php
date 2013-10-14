<table width="174" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td  height="27" colspan="2">&nbsp;</td>
  </tr>
  <tr  class="RegistrationCellBg">
    <td  height="27" colspan="2"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Customer Sign In </p></td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
<tr id="tr_id" style="display:none">
    <td width="47" bgcolor="FFFFAE" height="26">&nbsp;</td>
    <td width="677" bgcolor="FFFFAE" align="left" valign="middle">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="3%"><img src="" width="15" height="15" align="absmiddle" id="strip_image"></td>
          <td width="97%" class="RegistrationBodyText">
            <div align="left" id="divError"> </div></td>
        </tr>
    </table></td>
  </tr>    
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr valign="top">
    <td height="259" colspan="2"><table width="148" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="148" align="left" class="RegistrationBodyText"><strong><font color="red" size="3">*</font>Email: </strong></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><input name="txtEmail" type="text" id="txtEmail" size="20" <?php if(isset($_COOKIE['RemeberMeEmail']) && $_COOKIE['RemeberMeEmail']!="") echo "value=".$_COOKIE['RemeberMeEmail']."";?>></td>
        </tr>
        <tr>
          <td align="left" height="5"></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="RegistrationBodyText"><strong><strong><font color="red" size="3">*</font></strong>Password : </strong></td>
        </tr>
        <tr valign="middle">
          <td align="left"><input name="txtPassword" type="password" id="txtPassword" size="20" <?php if(isset($_COOKIE['RemeberMePassword']) && $_COOKIE['RemeberMePassword']!="") echo "value=".$_COOKIE['RemeberMePassword']."";?>></td>
        </tr>
        <tr>
          <td align="left" height="10">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" height="10"><span class="RegistrationBodyText"><strong>as:
                <label> </label>
          </strong>
              <label>
              <select name="cmbCustomerType" id="cmbCustomerType">
                <option value="1" <?php if(isset($_COOKIE['SignInAs']) && $_COOKIE['SignInAs']=="1") echo "selected"?>>Consumer</option>
                <option value="2" <?php if(isset($_COOKIE['SignInAs']) && $_COOKIE['SignInAs']=="2") echo "selected"?>>Producer</option>
              </select>
              </label>
          </span></td>
        </tr>
        <tr>
          <td align="left" height="10">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" height="10"><span class="RegistrationBodyText">
            <input name="chkRemeberMe" type="checkbox" id="chkRemeberMe" value="1" <? if(isset($_COOKIE['RemeberMeEmail']) && $_COOKIE['RemeberMeEmail']!="") echo "checked";?>>
Remember me on this computer </span></td>
        </tr>
        <tr>
          <td align="left" height="10">
            <input type="hidden" name="urlAfterLogin" id="urlAfterLogin" value="<?php if(isset($_POST["urlAfterLogin"]) && $_POST["urlAfterLogin"]!="") echo $_POST["urlAfterLogin"]; else echo "/placecast/producer/viewPlaceCast.php";?>">
            <input type="hidden" name="IsMsg" id="IsMsg" value="<?php if(isset($_POST["IsMsg"]) && $_POST["IsMsg"]!="") echo $_POST["IsMsg"]; ?>">
&nbsp; </td>
        </tr>
        <tr>
          <td align="left"><input name="Submit" type="button" class="RegistrationButton" value="Sign In" onClick="createXml()">            <div id="loading" style="display:none" class="RegistrationBodyText">Processing...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div></td>
        </tr>
        <tr>
          <td align="left" height="10"></td>
        </tr>
        <tr>
          <td align="left"><div align="right"><a href="ForgetPassword.php" class="LinkSmall">Forget Password </a></div></td>
        </tr>
        <tr>
          <td align="left" height="10"></td>
        </tr>
        <tr>
          <td align="left" class="RegistrationBodyText">If you are not a Member <a href="/SignUpOption.php" class="LinkSmall">SignUp Now!</a></td>
        </tr>
    </table></td>
  </tr>
</table>
