<?php
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");
include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
require_once("clsResizeImage.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");	
if(isset($_POST['btnNext']) && ($_POST['btnNext']=="Next" || $_POST['btnNext']=="Done" ))
{
	$intImgNo=0;
	$strImgXml="";
	
	$objXmlEncode=new xmlEncode();

	$strXml.="<WayPoint>";
	$strXml.="<Name>".$objXmlEncode->xmlCdataEncode($_POST["txtName"])."</Name>";
	$strXml.="<Description>".$objXmlEncode->xmlCdataEncode($_POST["txtDescription"])."</Description>";
	$strXml.="<Longitude>".$objXmlEncode->xmlCdataEncode($_POST["txtLong1"])."</Longitude>";
	$strXml.="<Latitude>".$objXmlEncode->xmlCdataEncode($_POST["txtLat1"])."</Latitude>";

	$imgCount=0;
	while(list($key,$value) = each($_FILES[images][name]))
	{ 
		$imgCount++;
		if(!empty($value))
		{
			$filename = $value;
			$add = "UploadImages/$filename";
		
			if($intImgNo==0)
			{
				$strIconExtName = strstr($add, '.');
				$intIconStringLen=strlen($strIconExtName);
				$intImageStringLen=strlen($add);
				$intReturnLen=$intImageStringLen-$intIconStringLen;
				$strNewIconPath=substr($add,0,$intReturnLen);
				$strNewIconPath=$strNewIconPath."_ico".$strIconExtName;
				$strXml.="<Imageicon>".$objXmlEncode->xmlCdataEncode($strNewIconPath)."</Imageicon>";
				$PathIcon=$add;
			}
		
			$strImgXml.="<image>UploadImages/".$objXmlEncode->xmlCdataEncode($filename)."</image>";
			copy($_FILES[images][tmp_name][$key], $add);
			chmod("$add",0777);
			$intImgNo++;
		}
		else if($_POST["imgLen"]>=$imgCount)
		{
			if($intImgNo==0)
			{
				$add=$_POST["imgPathArray$imgCount"];
				$strIconExtName = strstr($add, '.');
				$intIconStringLen=strlen($strIconExtName);
				$intImageStringLen=strlen($add);
				$intReturnLen=$intImageStringLen-$intIconStringLen;
				$strNewIconPath=substr($add,0,$intReturnLen);
				$strNewIconPath=$strNewIconPath."_ico".$strIconExtName;
				$strXml.="<Imageicon>".$objXmlEncode->xmlCdataEncode($strNewIconPath)."</Imageicon>";
				$PathIcon=$add;
			}

			$intImgNo++; // prevent to create an incon image
			$strImgXml.="<image>".$_POST["imgPathArray$imgCount"]."</image>";
		}

	}
	
	$strXml.="<images>";
	$strXml.=$strImgXml;
	$strXml.="</images>";

	/// make icon image
	$rimg=new clsResizeImage($PathIcon);
	$strIconExtName = strstr($PathIcon, '.');
	$intIconStringLen=strlen($strIconExtName);
	$intImageStringLen=strlen($PathIcon);
	$intReturnLen=$intImageStringLen-$intIconStringLen;
	$strNewIconPath=substr($PathIcon,0,$intReturnLen);
	$strNewIconPath=$strNewIconPath."_ico".$strIconExtName;
	$rimg->resize_limitwh(50,50,$strNewIconPath);
	$rimg->close();
	////

	$strXml.="</WayPoint>";
	
	$strFileName=$_SESSION["strFileName"];
	$handle = fopen($strFileName, "r");
	$contents = fread($handle, filesize($strFileName));
	fclose($handle);
	
	$arrWayPoints=explode("</WayPoint>",$contents);

	if(sizeof($arrWayPoints)==1) // For first time enter first record
	{
		$arrWayPoints=explode("<WayPoints>",$contents);
		$contXml=$arrWayPoints[0];
		$contXml.="<WayPoints>";
		$contXml.=$strXml;
		$contXml.=$arrWayPoints[1];
	}
	else if(sizeof($arrWayPoints)>1)
	{

		if($_REQUEST["counter"]==1) // edit first record
		{
			$arrWayPointFirst=explode("<WayPoint>",$arrWayPoints[0]);
			$contXml.=$arrWayPointFirst[0];
			$contXml.=$strXml;
		}
		else
			 $contXml=$arrWayPoints[0];
			
			for($i=1;$i<=sizeof($arrWayPoints);$i++)
			{
		
				if($_REQUEST["counter"]==$_REQUEST["maxCount"]+1) // add new record
				{ 
					if($i==$_REQUEST["maxCount"])
					{
						$contXml.="</WayPoint>";
						$contXml.=$strXml;
					}
					else if($i!=$_REQUEST["maxCount"]+1)
						$contXml.="</WayPoint>";

					$contXml.=$arrWayPoints[$i];
				}
				else // edit records
				{
					if($i==$_REQUEST["counter"]-1)
					{ 
						$contXml.="</WayPoint>";
						$contXml.=$strXml;
						$i++;
					}
					else if($i!=$_REQUEST["maxCount"]+1)
						if($i!=$_REQUEST["counter"])
							$contXml.="</WayPoint>";
					$contXml.=$arrWayPoints[$i];
				}
			}
	}
	
//echo "<textarea rows=30 cols=100>".$contXml."</textarea>";
//echo sizeof($arrWayPoints);
//exit;


	$FileHandle = fopen($strFileName, 'w') or die("can't open file");
	fwrite($FileHandle,$contXml);
	fclose($FileHandle);

	$maxCount=$_REQUEST["maxCount"];
	if($_REQUEST["counter"]==$_REQUEST["maxCount"]+1)
		$maxCount=$_REQUEST["maxCount"]+1;

if($_POST['btnNext']=="Next")
{
	echo '<script language="Javascript"> location.href=\'WayPointForm.php?counter='.($_REQUEST["counter"]+1).'&maxCount='.$maxCount.'\' </script>';
}
else
{	
	echo '<script language="Javascript"> location.href=\'ViewForm.php?counter='.$_REQUEST["counter"].'&maxCount='.$_REQUEST["maxCount"].'\' </script>';
}
	exit;
}
else if(isset($_POST['btnNext']) && $_POST['btnNext']=="Back")
{
	if($_REQUEST["counter"]==1)
		echo '<script language="Javascript"> location.href=\'TourForm.php?maxCount='.$_REQUEST["maxCount"].'\' </script>';
	else
		echo '<script language="Javascript"> location.href=\'WayPointForm.php?counter='.($_REQUEST["counter"]-1).'&maxCount='.$_REQUEST["maxCount"].'\' </script>';
	exit;
}
else if(isset($_POST['btnNext']) && $_POST['btnNext']=="Done")
{	
//// temprarely disabled ////
/*
	echo '<script language="Javascript"> location.href=\'ViewForm.php?counter='.$_REQUEST["counter"].'&maxCount='.$_REQUEST["maxCount"].'\' </script>';*/
	exit;
}

