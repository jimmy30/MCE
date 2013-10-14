var objMap="";
var objMarker="";
var strPoint="";
var myPoint="";
var strHtml="";
var intCounter=0;
var intCountEvent=0;
var fltLongitude="";
var fltLatitude="";
var strRetResult="";
var req="";
var strName="";
var strUrl="";
var loadFlag=0;
var objMarkerA="";
var dblLongA=0;
var dblLongB=0;
var dblLongC=0;
var dblLongD=0;
var dblLatA=0;
var dblLatB=0;
var dblLatC=0;
var dblLatD=0;
var Zoom=13;
var btn;

var centx = 0.0;
var centy = 0.0;

var dblPolyLineId1="";
var dblPolyLineId2="";
var dblPolyLineId3="";

var dblMarkerId1="";
var dblMarkerId2="";
var dblMarkerId3="";
var dblMarkerId4="";


var intPloyLineStatus="";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////const variable 
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	var WARNING_IMAGE_PATH="/ImageFiles/common/Warning.gif"
	var MAP_HEIGHT=450;
	var MAP_WIDTH=800;
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////Global Variable 
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	var G_CURRENT_POINT=new YGeoPoint(30.244047, -97.747175); 

/*******************************************************************************************************************
	Name				: findLongLatPoints()
	Description			: It is callback function which is called when ever double mouse click event occur
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	28-07-2006       1.00

	*********************************************************************************************************************/

function findLongLatPoints(pMyPoint)
{
	

	//Create New Marker 
	objMarker = new YMarker(pMyPoint);
	objMarker=createMarker(pMyPoint,strHtml);

	if (intCounter>3)
	{
		RemoveAllMarker();
		objMap.removeMarkersAll();
		clearTextBox();
	}

	if(intCounter==0)
	{

		RemoveAllMarker();
		objMap.removeMarkersAll();
		removeCircle();
		clearTextBox();
		objMap.addOverlay(objMarker);
		dblLongA=pMyPoint.Lon;
		dblLatA=pMyPoint.Lat;
		objMarker.addLabel("<blink>A</blink>");
		document.getElementById("txtLat1").value=pMyPoint.Lat;
		document.getElementById("txtLong1").value=pMyPoint.Lon;		
		document.getElementById("txtLat2").value="";
		document.getElementById("txtLong2").value="";	
		document.getElementById("txtLat3").value="";
		document.getElementById("txtLong3").value="";
		document.getElementById("txtLat4").value="";
		document.getElementById("txtLong4").value="";		
		intCounter=intCounter+1;
		
		var myF = function(e) 
		{
		};
		YEvent.Capture(objMap,EventsList.polylineRemoved,myF);
		
		if(intPloyLineStatus==1)
		{
			for (i=0;i<dblPolyLineId3.length;i++)
			{

				var objPolyLine=objMap.getPolylineObject(dblPolyLineId3[i]);		
				objMap.removeOverlay(objPolyLine);
			}
		}
		dblMarkerId1=objMap.getMarkerIDs();
	}
	else if(intCounter==1)
	{
		
		
		dblLongB=pMyPoint.Lon;
		dblLatB=pMyPoint.Lat;
				
		objMarker.addLabel("<blink>B</blink>");
		objMap.addOverlay(objMarker);
		document.getElementById("txtLat2").value=pMyPoint.Lat;
		document.getElementById("txtLong2").value=pMyPoint.Lon;		
		document.getElementById("txtLat3").value="";
		document.getElementById("txtLong3").value="";	
		document.getElementById("txtLat4").value="";
		document.getElementById("txtLong4").value="";		
		intCounter=intCounter+1;		
		
		var cPT = new YGeoPoint(dblLatA,dblLongA);
		var cPT2 = new YGeoPoint(dblLatB,dblLongB);
		poly1 = new YPolyline([cPT,cPT2],'green',7,0.7);
		objMap.addOverlay(poly1);
		dblMarkerId2=objMap.getMarkerIDs();
		dblPolyLineId1=objMap.getPolylineIDs();
		
   }
	else if(intCounter==2)
	{
		
		dblLongC=pMyPoint.Lon;
		dblLatC=pMyPoint.Lat;
		objMarker.addLabel("<blink>C</blink>");
		objMap.addOverlay(objMarker);
	//	objMap.drawZoomAndCenter(pMyPoint,Zoom);
		document.getElementById("txtLat3").value=pMyPoint.Lat;
		document.getElementById("txtLong3").value=pMyPoint.Lon;	
		document.getElementById("txtLat4").value="";
		document.getElementById("txtLong4").value="";		
		intCounter=intCounter+1;
		var cPT2 = new YGeoPoint(dblLatB,dblLongB);
		var cPT3 = new YGeoPoint(dblLatC,dblLongC);
		poly1 = new YPolyline([cPT2,cPT3],'green',7,0.7);
		objMap.addOverlay(poly1);
		dblMarkerId3=objMap.getMarkerIDs();
		dblPolyLineId2=objMap.getPolylineIDs();
		
	}
	else if(intCounter==3)
	{
		dblLongD=pMyPoint.Lon;
		dblLatD=pMyPoint.Lat;
		objMarker.addLabel("<blink>D</blink>");
		objMap.addOverlay(objMarker);
		document.getElementById("txtLat4").value=pMyPoint.Lat;
		document.getElementById("txtLong4").value=pMyPoint.Lon;		
		intCounter=intCounter+1;
		
		dblMarkerId4=objMap.getMarkerIDs();
		intPloyLineStatus=1;

		var cPT = new YGeoPoint(dblLatA,dblLongA);
		var cPT2 = new YGeoPoint(dblLatB,dblLongB);
		var cPT3 = new YGeoPoint(dblLatC,dblLongC);
		var cPT4 = new YGeoPoint(dblLatD,dblLongD);
		var cPT5 = new YGeoPoint(dblLatA,dblLongA);
		
		poly1 = new YPolyline([cPT,cPT2,cPT3,cPT4,cPT5],'green',7,0.7);
		objMap.addOverlay(poly1);
		
		// Draw Circle Functionality
		
		centroidCoordinates(dblLatA,dblLongA,dblLatB,dblLongB,dblLatC,dblLongC,dblLatD,dblLongD);

    	var G_CENT_POINT=new YGeoPoint(centx,centy); 
		//var MaxRadius=CompareDistance(cPT,cPT2,cPT3,cPT4,G_CENT_POINT);
		//drawCircle(objMap,G_CENT_POINT,MaxRadius);
		//
		
		dblPolyLineId3=objMap.getPolylineIDs();
		intPloyLineStatus=1;
		var myF = function(e) {
		};

		YEvent.Capture(objMap,EventsList.polylineAdded,myF);
	
	}
}

