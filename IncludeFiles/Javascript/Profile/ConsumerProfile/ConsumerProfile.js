
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){

// First Name
	if(document.frmRegistration.txtFirstName.value=='')
	{
		alert("Please enter First Name");
		document.frmRegistration.txtFirstName.focus();
		return false;
	}

// Last Name
	if(document.frmRegistration.txtLastName.value=='')
	{
		alert("Please enter Last Name");
		document.frmRegistration.txtLastName.focus();
		return false;
	}

// Address
	if(document.frmRegistration.txtAddress1.value=='')
	{
		alert("Please enter Street Address");
		document.frmRegistration.txtAddress1.focus();
		return false;
	}

// City
	if(document.frmRegistration.txtCity.value=='')
	{
		alert("Please enter City");
		document.frmRegistration.txtCity.focus();
		return false;
	}

// ZipCode
	if(document.frmRegistration.txtZipCode.value=='')
	{
		alert("Please enter Zip Code");
		document.frmRegistration.txtZipCode.focus();
		return false;
	}

// Telephone
	if(document.frmRegistration.txtTelephone1.value=='')
	{
		alert("Please enter Telephone");
		document.frmRegistration.txtTelephone1.focus();
		return false;
	}


// Year
	if(document.frmRegistration.cmbYear.value=='')
	{
		alert("Please enter Year");
		document.frmRegistration.cmbYear.focus();
		return false;
	}
	
// Secret Answer	
	if(document.frmRegistration.txtAnswer.value=='')
	{
		alert("Please enter Secret Answer");
		document.frmRegistration.txtAnswer.focus();
		return false;
	}

////////////////////////////////////////////////////////////////////////////
////////////////// Valid Fields Checks /////////////////////////////////////
////////////////////////////////////////////////////////////////////

// First name IsAlphabet check
	if(!isValidAlpha(document.frmRegistration.txtFirstName.value,"First Name"))
	{
	document.frmRegistration.txtFirstName.focus();
	document.frmRegistration.txtFirstName.select();		
	return false;
	}

// Last name IsAlphabet check
	if(!isValidAlpha(document.frmRegistration.txtLastName.value,"Last Name"))
	{
	document.frmRegistration.txtLastName.focus();
	document.frmRegistration.txtLastName.select();		
	return false;
	}

// ZipCode is valid check
	if(!isValidZip(document.frmRegistration.txtZipCode.value,"Zip Code",document.frmRegistration.cmbCountryRegion.value))
	{
	document.frmRegistration.txtZipCode.focus();
	document.frmRegistration.txtZipCode.select();		
	return false;
	}

// Telephone is valid check
	if(!isValidPhone(document.frmRegistration.txtTelephone1.value,"Telephone"))
	{
	document.frmRegistration.txtTelephone1.focus();
	document.frmRegistration.txtTelephone1.select();		
	return false;
	}

// Extension is valid check
	if(!isValidNumeric(document.frmRegistration.txtExtension.value,"Extension"))
	{
	document.frmRegistration.txtExtension.focus();
	document.frmRegistration.txtExtension.select();		
	return false;
	}
	
// Year is Numeric
	if(!isValidNumeric(document.frmRegistration.cmbYear.value,"Year"))
	{
	document.frmRegistration.cmbYear.focus();
	document.frmRegistration.cmbYear.select();		
	return false;
	}

// Year is valid check
	var today = new Date();
	if((document.frmRegistration.cmbYear.value < 1900 || document.frmRegistration.cmbYear.value > today.getFullYear()))
	{
		alert("Invalid Year");
		document.frmRegistration.cmbYear.focus();
		document.frmRegistration.cmbYear.select();		
		return false;
	}
return true;
}
