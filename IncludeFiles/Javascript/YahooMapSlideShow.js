var objMap="";
var objMarker="";
var strPoint="";
var myPoint="";
var strHtml="";



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
function loadmap(pLong1,pLat1,pLong2,pLat2,pLong3,pLat3,pLong4,pLat4)
{
	var WARNING_IMAGE_PATH="/ImageFiles/common/Warning.gif"
	var MAP_HEIGHT=450;
	var MAP_WIDTH=320;
	
	var G_CURRENT_POINT=new YGeoPoint(30.244047, -97.747175); 

	objSize=new YSize(MAP_WIDTH,MAP_HEIGHT);
	objMap = new  YMap(document.getElementById('mapContainer'),YAHOO_MAP_REG,objSize);
	//objMap.removeMarkersAll();
	// Create a lat/lon object
	myPoint =G_CURRENT_POINT; //new YGeoPoint(30.244047, -97.747175);           //G_CURRENT_POINT; // 
	objMap.addTypeControl();
	// Add a slider zoom control
	objMap.addPanControl();
	objMap.addZoomLong();
	//Display the map centered on a latitude and longitude
//	objMap.drawZoomAndCenter(myPoint, 10);	
		var cPT = new YGeoPoint(pLat1,pLong1);
		var cPT2 = new YGeoPoint(pLat2,pLong2);
		var cPT3 = new YGeoPoint(pLat3,pLong3);
		var cPT4 = new YGeoPoint(pLat4,pLong4);
		var cPT5 = new YGeoPoint(pLat1,pLong1);
		
		poly1 = new YPolyline([cPT,cPT2,cPT3,cPT4,cPT5],'green',7,0.5);
		
		centroidCoordinates(pLat1,pLong1,pLat2,pLong2,pLat3,pLong3,pLat4,pLong1);

		var G_CENT_POINT=new YGeoPoint(centx,centy); 

		var MaxRadius=CompareDistance(cPT,cPT2,cPT3,cPT4,G_CENT_POINT);

		//Ccolor=placeCastColor;
		//drawCircle(objMap,G_CENT_POINT,MaxRadius);
		
		objMap.addOverlay(poly1);


}

/*******************************************************************************************************************
	Name				: CreateAndSetMarker()
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
function CreateAndSetMarker(WaypointId,WaypointName,Address,Location,pLat,pLong,pRadius,MarkerImage,recordNo)
{
		myPoint.Lat=pLat;
		myPoint.Lon=pLong;
		//objMap.drawZoomAndCenter(myPoint, 7);

		var myImage = new YImage();
		myImage.src = MarkerImage;
		myImage.size = new YSize(40,40);
		myImage.offsetSmartWindow = new YCoordPoint(0,0);
		var objMarker="";
		objMarker = new YMarker(myPoint,myImage);
		
		var swtext = "<table><tr><td><font size=2 face=arial><b>Name:</font></b></td><td><font size=2 face=arial>"+WaypointName+"</font></td></tr>";
		swtext += "<tr><td><b><font size=2 face=arial>Address:</font></b></td><td><font size=2 face=arial>"+Address+"</font></td></tr>";
		swtext += "<tr><td><b><font size=2 face=arial>Latitude:</font></b></td><td><font size=2 face=arial>"+pLat+"</font></td></tr>";
		swtext += "<tr><td><b><font size=2 face=arial>Longitude:</font></b></td><td><font size=2 face=arial>"+pLong+"</font></td></tr>";
				swtext += "<tr><td><b><font size=2 face=arial>Radius:</font></b></td><td><font size=2 face=arial>"+pRadius+" m</font></td></tr></table>";
		objMarker.addAutoExpand(swtext);
		YEvent.Capture(objMarker,EventsList.MouseClick, 
		function() 
		{ 
		loadHtmlContent(WaypointId,WaypointName,Location,pLat,pLong,recordNo);
		//objMarker.openSmartWindow(swtext) 
		});

		if(pRadius!=null)
		{
			var waypointRadius= pRadius/1000;
			Ccolor=waypointColor;
			var G_CENT_POINT_WAYPOINT=new YGeoPoint(pLat,pLong); 
			drawCircle(objMap,G_CENT_POINT_WAYPOINT,waypointRadius);
		}

	objMap.addOverlay(objMarker);

}
