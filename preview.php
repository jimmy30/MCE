<?php 
	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
		
	$width=175;
	$height=220;
	$type=0;
	if(isset($_POST["size"]))
	{
		$type=$_POST["size"];
		if($_POST["size"]=="1")
		{
			$width=320;
			$height=240;
		}
		else if($_POST["size"]=="2")
		{
			$width=240;
			$height=320;
		}
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>MCE-Mobile Preview</title>

<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">

</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="RegistrationTabBorder" height="100%">
  <tr  class="RegistrationCellBg">
    <td width="600" height="27"><p class="RegistrationTitleText">&nbsp;&nbsp;&nbsp;Preview</p></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr align="left" valign="top">
    <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="63" class="RegistrationBodyText"><form id="form1" name="form1" method="post" action="">
          <div align="center">Select screen sizes
            <select name="size" onChange="document.form1.submit()">
                    <option value="0" <?php if(isset($_POST["size"]) && $_POST["size"]=="0") echo "selected";?>>175 x 220</option>
                    <option value="1" <?php if(isset($_POST["size"]) && $_POST["size"]=="1") echo "selected";?>>320 x 240</option>
                    <option value="2" <?php if(isset($_POST["size"]) && $_POST["size"]=="2") echo "selected";?>>240 x 320</option>
                  </select>
          </div>
        </form></td>
      </tr>
      <tr>
        <td height="126" align="center"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3" align="center"><img src="ImageFiles/common/PDA/<?php echo $type?>/top.jpg"></td>
          </tr>
          <tr>
            <td align="center"><img src="ImageFiles/common/PDA/<?php echo $type?>/left.jpg" ></td>
            <td><div id="htmlContent" style="width:<?php echo $width?>px; height:<?php echo $height?>px; overflow:scroll;"><?php echo urldecode($content)?></div></td>
            <td align="center"><img src="ImageFiles/common/PDA/<?php echo $type?>/right.jpg"></td>
          </tr>
          <tr>
            <td colspan="3" align="center"><img src="ImageFiles/common/PDA/<?php echo $type?>/bottom.jpg"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

<script language="JavaScript" src="<?php $_SERVER['DOCUMENT_ROOT']?>/IncludeFiles/JavaScript/tmenu.js"></script>
</body>
</html>
	<script language="javascript">
	document.getElementById("htmlContent").innerHTML=opener.document.getElementById("hiddenHtmlContent").value;
	</script>
