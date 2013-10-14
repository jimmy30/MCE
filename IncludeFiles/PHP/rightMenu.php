<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/RightMenuService.php");
include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");

$objRightMenuService=new RightMenuService();

$strPage=$_SERVER['PHP_SELF'];
$strPage=substr($strPage,1,strlen($strPage)-1);

$objRightMenuService->GetImageList($strPage,'sniffet');
//echo($_SERVER['PHP_SELF']);
?>
<!--
<table cellspacing="0" cellpadding="0" border="0">
			      <tr>
			        <td height="27" class="HeadingText">&nbsp;</td>
			      </tr>
			      <tr>
			        <td align="center" bgcolor=<?php //echo($strColor);?>  height="27" width="175" class="HeadingText">Advertisement</td>
			      </tr>
			      <tr>
			        <td height="4"></td>
			      </tr>
			      <tr>
			        <td><table cellspacing="0" cellpadding="0"  border="0">
				          <tr>
        				    <td height="10"></td>
				          </tr>
				          <tr>
				            <td width="10" colspan="4"> <img src="/ImageFiles/<?php //echo($strSkin);?>/Add.jpg" width="174" height="105"> </td>
				          </tr>
				          <tr>
				            <td height="10"></td>
				          </tr>
				          <tr>
				            <td colspan="4"> <img src="/ImageFiles/<?php //echo($strSkin);?>/Add.jpg" width="174" height="105"> </td>
				          </tr>
			        </table>
				</td>
		      </tr>
		    </table>
		-->	