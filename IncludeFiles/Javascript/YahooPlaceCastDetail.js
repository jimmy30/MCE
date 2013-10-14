var objMap="";
var objMarker="";
var strPoint="";
var myPoint="";
var strHtml="";

var centx = 0.0;
var centy = 0.0;

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
	objMap = new  YMap(document.getElementById('mapContainer'),YAHOO_MAP_REG);
	//objMap.removeMarkersAll();
	// Create a lat/lon object
	objMap.addTypeControl();
	objMap.setMapType(YAHOO_MAP_SAT);
	// Add a slider zoom control
	objMap.addPanControl();
	objMap.addZoomLong();
	//Display the map centered on a latitude and longitude
		var cPT = new YGeoPoint(pLat1,pLong1);
		var cPT2 = new YGeoPoint(pLat2,pLong2);
		var cPT3 = new YGeoPoint(pLat3,pLong3);
		var cPT4 = new YGeoPoint(pLat4,pLong4);
		var cPT5 = new YGeoPoint(pLat1,pLong1);
		
		poly1 = new YPolyline([cPT,cPT2,cPT3,cPT4,cPT5],'blue',7,0.7);
		objMap.addOverlay(poly1);

		centroidCoordinates(pLat1,pLong1,pLat2,pLong2,pLat3,pLong3,pLat4,pLong1);

		var G_CENT_POINT=new YGeoPoint(centx,centy); 

		//var MaxRadius=CompareDistance(cPT,cPT2,cPT3,cPT4,G_CENT_POINT);
		//Ccolor=placeCastColor;
		//drawCircle(objMap,G_CENT_POINT,MaxRadius);
		objMap.drawZoomAndCenter(G_CENT_POINT,10);

}
