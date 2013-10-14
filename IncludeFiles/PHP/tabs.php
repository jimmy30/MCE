<?php
$currentPage=$_SERVER['PHP_SELF'];
if($currentPage=="/index.php")
{
	$homeImg="Tab_top_HightLighted.gif";
	$homeTxt="TabTopTextHightLight";
}
else
{
	$homeImg="Tab_top.gif";
	$homeTxt="TabTopText";
}

if($currentPage=="/Features.php")
{
	$featuresImg="Tab_top_HightLighted.gif";
	$featuresTxt="TabTopTextHightLight";
}
else
{
	$featuresImg="Tab_top.gif";
	$featuresTxt="TabTopText";
}

if($currentPage=="/AboutUs.php")
{
	$aboutUsImg="Tab_top_HightLighted.gif";
	$aboutUsTxt="TabTopTextHightLight";
}
else
{
	$aboutUsImg="Tab_top.gif";
	$aboutUsTxt="TabTopText";
}

if($currentPage=="/ContactUs.php")
{
	$contactUsImg="Tab_top_HightLighted.gif";
	$contactUsTxt="TabTopTextHightLight";
}
else
{
	$contactUsImg="Tab_top.gif";
	$contactUsTxt="TabTopText";
}

if($currentPage=="/Help.php")
{
	$helpUsImg="Tab_top_HightLighted.gif";
	$helpUsTxt="TabTopTextHightLight";
}
else
{
	$helpUsImg="Tab_top.gif";
	$helpUsTxt="TabTopText";
}

?>
<table cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="125"></td>
									<td align="center" background="/ImageFiles/<?php echo($strSkin);?>/<?php echo $homeImg?>" width="84" height="27"><a href='<?php $_SERVER['DOCUMENT_ROOT']?>/index.php' class="<?php echo $homeTxt;?>">Home</a> </td>	
									<td width="5"></td>
									<td align="center" background="/ImageFiles/<?php echo($strSkin);?>/<?php echo $featuresImg?>" width="84" height="27"><a href='<?php $_SERVER['DOCUMENT_ROOT']?>/Features.php' class="<?php echo $featuresTxt;?>">Features</a> </td>	
									<td width="5"></td>
									<td align="center" background="/ImageFiles/<?php echo($strSkin);?>/<?php echo $aboutUsImg?>" width="84" height="27"><a href='<?php $_SERVER['DOCUMENT_ROOT']?>/AboutUs.php' class="<?php echo $aboutUsTxt;?>">About Us</a></td>	
									<td width="5"></td>
									<td align="center" background="/ImageFiles/<?php echo($strSkin);?>/<?php echo $contactUsImg?>" width="84" height="27"><a href='<?php $_SERVER['DOCUMENT_ROOT']?>/ContactUs.php' class="<?php echo $contactUsTxt;?>">Contact Us</a></td>	
									<td width="5"></td>
									<td align="center" background="/ImageFiles/<?php echo($strSkin);?>/<?php echo $helpUsImg?>" width="84" height="27"><a href='<?php $_SERVER['DOCUMENT_ROOT']?>/Help.php' class="<?php echo $helpUsTxt;?>">Help</a></td>	
								</tr>		
							</table>