/*******************************************************************************************************************
	Name				: clearTextBox()
	Description			: This function is used to clear textboxes
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	8-08-2006       1.00

	*********************************************************************************************************************/

function clearTextBox()
{
	document.getElementById("txtLat1").value="";
	document.getElementById("txtLong1").value="";		
	document.getElementById("txtLat2").value="";
	document.getElementById("txtLong2").value="";	
	document.getElementById("txtLat3").value="";
	document.getElementById("txtLong3").value="";
	document.getElementById("txtLat4").value="";
	document.getElementById("txtLong4").value="";		
	intCounter=0;
	dblLongA=0;
	dblLongB=0;
	dblLongC=0;
	dblLongD=0;
	dblLatA=0;
	dblLatB=0;
	dblLatC=0;
	dblLatD=0;
	centx = 0.0;
	centy = 0.0;
	
	dblPolyLineId1="";
	dblPolyLineId2="";
	dblPolyLineId3="";
	
	dblMarkerId1="";
	dblMarkerId2="";
	dblMarkerId3="";
	dblMarkerId4="";
	intPloyLineStatus="";
}
/*******************************************************************************************************************
	Name				: createMarker()
	Description			: This function creates new Marker on double mouse click event  
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	28-07-2006       1.00

	*********************************************************************************************************************/

function createMarker(pMyPoint,strHtml)
{
	objMarker=new YMarker(pMyPoint);
	/*YEvent.Capture(objMarker, EventsList.MouseClick, 
    function onSmartWinEvent() {
    objMarker.openSmartWindow(strHtml);
	} 
	);*/
	return objMarker;
}

/*******************************************************************************************************************
	Name				: loadMap()
	Description			: This function Yahoo Map first Time
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	28-07-2006       1.00

	*********************************************************************************************************************/
