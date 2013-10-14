<?php require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php"); ?>
<table cellspacing="0" cellpadding="0" border="0" bordercolor="#FF0000">
	<tr>
		<td align="center"  bgcolor=<?php echo($strColor);?> width="150" height="27" class="HeadingText">Menu</td>
	</tr>
	<tr>
		<td height="3"></td>	
	</tr>
</table>

<?php 
// check session exists
if($_SESSION[sessionKeys::ADMIN_TYPE]==3) // for producer
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
						<li><a href="/Admin/Placecast/ViewPlaceCast.php">View</a></li>
					</ul>
				</li>

				<li expended=1><span>Users Management<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/admin/Producer/viewProducer.php">&nbsp;View Producer</a></li>
						<li><a href="/admin/Consumer/ViewConsumer.php">View Consumer</a></li>
					</ul>
				</li>

				<li expended=1><span>Ads Management<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/admin/Ads/AddAds.php">&nbsp;Add Ads</a></li>
						<li><a href="/admin/Ads/ViewAds.php">View Ads</a></li>
					</ul>
				</li>

				<li expended=1><span>Reports<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/admin/Reports/UsersReport.php">&nbsp;Users Report</a></li>
						<li><a href="/admin/Reports/PlaceCastReport.php">&nbsp;PlaceCast Report</a></li>
						<li><a href="/admin/Reports/WaypointReport.php">&nbsp;Waypoint Report</a></li>
						<li><a href="/admin/Reports/PlaceCastDownloadReport.php">&nbsp;PlaceCast Downloads Report</a></li>
						<li><a href="/admin/Reports/WaypointDownloadReport.php">&nbsp;Waypoint Downloads Report</a></li>
						<li><a href="/admin/Reports/WebsiteHitsReport.php">&nbsp;Website Hits Report</a></li>
						<li><a href="/admin/Reports/AdsReport.php">&nbsp;Ads Report</a></li>
						<li><a href="/admin/Reports/FeatureStatReport.php">&nbsp;Feature Stat Report</a></li>
					</ul>
				</li>
				<li expended=1><span>My Account<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/admin/Preferences.php">Preferences</a></li>
						<li><a href="/admin/AdminChangePassword.php">Change Password </a></li>
					</ul>
				</li>
				<li expended=1><span>Sign Out<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/admin/AdminSignout.php">Admin Sign Out</a></li>
					</ul>
				</li>

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
			
				</li>
				<li expended=1><span>Sign In<div id="Spacer" style="position:relative; height:4px; width:1px; font-size:1px;">&nbsp;</div></span>
					<ul>
						<li><a href="/admin/AdminSignIn.php">Admin Sign In</a></li>
					</ul>
				</li>
			</ul>
		</div>

<?php
}
?>