$check_load_val=false;
if($_REQUEST["counter"]-1!=$_REQUEST["maxCount"]) /// load XML data to show in feilds
{

	$check_load_val=true;
	$countWaypoint=0;
	$strFileName=$_SESSION["strFileName"];
	$strXml = simplexml_load_file($strFileName) or die(errorFunc()); 
		foreach($strXml as $strTour=>$strTourValue) 
		{
			if ($strTour=="WayPoints")
			{
				foreach($strTourValue as $strWaypoints=>$strWaypointsValue) 
				{
				$countWaypoint++;
					if ($strWaypoints=="WayPoint" && $_REQUEST["counter"]==$countWaypoint)
					{
						foreach($strWaypointsValue as $strWayPoint=>$strXmlValue)
						{
							if($strWayPoint=="Name")
							{
								$txtName=$strXmlValue;
							}
							elseif ($strWayPoint=="Longitude")
							{
								$txtLong=$strXmlValue;
							}
							elseif ($strWayPoint=="Latitude")
							{
								$txtLat=$strXmlValue;
								
							}
							elseif ($strWayPoint=="Description")
							{
								$txtDesc=$strXmlValue;
								
							}
							elseif ($strWayPoint=="images")
							{
								$imgCounter=0;
								foreach($strXmlValue as $strImgs=>$strImgValue)
								{
									$imgArray[$imgCounter]=$strImgValue;
									$imgCounter++;
								}
							}
						}
						$intImageIndex=0;
						$intImage++;	
					}	
				}
			}
		}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<script language="javascript" type="text/javascript">

var extArray= new Array();
extArray[0]="jpg";
extArray[1]="bmp";
extArray[2]="gif";
extArray[3]="png";

function chkExt(str)
{
var chkExt=0;
	var strExt=str.substr(str.length-3,str.length-(str.length-3));
		for(var i=0;i<extArray.length;i++)
		{
			if(strExt.toLowerCase()==extArray[i])
			{
			chkExt=1;
			}
			
		}
		if(chkExt==0)
		{
			alert("Only .JPG, .GIF, .BMP, .PNG file extensions are supported!");
			return false;
		}
		return true;
}

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

	function validateForm()
	{
		if (document.getElementById("txtName").value=="")
		{
			alert("Please specify name");
			document.getElementById("txtName").focus();
			return false;
		}
		if (document.getElementById("txtLong1").value=="")
		{
			alert("Please specify logitude value");
			document.getElementById("txtLong1").focus();
			return false;
		}
		if (document.getElementById("txtLat1").value=="")
		{
			alert("Please specify latitude value");
			document.getElementById("txtLat1").focus();
			return false;
		}
		if (document.getElementById("txtDescription").value=="")
		{
			alert("Please specify description");
			document.getElementById("txtDescription").focus();
			return false;
		}

		if(document.frmWayPointForm.elements[5].value!="")
		{
			if(!chkExt(document.frmWayPointForm.elements[5].value))
			{
			document.frmWayPointForm.elements[5].focus();		
			document.frmWayPointForm.elements[5].select();						
			return false;
			}
		}

		if(document.frmWayPointForm.elements[6].value!="")
		{
			if(!chkExt(document.frmWayPointForm.elements[6].value))
			{
			document.frmWayPointForm.elements[6].focus();			
			document.frmWayPointForm.elements[6].select();									
			return false;
			}
		}
	
		if(document.frmWayPointForm.elements[7].value!="")
		{
			if(!chkExt(document.frmWayPointForm.elements[7].value))
			{
			document.frmWayPointForm.elements[7].focus();
			document.frmWayPointForm.elements[7].select();									
			return false;
			}
		}
		if(document.frmWayPointForm.elements[8].value!="")
		{
			if(!chkExt(document.frmWayPointForm.elements[8].value))
			{
			document.frmWayPointForm.elements[8].focus();
			document.frmWayPointForm.elements[8].select();									
			return false;
			}
		}
		
		if(!checkchar(document.frmWayPointForm.txtLong1.value," ?/:,;=+'\"<>|\\`~{}#$%@!^&*()_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"))
			{
				alert("Invalid Longitude value.");
				document.frmWayPointForm.txtLong1.focus();
				document.frmWayPointForm.txtLong1.select();
				return false;
			}
		if(!checkchar(document.frmWayPointForm.txtLat1.value," ?/:,;=+'\"<>|\\`~{}#$%@!^&*()_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"))
			{
				alert("Invalid Latiitude value.");
				document.frmWayPointForm.txtLat1.focus();
				document.frmWayPointForm.txtLat1.select();
				return false;
			}

		return true;		
		
	}
	function clearFields()
	{
		document.getElementById("txtName").value=="";
		document.getElementById("txtLong1").value=="";
		document.getElementById("txtLat1").value=="";
		document.getElementById("txtDescription").value=="";
	}
/*	function checknumber()
	{
		var fltLongitude=document.frmWayPointForm.txtLong1.value
		var fltLatitude=document.frmWayPointForm.txtLat1.value
		var strValue=/^((\+ \d)?\d*(\.\d+)?$/
		if (strValue.test(fltLongitude))
		strResult=true
		else
		{
			alert("Please input a valid Longitude value");
			strResult=false
		}
		if (strValue.test(fltLatitude))
		strResult=true
		else
		{
			alert("Please input a valid Latitude value");
			strResult=false
		}
		return (strResult)
	}
*/


</script>
<head>
<!--------------------------------------------------Yahoo Map ---------------------------------------->
<script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=yahoomapapi1234"></script>
<script language="javascript" src="../IncludeFiles/JavaScript/YahooMap.js"></script>
<script language="javascript"  >
	function openMapSearchSettingBox()
	{
		alert('This functionlity is still under development');
		//openAlertDialog();
		//effect_1 = Effect.SlideDown('d2',{duration:1.0}); 
		//return false;
	}

	function closeMapSearchSettingBox()
	{
		//loadMap();
		//effect_1 = Effect.SlideUp('d2',{duration:1.0}); 
		//loadMap();
		return false;
	}

	function openYahooMapDialog()
	{
		javascript:dlg.show();
		loadMap();
	}
</script>
<!-----------------------End Yahoo Maps------------------------------------------>


<!-------------Start Dialog ----------------->
	<script type="text/javascript"> djConfig = { isDebug: true }; </script>
	<script type="text/javascript" src="../IncludeFiles/Javascript/dojo/dojo.js"></script>
	<script type="text/javascript">
		dojo.require("dojo.widget.Dialog");
	</script>

	<script type="text/javascript">
		var dlg;
		function init(e) 
		{
			dlg = dojo.widget.byId("DialogContent");
			var btn = document.getElementById("hider");
			dlg.setCloseControl(btn);
			
		}
		dojo.addOnLoad(init);

	</script>
	
<!-------------End Dialog --------------------->
<title>GPS Tagging Wizard</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
	.dojoDialog 
	{
		background : #eee;
		border : 1px solid #999;
		-moz-border-radius : 1px;
		padding :0px;
	}
</style>
<link href="/IncludeFiles/<?php echo($strSkin); ?>/CSS/Default.css" rel="stylesheet" type="text/css">
</head>

<body topmargin="0" leftmargin="0" bottommargin="0"  rightmargin="0">
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="frmWayPointForm" action="" method="post" enctype='multipart/form-data'>
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
        <td width="62"><span class="GPSTaggingBodyTextWhite"><strong>Step 2 </strong></span></td>
        <td width="601" class="style3"><strong class="GPSTaggingBodyText">Step 3</strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="style3"><table width="727"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="68" height="23">&nbsp;</td>
            <td width="236"><img src="/ImageFiles/<?php echo($strSkin); ?>/GPSTagging/bullet.gif" width="13" height="15" align="middle"> <span class="GPSTaggingBodyText"><strong>Waypoint Information</strong></span> </td>
            <td width="133" class="GPSTaggingBodyText"><strong>Current Waypoint: </strong></td>
            <td width="82" class="GPSTaggingBodyText"><span class="GPSTaggingBodyTextWhite">
              <?=$_REQUEST["counter"];?>
</span></td>
            <td width="134" class="GPSTaggingBodyText"><strong>Defined Waypoint: </strong></td>
            <td width="94" class="GPSTaggingBodyText"><span class="GPSTaggingBodyTextWhite">
              <?=$_REQUEST["maxCount"]?>
</span></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="GPSTaggingBodyCellBg"><table width="778" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="289" valign="top"><img src="/ImageFiles/<?php echo($strSkin); ?>/GPSTagging/image_05.jpg" width="289" height="441"></td>
        <td width="778" valign="top"><table width="446" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td width="57">&nbsp;</td>
            <td width="82"><span class="GPSTaggingBodyText">Name</span></td>
            <td width="277"><input name="txtName" type="text" value="<?php if($check_load_val) echo $txtName?>"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="GPSTaggingBodyText">Longitude</td>
            <td><input name="txtLong1" type="text" value="<?php if($check_load_val) echo $txtLong ?>">
			<input type="button" id="btnBrowse" value="Get Map" onclick="javascript:openYahooMapDialog();" class="GPSTaggingButton">
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="GPSTaggingBodyText">Latitude</td>
            <td><input name="txtLat1" type="text" value="<?php if($check_load_val) echo $txtLat ?>"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="GPSTaggingBodyText">Description</td>
            <td><textarea name="txtDescription" cols="30" rows="5"><?php if($check_load_val) echo $txtDesc ?></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><br>
              <br></td>
            <td class="GPSTaggingBodyText">Image 1 </td>
            <td><input name="images[]" type="file" onChange="setImg(1)">
			  <img id="img1" height="25" width="25" style="display:none">
			  </td>
          </tr>
          <tr>
            <td><br>
              <br></td>
            <td class="GPSTaggingBodyText">Image 2 </td>
            <td><input name="images[]" type="file" onChange="setImg(2)"> 
			  <img id="img2" height="25" width="25" style="display:none"></td>
          </tr>
          <tr>
            <td><br>
              <br></td>
            <td class="GPSTaggingBodyText">Image 3 </td>
            <td><input name="images[]" type="file" onChange="setImg(3)">
			  <img id="img3" height="25" width="25" style="display:none"></td>
          </tr>
          <tr>
            <td><br>
              <br></td>
            <td class="GPSTaggingBodyText">Image 4 </td>
            <td><input name="images[]" type="file" onChange="setImg(4)">
			  <img id="img4" height="25" width="25" style="display:none"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="style3">&nbsp;</td>
            <td><input type="hidden" name="imgLen" value="<?=$imgCounter?>">
              <input type="hidden" name="imgPathArray1" value="<? if(isset($imgArray[0])) echo $imgArray[0]?>">
			  <input type="hidden" name="imgPathArray2" value="<? if(isset($imgArray[1])) echo $imgArray[1]?>">
			  <input type="hidden" name="imgPathArray3" value="<? if(isset($imgArray[2])) echo $imgArray[2]?>">
			  <input type="hidden" name="imgPathArray4" value="<? if(isset($imgArray[3])) echo $imgArray[3]?>">			  <br>			  </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="style3">&nbsp;</td>
            <td>
			  <input name="btnNext" type="submit" class="GPSTaggingButton" value="Back">
              <input name="btnNext" type="submit" class="GPSTaggingButton" value="Next" onClick="return validateForm();">
              <input name="btnNext" type="submit" class="GPSTaggingButton" value="Done" onClick="return validateForm();"></td></tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="GPSTaggingBodyCellBg">&nbsp;</td>
  </tr>
</form>
</table>

<!-------------------------------------------------------------------------------------------------------------->

<!------------------------------------------Start Google Map Div---------------------------------------------------------------->
<div  dojoType="dialog" id="DialogContent" bgColor="white" bgOpacity="0.7" toggle="fade" toggleDuration="200">

		<table border="0" align="center" cellspacing="0" cellpadding="0">
	<form   id="Form1" onsubmit="return false;">
			<tr valign="top">
				<td  colspan="6" valign="middle" bgcolor="#0E3F84" height="30" class="GPSTaggingBodyTextWhite" >&nbsp;&nbsp; GPS Information</td>
			</tr>
			<tr>
				<td colspan="6" height="10"></td>
			
			</tr>
			<tr>
				<td width="1"></td>
				<td colspan="4" align="center">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td class="InputLabel">Location</td>
							<td width="5"></td>
							<td><input name="txtLocation" type="text" class="TextBox"></td>
							<td width="5"></td>
							<td colspan= align="right"><input type="button" name="search" value="Search" class="Button" onClick="searchLocation();"> </td>
							<td width="5"></td>
							<td><a href="#" class="LinkSmall" onclick="return openMapSearchSettingBox()">Advance</a></td>		    				
							<td width="10"></td>
							<td width="150"><div id="divSearchStatus"></div></td>
						</tr>
					</table>
				</td>	
				<td width="1"></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="4" align="center">
				<!-------------------->
				<div id="d2" style="display:none;"><div  class="SearchSettings">
					<p>
				  <table border=0  cellPadding=0 cellSpacing=0>
							<tr valign='top'>
								<td colspan='5' valign='middle'  height='30' class='HeadingText' >&nbsp;&nbsp; Adnavce Search</td>
							</tr>
	  						<tr>
  								<td width=10></td>
  								<td align="right" class="SearchSettingText">Street:</td>
  								<td width="10">&nbsp;</td>
  								<td><input name='txtStreet' type='text'' class="TextBox" ></td>
  								<td width=10></td>
  	  						</tr>
  							<tr>
 								<td></td>
 								<td  align="right" class="SearchSettingText">City:</td>
 								<td></td>
  								<td><input name='txtCity' type='text' class="TextBox" ></td>
  								<td></td>
  							</tr>
 							<tr>
 								<td></td>
 								<td align="right" class="SearchSettingText">State:</td>
 								<td></td>
 								<td><input name='txtState'' type='text' class="TextBox" ></td> 
 								<td></td>
 							</tr>
 							<tr>
 								<td></td>
 								<td align="right" class="SearchSettingText">Zip:</td>
 								<td></td>
 								<td><input name='txtZipCode' type='text' class="TextBox" ></td> 
 								<td></td>
 							</tr>
 							<tr>
 								<td colspan="5" height='10'></td>
 							</tr>
								 
 							
								 <td colspan='5' align='center'><a href="#" class="SearchSettingLink" onclick="return closeMapSearchSettingBox();">Close</a></td>
								 
 							</tr>
 							<tr>
  								<td colspan="5" height='10'></td>
  							</tr>
				  </table>
					</p>
				</div></div>
				<!-------------------->
				</td>
				<td></td>
			</tr>
		    <tr>
				<td colspan="6" height="10"></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="4" valign="top"><div id="divMapErrorBox" style="Visibility:hidden"></div></td>
				<td></td>
			</tr>
			<tr>
					<td></td>
					<td colspan="4">
						<div id="mapContainer" style="width:730px;height:450px;"></div>
					</td>	
					<td></td>
					<!--<script language=javascript>loadMap();</script>-->
 				</td>
			</tr>
			<tr>
				<td colspan="6" height="10"></td>
			</tr>
			<tr>
				<td colspan="6"  align="center">
					<input type="button" id="hider" class="Button" value="Close">
				</td>
			</tr>
			<tr>
				<td colspan="6" height="10"></td>
			</tr>
			</form>
		</table>	

</div>
<div class="notes" id="notesSection"></div>
<!--------------------------------------------------------------------------------------------------------------->
</body>
</html>
<script language="javascript">
<?php
	if(isset($imgArray[0])) 
{
?>
	document.getElementById("img1").style.display="inline";
	document.getElementById("img1").src="<?=$imgArray[0]?>";
<?php
}
if(isset($imgArray[1])) 
{
?>
document.getElementById("img2").style.display="inline";
document.getElementById("img2").src="<?=$imgArray[1]?>";
<?php
}
if(isset($imgArray[2])) 
{
?>
document.getElementById("img3").style.display="inline";
document.getElementById("img3").src="<?=$imgArray[2]?>";
<?php
}
if(isset($imgArray[3])) 
{
?>
document.getElementById("img4").style.display="inline";
document.getElementById("img4").src="<?=$imgArray[3]?>";
<?php
}

?>

function setImg(val)
{
	if(val==1)
	{
		document.getElementById("img1").style.display="inline";
		document.getElementById("img1").src=document.frmWayPointForm.elements[5].value;
	}
	else if(val==2)
	{
			document.getElementById("img2").style.display="inline";
			document.getElementById("img2").src=document.frmWayPointForm.elements[6].value;
	}
	else if(val==3)
	{
			document.getElementById("img3").style.display="inline";
			document.getElementById("img3").src=document.frmWayPointForm.elements[7].value;
		
	}
	else if(val==4)
	{
			document.getElementById("img4").style.display="inline";
			document.getElementById("img4").src=document.frmWayPointForm.elements[8].value;
		
	}

}

</script>

	<!--  Disable Done button  -->
	<script language="javascript">
	<?php 
	if($_REQUEST["maxCount"]==0) 
	{
	?>
	document.frmWayPointForm.elements[16].disabled=true;
	<?php
	}
	?>
	</script>
