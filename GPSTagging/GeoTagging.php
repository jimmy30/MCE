<?php 
		$strFileName=$_SESSION['strFileName'];
		//$strFileName='GPSTagging_si4bmsj2n1jv5l51oeh2ogqfp3.xml';
		//echo($strFileName);
//		$strFileName='GPSTagging_abc.xml';

		
		if (file_exists($strFileName))
		{
			$strXml = simplexml_load_file($strFileName); 			
			if ($strXml)
			{
				$intLongitudeIndex=0;
				$intLatitudeIndex=0;
				$intIconPathIndex=0;
				$intImageIndex=0;
				$intImage=0;
				$intNameIndex=0;
				$intDescriptionIndex=0;
				
		
		foreach($strXml as $strTour=>$strTourValue) 
		{
				if ($strTour=="Tourname")
				{
					$strTourName=$strTourValue;
					//echo($strTourName);
				}
				if ($strTour=="Description")
				{	
					$strTourDescription=$strTourValue;
					//echo($strTourDescription);
				}	
		
			if ($strTour=="WayPoints")
			{
				foreach($strTourValue as $strWaypoints=>$strWaypointsValue) 
				{
				$countWaypoint++;
					if ($strWaypoints=="WayPoint")
					{
						foreach($strWaypointsValue as $strWayPoint=>$strXmlValue)
						{

							if ($strWayPoint=="Name")
							{
								$strNameArray[$intNameIndex]=$strXmlValue;

								$intNameIndex++;
							}
							elseif ($strWayPoint=="Description")
							{
								$strDescriptionArray[$intDescriptionIndex]=$strXmlValue;
								$intDescriptionIndex++;
							}

							elseif ($strWayPoint=="Longitude")
							{
								
								$fltLong[$intLongitudeIndex]=$strXmlValue;
								
								$intLongitudeIndex++;
							}
							elseif ($strWayPoint=="Latitude")
							{
								$fltLat[$intLatitudeIndex]=$strXmlValue;
								//echo("<br>");
								//echo($strXmlValue);
								$intLatitudeIndex++;
							}
							elseif ($strWayPoint=="Imageicon")
							{
								$imgPath[$intIconPathIndex]=$strXmlValue;


								$intIconPathIndex++;

				
							}
							elseif ($strWayPoint=="images")
							{
								foreach($strXmlValue as $strXmlValue=>$strImageValue)
								{
									$imgNewPath[$intImage][$intImageIndex]=$strImageValue;
									$intImageIndex++;
								}
							}
						}
						}
						
						$intImageIndex=0;
						$intImage++;	
					}
					}	
				}
		
				$intArrayIndex=$intLongitudeIndex+1;
				 echo "<script language='javascript'>";
				 echo "var imgArray= new Array();";
				 echo "var longArray= new Array(".$intArrayIndex.");";
				 echo "var latArray= new Array(".$intArrayIndex.");";
				 echo "var imgIconArray= new Array(".$intArrayIndex.");";
				 echo "var nameArray= new Array(".$intArrayIndex.");";
				 echo "var descriptionArray= new Array(".$intArrayIndex.");";
				 
				
				for ($intFirstIndex=0;$intFirstIndex<$intLongitudeIndex;$intFirstIndex++)
				{
					
					  echo " imgArray[".$intFirstIndex."] = new Array();";
					
					  for ($intSecondIndex=0;$intSecondIndex<count($imgNewPath[$intFirstIndex]);$intSecondIndex++)
					  {
						echo " imgArray[".$intFirstIndex."][".$intSecondIndex."] = new Image (144,96);"; 		 
						echo " imgArray[".$intFirstIndex."][".$intSecondIndex."].src ='".$imgNewPath[$intFirstIndex][$intSecondIndex]."' ;"; 
					  }
				}

				for ($intStartIndex=0; $intStartIndex<$intNameIndex;$intStartIndex++)
				{
					echo " nameArray[".$intStartIndex."]='".$strNameArray[$intStartIndex]."';";
				}
				
				for ($intStartIndex=0; $intStartIndex<$intDescriptionIndex;$intStartIndex++)
				{
					echo " descriptionArray[".$intStartIndex."]='".$strDescriptionArray[$intStartIndex]."';";
				}
			
				
				for ($intStartIndex=0; $intStartIndex<$intLongitudeIndex;$intStartIndex++)
				{
					echo " longArray[".$intStartIndex."]=".$fltLong[$intStartIndex].";";
				}
		
				for ($intStartIndex=0; $intStartIndex<$intLongitudeIndex;$intStartIndex++)
				{
					echo " latArray[".$intStartIndex."]=".$fltLat[$intStartIndex].";";
				}
		
				for ($intStartIndex=0; $intStartIndex<$intLongitudeIndex;$intStartIndex++)
				{
							
					echo " imgIconArray[".$intStartIndex."]='".$imgPath[$intStartIndex]."';";
				}					 
				echo "</script>";
			}
			else
			{
				echo("No Record Found");
			}	
		}
		else
		{
			echo("No File Exist");
		}