function loadMap(pStatus)
{
	//Create a map object

	btn = document.getElementById("hider");
	objSize=new YSize(MAP_WIDTH,MAP_HEIGHT);
	objMap = new  YMap(document.getElementById('mapContainer'),YAHOO_MAP_REG,objSize);
	// Create a lat/lon object
	myPoint =G_CURRENT_POINT; //new YGeoPoint(30.244047, -97.747175);           //G_CURRENT_POINT; // 
	objMap.addTypeControl();
	// Add a slider zoom control
	objMap.addPanControl();
	objMap.addZoomLong();
	//objMap.disableDragMap();
	//Display the map centered on a latitude and longitude
	objMap.drawZoomAndCenter(myPoint,Zoom);


	if (document.getElementById("txtLat1").value!="")
	{	
		myPoint.Lat=document.getElementById("txtLat1").value;
		myPoint.Lon=document.getElementById("txtLong1").value;
		
		objMarker = new YMarker(myPoint);
		objMarker=createMarker(myPoint,strHtml);
		objMarker.addLabel("<blink>A</blink>");
		objMap.addOverlay(objMarker);
		objMap.drawZoomAndCenter(myPoint,Zoom);
	
		intCounter=1;
		dblLongA=document.getElementById("txtLong1").value;
		dblLatA=document.getElementById("txtLat1").value;;
			
	}
	if (document.getElementById("txtLat2").value!="")
	{	
		
		myPoint.Lat=document.getElementById("txtLat2").value;
		myPoint.Lon=document.getElementById("txtLong2").value;

		objMarker = new YMarker(myPoint);
		objMarker=createMarker(myPoint,strHtml);
		objMarker.addLabel("<blink>B</blink>");
		objMap.addOverlay(objMarker);
		objMap.drawZoomAndCenter(myPoint,Zoom);
		intCounter=2;
		dblLongB=document.getElementById("txtLong2").value;
		dblLatB=document.getElementById("txtLat2").value;
		
		var cPT = new YGeoPoint(dblLatA,dblLongA);
		var cPT2 = new YGeoPoint(dblLatB,dblLongB);
		poly1 = new YPolyline([cPT,cPT2],'green',7,0.7);
		objMap.addOverlay(poly1);
		
		dblMarkerId2=objMap.getMarkerIDs();
		dblPolyLineId1=objMap.getPolylineIDs();
			
	}
	if (document.getElementById("txtLat3").value!="")
	{	
		myPoint.Lat=document.getElementById("txtLat3").value;
		myPoint.Lon=document.getElementById("txtLong3").value;

		objMarker = new YMarker(myPoint);
		objMarker=createMarker(myPoint,strHtml);
		objMarker.addLabel("<blink>C</blink>");
		objMap.addOverlay(objMarker);
		objMap.drawZoomAndCenter(myPoint,Zoom);
		intCounter=3;
		dblLongC=document.getElementById("txtLong3").value;
		dblLatC=document.getElementById("txtLat3").value;
		
		var cPT = new YGeoPoint(dblLatB,dblLongB);
		var cPT2 = new YGeoPoint(dblLatC,dblLongC);
		poly1 = new YPolyline([cPT,cPT2],'green',7,0.7);
		objMap.addOverlay(poly1);
		
		dblMarkerId3=objMap.getMarkerIDs();
		dblPolyLineId2=objMap.getPolylineIDs();
			
	}
	if (document.getElementById("txtLat4").value!="")
	{
		myPoint.Lat=document.getElementById("txtLat4").value;
		myPoint.Lon=document.getElementById("txtLong4").value;		

		objMarker = new YMarker(myPoint);
		objMarker=createMarker(myPoint,strHtml);
		objMarker.addLabel("<blink>D</blink>");
		objMap.addOverlay(objMarker);
		objMap.drawZoomAndCenter(myPoint,Zoom);
		intCounter=0;
		dblLongA=document.getElementById("txtLong1").value;
		dblLongB=document.getElementById("txtLong2").value;
		dblLongC=document.getElementById("txtLong3").value;
		dblLongD=document.getElementById("txtLong4").value;
		dblLatA=document.getElementById("txtLat1").value;
		dblLatB=document.getElementById("txtLat2").value;
		dblLatC=document.getElementById("txtLat3").value;
		dblLatD=document.getElementById("txtLat4").value;
		
		
		var cPT = new YGeoPoint(dblLatA,dblLongA);
		var cPT2 = new YGeoPoint(dblLatB,dblLongB);
		var cPT3 = new YGeoPoint(dblLatC,dblLongC);
		var cPT4 = new YGeoPoint(dblLatD,dblLongD);
		var cPT5 = new YGeoPoint(dblLatA,dblLongA);
		
		poly1 = new YPolyline([cPT,cPT2,cPT3,cPT4,cPT5],'green',7,0.7);
		objMap.addOverlay(poly1);
		dblMarkerId4=objMap.getMarkerIDs();
		dblPolyLineId3=objMap.getPolylineIDs();
		intPloyLineStatus=1;
		
		centroidCoordinates(dblLatA,dblLongA,dblLatB,dblLongB,dblLatC,dblLongC,dblLatD,dblLongD);

    	var G_CENT_POINT=new YGeoPoint(centx,centy); 
		//var MaxRadius=CompareDistance(cPT,cPT2,cPT3,cPT4,G_CENT_POINT);
		//drawCircle(objMap,G_CENT_POINT,MaxRadius);
		
	}
	if (pStatus=="Add")
	{
		if (document.getElementById("txtLat1").value=="" && document.getElementById("txtLat2").value=="" && document.getElementById("txtLat3").value=="" && document.getElementById("txtLat4").value=="")
		{	
			captureEvent();
		}
	}
	else 
	{
		
			captureEvent();
	}
}




