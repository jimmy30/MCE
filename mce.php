<?php
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ProducerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/clsCurl.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/ManageFile.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/MceService.php");
//Property class object
$objProperties=new Properties();
$objFile=new ManageFile();
//Load property file
$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT']."/Properties/default.properties"));

// include server name with directory
/*
$strServerName=$objProperties->getProperty('site_url');
$strUploadDirectory=$strServerName."/".$objProperties->getProperty('user_files_upload_directory');
*/
$id=$_GET['id'];
$pid=$_GET['pid'];


$strUploadDirectory="/".$objProperties->getProperty('user_files_upload_directory');
// set user sessionId with directory
$strUploadDirectory=$strUploadDirectory."/".$_SESSION[sessionKeys::USER_ID]."/";		
$intPaggingLimit=$objProperties->getProperty('user_files_pagging_record_limit');
$strServerName=$objProperties->getProperty('site_url');
$strDownloadDirectory=$objProperties->getProperty('waypoint_content_directory');
//$strDownloadDirectory=$strServerName."/".$strDownloadDirectory;


$strNewDownloadDirectory=$strDownloadDirectory."/".$pid."/Waypoints"."/".$id;
$strPath=$strServerName.'/'.$strNewDownloadDirectory;
//echo($strPath);


$status=$objFile->findDirectory($strNewDownloadDirectory);

$strFileName=$strNewDownloadDirectory.'/'.$id.".html";
$strFileData="";

$strFileData=$objFile->readFile($strFileName);
//echo($strFileData.'</br>');
$strData=$strFileData;



function str_replace_count($search,$replace,$subject,$times) {

   $subject_original=$subject;
   
   $len=strlen($search);    
   $pos=0;
   for ($i=1;$i<=$times;$i++) {
       $pos=strpos($subject,$search,$pos);
       
       if($pos!==false) {                
           $subject=substr($subject_original,0,$pos);
           $subject.=$replace;
           $subject.=substr($subject_original,$pos+$len);
           $subject_original=$subject;
       } else {
           break;
       }
   }
   
   return($subject);

}


$strData=str_replace_count("rtsp://","http://",$strData,100);



//To Do................................
//$strData=$objFile->contentEditorHtml($strFileData,$id,$pid);
//echo($strData.'</br>');

