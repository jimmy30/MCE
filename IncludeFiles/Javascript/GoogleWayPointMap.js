  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //	Global Variables 	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
    var G_INITIAL_ZOOM_LEVEL=8; 
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
	var fltLatTwo=0;
	var fltLongThree=0;
	var fltLatThree=0;
	var fltLongFour=0;
	var fltLatFour=0;
	var centx = 0.0;
	var centy = 0.0;
	var WARNING_IMAGE_PATH="/ImageFiles/common/Warning.gif";
	var objMarker;
	var Cpoints = [];
    var polygon;
	var MyMarkerArray=[];

	function init_var(pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour){

		fltLongOne=parseFloat(pIntPlaceCastLongOne);
		fltLatOne=parseFloat(pIntPlaceCastLatOne);
		fltLongTwo=parseFloat(pIntPlaceCastLongTwo);
		fltLatTwo=parseFloat(pIntPlaceCastLatTwo);
		fltLongThree=parseFloat(pIntPlaceCastLongThree);
		fltLatThree=parseFloat(pIntPlaceCastLatThree);
		fltLongFour=parseFloat(pIntPlaceCastLongFour);
		fltLatFour=parseFloat(pIntPlaceCastLatFour);
	}

   function loadMap(pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour)
    {
	init_var(pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour);
	pIntPlaceCastLatOne=parseFloat(pIntPlaceCastLatOne);
	pIntPlaceCastLongOne=parseFloat(pIntPlaceCastLongOne);
	pIntPlaceCastLatTwo=parseFloat(pIntPlaceCastLatTwo);
	pIntPlaceCastLongTwo=parseFloat(pIntPlaceCastLongTwo);
	pIntPlaceCastLatThree=parseFloat(pIntPlaceCastLatThree);
	pIntPlaceCastLongThree=parseFloat(pIntPlaceCastLongThree);
	pIntPlaceCastLatFour=parseFloat(pIntPlaceCastLatFour);
	pIntPlaceCastLongFour=parseFloat(pIntPlaceCastLongFour);

      if (GBrowserIsCompatible()) 
	  { 
	
      // Display the map, with some controls and set the initial location 
      G_MAP = new GMap(document.getElementById("mapContainer"));
      G_MAP.addControl(new GLargeMapControl());
      G_MAP.addControl(new GMapTypeControl());
	  G_MAP.setMapType(G_SATELLITE_MAP);
      DrawRectangle(pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour);
	 GPolygon.prototype.Contains = function(point) 
	 {
      
	   	var j=0;
        var oddNodes = false;
        var x = point.lng();
        var y = point.lat();
        for (var i=0; i < this.getVertexCount(); i++)
		 {
          j++;
          if (j == this.getVertexCount()) {j = 0;}
          if (((this.getVertex(i).lat() < y) && (this.getVertex(j).lat() >= y))
          || ((this.getVertex(j).lat() < y) && (this.getVertex(i).lat() >= y))) {
            if ( this.getVertex(i).lng() + (y - this.getVertex(i).lat())
            /  (this.getVertex(j).lat()-this.getVertex(i).lat())
            *  (this.getVertex(j).lng() - this.getVertex(i).lng())<x ) {
              oddNodes = !oddNodes
            }
          }
        }
        return oddNodes;
      }
	  if (document.getElementById("txtLong1").value!="" && document.getElementById("txtLat1").value!="")
	  {
		  var fltLong=document.getElementById("txtLong1").value;
		  var fltLat=document.getElementById("txtLat1").value;
		  fltLong=parseFloat(fltLong);
  	   	  fltLat=parseFloat(fltLat);
		  var strPoint = new GPoint(fltLong,fltLat); 
		
		  G_MAP.centerAndZoom(new GLatLng(strPoint.y,strPoint.x),G_INITIAL_ZOOM_LEVEL);		
		  objMarker = new GMarker(strPoint);
		  objMarker.showMapBlowup(19);
		  MyMarkerArray[0]=objMarker;
		  G_MAP.addOverlay(MyMarkerArray[0]);	
	  }
      GPolyline.prototype.Contains = GPolygon.prototype.Contains;
      GEvent.addListener(G_MAP, "dblclick", function (overlay,p)
	   {
		   
			if (polygon.Contains(p)) 
			{
				markPoint(p,G_INITIAL_ZOOM_LEVEL);
			} 
			else 
			{
		         G_MAP.openInfoWindowHtml(p, "The searched location is outside the Placecast");
        	}
      });
	  

    }

    
    // display a warning if the browser was not compatible
    else
	{
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
	
}
	
	function markPoint(p,G_INITIAL_ZOOM_LEVEL)
	{
		document.getElementById("txtLong1").value="";
		document.getElementById("txtLat1").value="";
		url="http://124.29.215.84/CrimeAnalysis/icon/icon0.png";
		var strPoint = new GPoint(p.x,p.y); 
	    G_MAP.centerAndZoom(new GLatLng(p.y, p.x),G_INITIAL_ZOOM_LEVEL);		

		if(MyMarkerArray[0]){
				G_MAP.removeOverlay(MyMarkerArray[0]) 
				
		}
		objMarker = new GMarker(strPoint);
		objMarker.showMapBlowup(19);
		MyMarkerArray[0]=objMarker;
		G_MAP.addOverlay(MyMarkerArray[0]);	

		document.getElementById("txtLong1").value=p.x;
		document.getElementById("txtLat1").value=p.y;
	}
	
	function DrawRectangle(pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour)
	{
		centroidCoordinates(pIntPlaceCastLatOne,pIntPlaceCastLongOne,pIntPlaceCastLatTwo,pIntPlaceCastLongTwo,pIntPlaceCastLatThree,pIntPlaceCastLongThree,pIntPlaceCastLatFour,pIntPlaceCastLongFour);
 	    G_MAP.centerAndZoom(new GLatLng(centx,centy),G_INITIAL_ZOOM_LEVEL);		
        var pts = [new GLatLng(pIntPlaceCastLatOne,pIntPlaceCastLongOne), new GLatLng(pIntPlaceCastLatTwo,pIntPlaceCastLongTwo), new GLatLng(pIntPlaceCastLatThree,pIntPlaceCastLongThree), new GLatLng(pIntPlaceCastLatFour,pIntPlaceCastLongFour), new GLatLng(pIntPlaceCastLatOne,pIntPlaceCastLongOne)];
		polygon = new GPolygon(pts, null, 5, 0.7, "#aaaaff", 0.5 );
	    G_MAP.addOverlay(polygon);
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
		pIntCounter=0;
		intCounter=0;
		strPoint = new GLatLng(Latitude,Longitude);

		if (polygon.Contains(strPoint)) 
			{

				markPoint(strPoint,G_INITIAL_ZOOM_LEVEL);
				document.getElementById("txtLong1").value=strPoint.x;
				document.getElementById("txtLat1").value=strPoint.y;
			} 
			else 
			{
		        alert("The searched location is outside the Placecast");
        	}
				loadMap(fltLatOne,fltLongOne,fltLatTwo,fltLongTwo,fltLatThree,fltLongThree,fltLatFour,fltLongFour);

	}
	