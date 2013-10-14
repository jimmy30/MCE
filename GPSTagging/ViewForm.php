<?php
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
	$strFileName=$_SESSION["strFileName"];
	$strXml = simplexml_load_file($strFileName) or die(errorFunc()); 
	foreach($strXml as $strTour=>$strTourValue) 
	{
		if ($strTour=="Tourname")
		{
			$txtName=$strTourValue;
		}
		elseif ($strTour=="Description")
		{
			$txtDesc=$strTourValue;
		}
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>GPS Tagging Wizard</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="/IncludeFiles/<?php echo($strSkin); ?>/CSS/Default.css" rel="stylesheet" type="text/css">
</head>

<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" >
<form action="GeoTagging.php" method="post">
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="55" class="GPSTaggingTitleCellBg">
	<table width="778" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="47">&nbsp;</td>
        <td width="731" class="GPSTaggingTitleText">GPS Tagging Wizard</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="7" background="/ImageFiles/<?php echo($strSkin); ?>/GPSTagging/image_02.jpg"></td>
  </tr>
  <tr>
    <td height="56" class="GPSTaggingBodyCellBg"><table width="778" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="48">&nbsp;</td>
        <td width="67" class="style3"><strong class="GPSTaggingBodyText">Step 1 </strong></td>
        <td width="62"><span class="GPSTaggingBodyText"><strong>Step 2 </strong></span></td>
        <td width="601" class="style3"><strong class="GPSTaggingBodyTextWhite">Step 3</strong></td>
      </tr>
      <tr>
        <td height="24">&nbsp;</td>
        <td class="style3">&nbsp;</td>
        <td class="style3">&nbsp;</td>
        <td class="style3"><img src="/ImageFiles/<?php echo($strSkin); ?>/GPSTagging/bullet.gif" width="13" height="15" align="middle"> <span class="GPSTaggingBodyText"><strong>Summary</strong></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="GPSTaggingBodyCellBg"><table width="778" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="289" valign="top"><img src="/ImageFiles/<?php echo($strSkin); ?>/GPSTagging/image_05.jpg" width="289" height="441"></td>
        <td width="778" valign="top"><table width="488" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="79"></td>
            </tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="2" class="GPSTaggingBodyTextWhite"><strong>Tour Description</strong></td>
			  </tr>
			<tr>
				<td> </td>
				<td width="117" align="left" class="GPSTaggingBodyText"><strong>Tour Name</strong></td>
				
				<td width="268" class="GPSTaggingBodyTextGrey"><?=$txtName?></td>
			</tr>
			<tr>
				<td class="GPSTaggingBodyText" align="right">&nbsp;</td>
				<td valign="top"><span class="GPSTaggingBodyText"><strong>Tour Description</strong></span></td>
				<td class="GPSTaggingBodyTextGrey"><?=$txtDesc?></td>
			</tr>
			<tr>
			  <td class="GPSTaggingBodyText" align="right">&nbsp;</td>
			  <td class="GPSTaggingBodyText"><strong>No.of Waypoints </strong></td>
			  <td class="GPSTaggingBodyTextGrey"><?=$_REQUEST["maxCount"]?></td>
			  </tr>
			<tr>
			  <td class="GPSTaggingBodyTextWhite">&nbsp;</td>
			  <td colspan="2" class="bodyTxtWhite">            
			  <td width="0">            
			  </tr>
			<tr>
			<td class="GPSTaggingBodyTextWhite"><b> </b></td>
			<td colspan="2" class="GPSTaggingBodyTextWhite">			  <b> Waypoints Description</b>
			<td>
			</tr>
			<?php 
				$counter=0;
				foreach($strTourValue as $strTour=>$strTourValue) 
				{
					$counter++;
					if($strTour=="WayPoint")
					{
		
			?>	
			<tr>
				<td class="GPSTaggingBodyText" align="right">&nbsp; </td>
				<td><span class="GPSTaggingBodyText">Name</span> </td>
				<td class="GPSTaggingBodyTextGrey"> 
				<?php 
					foreach($strTourValue as $strTour=>$strWaypointValue) 
					{
						if($strTour=="Name") echo $strWaypointValue; 
					}
				?>
				</td>
			</tr>
			<tr>
				<td class="GPSTaggingBodyText" align="right">&nbsp; </td>
				<td><span class="GPSTaggingBodyText">Longitude</span> </td>
				<td class="GPSTaggingBodyTextGrey"><?php 
					foreach($strTourValue as $strTour=>$strWaypointValue) 
					{
						if($strTour=="Longitude") echo $strWaypointValue; 
					}
				?>
				</td>
				
			</tr>
			<tr>
				<td class="GPSTaggingBodyText" align="right">&nbsp;</td>
				<td><span class="GPSTaggingBodyText">Latitude</span></td>
				<td class="GPSTaggingBodyTextGrey">
                <?php 
					foreach($strTourValue as $strTour=>$strWaypointValue) 
					{
						if($strTour=="Latitude") echo $strWaypointValue; 
					}
				?>
</td>
			</tr>
			<tr>
				<td class="GPSTaggingBodyText" align="right">&nbsp;</td>
				<td valign="top"><span class="GPSTaggingBodyText">Description</span></td>
				<td class="GPSTaggingBodyTextGrey"> 
                <?php 
				foreach($strTourValue as $strTour=>$strWaypointValue) 
				{
					if($strTour=="Description") echo $strWaypointValue; 
				}
				?>
</td>
			</tr>
			<tr>
			  <td class="GPSTaggingBodyText" align="right">&nbsp;</td>
			  <td class="GPSTaggingBodyText"><strong class="bodyTxt">Images</strong></td>
			  <td class="GPSTaggingBodyTextGrey">&nbsp;</td>
			  </tr>
			  <?php
  				foreach($strTourValue as $strTour=>$strWaypointValue) 
				{
					if($strTour=="images") 
					{
					$imgCounter=0;
						foreach($strWaypointValue as $strTour=>$strWaypointValue) 
						{
						$imgCounter++;
						
			  ?>
			<tr>
			  <td class="GPSTaggingBodyText" align="right">&nbsp;</td>
			  <td><span class="GPSTaggingBodyText"><?=$imgCounter?>. </span><img src="<?=$strWaypointValue?>" width="25" height="25"> 
			  </td>
			  <td class="GPSTaggingBodyTextGrey"><?=$strWaypointValue;?></td>
			  </tr>
			<?php
						}
					}
					
				}

			?>			

			<tr>
			  <td class="GPSTaggingBodyText" align="right">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td class="GPSTaggingBodyTextGrey"><input name="btnNext2" type="button" class="GPSTaggingButton" id="btnNext2" value="Edit" onClick="javascript:location.href='WayPointForm.php?counter=<?=$counter?>&maxCount=<?=$_REQUEST["maxCount"]?>'">
			    <input name="btnNext3" type="button" class="GPSTaggingButton" id="btnNext3" value="Delete" onClick="confirmDelete(<?=$counter?>)"></td>
			  </tr>
			<tr>
			  <td class="GPSTaggingBodyText" align="right">&nbsp;</td>
			  <td colspan="2"><hr align="left" width="300" size="1" class="GPSTaggingBodyTextWhite"></td>
			  </tr>
			<tr>
			  <td ></td>
			  </tr>
			
			<tr>
			  <td ></td>
			  </tr>
			<?php 
				}
			}
			?>
			 <tr>
				<td colspan="3" align="center"> 
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="228">&nbsp;</td>
							<td width="165"><input name="btnNext4" type="button" class="GPSTaggingButton" id="btnNext4" value="Modify" onClick="javascript:location.href='TourForm.php?maxCount=<?=$_REQUEST["maxCount"]?>'">
							<input type="submit" name="btnView" value="Done" class="GPSTaggingButton"></td>
						</tr>
					</table>
				</td>	
			 </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="GPSTaggingBodyCellBg">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
<script language="javascript">
function confirmDelete(count)
{
	if(window.confirm("Are you sure, you want to delete this record?"))
		location.href='DeleteWayPoint.php?maxCount=<?=$_REQUEST["maxCount"]?>&id='+count;
	return false;
}
</script>