<?php
	include_once("IncludeFiles/PHP/CheckSkins.php");
	require_once("FCKeditor/fckeditor.php");
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Mobile Content Exchange</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../sample.css" rel="stylesheet" type="text/css" />
	<link href="IncludeFiles/<?php echo($strSkin);  ?>/CSS/Default.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="IncludeFiles/JavaScript/design7.js" type="text/javascript"></script>	

	<!-------------------------------Plugin Detection--------------------------------->
	<script language="JavaScript">
	<!--
	// initialize a variable to test for JavaScript 1.1.
	// which is necessary for the window.location.replace method
	var javascriptVersion1_1 = false;
	// -->
	</script>
	<script language="JavaScript1.1">
	<!--
	javascriptVersion1_1 = true;
	// -->
	</script>
	<script language="JavaScript" src="IncludeFiles/Javascript/PluginDetection.js"></script>
	<!-------------------------------End Plugin Detection -------------------------------->
	
	<!-----------------------Start Yahoo Maps ---------------------------------------->
	<script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=yahoomapapi1234"></script>
	<script language="javascript" src="/IncludeFiles/Javascript/YahooMap.js"></script>
	
	<script language language="javascript"  >
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
		effect_1 = Effect.SlideUp('d2',{duration:1.0}); 
		//loadMap();
		return false;
		
	}
	</script>
	<!-----------------------End Yahoo Maps------------------------------------------>

	<!-------------Start Dialog ----------------->
	<script type="text/javascript"> djConfig = { isDebug: true }; </script>
	<script type="text/javascript" src="/IncludeFiles/Javascript/dojo/dojo.js"></script>
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
	
	<!-------------Popup Window ------------------->
	<link href="IncludeFiles/Javascript/PopupWindow/themes/default.css" rel="stylesheet" type="text/css" ></link>
	<link href="IncludeFiles/Javascript/PopupWindow/themes/theme1.css" rel="stylesheet" type="text/css" ></link>
	<link href="IncludeFiles/Javascript/PopupWindow/themes/alert.css" rel="stylesheet" type="text/css" ></link>
	<link href="IncludeFiles/Javascript/PopupWindow/themes/alert_lite.css" rel="stylesheet" type="text/css" ></link>
	
	<script type="text/javascript" src="IncludeFiles/Javascript/PopupWindow/prototype.js"> </script> 
	<script type="text/javascript" src="IncludeFiles/Javascript/PopupWindow/effects.js"> </script>
	<script type="text/javascript" src="IncludeFiles/Javascript/PopupWindow/window.js"> </script>
	<script type="text/javascript" src="IncludeFiles/Javascript/PopupWindow/debug.js"> </script>
	
	
	<script language="javascript">
	function openAlertDialog() 
	{
		
		var strHTML="<img ID="imgTest" src='ImageFiles/Common/Google_Map.JPG' width=400 height=340>"; 
		Dialog.alert(strHTML, 
				        {windowParameters: {width:600, height:400}, okLabel: "close", 
						    ok:function(win) 
						    {
						    	//var doc=win.document();
						    	//alert(document.getElementById("imgTest"));
						    
						    
						    }
						    });
	}
	
	</script>
	<!----------End PopUp Window ------------------>

	<!------- Start Search Setting Script ------------------------->
	<script src="IncludeFiles/JavaScript/JavascriptEffects/lib/prototype.js" type="text/javascript"></script>
	<script src="IncludeFiles/JavaScript/JavascriptEffects/src/scriptaculous.js" type="text/javascript"></script>
	<script src="IncludeFiles/JavaScript/JavascriptEffects/src/unittest.js" type="text/javascript"></script>
	<script language="javascript" src="IncludeFiles/JavaScript/Utilities.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" charset="utf-8">
	// <![CDATA[
	  var effect_1 = null;
	// ]]>
	</script>
	<!---------End  Reaserch Seetting Script ---------------------->
	<!-------Start Drag and Drop  --------------------------->
	<script type="text/javascript">
		//new Draggable('product_id', {revert:false})
	</script>
	<!--------End Dag and Drop -------------------------------->
	
	
	<!------------Start Content Editor Script ------------>
	<script type="text/javascript">
	var	objEditorInstance;
	
	function FCKeditor_OnComplete( editorInstance )
	{	
		
		objEditorInstance=editorInstance;
		/*
		if (waitWin && !waitWin.closed)
		{		
			waitWin.close();
		}
		*/
	}
	</script>
	<script src="IncludeFiles/Javascript/LeftMenu.js"></script>
