
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){

// Waypoint Name
	if(trim(document.frmWaypoint.txtWaypointName.value)=='')
	{
		alert("Please enter Waypoint Name");
		document.frmWaypoint.txtWaypointName.focus();
		return false;
	}

// Address
	if(trim(document.frmWaypoint.txtAddress1.value)=='')
	{
		alert("Please enter Street Address");
		document.frmWaypoint.txtAddress1.focus();
		return false;
	}

// City
	if(trim(document.frmWaypoint.txtCity.value)=='')
	{
		alert("Please enter City");
		document.frmWaypoint.txtCity.focus();
		return false;
	}

// Description
	if(trim(document.frmWaypoint.txtArDescription.value)=='')
	{
		alert("Please enter Description");
		document.frmWaypoint.txtArDescription.focus();
		return false;
	}

// Latitute
	if(trim(document.frmWaypoint.txtLat1.value)=='')
	{
		alert("Please enter Latitute value");
		document.frmWaypoint.txtLat1.focus();
		return false;
	}

// Longitute
	if(trim(document.frmWaypoint.txtLong1.value)=='')
	{
		alert("Please enter Longitute value");
		document.frmWaypoint.txtLong1.focus();
		return false;
	}
// Radius
	if(trim(document.frmWaypoint.txtRadius.value)=='')
	{
		alert("Please enter Radius value");
		document.frmWaypoint.txtRadius.focus();
		return false;
	}


////////////////////////////////////////////////////////////////////////////
////////////////// Valid Fields Checks /////////////////////////////////////
////////////////////////////////////////////////////////////////////


// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmWaypoint.txtLat1.value,"Latitude1"))
	{
	document.frmWaypoint.txtLat1.focus();
	document.frmWaypoint.txtLat1.select();		
	return false;
	}
// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmWaypoint.txtLong1.value,"Longitude"))
	{
	document.frmWaypoint.txtLong1.focus();
	document.frmWaypoint.txtLong1.select();		
	return false;
	}
// Radius isValidNumeric check
	if(!isValidNumeric(document.frmWaypoint.txtRadius.value,"Radius"))
	{
	document.frmWaypoint.txtRadius.focus();
	document.frmWaypoint.txtRadius.select();		
	return false;
	}

return true;
}
