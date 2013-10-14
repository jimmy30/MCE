  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //	Global Variables 	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
    var G_INITIAL_ZOOM_LEVEL=15; 
    var G_MAP;
    var G_POLYLINE_WEIGHT=3;
    var G_POLYLINE_COLOR="#000000";
    var G_POLYLINE_OPACITY=0.5;
	var intLastClick;
	var strPoint;
	var fltLongitude;
	var fltLatitude;
	var intCounter=0;
	var fltLongOne=0;
	var fltLatOne=0;
	var fltLongTwo=0;
	var fltLat=0;
	var fltLongThree=0;
	var fltLatThree=0;
	var fltLongFour=0;
	var fltLatFount=0;
	var centx = 0.0;
	var centy = 0.0;
	var WARNING_IMAGE_PATH="/ImageFiles/common/Warning.gif"
    function loadMap() 
    {

      if (GBrowserIsCompatible()) 
      {
			//alert(document.getElementById("cmbPoliceStation").value);

			G_MAP = new GMap2(document.getElementById("mapContainer"));
			G_MAP.addControl(new GSmallMapControl());
			//G_MAP.addControl(new GMapTypeControl());
			//G_MAP.addControl(new GOverviewMapControl(new GSize(180,180)));
			
			G_MAP.setCenter(new GLatLng(30.244047, -97.747175),G_INITIAL_ZOOM_LEVEL);		
			G_MAP.setMapType(G_SATELLITE_MAP);
			strPoint = new GPoint(-97.747175,30.244047) ;
			//strPoint = new GLatLng(31.577182675335468, 74.3600606918335) ;
			var intZoomlvl=G_MAP.getZoom();
			//alert(intZoomlvl);

			GEvent.addListener(G_MAP, 'dblclick', function(overlay, strPointb)
			 {


					var intZoomlvl = G_MAP.getZoom();
					G_MAP.setCenter(new GLatLng(strPointb.y, strPointb.x),intZoomlvl);		
				

			 });
		 
      }
	}
	
 	function markPoint( pStrPoint, pIntZoomlvl,pUrl)
	{
		var strHtml = "";
		
		G_MAP.getCenter( pStrPoint, pIntZoomlvl) ;
		strHtml += strHtml + "Longitude , Latitude <br>" + pStrPoint.x +" , " + pStrPoint.y;

		var objIcon = new GIcon();
		objIcon.image = pUrl;

		objIcon.iconSize = new GSize(20, 30);
		objIcon.iconAnchor = new GPoint(6, 20);
		objIcon.infoWindowAnchor = new GPoint(5, 1);

		var objMarker = new createMarker(pStrPoint, strHtml,objIcon);
		G_MAP.addOverlay(objMarker);
		
	}
	function createMarker(pStrPoint, strHtml,objIcon) 
	{
		 var objMarker = new GMarker(pStrPoint,objIcon);

		 GEvent.addListener(objMarker, "click", function()
		 {
			 objMarker.openInfoWindowHtml(strHtml);
			 objMarker.showMapBlowup(19);
		 });
		 return objMarker;
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
		
		strLocation=document.getElementById('txtLocation').value; 
		if (strLocation!="")
		{

			if(window.XMLHttpRequest)
			{
				req = new XMLHttpRequest(); 
	
			}	
					
			else if (window.ActiveXObject)
			{
				strName="Microsoft.XMLHTTP";
				req  = new ActiveXObject(strName); 
			}
			
	
		
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
		else
		{
			alert("Please enter search text");	
		}	
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
		
		strUrl="/MapService/clsMapService.php?appid=yahoomapapi1234&location="+strLocation;	
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
			//G_CURRENT_POINT=new YGeoPoint(fltLatitude,fltLongitude);
			
			//Show Marker 
	  	    showMarker(fltLatitude, fltLongitude,13,"",strHtml);
	  	    
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
		G_MAP.clearOverlays();
		var strPointa = new GPoint(Longitude,Latitude);
		G_MAP.setCenter(new GLatLng(strPointa.y,strPointa.x),Zoom);
		objMarker = new GMarker(strPointa);
		G_MAP.addOverlay(objMarker);
		objMarker.openInfoWindowHtml(Text);
		
		
	
	}
	
	


