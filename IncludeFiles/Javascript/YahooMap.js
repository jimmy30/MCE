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
var flag=1;
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
var valZoom=13;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////const variable 
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	var WARNING_IMAGE_PATH="/ImageFiles/common/Warning.gif"
	var MAP_HEIGHT=450;
	var MAP_WIDTH=730;
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
		objMarker = new YMarker(pMyPoint);
		objMarker=createMarker(pMyPoint,strHtml);
		if (intCounter>0)
		{
		objMap.removeMarkersAll();
		intCounter=0;
  	    }
		if(intCounter==0){
		objMarker.addLabel("<blink>A</blink>");
		objMap.addOverlay(objMarker);
		document.getElementById("txtLat1").value=pMyPoint.Lat;
		document.getElementById("txtLong1").value=pMyPoint.Lon;		
		intCounter++;
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
	if (pStatus=="Add") {
		valZoom=13;
	}else{
		valZoom=13;
	}
	
	objMap.drawZoomAndCenter(myPoint, valZoom);

	// Set map type to either of: YAHOO_MAP_SAT YAHOO_MAP_HYB YAHOO_MAP_REG
//	objMap.setMapType(YAHOO_MAP_SAT);

	
	
	if (document.getElementById("txtLat1").value!="")
	{	
	
		myPoint.Lat=document.getElementById("txtLat1").value;
		myPoint.Lon=document.getElementById("txtLong1").value;
		objMap.drawZoomAndCenter(myPoint, 13);
		objMarker = new YMarker(myPoint);
		objMarker=createMarker(myPoint,strHtml);
		objMarker.addLabel("<blink>A</blink>");
		objMap.addOverlay(objMarker);
		intCounter=1;
		flag=1;
	}

	YEvent.Capture
			  (objMap, EventsList.MouseDoubleClick, 
				  function(overlay,G_CURRENT_POINT) 
				  {
					  if (G_CURRENT_POINT)
					  {
						  findLongLatPoints(G_CURRENT_POINT);
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
	
			// Remove Previous Marker 	
			//objMap.removeMarkersAll();
			
			// Save Location in Global Variables 
			objMap.removeMarkersAll();
			G_CURRENT_POINT=new YGeoPoint(fltLatitude,fltLongitude);
				objMap.drawZoomAndCenter(G_CURRENT_POINT, valZoom);
			// Update Longitude and Latitude Textfields 
			//document.getElementById("txtLatitude").value=fltLatitude;
		//	document.getElementById("txtLongitude").value=fltLongitude;
			objMarker = new YMarker(G_CURRENT_POINT);
			objMarker=createMarker(G_CURRENT_POINT,strHtml);
			objMarker.addLabel("<blink>A</blink>");
		  	objMap.addOverlay(objMarker);
			
			 dblLongA=G_CURRENT_POINT.Lon;
			 dblLatA=G_CURRENT_POINT.Lat;
		    document.getElementById("txtLat1").value=G_CURRENT_POINT.Lat;
		  	document.getElementById("txtLong1").value=G_CURRENT_POINT.Lon;
		
			//Show Marker 
	  	 //   showMarker(fltLatitude, fltLongitude,valZoom,"A",strHtml);
	  	    
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
		objMarker=createMarker(myPoint,Text);
		objMarker.addLabel("<blink>A</blink>");
	  	objMap.addOverlay(objMarker);

		if(intCounter==1)
		{ 

		  dblLongA=myPoint.Lon;
		  dblLatA=myPoint.Lat;
		  
		  document.getElementById("txtLat1").value=myPoint.Lat;
		  document.getElementById("txtLong1").value=myPoint.Lon;
    
		  intCounter++;
		}
		  
		if(intCounter>0)
		{
		 objMap.removeMarkersAll();
		 intCounter=0;
		 dblLongA=0;
		 dblLatA=0;
		}
		  
	 /* YEvent.Capture
		  	(objMarker, EventsList.MouseClick, 
		      	function onSmartWinEvent() 
		      	{
				  	objMarker.setSmartWindowColor("orange");
			      	objMarker.openSmartWindow("<div id=\"MapBuilderIW\">"+Text+"</div>");
				} 
			 );
		  objMap.addOverlay(objMarker);*/

	}
	