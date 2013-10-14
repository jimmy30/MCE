
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){

// First Name
	if(document.frmEditProducer.txtFirstName.value=='')
	{
		alert("Please enter First Name");
		document.frmEditProducer.txtFirstName.focus();
		return false;
	}

// Last Name
	if(document.frmEditProducer.txtLastName.value=='')
	{
		alert("Please enter Last Name");
		document.frmEditProducer.txtLastName.focus();
		return false;
	}

// Address
	if(document.frmEditProducer.txtAddress1.value=='')
	{
		alert("Please enter Street Address");
		document.frmEditProducer.txtAddress1.focus();
		return false;
	}

// City
	if(document.frmEditProducer.txtCity.value=='')
	{
		alert("Please enter City");
		document.frmEditProducer.txtCity.focus();
		return false;
	}

// ZipCode
	if(document.frmEditProducer.txtZipCode.value=='')
	{
		alert("Please enter Zip Code");
		document.frmEditProducer.txtZipCode.focus();
		return false;
	}

// Telephone
	if(document.frmEditProducer.txtTelephone1.value=='')
	{
		alert("Please enter Telephone");
		document.frmEditProducer.txtTelephone1.focus();
		return false;
	}


// Year
	if(document.frmEditProducer.txtYear.value=='')
	{
		alert("Please enter Year");
		document.frmEditProducer.txtYear.focus();
		return false;
	}
	
// Email
	if(document.frmEditProducer.txtEmail.value=='')
	{
		alert("Please enter Email Address");
		document.frmEditProducer.txtEmail.focus();
		return false;
	}

// Password
	if(document.frmEditProducer.txtPassword.value=='')
	{
		alert("Please enter Password");
		document.frmEditProducer.txtPassword.focus();
		return false;
	}

// Secret Answer	
	if(document.frmEditProducer.txtAnswer.value=='')
	{
		alert("Please enter Secret Answer");
		document.frmEditProducer.txtAnswer.focus();
		return false;
	}

// Activation Code
	if(document.frmEditProducer.txtActivationCode.value=='')
	{
		alert("Please enter Activation Code");
		document.frmEditProducer.txtActivationCode.focus();
		return false;
	}

// Year
	if(document.frmEditProducer.txtYearDateCreated.value=='')
	{
		alert("Please enter Year");
		document.frmEditProducer.txtYearDateCreated.focus();
		return false;
	}

////////////////////////////////////////////////////////////////////////////
////////////////// Valid Fields Checks /////////////////////////////////////
////////////////////////////////////////////////////////////////////

// First name IsAlphabet check
	if(!isValidAlpha(document.frmEditProducer.txtFirstName.value,"First Name"))
	{
	document.frmEditProducer.txtFirstName.focus();
	document.frmEditProducer.txtFirstName.select();		
	return false;
	}

// Last name IsAlphabet check
	if(!isValidAlpha(document.frmEditProducer.txtLastName.value,"Last Name"))
	{
	document.frmEditProducer.txtLastName.focus();
	document.frmEditProducer.txtLastName.select();		
	return false;
	}

// ZipCode is valid check
	if(!isValidZip(document.frmEditProducer.txtZipCode.value,"Zip Code",document.frmEditProducer.cmbCountryRegion.value))
	{
	document.frmEditProducer.txtZipCode.focus();
	document.frmEditProducer.txtZipCode.select();		
	return false;
	}

// Telephone is valid check
	if(!isValidPhone(document.frmEditProducer.txtTelephone1.value,"Telephone"))
	{
	document.frmEditProducer.txtTelephone1.focus();
	document.frmEditProducer.txtTelephone1.select();		
	return false;
	}

// Extension is valid check
	if(!isValidNumeric(document.frmEditProducer.txtExtension.value,"Extension"))
	{
	document.frmEditProducer.txtExtension.focus();
	document.frmEditProducer.txtExtension.select();		
	return false;
	}
	
// Year is Numeric
	if(!isValidNumeric(document.frmEditProducer.txtYear.value,"Year"))
	{
	document.frmEditProducer.txtYear.focus();
	document.frmEditProducer.txtYear.select();		
	return false;
	}

// Year is valid check
	var today = new Date();
	if((document.frmEditProducer.txtYear.value < 1900 || document.frmEditProducer.txtYear.value > today.getFullYear()))
	{
		alert("Invalid Year");
		document.frmEditProducer.txtYear.focus();
		document.frmEditProducer.txtYear.select();		
		return false;
	}

// Email Check Valid
	if(!checkEmailAddress(document.frmEditProducer.txtEmail.value))
	{
		document.frmEditProducer.txtEmail.focus();
		document.frmEditProducer.txtEmail.select();		
		return false;
	}
	
// Password IS Alpha Numeric check
	if(!isValidAlphaNumeric(document.frmEditProducer.txtPassword.value,"Password"))
	{
		document.frmEditProducer.txtPassword.focus();
		document.frmEditProducer.txtPassword.select();		
		return false;
	}

// Password length check
	if(document.frmEditProducer.txtPassword.value.length < 6)
	{
		alert("Password must be atleast 6 characters long");
		document.frmEditProducer.txtPassword.focus();
		document.frmEditProducer.txtPassword.select();		
		return false;
	}

// Match Re Password
	if(document.frmEditProducer.txtPassword.value != document.frmEditProducer.txtRePassword.value){
		alert("Password does not matched");
		document.frmEditProducer.txtPassword.value = "";
		document.frmEditProducer.txtRePassword.value = "";
		document.frmEditProducer.txtPassword.focus();
		return false;
	}	

// Activation IS Alpha Numeric check
	if(!isValidAlphaNumeric(document.frmEditProducer.txtActivationCode.value,"Activation Code"))
	{
		document.frmEditProducer.txtActivationCode.focus();
		document.frmEditProducer.txtActivationCode.select();		
		return false;
	}

// Year is Numeric
	if(!isValidNumeric(document.frmEditProducer.txtYearDateCreated.value,"Year"))
	{
	document.frmEditProducer.txtYearDateCreated.focus();
	document.frmEditProducer.txtYearDateCreated.select();		
	return false;
	}

// Year is valid check

	if((document.frmEditProducer.txtYearDateCreated.value < 1900 || document.frmEditProducer.txtYearDateCreated.value > today.getFullYear()))
	{
		alert("Invalid Year");
		document.frmEditProducer.txtYearDateCreated.focus();
		document.frmEditProducer.txtYearDateCreated.select();		
		return false;
	}

return true;
}
