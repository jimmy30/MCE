var circle=0;
var Ccolor = 'green' ;           // color blue 
var placeCastColor='red';
var waypointColor='blue';

function drawCircle(objMap,myPoint,Radius) 
	{ 
		 var lat = myPoint.Lat; 
		 var lng = myPoint.Lon; 
	
		 var Cradius = Radius; 
		 var Cwidth = 13 ;                   // width pixels 
		 var d2r = Math.PI/180 ;            // degrees to radians 
		 var r2d = 180/Math.PI ;            // radians to degrees 
		 var Clat = (Cradius/3963) * r2d ;  //  using 3963 as earth's radius 
	
	
		 var Clng = Clat/Math.cos(lat*d2r); 
		 var Cpoints = [] ; 
		 for (var i = 0 ; i < 13 ; i++) 
		 { 
		  var theta = Math.PI * (i/6) ; 
		  Cx = lng + (Clng * Math.cos(theta)) ; 
		  Cy = lat + (Clat * Math.sin(theta)) ; 
		  Cpoints.push(new YGeoPoint(Cy,Cx)) ; 
			
		 } 
		 
		 circle = new YPolyline(Cpoints,Ccolor,7,0.7) ; 
		 objMap.addOverlay(circle);
		
	} 
function removeCircle() 
	{ 
		 objMap.removeOverlay(circle);		
		 circle=new YPolyline([0,0],"green",7,1); 
	} 
function CalculateRadius(x1,y1,x2,y2)
	{
		
		x1=parseFloat(x1);
		x2=parseFloat(x2);
		y1=parseFloat(y1);
		y2=parseFloat(y2);
		var difference1 = x2 - x1;
		//difference1=parseFloat(difference1);
        var  difference2 = y2 - y1;
		//difference2=parseFloat(difference2);
        var sum = Math.pow(difference1,2) + Math.pow(difference2,2);
		sum=parseFloat(sum);
		var value=(Math.abs(sum));
		value=parseFloat(value);
        var distance = Math.sqrt(value);
		distance=(distance*65);
		
	    return distance;
		
	}

 function CompareDistance(myPointa,myPointb,myPointc,myPointd,centeridPoint)
	 {
		
		
		var MaxRadius = CalculateRadius(myPointa.Lon,myPointa.Lat,centeridPoint.Lon,centeridPoint.Lat);
		//alert(MaxRadius+"A");
		if (CalculateRadius(myPointb.Lon,myPointb.Lat, centeridPoint.Lon,centeridPoint.Lat) > MaxRadius)
		{
			MaxRadius = CalculateRadius(myPointb.Lon,myPointb.Lat,centeridPoint.Lon,centeridPoint.Lat);
		}
		if (CalculateRadius(myPointc.Lon,myPointc.Lat, centeridPoint.Lon,centeridPoint.Lat) > MaxRadius)
		{
			MaxRadius = CalculateRadius(myPointc.Lon,myPointc.Lat,centeridPoint.Lon,centeridPoint.Lat);
		}
		if (CalculateRadius(myPointd.Lon,myPointd.Lat, centeridPoint.Lon,centeridPoint.Lat) > MaxRadius)
		{
			MaxRadius = CalculateRadius(myPointd.Lon,myPointd.Lat,centeridPoint.Lon,centeridPoint.Lat);
		}
	
		return MaxRadius;
		
    }
	

function centroidCoordinates(a_x,a_y,b_x,b_y,c_x,c_y,d_x,d_y)
{
	a_x=parseFloat(a_x);
	a_y=parseFloat(a_y);
	
	b_x=parseFloat(b_x);
	b_y=parseFloat(b_y);
	
	c_x=parseFloat(c_x);
	c_y=parseFloat(c_y);
	
	d_x=parseFloat(d_x);
	d_y=parseFloat(d_y);
	

	var xCoord1 = 0.0;
	var yCoord1 = 0.0;

	
	
	xCoord1 = (a_x + b_x + c_x) / 3;
	yCoord1 = (a_y + b_y + c_y) / 3;
	
	
	var areaTriangle1Part1 = 0.0;
	var areaTriangle1Part2 = 0.0;
	var areaTriangle1 = 0.0;
	
	
	areaTriangle1Part1 = (b_x - a_x) * (c_y - a_y);
	areaTriangle1Part2 = (c_x - a_x) * (b_y - a_y);
	areaTriangle1 = (areaTriangle1Part1 - areaTriangle1Part2) / 2;
	

	
   var xCoord2 = 0.0;
   var yCoord2 = 0.0;
   xCoord2 = (a_x + c_x + d_x) / 3;
   yCoord2 = (a_y + c_y + d_y) / 3;

   
   var areaTriangle2Part1 = 0.0;
   var areaTriangle2Part2 = 0.0;
   var areaTriangle2 = 0.0;

	areaTriangle2Part1 = (c_x - a_x) * (d_y - a_y);
	areaTriangle2Part2 = (c_x - a_x) * (c_y - a_y);
	areaTriangle2 = (areaTriangle2Part1 - areaTriangle2Part2) / 2;

	var totalArea = 0.0;
	totalArea = areaTriangle1 + areaTriangle2;




	centx = areaTriangle1 / totalArea;

	centx = (xCoord1 * centx) + (xCoord2 * (areaTriangle2 / totalArea));

	centy = areaTriangle1 / totalArea;
	centy = (yCoord1 * centy) + (yCoord2 * (areaTriangle2 / totalArea));

}
