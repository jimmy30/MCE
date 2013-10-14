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

<?php 
// check session exists
if($_SESSION[sessionKeys::USER_TYPE]==2) // for producer
{
?>
<!--
############################################################################################
//////////////////////////////////Producer Menu Start //////////////////////////////////////
############################################################################################
-->

		<div style=" position:relative; border-width:0px; border-style:solid; border-color:#06a; padding:0px; overflow:hidden; width:150px; background-color:#FFCCC00;">
		
			<ul id="tmenu0" style="display:none;">
			
				<li expended=1><span>PlaceCast<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/Placecast/Producer/AddPlaceCast.php">&nbsp;Add</a></li>
						<li><a href="/Placecast/Producer/ViewPlaceCast.php">View</a></li>
					</ul>
				</li>
				<li expended=1><span>File Manager<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/FileDetail.php">File Manager</a></li>
					</ul>
				</li>

				<li expended=1><span>My Account<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/Preferences.php?id=2">Preferences</a></li>
						<li><a href="/ProducerChangePassword.php">Change Password </a></li>
						<li><a href="/Profile/ProducerProfile/ProducerProfile.php">Edit Profile</a></li>
						<li><a href="/switch.php?id=1">Switch to Consumer</a></li>
					</ul>
				</li>
				<li expended=1><span>Sign Out<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/CustomerSignout.php">Customer Sign Out</a></li>
					</ul>
				</li>

				</li>
			</ul>
		</div><br />

<?php
$arr=explode("/",$_SERVER['PHP_SELF']);
if($arr[1]!="mce.php")
include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerResearchSpider.php");
}
else if($_SESSION[sessionKeys::USER_TYPE]==1) // for consumer
{
?>
<!--
############################################################################################
////////////////////////////////// Consumer Menu Start /////////////////////////////////////
############################################################################################
-->

		<div style=" position:relative; border-width:0px; border-style:solid; border-color:#06a; padding:0px; overflow:hidden; width:150px; background-color:#FFCCC00;">
		
			<ul id="tmenu0" style="display:none;">
			
				<li expended=1><span>PlaceCast<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/Placecast/Consumer/ViewPlaceCast.php">View</a></li>
					</ul>
				</li>
				<li expended=1><span>Consumer Alerts<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/Alert/ConsumerAlerts/AddConsumerAlerts.php">Add</a></li>
						<li><a href="/Alert/ConsumerAlerts/ViewConsumerAlerts.php">View</a></li>
					</ul>
				</li>
				<li expended=1><span>Sms Alerts<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/Alert/SmsAlerts/AddSmsAlerts.php">Add</a></li>
						<li><a href="/Alert/SmsAlerts/ViewSmsAlerts.php">View</a></li>
					</ul>
				</li>
				<li expended=1><span>My Account<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/Preferences.php?id=1">Preferences</a></li>
						<li><a href="/ConsumerChangePassword.php">Change Password </a></li>
						<li><a href="/Profile/ConsumerProfile/ConsumerProfile.php">Edit Profile</a></li>
						<li><a href="/switch.php?id=2">Switch to Producer</a></li>
					</ul>
				</li>
				<li expended=1><span>Sign Out<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/CustomerSignout.php">Customer Sign Out</a></li>
					</ul>
				</li>
			</ul>
		</div>

<?php 
}
else // means no session, load common menu
{
?>
<!--
############################################################################################
////////////////////////////////// Common Menu Start /////////////////////////////////////
############################################################################################
-->
		<div style=" position:relative; border-width:0px; border-style:solid; border-color:#06a; padding:0px; overflow:hidden; width:150px; background-color:#FFCCC00;">
		
			<ul id="tmenu0" style="display:none;">
			
				<li expended=1><span>Sign In<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/CustomerSignIn.php">Customer Sign In</a></li>
					</ul>
				</li>
				<li expended=1><span>Sign Up<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/SignUpOption.php">Customer Sign Up</a></li>
					</ul>
				</li>
			</ul>
		</div>

<?php
}
?>
