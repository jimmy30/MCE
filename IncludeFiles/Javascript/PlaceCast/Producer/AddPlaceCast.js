
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){

// PlaceCast Name
	if(trim(document.frmPlaceCast.txtPlaceCastName.value)=='')
	{
		alert("Please enter PlaceCast Name");
		document.frmPlaceCast.txtPlaceCastName.focus();
		return false;
	}

// Address
	if(trim(document.frmPlaceCast.txtAddress1.value)=='')
	{
		alert("Please enter Street Address");
		document.frmPlaceCast.txtAddress1.focus();
		return false;
	}

// City
	if(trim(document.frmPlaceCast.txtCity.value)=='')
	{
		alert("Please enter City");
		document.frmPlaceCast.txtCity.focus();
		return false;
	}

// ZipCode
	if(trim(document.frmPlaceCast.txtZipCode.value)=='')
	{
		alert("Please enter Zip Code");
		document.frmPlaceCast.txtZipCode.focus();
		return false;
	}

// Description
	if(trim(document.frmPlaceCast.txtArDescription.value)=='')
	{
		alert("Please enter Description");
		document.frmPlaceCast.txtArDescription.focus();
		return false;
	}

// Latitute left top
	if(trim(document.frmPlaceCast.txtLat1.value)=='')
	{
		alert("Please enter Latitute value");
		document.frmPlaceCast.txtLat1.focus();
		return false;
	}

// Longitute left top
	if(trim(document.frmPlaceCast.txtLong1.value)=='')
	{
		alert("Please enter Longitute value");
		document.frmPlaceCast.txtLong1.focus();
		return false;
	}

// Latitute right top
	if(trim(document.frmPlaceCast.txtLat2.value)=='')
	{
		alert("Please enter Latitute value");
		document.frmPlaceCast.txtLat2.focus();
		return false;
	}

// Longitute right top
	if(trim(document.frmPlaceCast.txtLong2.value)=='')
	{
		alert("Please enter Longitute value");
		document.frmPlaceCast.txtLong2.focus();
		return false;
	}

// Latitute left bottom
	if(trim(document.frmPlaceCast.txtLat3.value)=='')
	{
		alert("Please enter Latitute value");
		document.frmPlaceCast.txtLat3.focus();
		return false;
	}

// Longitute left bottom
	if(trim(document.frmPlaceCast.txtLong3.value)=='')
	{
		alert("Please enter Longitute value");
		document.frmPlaceCast.txtLong3.focus();
		return false;
	}

// Latitute right bottom
	if(trim(document.frmPlaceCast.txtLat4.value)=='')
	{
		alert("Please enter Latitute value");
		document.frmPlaceCast.txtLat4.focus();
		return false;
	}

// Longitute right bottom
	if(trim(document.frmPlaceCast.txtLong4.value)=='')
	{
		alert("Please enter Longitute value");
		document.frmPlaceCast.txtLong4.focus();
		return false;
	}

////////////////////////////////////////////////////////////////////////////
////////////////// Valid Fields Checks /////////////////////////////////////
////////////////////////////////////////////////////////////////////

// ZipCode is valid check
	if(!isValidZip(document.frmPlaceCast.txtZipCode.value,"Zip Code",document.frmPlaceCast.cmbCountryRegion.value))
	{
	document.frmPlaceCast.txtZipCode.focus();
	document.frmPlaceCast.txtZipCode.select();		
	return false;
	}

// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmPlaceCast.txtLat1.value,"Latitude1"))
	{
	document.frmPlaceCast.txtLat1.focus();
	document.frmPlaceCast.txtLat1.select();		
	return false;
	}
// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmPlaceCast.txtLong1.value,"Longitude"))
	{
	document.frmPlaceCast.txtLong1.focus();
	document.frmPlaceCast.txtLong1.select();		
	return false;
	}

// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmPlaceCast.txtLat2.value,"Latitude"))
	{
	document.frmPlaceCast.txtLat2.focus();
	document.frmPlaceCast.txtLat2.select();		
	return false;
	}
// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmPlaceCast.txtLong2.value,"Longitude"))
	{
	document.frmPlaceCast.txtLong2.focus();
	document.frmPlaceCast.txtLong2.select();		
	return false;
	}

// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmPlaceCast.txtLat3.value,"Latitude"))
	{
	document.frmPlaceCast.txtLat3.focus();
	document.frmPlaceCast.txtLat3.select();		
	return false;
	}
// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmPlaceCast.txtLong3.value,"Longitude"))
	{
	document.frmPlaceCast.txtLong3.focus();
	document.frmPlaceCast.txtLong3.select();		
	return false;
	}
// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmPlaceCast.txtLat4.value,"Latitude"))
	{
	document.frmPlaceCast.txtLat4.focus();
	document.frmPlaceCast.txtLat4.select();		
	return false;
	}
// Lat/Long  IsDecimal check
	if(!isValidDecimal(document.frmPlaceCast.txtLong4.value,"Longitude"))
	{
	document.frmPlaceCast.txtLong4.focus();
	document.frmPlaceCast.txtLong4.select();		
	return false;
	}

return true;
}