?>

<html>
  	<head>
		<link href="style.css" rel="stylesheet" type="text/css">

		 <link href='../IncludeFiles/Javascript/PopupWindow/themes/default.css' rel='stylesheet' type='text/css'></link>
		 <link href='../IncludeFiles/Javascript/PopupWindow/themes/theme1.css' rel='stylesheet' type='text/css'></link>
	     <link href='../IncludeFiles/Javascript/PopupWindow/themes/alert.css' rel='stylesheet' type='text/css' ></link>
		<link href='../IncludeFiles/Javascript/PopupWindow/themes/alert_lite.css' rel='stylesheet' type='text/css' ></link>
		<script type='text/javascript' src='../IncludeFiles/Javascript/PopupWindow/prototype.js'>	 </script>
		<script type='text/javascript' src='../IncludeFiles/Javascript/PopupWindow/effects.js'> </script>
		<script type='text/javascript' src='../IncludeFiles/Javascript/PopupWindow/window.js'> </script>
   	    <script type='text/javascript' src='../IncludeFiles/Javascript/PopupWindow/debug.js'> </script>
		<script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=yahoomapapi1234"></script>
		<script type='text/javascript'>
		
			var objMap='';
			//var objMarkerA='';
			var intLastClick='';
		    var strPoint='';
  			var strPointA='';
			var intCount=0;
			var objIcon='';
			var strTourName='';
			var strTourDescription='';
			
			//var IconImage= new Array();
	 	    //var imgArray= new Array();
			
		    function next(pIntIndex)
			 {

				intCount++;

				if (intCount >= imgArray[pIntIndex].length) 
				{
				
					intCount = 0;
				}
				eval('document.pImg.src=imgArray['+pIntIndex+']['+(intCount)+'].src');
			 }
			
			function back(pIntIndex) 
			{

			
			 if (intCount == 0) 
			 {
				intCount = imgArray[pIntIndex].length;
			 }
			eval('document.pImg.src=imgArray['+pIntIndex+'][' + (intCount-1) + '].src');
			 intCount--;
			}
			
			
			function createMarker(pStrPoint,objMarkerA,strHtml,intIndex)
			{
				YEvent.Capture
				(objMarkerA, EventsList.MouseClick, 
			    function onSmartWinEvent() 
				{
//					var strJsHTML ='<table width=200 border=0 align=center cellspacing=0 cellpadding=0 bgcolor="#93BBF6">';
					var strJsHTML ='<table width=200 border=0 align=center cellspacing=0 cellpadding=0>';
					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td colspan=2 width=600 align=center>';
					strJsHTML =strJsHTML + '<table border=0 cellpadding=0 cellspacing=0>';
					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td align=center>';
					strJsHTML=strJsHTML + ' <img name=\"pImg\" src='+imgArray[intIndex][0].src+' width=400 height=250>';
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';
					strJsHTML =strJsHTML + '</table>';
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';

					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td colspan=2 align=\"center\">';
					strJsHTML =strJsHTML + ' <a href=\"javascript:back('+intIndex+')\" class="links">Previous</a>';
					strJsHTML =strJsHTML + ' <a href=\"javascript:next('+intIndex+')\" class="links">Next</a>';
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';

					
					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td colspan=2>';
					strJsHTML =strJsHTML + '<hr size1>'; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';
					
					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td width=175 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #0E3F84;">';
					strJsHTML =strJsHTML + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tour Name:'; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '<td width=425 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #333333;">';
					strJsHTML =strJsHTML + strTourName;  
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';
					
					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td width=175 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #0E3F84;" valign="top">';
					strJsHTML =strJsHTML + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tour Description:' ; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '<td width=425>';
					strJsHTML =strJsHTML + '<textarea name=\"txtDescription\" readonly cols=50 rows=4 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #333333;">'+strTourDescription +'</textarea>'; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';

					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td colspan=2>';
					strJsHTML =strJsHTML + '<hr size1>'; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';

					
					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td width=175 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #0E3F84;">';
					strJsHTML =strJsHTML + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Waypoint Name';
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '<td width=425 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #333333;">';
					strJsHTML =strJsHTML +  nameArray[intIndex]; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';
					
					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td width=175 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #0E3F84;">';
					strJsHTML =strJsHTML + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Waypoint Longitude'; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '<td width=425 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #333333;">';
					strJsHTML =strJsHTML + longArray[intIndex] ; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';
					
					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td width=175 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #0E3F84;">';
					strJsHTML =strJsHTML + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Waypoint Latitude'; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '<td width=425 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #333333;">';
					strJsHTML =strJsHTML + latArray[intIndex] ; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';

					strJsHTML =strJsHTML + '<tr>';
					strJsHTML =strJsHTML + '<td width=175 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #0E3F84;" valign="top">';
					strJsHTML =strJsHTML + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Waypoint Description'; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '<td width=425>';
					strJsHTML =strJsHTML +  '<textarea name=\"txtDescription\" readonly cols=50 rows=4 style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #333333;">'+descriptionArray[intIndex] +'</textarea>' ; 
					strJsHTML =strJsHTML + '</td>';
					strJsHTML =strJsHTML + '</tr>';

				
					strJsHTML =strJsHTML + '</table>';
					
					/*strJsHTML = "<table  border=0 align='center' cellspacing='0' cellpadding='0'>";
					strJsHTML =strJsHTML + "<tr>";
					strJsHTML =strJsHTML + "<td width='200'>";
					strJsHTML =strJsHTML + "<table  border=1 align='center' cellspacing='0' cellpadding='0'>";
					strJsHTML =strJsHTML + "<tr>";
					strJsHTML =strJsHTML + "<td width='200'>";
					strJsHTML =strJsHTML + "sdfsdfsdf";
					strJsHTML =strJsHTML + "</td>";
					strJsHTML =strJsHTML + "</tr>";
					strJsHTML =strJsHTML + "</table>";

					strJsHTML =strJsHTML + "</td>";
					strJsHTML =strJsHTML + "</tr>";
					strJsHTML =strJsHTML + "</table>";
					
					*/
					Dialog.alert(strJsHTML,
							{windowParameters: {width:600, height:560}, okLabel: 'close', ok:function(win) {debug('validate alert panel')} 
						    });
				} 
				);
				
			 
			}
		
			function setIcon(pStrPoint,MyIcon,pIntIndex)
			{
				
				var myImage = new YImage();
			    myImage.src = MyIcon;
			    myImage.size = new YSize(20,20);
			    myImage.offsetSmartWindow = new YCoordPoint(0,0);
			    var  objMarkerA = new YMarker(pStrPoint,myImage);
				objMap.addOverlay(objMarkerA); 
				createMarker(pStrPoint,objMarkerA,'',pIntIndex);
				
			 }
			 
		   function loadMap()
		   {
				var intLastClick = '' ;
				//Create a map object
				objSize=new YSize(775,576);
				objMap = new  YMap(document.getElementById('map'),YAHOO_MAP_REG,objSize);
				objMap.addTypeControl();
				strTourName='<?php echo($strTourName);?>';
				strTourDescription='<?php echo($strTourDescription);?>';
				
				
				// Add a slider zoom control
				objMap.addPanControl();
				objMap.addZoomLong();

  
				// Create a lat/lon object
				strPointA = new YGeoPoint(latArray[0],longArray[0]);
				
				//Display the map centered on a latitude and longitude
				objMap.drawZoomAndCenter(strPointA, 13);
				objMarker = new YMarker(strPointA);

				var intFirstVar='';
				var intSecondVar='<?php echo($intLongitudeIndex); ?>';
				//alert (intSecondVar);
				var intImageArraySize='';
				for (intFirstVar=0; intFirstVar<intSecondVar;intFirstVar++)
				{
					
					strPointB = new YGeoPoint(latArray[intFirstVar],longArray[intFirstVar]); 
					setIcon(strPointB,imgIconArray[intFirstVar],intFirstVar);
				}
		   }		
	 </script>
	 </head>
	 
	 <body topmargin=0 leftmargin=0>
		<table border=0 bgcolor='#cccccc' cellPadding=0 cellSpacing=0 width='100%' height='85%'>
			<tr>
				<td align=center>
					 <script language="javascript">
						 document.write('<div id="map" style="width: ' + 700 + 'px; height:' + 500 + 'px"> </div>') ;
					 </script>
				</td>
				<td><input type="hidden" name="txtFirstVar"></td>
			</tr>
		</table>
		 <script type="text/javascript">
			  loadMap();
		 </script>
	 </body>
</html>
			
		