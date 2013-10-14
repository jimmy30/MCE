<?php 
include($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/ConsumerSessionCheck.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/GUIService/Waypoint/Consumer/ViewSlideShowService.php");
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/Najax/najax.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
try
{

	$objReg = new ViewSlideShowService();
	NAJAX_Server::allowClasses("ViewSlideShowService");
	if (NAJAX_Server::runServer()) 
	{
		exit;
	}

			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
$stieUrl=$objProperties->getProperty('site_url');
?>

<?php 
	echo(NAJAX_Utilities::header('/IncludeFiles/PHP/Najax'));
	include_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/CheckSkins.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Waypoints Slide Show</title>
<link href="<?php echo("/includeFiles/" .$strSkin . "/CSS/Default.css");  ?>" rel="stylesheet" type="text/css">

<script language="javascript">
var obj = <?= NAJAX_Client::register(new ViewSlideShowService()) ?>;
var intNoOfRecords=0;
var intRecordPointer=1;
var arrWaypointId = new Array();
var arrWaypointName = new Array();
var arrWaypointAddress = new Array();
var arrWaypointLocation = new Array();
var arrWaypointLat = new Array();
var arrWaypointLong = new Array();
var arrWaypointRadius = new Array();
var MarkerImage='<?php echo $stieUrl."/ImageFiles/common/slideShowMarker.png"?>';

	function getSlideShowXML()
	{
		obj.getSlideShowXML(<?php echo $_REQUEST["id"]?>,function(result){parseXMLResponse(result);});
	}

	function parseXMLResponse(strResonse)
	{
		// code for IE
		if (window.ActiveXObject)
		{
			var doc=new ActiveXObject("Microsoft.XMLDOM");
			doc.async="false";
			doc.loadXML(strResonse);
		}
		// code for Mozilla, Firefox, Opera, etc.
		else
		{
			var parser=new DOMParser();
			var doc=parser.parseFromString(strResonse,"text/xml");
		}
		
		var XMLDoc=doc.documentElement;
		var long1 = XMLDoc.getElementsByTagName('Direction')[0].getAttribute('Long1');
		var lat1 = XMLDoc.getElementsByTagName('Direction')[0].getAttribute('Lat1');
		var long2 = XMLDoc.getElementsByTagName('Direction')[0].getAttribute('Long2');
		var lat2 = XMLDoc.getElementsByTagName('Direction')[0].getAttribute('Lat2');
		var long3 = XMLDoc.getElementsByTagName('Direction')[0].getAttribute('Long3');
		var lat3 = XMLDoc.getElementsByTagName('Direction')[0].getAttribute('Lat3');
		var long4 = XMLDoc.getElementsByTagName('Direction')[0].getAttribute('Long4');
		var lat4 = XMLDoc.getElementsByTagName('Direction')[0].getAttribute('Lat4');
		
		intNoOfRecords=XMLDoc.getElementsByTagName('WayPoint').length;

		for(var i=0;i<intNoOfRecords;i++)
		{
			arrWaypointId[i] = XMLDoc.getElementsByTagName('WayPoint')[i].getAttribute('ID');
			arrWaypointName[i] = XMLDoc.getElementsByTagName('Name')[i+1].childNodes[0].nodeValue;
			arrWaypointAddress[i] = XMLDoc.getElementsByTagName('Address')[i].childNodes[0].nodeValue;
			arrWaypointLocation[i] = XMLDoc.getElementsByTagName('link')[i].childNodes[0].nodeValue;
			arrWaypointLong[i] = XMLDoc.getElementsByTagName('Long1')[i].childNodes[0].nodeValue;
			arrWaypointLat[i] = XMLDoc.getElementsByTagName('Lat1')[i].childNodes[0].nodeValue;
			if(XMLDoc.getElementsByTagName('Radius')[i].childNodes[0])
			arrWaypointRadius[i] = XMLDoc.getElementsByTagName('Radius')[i].childNodes[0].nodeValue;
			else
			arrWaypointRadius[i]=null;
		}

		loadmap(long1,lat1,long2,lat2,long3,lat3,long4,lat4);
		for(var p=0;p<arrWaypointId.length;p++)
		{
			CreateAndSetMarker(arrWaypointId[p],arrWaypointName[p],arrWaypointAddress[p],arrWaypointLocation[p],arrWaypointLat[p],arrWaypointLong[p],arrWaypointRadius[p],MarkerImage,p+1)
	
		}
	
		loadHtmlContent(arrWaypointId[intRecordPointer-1],arrWaypointName[intRecordPointer-1],arrWaypointLocation[intRecordPointer-1],arrWaypointLat[intRecordPointer-1],arrWaypointLong[intRecordPointer-1],intRecordPointer);
	}

function goSlide(condition)
{

	if(condition==1)
		intRecordPointer ++;
	else if(condition==0)
		intRecordPointer --;
	else if(condition==2)
		intRecordPointer=intNoOfRecords;
	else
		intRecordPointer=1;
	
	if(intRecordPointer>intNoOfRecords)
		intRecordPointer--;
	if(intRecordPointer<1)
		intRecordPointer++;
loadHtmlContent(arrWaypointId[intRecordPointer-1],arrWaypointName[intRecordPointer-1],arrWaypointLocation[intRecordPointer-1],arrWaypointLat[intRecordPointer-1],arrWaypointLong[intRecordPointer-1],intRecordPointer);
}

function loadHtmlContent(WaypointId,WaypointName,Location,pLat,pLong,recordNo)
{

			intRecordPointer=recordNo;
		var strHtmlTitle='<table width="100%" border="0" cellspacing="2" cellpadding="2">';
			strHtmlTitle+='<tr>';
    		strHtmlTitle+='<td><div align="left" class="RegistrationBodyText">&nbsp;<strong>Waypoint Name:</strong> '+WaypointName+' </div></td>';
		    strHtmlTitle+='<td><div align="right" class="RegistrationBodyText"><strong>Slide No.</strong> '+intRecordPointer+'/'+intNoOfRecords+'&nbsp; </div></td>';
 		 	strHtmlTitle+='</tr>';
			strHtmlTitle+='</table>';
			document.getElementById("ListTitle").innerHTML=strHtmlTitle;

myPoint.Lat=pLat;
myPoint.Lon=pLong;
objMap.drawZoomAndCenter(myPoint, 9);
		
document.getElementById("myframe").src='/'+Location;

//obj.getHtmlContent(Location,function(result){parseHTMLContent(result,WaypointId,WaypointName,Location);});
}
function parseHTMLContent(result,WaypointId,WaypointName,Location)
{
	if(result!=null)
	{
		var abc=replaceAll(result,[['ContentFiles/','abc123xyz/']]);
		abc=replaceAll(abc,[['abc123xyz/','/Contents/PlaceCasts/<?php echo $_REQUEST["id"]?>/Waypoints/'+WaypointId+'/ContentFiles/']]);		
		
		document.getElementById("ListContainer").innerHTML=abc;
		
	}
	else alert("There is no content file exists");
	
}
function replaceAll( str, replacements ) {
    for ( i = 0; i < replacements.length; i++ ) {
        var idx = str.indexOf( replacements[i][0] );

        while ( idx > -1 ) {
            str = str.replace( replacements[i][0], replacements[i][1] );
            idx = str.indexOf( replacements[i][0] );
        }

    }

    return str;
}
//-->//-->
</script>

<!--------------------------------------------------Yahoo Map ---------------------------------------->
<script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.4&appid=yahoomapapi1234"></script>
<script language="javascript" src="../../IncludeFiles/JavaScript/MapCircle.js"></script>
<script language="javascript" src="../../IncludeFiles/JavaScript/YahooMapSlideShow.js"></script>
<!-----------------------End Yahoo Maps------------------------------------------>



</head>

<body class="RegistrationCellBg" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">
<table width="800" height="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><p class="RegistrationTitleText" align="left">&nbsp;&nbsp;Waypoints Slide Show</p>
      <table width="781" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="325" valign="top"><div id="mapContainer"></div></td>
          <td width="450" bgcolor="#FFFFFF">
		  <div id="ListTitle" style="border-style:solid; border-width:1px; width:452; height:20;"></div>
			<iframe id="myframe" src="" width="451" height="430" style="border:solid; border-width:1px;" scrolling="Auto"></iframe>
            </div>          </td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td>            <div align="center">
                <input type="button" name="Button32" value="|&lt;" onclick="goSlide(-1)" />
                <input type="button" name="Button2" value="&lt;&lt;" onclick="goSlide(0)" />
                <input type="button" name="Button" value="&gt;&gt;" onclick="goSlide(1)" />
                <input type="button" name="Button3" value="&gt;|" onclick="goSlide(2)" />
              </div>
</td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
}
catch (Exception  $e)
{
	echo("Exception occured</br>");
	$e->displayMessage();
}
require_once($_SERVER['DOCUMENT_ROOT']."/IncludeFiles/PHP/featurestat.php");
?>
<script language="javascript">getSlideShowXML();</script>
