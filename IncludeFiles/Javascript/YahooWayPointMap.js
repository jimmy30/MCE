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
var MaxRadius=0;
var valZoom=13;


var centx = 0.0;
var centy = 0.0;


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
	var G_CENT_POINT=new YGeoPoint(0, 0); 
	
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

	function findLongLatPoints(pMyPoint,pIntCounter)
	{
		
			objMap.removeMarkersAll();
			// calculating the current point line distance
			var C_Radius= CalculateRadius(pMyPoint.Lon,pMyPoint.Lat,G_CENT_POINT.Lon,G_CENT_POINT.Lat);
			if(flag==0)
			{
				if(C_Radius<MaxRadius)
				{
					flag=1;
					objMarker = new YMarker(pMyPoint);
					objMarker=createMarker(pMyPoint,strHtml);
					var strLabelString="<blink>"+pIntCounter+"</blink>";
					objMarker.addLabel(strLabelString);
	
					objMap.addOverlay(objMarker);
					document.getElementById("txtLat1").value=pMyPoint.Lat;
					document.getElementById("txtLong1").value=pMyPoint.Lon;		
				}
				else
				{
					
						alert("Selected Waypoint is outside the PlaceCast Boundry");
						document.getElementById("txtLat1").value="";
						document.getElementById("txtLong1").value="";
						flag=1;
				}
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
	function loadMap(pStatus,pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour,pIntCounter)
	
	{
		
		//Create a map object
		objSize=new YSize(MAP_WIDTH,MAP_HEIGHT);
		objMap = new  YMap(document.getElementById('mapContainer'),YAHOO_MAP_REG,objSize);
		// Create a lat/lon object
		myPoint =new YGeoPoint(pIntPlaceCastLatFour,pIntPlaceCastLongFour);; 
		objMap.addTypeControl();
		// Add a slider zoom control
		objMap.addPanControl();
		objMap.addZoomLong();
		
		
		
		var cPT = new YGeoPoint(pIntPlaceCastLatOne,pIntPlaceCastLongOne);
		var cPT2 = new YGeoPoint(pIntPlaceCastLatTwo,pIntPlaceCastLongTwo);
		var cPT3 = new YGeoPoint(pIntPlaceCastLatThree,pIntPlaceCastLongThree);
		var cPT4 = new YGeoPoint(pIntPlaceCastLatFour,pIntPlaceCastLongFour);
		var cPT5 = new YGeoPoint(pIntPlaceCastLatOne,pIntPlaceCastLongOne);

		
		poly1 = new YPolyline([cPT,cPT2,cPT3,cPT4,cPT5],'green',7,0.7);
		objMap.addOverlay(poly1);
		
		//Display the map centered on a latitude and longitude
		
		centroidCoordinates(pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour);
		G_CENT_POINT=new YGeoPoint(centx,centy); 
		//MaxRadius=CompareDistance(cPT,cPT2,cPT3,cPT4,G_CENT_POINT);

		//Ccolor=placeCastColor;
		//drawCircle(objMap,G_CENT_POINT,MaxRadius);
		objMap.drawZoomAndCenter(G_CENT_POINT,9);
	
		if (pStatus=="Add")
		{

			if (document.getElementById("txtLat1").value!="")
			{	

				flag=-1;
				G_CURRENT_POINT=new YGeoPoint(document.getElementById("txtLat1").value,document.getElementById("txtLong1").value);
				objMap.drawZoomAndCenter(G_CURRENT_POINT, 13);
				objMarker = new YMarker(G_CURRENT_POINT);
				objMarker=createMarker(G_CURRENT_POINT,strHtml);
				var strLabelString="<blink>"+pIntCounter+"</blink>";
				objMarker.addLabel(strLabelString);
		  		objMap.addOverlay(objMarker);
			
			}
			else
			{
				
				captureEvent(pIntCounter);
			}
		}
		else
		{
			if (document.getElementById("txtLat1").value!="")
			{	
				
				flag=1;
				G_CURRENT_POINT=new YGeoPoint(document.getElementById("txtLat1").value,document.getElementById("txtLong1").value);
				centroidCoordinates(pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour);
				G_CENT_POINT=new YGeoPoint(centx,centy); 
				objMap.drawZoomAndCenter(G_CENT_POINT,9);
				objMarker = new YMarker(G_CURRENT_POINT);
				objMarker=createMarker(G_CURRENT_POINT,strHtml);
				var strLabelString="<blink>"+pIntCounter+"</blink>";
				objMarker.addLabel(strLabelString);
		  		objMap.addOverlay(objMarker);
				
			}
			else
			{
				captureEventEdit(pIntCounter);
			}
			

			
		}
		if(flag==1)
		{
			YEvent.Capture
				  (objMap, EventsList.MouseDoubleClick, 
					  function(overlay,G_CURRENT_POINT) 
					  {
						 flag=0;
						 if (G_CURRENT_POINT)
						 {

							  findLongLatPoints(G_CURRENT_POINT,pIntCounter);
						 }
						
					  } 
				  );
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

	function captureEvent(pIntCounter)
	{
		YEvent.Capture
			  (objMap, EventsList.MouseDoubleClick, 
				  function(overlay,G_CURRENT_POINT) 
				  {
					  if (G_CURRENT_POINT)
					  {
						  flag=1;
						  findLongLatPoints(G_CURRENT_POINT,pIntCounter);
					  }
					
				  } 
			  );
	}

	function captureEventEdit()
	{

		YEvent.Capture
			  (objMap, EventsList.MouseDoubleClick, 
				  function(overlay,G_CURRENT_POINT) 
				  {
					  if (G_CURRENT_POINT)
					  {			
							flag=1;
							findLongLatPoints(G_CURRENT_POINT,pIntCounter);
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
			objMap.removeMarkersAll();
			G_CURRENT_POINT=new YGeoPoint(fltLatitude,fltLongitude);
			
			// calculating the current point line distance
			var C_Radius= CalculateRadius(G_CURRENT_POINT.Lon,G_CURRENT_POINT.Lat,G_CENT_POINT.Lon,G_CENT_POINT.Lat);
		
			if(C_Radius<MaxRadius){
			objMap.drawZoomAndCenter(G_CURRENT_POINT, valZoom);
			objMarker = new YMarker(G_CURRENT_POINT);
			objMarker=createMarker(G_CURRENT_POINT,strHtml);
			var strLabelString="<blink>"+pIntCounter+"</blink>";
			objMarker.addLabel(strLabelString);
		 
		 	objMap.addOverlay(objMarker);
		    document.getElementById("txtLat1").value=G_CURRENT_POINT.Lat;
		  	document.getElementById("txtLong1").value=G_CURRENT_POINT.Lon;
			}
			else{
				alert("Selected Waypoint is outside the PlaceCast Boundry");
			}

		 }

	}
	
	