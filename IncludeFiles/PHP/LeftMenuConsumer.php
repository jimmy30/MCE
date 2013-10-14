<?php require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php"); ?>
<table cellspacing="0" cellpadding="0" border="0" bordercolor="#FF0000">
	<tr>
		<td height="27"></td>
	</tr>
	<tr>
		<td align="center"  bgcolor=<?php echo($strColor);?> width="150" height="27" class="HeadingText">Menu</td>
	</tr>
	<tr>
		<td height="3"></td>	
	</tr>
</table>

<div style=" position:relative; border-width:0px; border-style:solid; border-color:#06a; padding:0px; overflow:hidden; width:150px; background-color:#FFCCC00;">

	<ul id="tmenu0" style="display:none;">
	
		<li expended=1><span>PlaceCast<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
			<ul>
				<li><a href="/Placecast/Producer/AddPlaceCast.php">&nbsp;Add</a></li>
				<li><a href="/Placecast/Producer/ViewPlaceCast.php">View</a></li>
			</ul>
		</li>
	
	

		<li><span >Waypoints<div id="Spacer" style="height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
			<ul>
				<li><a href="#">&nbsp;Add</a></li>
<!--				<li><a href="/Waypoint/ViewWaypoint.php">View</a></li>-->
				<li><a href="#">View</a></li>
			</ul>
		</li>
	
	

		<li><span>Contents<div id="Spacer" style="height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
			<ul>
				<li><a href="#">&nbsp;Add</a></li>
				<li><a href="#">View</a></li>
			</ul>
		</li>

	  <li><span>GPS Tagging<div id="Spacer" style="height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
			<ul>
				<li><a href="#" onClick="javascript:window.open('/GPSTagging/TourForm.php','AccountType','status=yes,scrollbars=yes,resizable=no,width=795,height=578')">&nbsp;Wizard</a></li>
			</ul>
		</li>
		
		<li expended=1><span>Skins<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
			<ul>
				<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?skin=skin1<?php if(isset($_GET["id"])) echo "&id=".$_GET["id"]?>">Skin1</a></li>
				<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?skin=skin2<?php if(isset($_GET["id"])) echo "&id=".$_GET["id"]?>">skin2</a></li>
				<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?skin=skin3<?php if(isset($_GET["id"])) echo "&id=".$_GET["id"]?>">Skin3</a></li>
				<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?skin=skin4<?php if(isset($_GET["id"])) echo "&id=".$_GET["id"]?>">skin4</a></li>
				<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?skin=skin5<?php if(isset($_GET["id"])) echo "&id=".$_GET["id"]?>">skin5</a></li>
			</ul>
		</li>

<?php if(isset($_SESSION[sessionKeys::USER_ID]) || $_SESSION[sessionKeys::USER_ID]!="") 
{
?>
		<li expended=1><span>My Account<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
			<ul>
				<li><a href="/ConsumerChangePassword.php">Change Password </a></li>
				<li><a href="/Profile/ConsumerProfile/ConsumerProfile.php">Edit Profile</a></li>
				<li><a href="/CustomerSignout.php">Signout</a></li>
			</ul>
		</li>
<?php } ?>	
	</ul>
</div>