</head>
<body leftmargin="0" topmargin="0" >
<!-------------------------------->
<script type="text/javascript" src="IncludeFiles/Javascript/Tooltip.js"></script>
<!------------------------------>
	<table align="center" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td colspan="5">
				<table cellspacing="0" cellpadding="0" border="0" bordercolor="#00FF00">
					<tr>
						<td><img src="ImageFiles/<?php echo($strSkin); ?>/LeftLogo.gif" width="131" height="66"></td>
						<td width="600" valign="bottom"></td>
						<td align="right"><img src="ImageFiles/<?php echo($strSkin); ?>/RightLogo.gif" width="214" height="42"></td>

					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<!---------------Start Left Portion ---------------->
			<td align="left" valign="top">
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
					<tr>
						<td height="150" valign="top">
							<!------------------Start Left Menu----------------------->
						
							<?php include_once("IncludeFiles/PHP/LeftMenu.php");?>
							
							<!---------------------End Left Menu -------------------->
						</td>
					</tr>
					<!-------------------Start Resaerch Tools ------------------------->
					<tr>
						<td>
							<table cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td align="center" bgcolor=<?php echo($strColor);?> width="150" height="25" class="HeadingText">Research Tools </td>
								</tr>
								<tr>
									<td height="5"></td>
								</tr>	
								<tr>
									<td><label class="InputLabelSmall">&nbsp;&nbsp;Enter Text</label></td>
								</tr>
								<tr>
									<td>&nbsp;&nbsp;<input id="txtQuery" name="txtQuery" type="text" class="TextBox"></td>
								</tr>
								<tr>
									<td height="2"></td>
								</tr>
								<tr>
									<td align="right">
										<input type="button" value="Search" class="Button" width="120" onClick="javascript:ShowSearchResults()">
											&nbsp;&nbsp;&nbsp;&nbsp;
									</td>
								</tr>
								<tr>
									<td height="10"></td>
								</tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0" border="0">
											
											<tr>
												<td width="40"></td>
												<td>
													<input id='chkImage' checked type="checkbox" onclick="ImageContentCheckBoxChange()" ><label class="TextNormal">Images</label></br>
													<input id='chkText' checked type="checkbox" onclick="TextContentCheckBoxChange()" ><label class="TextNormal">Text</label></br>
													<input id='chkAudio' checked type="checkbox" onclick="AudioContentCheckBoxChange()" ><label class="TextNormal">Audio</label></br>
													<input id='chkVideo' checked type="checkbox" onclick="VideoContentCheckBoxChange()" ><label class="TextNormal">Video</label></br>
													
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td height="5"></td>
								</tr>	
								<tr>
									<td>
										<!---------------------------Start Search Setting----------------------->
											&nbsp;&nbsp;&nbsp;<a href="#" class="LinkSmall" onclick="effect_1 = Effect.SlideDown('d1',{duration:1.0}); return false;">Settings</a> 
											<div id="d1" style="display:none;"><div  class="SearchSettings">
												<p>
													<table align="left" cellspacing="0" cellpadding="0" border="0">
														<tr>
															<td colspan="2" class="SearchSettingHeading">Includes in search</td> 
														</tr>
														<tr>
															<td height="8"></td>
														</tr>
														<tr>
															<td width="25"></td>
															<td align="left" class="SearchSettingText"><input  name="chkYahoo" id='chkYahoo' type="checkbox" value="yahoo" checked>Yahoo</td>
														</tr>	
														<tr>
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkGoogle"  id='chkGoogle' type="checkbox" value="google">Google</td>
														</tr>
														<tr>
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkMsn" id='chkMsn' type="checkbox" value="msn">MSN</td>
														</tr>
														<tr>
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkFlickr" id='chkFlickr' type="checkbox" value="flickr">Flickr</td>
														</tr>
														<tr>
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkGrouper" id='chkGrouper' type="checkbox" value="grouper">Grouper</td>
														</tr>
														<tr>
															<td height="25"></td>
															<td align="right"><a href="#" class="SearchSettingLink" onclick="effect_1 = Effect.SlideUp('d1',{duration:1.0}); return false;">Close</a></td>
														</tr>
													</table>
												</p>
											</div></div>
										<!-------------------------End Serach Settings --------------------------> 
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!------------------- End Resaerch Tools ------------------------->
				</table>
			</td>
			<!------------End Left Portion ---------------->
			<td width="3"></td>
			<!------------start Middle Portion -------------->
			<td align="left" valign="top">
				<table width="670" cellpadding="0"  cellspacing="0" border="0">
					<!-----------------Start Content Editor ---------------->
					<tr>
						<td>
							<!-----------Start Tabs --------->
							<table cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="125"></td>
									<td align="center" background="ImageFiles/<?php echo($strSkin);?>/Tab_top_HightLighted.gif" width="84" height="27"><a href='Home1.php' class="TabTopTextHightLight">Home</a> </td>	
									<td width="5"></td>
									<td align="center" background="ImageFiles/<?php echo($strSkin);?>/Tab_top.gif" width="84" height="27"><a href='Home1.php' class="TabTopText">Features</a> </td>	
									<td width="5"></td>
									<td align="center" background="ImageFiles/<?php echo($strSkin);?>/Tab_top.gif" width="84" height="27"><a href='AboutUs.php' class="TabTopText">About Us</a></td>	
									<td width="5"></td>
									<td align="center" background="ImageFiles/<?php echo($strSkin);?>/Tab_top.gif" width="84" height="27"><a href='ContactUs1.php' class="TabTopText">Contact Us</a></td>	
									<td width="5"></td>
									<td align="center" background="ImageFiles/<?php echo($strSkin);?>/Tab_top.gif" width="84" height="27"><a href='help1.php' class="TabTopText">Help</a></td>	
								</tr>		
							</table>
							<!-----------End Tabs ------------>
						</td>
					</tr>
					<tr>
						<td>
							<table cellspacing="0" cellpadding="0"  border="1" bordercolor=<?php echo($strColor);?>>
								<tr>
									<td width="670" align="left" bgcolor=<?php echo($strColor);?> height="25" class="HeadingMainText">&nbsp;&nbsp;&nbsp;&nbsp;Content Editor</td>
								</tr>
								<tr>
									<td height="400">
										<?php
											// Automatically calculates the editor base path based on the _samples directory.
											// This is usefull only for these samples. A real application should use something like this:
											// $oFCKeditor->BasePath = '/FCKeditor/' ;	// '/FCKeditor/' is the default value.
											//$sBasePath = $_SERVER['PHP_SELF'] ;
											//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
											$sBasePath='/FCKeditor/';
											$oFCKeditor = new FCKeditor('FCKeditor1') ;
											$oFCKeditor->BasePath = $sBasePath ;
	
											//if ( isset($_GET['Skin']) )
											//$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/' . 'office2003' . '/' ;
											//$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/' . 'silver' . '/' ;
											$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/' . 'default' . '/' ;
											$oFCKeditor->Height="400";	
											$oFCKeditor->Width="100%";	
											
											
											$oFCKeditor->Value = 'This is some <strong>sample text</strong>.' ;
											$oFCKeditor->Create() ;
										?>
									</td>
								</tr>
							</table> 
						</td>
					</tr>
					
					<!-----------------------End Content Editor ----------------------->
					<tr>
						<td height="5"></td>
					</tr>
					<!----------------------Start Searcch Results --------------------->
					<tr>
						<td>
							<div id='divSearchResults' style="visibility:hidden"  >
								<table cellspacing="0"  cellpadding="0" border="0">
									<tr>
										<td width="670" height="25" bgcolor=<?php echo($strColor);?> class="HeadingMainText">&nbsp;Search Results Are</td>
									</tr>
									<tr>
										<td height="10"></td>
									</tr>
									<tr>
										<td>
											<table cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td width="50"></td>
													<td id='tdImage' align="center"  background="ImageFiles/<?php echo($strSkin);?>/Tag_Bottom_HighLighted.gif" width="76" height="24"><a id="hplImage" href="#" class="TabBottomTextHightLight" onClick="javascript:return ChangeResultType('IMAGE')">Images</a></td>
													<td width="5"></td>
													<td id='tdText' align="center" background="ImageFiles/<?php echo($strSkin);?>/Tag_Bottom.gif" width="76"  height="24"><a id='hplText' href="" class="TabBottomText" onClick="javascript:return ChangeResultType('TEXT')">Text</a></td>
													<td width="5"></td>
													<td id='tdAudio' align="center" background="ImageFiles/<?php echo($strSkin);?>/Tag_Bottom.gif" width="76"  height="24"><a id="hplAudio" href="" class="TabBottomText" onClick="javascript:return ChangeResultType('AUDIO')">Audio</a></td>
													<td width="5"></td>
													<td id='tdVideo' align="center" background="ImageFiles/<?php echo($strSkin);?>/Tag_Bottom.gif" width="76"  height="24"><a id="hplVideo" href="" class="TabBottomText" onClick="javascript:return ChangeResultType('VIDEO')">Video</a></td>
												</tr>										
											</table>
										</td>
									</tr>
									<tr>
										<td >
											<table cellspacing="0" cellpadding="0" border="1" bordercolor=<?php echo($strColor);?> >
												<tr>
													<td width="670" height="100">
														<div id='divResults' style="overflow:scroll;height:200">
															<table cellspacing="0" cellpadding="0" border="0">
																<tr>
																	<td></td>
																</tr>
															</table>
														</div>	
													</td>
												</tr>
											</table>		  
										</td>
									</tr>
								</table>
							</div>	
						</td>
					</tr>
					<!---------------------End Search Results ----------------------------->
				</table>
			</td>
			<!------------End Middle Potion ----------------->
			<td width="3"></td>
			<!------------Start Right Portion ------------->
			<td width="175" valign="top">
				<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td height="27"></td>
					</tr>
					<!-----------Start Google Map And Adds Portion ----------------->
					<tr valign="top">
						<td valign="top">
							<table cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td align="center" bgcolor=<?php echo($strColor);?>  height="27" width="175" class="HeadingText">GPS Information</td>
								</tr>
								<tr>
									<td height="4"></td>
								</tr>
								<tr>
									<td><img src="ImageFiles/<?php echo($strSkin);?>/Google_Map.JPG" width="174" height="174"></td>
								</tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0"  border="0">
											<tr>
												<td height="10"></td>
											</tr>
											<tr>
												<td width="10"></td>
												<td>
													<label class="InputLabelSmall">Longitude</label></br>
													<input id="txtLongitude" type="text" class="TextBoxSmall" > 
												</td>
												<td width="10"></td>
												<td>
												 	<label class="InputLabelSmall">Latitude</label></br>
													<input id="txtLatitude" type="text" class="TextBoxSmall" > 
												</td>
											</tr>
											<tr>
												<td height="10"></td>
											</tr>	
											<tr>
												<td align="right" colspan="4">
													<!--<input type="button"  value="Find" onclick="Javascript:openAlertDialog()" class="ButtonSmall"  >-->
													<input type="button"  value="Find" onclick="Javascript:OpenGoogleMapDialog()" class="ButtonSmall"  >
													&nbsp;&nbsp;&nbsp;
												</td>
											</tr>				
											<tr>
												<td height="10"></td>
											</tr>
											<tr>
												<td colspan="4">
													<img src="ImageFiles/<?php echo($strSkin);?>/Add.jpg" width="174" height="105">
												</td>
											</tr>
											<tr>
												<td height="10"></td>
											</tr>
											<tr>
												<td colspan="4">
													<img src="ImageFiles/<?php echo($strSkin);?>/Add.jpg" width="174" height="105">
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!-----------End Google Map and Adds Portion ----------------->
				</table>
			</td>
			<!-------------End Right Portion --------------->
		</tr>
		<tr>
			<td height="5"></td>
		</tr>
		
		<tr>
			<td>
				<div id="" style="visibility:hidden" >
						<textarea id='txtCache' cols="1" rows="1" ></textarea>
					</div>
			</td>
		</tr>
		<!---------------------------------------------------------------------------->
		<!-----------------------------Start Footer----------------------------------->
		<!---------------------------------------------------------------------------->
		
		<tr>
			<td align="center" height="35" colspan="5" bgcolor=<?php echo($strColor);?> class="Footer" >
					© 2006 MCE
			</td>
		</tr>
		<!-----------------------------End Footer ------------------------------------>
		
		<!-----------------------------Start Hidden Fields ---------------------------->
		<tr>
			<td>
				<input type="hidden" id="hdnImageStartIndex" name="hdnStartIndex" value="1">
				<input type="hidden" id="hdnTextStartIndex" name="hdnTextStartIndex" value="1">
				<input type="hidden" id="hdnAudioStartIndex" name="hdnAudioStartIndex" value="1">
				<input type="hidden" id="hdnVideoStartIndex" name="hdnVideoStartIndex" value="1">
			</td>
		</tr>
		<!-----------------------------End Hidden Fields ---------------------------------->
		
	</table>

<!------------------------------------------Start Google Map Div---------------------------------------------------------------->
<div  dojoType="dialog" id="DialogContent" bgColor="white" bgOpacity="0.7" toggle="fade" toggleDuration="200">
	<form  onsubmit="return false;">
		<table border="0" align="center" cellspacing="0" cellpadding="0">
			<tr valign="top">
				<td  colspan="6" valign="middle" bgcolor=<?php echo($strColor);?> height="30" class="HeadingText" >&nbsp;&nbsp; GPS Information</td>
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
						<div id="mapContainer" style="width:800px;height:500px;"></div>
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
		</table>	
	</form>
</div>
<!----------------------------------------End Google Map ---------------------------------------->
<script language="JavaScript" src="IncludeFiles/JavaScript/tmenu.js"></script>
</body>
</html>