/*******************************************************************************************************************
	Name				: captureEvent()
	Description			: This function is use to capture event
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	08-08-2006       1.00
	*********************************************************************************************************************/

function captureEvent()
{


	YEvent.Capture
		  (objMap, EventsList.endMapDraw, 
			  function(overlay,myPoint) 
			  {
				  objMap.enableDragMap();
				  if (myPoint)
				  {
						
						findLongLatPoints(myPoint);
						
						
				  }
				
			  } 
		  );
		  
	YEvent.Capture
		  (objMap, EventsList.MouseDoubleClick, 
			  function(overlay,myPoint) 
			  {
				  if (myPoint)
				  {
						findLongLatPoints(myPoint);
				
				  }
				
			  } 
		  );	  
		  
}
/*******************************************************************************************************************
	Name				: searchLocation()
	Description			: This function is callled whenever user press search Button 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	13-06-2006       1.00
		KM            Created     -----------    	14-06-2006       1.00
	*********************************************************************************************************************/
	function searchLocation()
	{
		
		if(window.XMLHttpRequest)
		{
			req = new XMLHttpRequest(); 

		}	
				
		else if (window.ActiveXObject)
		{
			strName="Microsoft.XMLHTTP";

		}
		
		req  = new ActiveXObject(strName); 
	
		document.getElementById('divSearchStatus').innerHTML="&nbsp;&nbsp;<span class=DefaultText>Searching ...</span><img src='/ImageFiles/common/Busy.gif' width=16 height=16>" ;
	
		req.onreadystatechange = function()
			{ 
				
		  		if(req.readyState == 4)
				{
				       if(req.status == 200) 
					   {
					   		
							
							document.getElementById('divSearchStatus').innerHTML="";

							markMap();
							  
					   }  
			       		else 
					   {	
						  alert("Error");
					   }  
				 } 
				 else
				 {
					  		
				 }  
		  };
		
		 // First Get URL from where we have to get GPS information against any Location 
		strUrl=getUrl();
		req.open("GET",strUrl, true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
		req.send(null);
	}
	
	/*******************************************************************************************************************
	Name				: getUrl()
	Description			: This function returns the URLdepending upon which options user have provided during search 
	Input Parameters	: 
	Returns				: URL 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	13-06-2006       1.00
		KM            Created     -----------    	14-06-2006       1.00
	*********************************************************************************************************************/

	function getUrl()
	{
		strLocation=document.getElementById('txtLocation').value; 
		
		if (strLocation!="")
		{

			strUrl="/MapService/clsMapService.php?appid=yahoomapapi1234&location="+strLocation;	
		}	
		return strUrl;
		
	}
	/*******************************************************************************************************************
	Name				: showSearchResultsError()
	Description			: This function shows Error Message Box 
	Input Parameters	: pErrorMessage is the error message to be displayer 
						  pErrorTypeis Type of warning(Error,Warnings,Suggestions)	
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		KM            Created     -----------    	14-06-2006       1.00
	*********************************************************************************************************************/
	function showSearchResultsError(pErrorMessage,pErrorType) 
	{
		var strImagePath="";
		
		if (pErrorType=="WARNING")
		{
			strImagePath=WARNING_IMAGE_PATH;
		}
		else
		{
			//TODO- check other cases 
			strImagePath=WARNING_IMAGE_PATH;
		}
		
		var strErrHTML="<table  height=40 cellspacing=0 cellpadding=0 border=1>"; 
					strErrHTML=strErrHTML+"<tr bgcolor='#ffffae'>";
					strErrHTML=strErrHTML+"<td width='798'>";
					strErrHTML=strErrHTML+"<table cellspacing=0 cellpadding=0 border=0>";
					strErrHTML=strErrHTML+"<tr><td  width=5></td>";
					strErrHTML=strErrHTML+"<td><img src='" + strImagePath + "' width=15 height=15></td><td width=0></td>";
					strErrHTML=strErrHTML+"<td align=left class='ErrorBoxText'>&nbsp;&nbsp; "+ pErrorMessage + " </td>"
					strErrHTML=strErrHTML+"</tr></table>";
					strErrHTML=strErrHTML+"</td></tr></table>";
				
		
		
		document.getElementById("divMapErrorBox").style.visibility="visible";
		document.getElementById("divMapErrorBox").innerHTML=strErrHTML;
						
	}
	
	/*******************************************************************************************************************
	Name				: getValue()
	Description			: This function is used for XML Parsing 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	13-06-2006       1.00
		KM            Created     -----------    	14-06-2006       1.00
	*********************************************************************************************************************/

	function getValue(strStartAttribute,strEndAttribute,intIndex)
	{
			intStart=strResult.indexOf(strStartAttribute)+intIndex;
			intEnd=strResult.indexOf(strEndAttribute);
			strRetResult=strResult.substring(intStart,intEnd);
			return strRetResult;
	}
	/*******************************************************************************************************************
	Name				: markMap()
	Description			: This function create marker on find location. 
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	13-06-2006       1.00
		KM            Created     -----------    	14-06-2006       1.00
	*********************************************************************************************************************/
	function markMap()
	{


		strResult=req.responseText;

		fltLongitude=getValue("<Longitude>","</Longitude>",11);
		fltLatitude=getValue("<Latitude>","</Latitude>",10);
		
		if( fltLongitude=="" || fltLatitude=="")
		{
			showSearchResultsError('No information found',"WARNING");
		}
		else
		{
			// First Clear any Previous Error Messages 	
			document.getElementById("divMapErrorBox").innerHTML="";
			document.getElementById("divMapErrorBox").style.visibility="visible";
			
			// Create Html 
			strHtml="<table cellspacing=0 cellpadding=0 border=0>";
			strHtml=strHtml+"<tr><td align=right><b>Longitude:</b></td><td width=5></td><td>"+fltLongitude+"</td>";
			strHtml=strHtml+"<tr><td align=right><b>Latitude:</b></td><td width=5></td><td>"+fltLatitude+"</td>";
			strHtml=strHtml+"</table>";
			
			// Save Location in Global Variables 
			G_CURRENT_POINT=new YGeoPoint(fltLatitude,fltLongitude);
			
			//Show Marker 
	  	    showMarker(fltLatitude, fltLongitude,Zoom,"",strHtml);
	  	    
	  	    //document.getElementById('mapContainer').innerHTML="Problems ..........";
		}  
	}
	
	/*******************************************************************************************************************
	Name				: showMarker()
	Description			: This function creates new Marker and then show Marker information . This function is only callled when we search
	Input Parameters	: 
	Returns				: 
	Pre assumptions		: 
	Post assumptions	: 
	____________________________________________________________________________________________________________________
	 Created          Action      Remarks            Date           Version
	_____________________________________________________________________________________________________________________
		NE            Created     -----------    	13-06-2006       1.00
		KM            Created     -----------    	14-06-2006       1.00
	*********************************************************************************************************************/
	function showMarker(Latitude, Longitude, Zoom, Label, Text)
	{

		 var myPoint = new YGeoPoint(parseFloat(Latitude), parseFloat(Longitude)); 
		  objMap.drawZoomAndCenter(myPoint, Zoom);
		  //Create new Marker 
		  objMarker = new YMarker(myPoint);
		  if(intCounter==0)
		  {
			dblLongA=myPoint.Lon;
			dblLatA=myPoint.Lat;
			objMarker.addLabel("<blink>A</blink>");
			document.getElementById("txtLat1").value=myPoint.Lat;
			document.getElementById("txtLong1").value=myPoint.Lon;
			document.getElementById("txtLat2").value="";
			document.getElementById("txtLong2").value="";	
			document.getElementById("txtLat3").value="";
			document.getElementById("txtLong3").value="";
			document.getElementById("txtLat4").value="";
			document.getElementById("txtLong4").value="";		

			objMap.addOverlay(objMarker);
			intCounter++;
		  }
		  else if (intCounter==1)
		  {
			dblLongB=myPoint.Lon;
			dblLatB=myPoint.Lat;
			objMarker.addLabel("<blink>B</blink>");
			document.getElementById("txtLat2").value=myPoint.Lat;
			document.getElementById("txtLong2").value=myPoint.Lon;		
			document.getElementById("txtLat3").value="";
			document.getElementById("txtLong3").value="";
			document.getElementById("txtLat4").value="";
			document.getElementById("txtLong4").value="";		
			objMap.addOverlay(objMarker);
			intCounter++;
		  }
		  else if (intCounter==2)
		  {
			dblLongC=myPoint.Lon;
			dblLatC=myPoint.Lat;
			objMarker.addLabel("<blink>C</blink>");
			document.getElementById("txtLat3").value=myPoint.Lat;
			document.getElementById("txtLong3").value=myPoint.Lon;
			document.getElementById("txtLat4").value="";
			document.getElementById("txtLong4").value="";	
			objMap.addOverlay(objMarker);
			intCounter++;
		  }
  		  else if (intCounter==3)
		  {
			dblLongD=myPoint.Lon;
			dblLatD=myPoint.Lat;
			objMarker.addLabel("<blink>D</blink>");
			document.getElementById("txtLat4").value=myPoint.Lat;
			document.getElementById("txtLong4").value=myPoint.Lon;		
			objMap.addOverlay(objMarker);
			RemoveAllMarker();
			objMap.removeMarkersAll();
			clearTextBox();
		  }
		  else if  (intCounter>=4)
	  	  {
			RemoveAllMarker();
			objMap.removeMarkersAll();
			removeCircle();
			clearTextBox();
			objMarker.addLabel("A");
			objMap.addOverlay(objMarker);
			intCounter++;
		 }
}


function RemoveAllMarker()
{

		for(d=0;d<dblMarkerId1.length;d++)
		{
			objMap.removeMarker(dblMarkerId1[d]);
		}
		
		for(k=0;k<dblMarkerId2.length;k++)
		{
			objMap.removeMarker(dblMarkerId2[k]);
		}
		
    	for(c=0;c<dblMarkerId3.length;c++)
		{
			objMap.removeMarker(dblMarkerId3[c]);
		}

		for(i=0;i<dblMarkerId4.length;i++)
		{
			objMap.removeMarker(dblMarkerId4[i]);
		}
		
		
		
		
	
		for(l=0;l<dblPolyLineId1.length;l++)
		{
			var objPolyLine=objMap.getPolylineObject(dblPolyLineId1[l]);		
			objMap.removeOverlay(objPolyLine);
		}
		for(b=0;b<dblPolyLineId2.length;b++)
		{
			var objPolyLine=objMap.getPolylineObject(dblPolyLineId2[b]);		
			objMap.removeOverlay(objPolyLine);
		}
			for (j=0;j<dblPolyLineId3.length;j++)
		{
			var objPolyLine=objMap.getPolylineObject(dblPolyLineId3[j]);		
			objMap.removeOverlay(objPolyLine);
		}
		removeCircle();
		clearTextBox();
}

function EnableOption()
{

	document.getElementById('firstImg1').disabled=false;
}
function CheckTextBox()
{
		dlg.setCloseControl(btn);	
}