if (NAJAX_Server::runServer()) 
{
	exit;
}
?>
<?php 
	echo(NAJAX_Utilities::header('/IncludeFiles/PHP/Najax'));
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
	<LINK REL=StyleSheet HREF="IncludeFiles/JavaScript/floating_dimming_div/dimming.css" TYPE="text/css">

	<script language="javascript" src="IncludeFiles/JavaScript/design7.js" type="text/javascript"></script>	
	<script language="javascript" src="IncludeFiles/JavaScript/querystring.js" type="text/javascript"></script>	
	<script language="javascript" src="IncludeFiles/JavaScript/Utilities.js" type="text/javascript"></script>

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

	<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAk8dPRHlV_kG_hFvgb_jPdhQcaM2NFj5ByKgrIExaYbRca0LkLBSV33nxT9M1kkKL3DiSaf1cI-ZMiA" type="text/javascript"></script>
	<script language="javascript" src="/IncludeFiles/Javascript/googleMap.js"></script>

	<script language="javascript">
	function openMapSearchSettingBox()
	{
		alert('This functionlity is still under development');
		
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

<?php if(isset($_SESSION[sessionKeys::USER_EMAIL]) || $_SESSION[sessionKeys::USER_EMAIL]!="")
{
?>
	<script type="text/javascript"> djConfig = { isDebug: true }; </script>
	<script type="text/javascript" src="/IncludeFiles/Javascript/dojo/dojo.js"></script>

	<script type="text/javascript">
		dojo.require("dojo.widget.Dialog");
	</script>
<?php }?>

	<script type="text/javascript">
		var dlg;
		var dlgDownLoadReport;
		function init(e) 
		{
			
			<!-------------Start Yahoo Map------------------>
			dlg = dojo.widget.byId("DialogContent");
			var btn = document.getElementById("hider");
			dlg.setCloseControl(btn);
			<!-------------End Yahoo Map------------------>
			
			<!-------------Start Download Report------------------>
			dlgDownLoadReport = dojo.widget.byId("divContentDowloadReport");
			var btnDownloadReport = document.getElementById("downLoadReporthider");
			dlgDownLoadReport.setCloseControl(btnDownloadReport);
			<!-------------End Download Report-------------------->
			
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
		
		var strHTML="<img ID='imgTest' src='ImageFiles/Common/Google_Map.JPG' width=400 height=340>"; 
		Dialog.alert(strHTML, 
				        {windowParameters: {width:600, height:400}, okLabel: "close", 
						    ok:function(win) 
						    {
						    							    }
						    });
	}
	
	</script>
	<!----------End PopUp Window ------------------>

	<!------- Start Search Setting Script ------------------------->
	<script src="IncludeFiles/JavaScript/JavascriptEffects/lib/prototype.js" type="text/javascript"></script>
	<script src="IncludeFiles/JavaScript/JavascriptEffects/src/scriptaculous.js" type="text/javascript"></script>
	<script src="IncludeFiles/JavaScript/JavascriptEffects/src/unittest.js" type="text/javascript"></script>

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
	var counter = 0 ;
	var strWaypointLongitude;
	var strWaypointLatitude;
	var intRadius;
	var intFolderId='<?php echo($_REQUEST["id"]);?>';
				

	function DoSomething( editorInstance )
	{
		alert('test');
	}
	function FCKeditor_OnComplete( editorInstance )
	{	
		
		
		objEditorInstance=editorInstance;

		getFileList();
		

	}
	<!------------Get Value From Content Editor Script ------------>
	function getEditorValue()
	{
		
		try
		{
			var strStatus='<?php echo($status);?>';	
			// Parse the current page's querystring
			var objQueryString = new Querystring()
			// get a given querystring variable value
			var strQueryValue = objQueryString.get("id")
			var strPlaceCastValue=objQueryString.get("pid")
			

			
			var strHtml='';
			var strXml='';
			var strStatus="";
			var strProgressBarHTML="";
			var strSimpleHtml="";
			
			if(strQueryValue==null)
			{
				strSimpleHtml=" <Table cellspacing=0 cellpadding=0 border=0>";
				strSimpleHtml=strSimpleHtml+" <tr> <td height=40></td></tr>";
				strSimpleHtml=strSimpleHtml+" <tr><td valign='middle' align='center'>";
				strSimpleHtml=strSimpleHtml+'<td class="RegistrationBodyText">Unable to save contents Please <a href="/PlaceCast/Producer/ViewPlaceCast.php" class="RegistrationBodyText" >Click Here</a>';
				strSimpleHtml=strSimpleHtml+" </td></tr></table>";
				Dialog.alert(strSimpleHtml,
								{windowParameters: {width:300, height:120}, okLabel: 'close', ok:function(win) {debug('validate alert panel')} 
								});
				
				
			}
			else
			{
				var objNajax = <?= NAJAX_Client::register(new clsCurl()) ?>;
				
				// get editor html
				strHtml="<Html>";
				strHtml=strHtml+objEditorInstance.GetXHTML(true);
				strHtml=strHtml+"</Html>";
			//	alert(strHtml);
				// Progress bar html 
				strProgressBarHTML=" <Table cellspacing=0 cellpadding=0 border=0>";
				strProgressBarHTML=strProgressBarHTML+" <tr> <td height=40></td></tr>";
				strProgressBarHTML=strProgressBarHTML+" <tr><td valign='middle' align='center'>";
				strProgressBarHTML=strProgressBarHTML+'<div id="loading" style="display:none" class="RegistrationBodyText" align="center">Downloading in progress...<img src="/ImageFiles/common/Busy.gif" width="16" height="16"></div>';
				strProgressBarHTML=strProgressBarHTML+" </td></tr></table>";
				// Display progress bar window.
				if (window.ActiveXObject)
				{
				Dialog.info(strProgressBarHTML,
							{windowParameters: {className: "alert_lite",width:250, height:100}, showProgress: false});
				}
				else // mozilla
				{
					document.getElementById("progressBar").innerHTML=strProgressBarHTML;
					displayFloatingDiv('progressBar', 'Floating and Dimming Div', 250, 100, screen.width/3, screen.height/3);
				}
				/*			
				Dialog.alert(strJsHTML,
								{windowParameters: {width:200, height:100}, okLabel: 'close', ok:function(win) {debug('validate alert panel')} 
								});
				*/				
	
				document.getElementById("loading").style.display="inline";				
				// call downloadfile function
				var intPlaceCastFolderId='<?php echo($_REQUEST["pid"]);?>';
				var intCountryId='<?php echo($_REQUEST["cid"]);?>';	
				var strWayPointName='<?php echo($_REQUEST["waypointname"]);?>';
				
				
			
				objNajax.downLoadFile(strHtml,intFolderId,intPlaceCastFolderId,strWayPointName,strWaypointLongitude,strWaypointLatitude,intRadius,function(result)
					 {
						 

						 strStatus=result;
						
						 if (strStatus==null)
						 {
							document.getElementById("loading").style.display="none";
						 }
						else
						{
							//alert(result);
							strXml=result;

							document.getElementById("loading").style.display="none";
							if (window.ActiveXObject)
							{
							Dialog.closeInfo();
							}
							else
							{
							hiddenFloatingDiv('progressBar');void(0);
							}
							javascript:dlgDownLoadReport.show();
							document.getElementById("divTest").innerHTML=strXml;
							
							//SendEmailAlert(intCountryId,intFolderId);	
							//SendSmsAlert(intCountryId,intFolderId);	
							EnablePlaceCastStatus(intPlaceCastFolderId,1);
							EnableWaypointStatus(intFolderId,1);
							
							// To Do..
							/*Dialog.alert(strXml,
								{
									windowParameters: {className:"alert_lite.css", width:520, height:400}, okLabel: 'close', ok:function(win) {debug('validate alert panel')} 
								});*/
							
						}
					 });
				
						
				
				 
			}
			return false;		 
		}
		catch (e) 		 
		{
			alert(e.message);
		}
	}
	
	function SendEmailAlert(pIntCountryId,intFolderId)
	{
		
		var objNajaxEmail = <?= NAJAX_Client::register(new MceService()) ?>;
		objNajaxEmail.SendEmailAlert(pIntCountryId,intFolderId,function(result)
		{
			//alert(result);
		});
		
	}
	function SendSmsAlert(pIntCountryId,intFolderId)
	{
		
		var objNajaxEmail = <?= NAJAX_Client::register(new MceService()) ?>;
		objNajaxEmail.SendSmsAlert(pIntCountryId,intFolderId,function(result)
		{
			//alert(result);
		});
		
	}
	function EnablePlaceCastStatus(pIntPlaceCastId,pIntStatus)
	{
		var objNajaxPlaceCast=<?= NAJAX_Client::register(new MceService()) ?>;
		objNajaxPlaceCast.EnablePlaceCastStatus(pIntPlaceCastId,pIntStatus,function(result)
		{
			//alert(result);
		});
		
	}
	
	function EnableWaypointStatus(pIntWaypoint,pIntStatus)
	{
		var objNajaxWaypoint=<?= NAJAX_Client::register(new MceService()) ?>;
		objNajaxWaypoint.EnableWaypointStatus(pIntWaypoint,pIntStatus,function(result)
		{
			// alert(result);
		});
		
	}
	function GetWaypointById(pIntWaypoint,pIntStatus)
	{
		
		var objNajaxWaypointById=<?= NAJAX_Client::register(new MceService()) ?>;
		objNajaxWaypointById.GetWaypointById(pIntWaypoint,pIntStatus,function(result)
		{
			//alert(result);
			ParseWayPointDetail(result);
		});
		
		
	}
	function ParseWayPointDetail(pResponse)
	{
		var XMLDoc =GetXmlHttpObject();
		var rootNode = "";
		var strStatus="";
		var intExceptionNo="";
		var strExceptionName="";
		var strResonse=pResponse;
		XMLDoc.async = "false";	  
		// For Internet Explorer	  
		if (window.ActiveXObject)
		{	  
			if(strResonse!=null)
			{
				if(XMLDoc.loadXML(strResonse)==true)
				{
					rootNode=XMLDoc.documentElement;
					intNoOfRecords=rootNode.selectSingleNode("NoOfRecords").text;
					for(i=0;i< intNoOfRecords;i++)	
					{
						intWaypointId=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(0).text;
						strWaypointName=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(1).text;				
						strWaypointAddress=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(2).text;				
						strWaypointCity=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(3).text;				
						strWaypointLongitude=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(4).text;
						strWaypointLatitude=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(5).text;
						intRadius=rootNode.selectSingleNode("WaypointList").childNodes.item(i).childNodes.item(7).text;
						

					}
				}	
			}
		}
		else
		{
			if(strResonse!=null)
			{
				var xmlDoc = XMLDoc.parseFromString(strResonse, "application/xml");
				var strWaypoints = xmlDoc.getElementsByTagName('Waypoints');
				var intNoOfRecords= strWaypoints[0].getElementsByTagName('NoOfRecords')[0].textContent;
				var strWaypointList = xmlDoc.getElementsByTagName('Waypoint');
				
				intWaypointId=strWaypointList[0].getElementsByTagName('WaypointId')[0].textContent;
				strWaypointName=strWaypointList[0].getElementsByTagName('WaypointName')[0].textContent;				
				strWaypointAddress=strWaypointList[0].getElementsByTagName('WaypointAddress')[0].textContent;				
				strWaypointCity=strWaypointList[0].getElementsByTagName('WaypointCity')[0].textContent;				
				strWaypointLongitude=strWaypointList[0].getElementsByTagName('WaypointLongitute')[0].textContent;
				strWaypointLatitude=strWaypointList[0].getElementsByTagName('WaypointLatitute')[0].textContent;
				intRadius=strWaypointList[0].getElementsByTagName('WaypointRadius')[0].textContent;
			}
		}		
	}
	function GetXmlHttpObject()
	{ 
		var objXMLHttp=null
		if (window.XMLHttpRequest)
		{
			objXMLHttp = new DOMParser();
		}
		else if (window.ActiveXObject)
		{
			objXMLHttp=new ActiveXObject("Microsoft.XMLDOM")
		}
		return objXMLHttp
	} 
	<!--------End Get Value From Content Editor Script-------------------------------->
	</script>
<script language="javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

</script>
	<script language="javascript">
	

	var intPageNo=1;
	var intRecordLimit='<?php echo($intPaggingLimit);?>';
	var strFileDirectoryPath='<?php echo($strUploadDirectory)?>';
	var strFileName="";
	var filename = new Array();
	var pathSplit = new Array();
	var intNoOfRecord;
	var intNoOfPages;
	var intStart=1;
	var MAX_TITLE_LENGTH=8;
	var intEnd=intRecordLimit;
	
	function addImagesToEditor(pUrl)
	{
		
		objEditorInstance.InsertHtml("<img src="+URLencode(pUrl)+" width=75 height=75>");
		return false;
	}
	
	function addFilesToEditor(pUrl,pImageUrl)
	{
		//alert(pUrl);
		objEditorInstance.InsertHtml("<a href='" + pUrl +"'><img src="+pImageUrl+" width=75 height=75></a>");
		return false;
	}
	function getFileList()
	{
	
	var objManageFile = <?= NAJAX_Client::register(new ManageFile()) ?>;
/*
objManageFile.getFileList('',
		function(result)
		{
			alert(result);
		}
		);
*/
	
	objManageFile.getFileList('',
		function(result)
		{
			var i;
			var strHTML="";
			var strFileExtension="";
			var strImageName="";
				var strFileName="";
			intNoOfRecord = result.length;
			intNoOfPages = Math.ceil(intNoOfRecord / intRecordLimit);
	
			strHTML+='<table  width=100% border="0" cellpadding="3" cellspacing="1" class=RegistrationTabBorder>';
			strHTML+='<tr class=RegistrationCellBg>';
			strHTML+='<td class=BodyTextSmall colspan=3>Uploaded File(s)</td>';
			strHTML+='</tr>';
			strHTML+='<tr bgcolor=#EEEEEE>';
			strHTML+='<td bgcolor=#EEEEEE class=RegistrationBodyText><strong>File Name  </strong></td>';
			strHTML+='<td bgcolor=#EEEEEE class=RegistrationBodyText><strong>Type  </strong></td>';
			strHTML+='<td bgcolor=#EEEEEE class=RegistrationBodyText><strong>Add</strong> </td>';
			strHTML+='</tr>';
			//alert('test');
			if(intNoOfPages==1)
			{
				intEnd=intNoOfRecord;
			}
	
			if(intNoOfRecord!=0)
			{
				for(i=intStart;i<=intEnd;i++)
				{
					pathSplit=result[i-1].split("/");
					filename=pathSplit[pathSplit.length-1].split(".");
					
					var strSubFileName=filename[0];
					if (strSubFileName.length>MAX_TITLE_LENGTH)
					{
						strSubFileName = strSubFileName.substring(0,MAX_TITLE_LENGTH)+"...";
					}
					
					//strFileName=strFileDirectoryPath+result[i-1];
					strFileName=result[i-1];
	
					strHTML+='<tr bgcolor=#EEEEEE>';
					strFileExtension=filename[1].toLowerCase();
					
					//alert(strFileExtension);

					if(strFileExtension=="jpg" || strFileExtension=="png" || strFileExtension=="jpeg" || strFileExtension=="gif" || strFileExtension=="bmp")
					{
						//strSubFileName
						strHTML+='<td class=RegistrationBodyText>'+strSubFileName+'</td>';
						strHTML+='<td class=RegistrationBodyText><img src="/ImageFiles/common/'+filename[1].toLowerCase()+'.gif"></td>';
						strHTML+='<td align="center"><img src="/ImageFiles/common/add.gif" border=0 onclick=\'return addImagesToEditor("'+strFileName+'")\'  style="cursor:hand"></td>';
					}
					
					else if(strFileExtension=="pdf" || strFileExtension=="mp3" || strFileExtension=="wav" || strFileExtension=="avi" || strFileExtension=="wmv" || strFileExtension=="rm")
					{
						
						strImageName="/ImageFiles/common/"+filename[1].toLowerCase()+".gif";
						strHTML+='<td class=RegistrationBodyText>'+strSubFileName+'</td>';
						strHTML+='<td class=RegistrationBodyText><img src="/ImageFiles/common/'+filename[1].toLowerCase()+'.gif"></td>';
						strHTML+='<td align="center"><img src="/ImageFiles/common/add.gif" border=0 onclick=\'return addFilesToEditor("'+strFileName+'","'+strImageName+'")\'></td>';
					}	
					
					strHTML+='</tr>';
				}
			}
	
			strHTML+='<tr>';
			strHTML+='<td colspan=3 align=center>';
			
			if(intNoOfRecord>intRecordLimit)
			{
				if(intPageNo==1)
				{
					strHTML+='<img src="/ImageFiles/common/paging/pre.gif" alt="Back">';
				}
				else
				{
					strHTML+='<img src="/ImageFiles/common/paging/pre.gif" alt="Back" style="cursor:hand" onclick="GoBack()">';
				}
		
				strHTML+='&nbsp;&nbsp;';
				
				if(intPageNo==intNoOfPages)
				{
					strHTML+='<img src="/ImageFiles/common/paging/next.gif" alt="Next">';
				}
				else
				{
					strHTML+='<img src="/ImageFiles/common/paging/next.gif" alt="Next" style="cursor:hand" onclick="GoNext()">';			
				}
			}
			var winWidth=690;
			var winHeight=453;
			var left=(screen.width / 2 - winWidth / 2);
			var top=(screen.height / 2 - winHeight / 2);


			strHTML+='</table>';
			strHTML+='<div align="center"><a href="#" onClick="MM_openBrWindow(\'/FileDetailpop.php\',\'AccountType\',\'status=yes,scrollbars=yes, width='+winWidth+', height='+winHeight+', left='+left+',top='+top+'\')" class="LinkSmall">Manage</a></div>';
	
			document.getElementById("FileList").innerHTML = strHTML;
			}
			);

	}

	function GoBack()
	{
		intPageNo--;
		intStart=(intRecordLimit*(intPageNo-1))+1;
		intEnd=intStart+(intRecordLimit-1);
			
		getFileList();
	}

	function GoNext()
	{
		intPageNo++;
		intStart=(intRecordLimit*(intPageNo-1))+1;

		if(intPageNo==intNoOfPages)
		{
			intEnd=intStart+(intNoOfRecord-((intNoOfPages-1)*intRecordLimit))-1;
		}
		else
			intEnd=intStart+(intRecordLimit-1);

		getFileList();
	}

//// Load file list ///
//getFileList();
///////////////////////
function contentPreview()
{
var winWidth=622;
var winHeight=540
var left=(screen.width / 2 - winWidth / 2);
var top=(screen.height / 2 - winHeight / 2);

document.getElementById("hiddenHtmlContent").value=objEditorInstance.GetXHTML(true);
window.open('/preview.php','','left='+left+', top='+top+', width='+winWidth+', height='+winHeight+',status=yes,scrollbars=yes');
//document.frmPreview.submit();
}
	</script>
	
	
	<script src="IncludeFiles/Javascript/LeftMenu.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<!-------------------------------->
<script type="text/javascript" src="IncludeFiles/Javascript/Tooltip.js"></script>
<!------------------------------>

	<table align="center" cellpadding="0" cellspacing="0" border="0" >
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
						<td width="150" height="27"><?php include_once("IncludeFiles/PHP/LeftMenu.php");?></td>
					</tr>

					<tr>
						<td valign="top"><div id="FileList"></div></td>
					</tr>
					<tr>
						<td height="12" valign="top"></td>
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
									<td>&nbsp;&nbsp;<input name="txtQuery"  type="text" id="txtQuery" size="16"></td>
								</tr>
								<tr>
									<td height="2"></td>
								</tr>
								<tr>
									<td align="right">
										<input type="button" value="Search" class="Button" width="120" onClick="javascript:ShowSearchResults()">
&nbsp;&nbsp;&nbsp;&nbsp;									</td>
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
													<input id='chkVideo' checked type="checkbox" onclick="VideoContentCheckBoxChange()"><label class="TextNormal">Video</label></br>											
													<input id='chkAudio' checked type="checkbox" onclick="AudioContentCheckBoxChange()" style="visibility:hidden"><label class="TextNormal" style="visibility:hidden">Audio</label></br>
													
												</td>
											</tr>
										</table>									</td>
								</tr>
								<tr>
									<td height="5"></td>
								</tr>	
								<tr>								</tr>
								<tr>
									<td>
										<!---------------------------Start Search Setting----------------------->
											&nbsp;&nbsp;&nbsp;<!--<a href="#" class="LinkSmall" onclick="effect_1 = Effect.SlideDown('d1',{duration:1.0}); return false;">Settings</a>-->
											<a href="#" class="LinkSmall" onclick="effect_1 = Effect.SlideDown('d1',{duration:0.5}); return false;">Settings</a> 
											<div id="d1" style="display:inline;"><div class="SearchSettings" style="height:150px">
											
											  <table align="left" cellspacing="0" cellpadding="0" border="0">
														<tr>
															<td colspan="2" class="SearchSettingHeading">Includes in search</td> 
														</tr>
														<tr>
															<td height="8"></td>
														</tr>
														<tr>
															<td width="25"></td>
															<td align="left" class="SearchSettingText"><input  name="chkYahoo" id='chkYahoo' type="checkbox" value="yahoo" onClick="EnableDisableCheck()" checked>Yahoo</td>
														</tr>	
														<tr>
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkGoogle"  id='chkGoogle' type="checkbox" value="google" onClick="EnableDisableCheck()">Google</td>
														</tr>
														<tr>
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkMsn" id='chkMsn' type="checkbox" onClick="EnableDisableCheck()" value="msn">MSN</td>
														</tr>
														<tr>
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkFlickr" id='chkFlickr' type="checkbox" onClick="EnableDisableCheck()" value="flickr">Flickr</td>
														</tr>
														<tr style="display:none">
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkGrouper" id='chkGrouper' type="checkbox" onClick="EnableDisableCheck()" value="grouper">Grouper</td>
														</tr>
														<tr >
															<td width="30"></td>
															<td align="left" class="SearchSettingText"><input name="chkYouTube" id='chkYouTube' type="checkbox" onClick="EnableDisableCheck()" value="youtube">Youtube</td>
														</tr>
														<tr>
															<td height="25"></td>
															<td align="right"><a href="#" class="SearchSettingLink" onclick="effect_1 = Effect.SlideUp('d1',{duration:0.5}); return false;">Close</a></td>
														</tr>
											  </table>
											</div></div>
										<!-------------------------End Serach Settings -------------------------->									</td>
								</tr>
							</table>						</td>
					</tr>
					<!------------------- End Resaerch Tools ------------------------->
				</table>
			</td>
			<!------------End Left Portion ---------------->
			<td width="3"></td>
			<!------------start Middle Portion -------------->
			<td align="left" valign="top">

			<form onSubmit="return getEditorValue()" name="frmEditor" method="post">
				<table width="670" cellpadding="0"  cellspacing="0" border="0">
					<!-----------------Start Content Editor ---------------->
					<tr>
						<td>
							<!-----------Start Tabs --------->
							<?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/tabs.php");?><!-----------End Tabs ------------></td>
					</tr>
					<tr>
						<td>
							<table cellspacing="0" cellpadding="0" class="RegistrationTabBorder">
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
											//$oFCKeditor->Config['UserFilesPath']='/UserFiles/16/';
											//echo($oFCKeditor->Config['UserFilesPath']."<br>");
											
											//GLOBALS["UserFilesPath"]='/UserFiles/16/';			
											//echo($GLOBALS["UserFilesPath"]);							
											$oFCKeditor->Value = $strData;
											$oFCKeditor->Create();
										?>
									</td>
								</tr>
							</table> 
		  </td>
	  </tr>
					
					<!-----------------------End Content Editor ----------------------->
					<tr>
						<td height="5"><div align="center">
						  <input name="button11" type="button" class="RegistrationButton" onclick="location.href='/Waypoint/Producer/ViewWaypoint.php?id=<?php echo $_REQUEST["pid"]?>'"  value="Back to Waypoints"  >
						  <input name="button113" type="submit" class="RegistrationButton" value="Save"  >
					      <input name="button112" type="button" class="RegistrationButton" onclick="contentPreview()"  value="Preview"  >
			  </form>						
						</div>
						</td>
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
													<td id='tdVideo' align="center" background="ImageFiles/<?php echo($strSkin);?>/Tag_Bottom.gif" width="76"  height="24"><a id="hplVideo" href="" class="TabBottomText" onClick="javascript:return ChangeResultType('VIDEO')">Video</a></td>
													<td width="5"></td>
													<td id='tdAudio' style="visibility:hidden" align="center" background="ImageFiles/<?php echo($strSkin);?>/Tag_Bottom.gif" width="76"  height="24"><a id="hplAudio" href="" class="TabBottomText" onClick="javascript:return ChangeResultType('AUDIO')">Audio</a></td>
													
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
								  <td class="InputLabel">Location:
								    <input name="txtLocation" type="text" class="TextBox" style="width:110px"></td>
							  </tr>
								<tr>
								  <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="search" value="Search" class="Button" onClick="searchLocation();"> <div id="divSearchStatus"></div></td>
							  </tr>
								<tr>
									<td>
									<div id="divMapErrorBox"></div>
									<div id="mapContainer" style="width:174px;height:174px;"></div></td>
								</tr>
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0"  border="0">				
											<tr>
											  <td width="174"><?php include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/rightMenu.php");?></td>
										  </tr>

											<tr>
											  <td>&nbsp;</td>
										  </tr>
										</table>									</td>
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
							<td width="150"></td>
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
						sldkfjsldkjf
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

<!------------------------------------------Start Content Dowload Report------------------------------------->
<div  dojoType="dialog" id="divContentDowloadReport" bgColor="white" bgOpacity="0.7" toggle="fade" toggleDuration="200">
<form  onsubmit="return false;">
	<table border="0" cellpadding="0" cellspacing="0" width="780" height="450">
		<tr>
			<td>
				<div id="divTest"></div>
			</td>
		</tr>
		<tr>
			<td align="center"> 
				<input type="button" id="downLoadReporthider" class="Button" value="Close">
			</td>
		</tr>	
	</table>
</form>
<form action="" name="frmPreview" method="post">
<input type="hidden" name="hiddenHtmlContent" id="hiddenHtmlContent">
</form>
	
</div>
<!----------------------------------------End Content Dowload Report------------------------------------->


<!--  the following hidden div will be used by the script -->
<div style="visibility:hidden;" id="progressBar" align="center">
</div>
<!-- End -->
<script language="JavaScript" src="IncludeFiles/JavaScript/tmenu.js"></script>
<script language="javascript">GetWaypointById(<?php echo($_REQUEST["id"]);?>,3);</script>
</body>
</html>
			<script language="javascript" src="IncludeFiles/JavaScript/floating_dimming_div/dimmingdiv.js">
		</script>
<script language=javascript>loadMap();</script>