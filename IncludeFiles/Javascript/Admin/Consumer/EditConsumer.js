
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){

// First Name
	if(document.frmEditConsumer.txtFirstName.value=='')
	{
		alert("Please enter First Name");
		document.frmEditConsumer.txtFirstName.focus();
		return false;
	}

// Last Name
	if(document.frmEditConsumer.txtLastName.value=='')
	{
		alert("Please enter Last Name");
		document.frmEditConsumer.txtLastName.focus();
		return false;
	}

// Address
	if(document.frmEditConsumer.txtAddress1.value=='')
	{
		alert("Please enter Street Address");
		document.frmEditConsumer.txtAddress1.focus();
		return false;
	}

// City
	if(document.frmEditConsumer.txtCity.value=='')
	{
		alert("Please enter City");
		document.frmEditConsumer.txtCity.focus();
		return false;
	}

// ZipCode
	if(document.frmEditConsumer.txtZipCode.value=='')
	{
		alert("Please enter Zip Code");
		document.frmEditConsumer.txtZipCode.focus();
		return false;
	}

// Telephone
	if(document.frmEditConsumer.txtTelephone1.value=='')
	{
		alert("Please enter Telephone");
		document.frmEditConsumer.txtTelephone1.focus();
		return false;
	}


// Year
	if(document.frmEditConsumer.txtYear.value=='')
	{
		alert("Please enter Year");
		document.frmEditConsumer.txtYear.focus();
		return false;
	}
	
// Email
	if(document.frmEditConsumer.txtEmail.value=='')
	{
		alert("Please enter Email Address");
		document.frmEditConsumer.txtEmail.focus();
		return false;
	}

// Password
	if(document.frmEditConsumer.txtPassword.value=='')
	{
		alert("Please enter Password");
		document.frmEditConsumer.txtPassword.focus();
		return false;
	}

// Secret Answer	
	if(document.frmEditConsumer.txtAnswer.value=='')
	{
		alert("Please enter Secret Answer");
		document.frmEditConsumer.txtAnswer.focus();
		return false;
	}

// Activation Code
	if(document.frmEditConsumer.txtActivationCode.value=='')
	{
		alert("Please enter Activation Code");
		document.frmEditConsumer.txtActivationCode.focus();
		return false;
	}

// Year
	if(document.frmEditConsumer.txtYearDateCreated.value=='')
	{
		alert("Please enter Year");
		document.frmEditConsumer.txtYearDateCreated.focus();
		return false;
	}

////////////////////////////////////////////////////////////////////////////
////////////////// Valid Fields Checks /////////////////////////////////////
////////////////////////////////////////////////////////////////////

// First name IsAlphabet check
	if(!isValidAlpha(document.frmEditConsumer.txtFirstName.value,"First Name"))
	{
	document.frmEditConsumer.txtFirstName.focus();
	document.frmEditConsumer.txtFirstName.select();		
	return false;
	}

// Last name IsAlphabet check
	if(!isValidAlpha(document.frmEditConsumer.txtLastName.value,"Last Name"))
	{
	document.frmEditConsumer.txtLastName.focus();
	document.frmEditConsumer.txtLastName.select();		
	return false;
	}

// ZipCode is valid check
	if(!isValidZip(document.frmEditConsumer.txtZipCode.value,"Zip Code",document.frmEditConsumer.cmbCountryRegion.value))
	{
	document.frmEditConsumer.txtZipCode.focus();
	document.frmEditConsumer.txtZipCode.select();		
	return false;
	}

// Telephone is valid check
	if(!isValidPhone(document.frmEditConsumer.txtTelephone1.value,"Telephone"))
	{
	document.frmEditConsumer.txtTelephone1.focus();
	document.frmEditConsumer.txtTelephone1.select();		
	return false;
	}

// Extension is valid check
	if(!isValidNumeric(document.frmEditConsumer.txtExtension.value,"Extension"))
	{
	document.frmEditConsumer.txtExtension.focus();
	document.frmEditConsumer.txtExtension.select();		
	return false;
	}
	
// Year is Numeric
	if(!isValidNumeric(document.frmEditConsumer.txtYear.value,"Year"))
	{
	document.frmEditConsumer.txtYear.focus();
	document.frmEditConsumer.txtYear.select();		
	return false;
	}

// Year is valid check
	var today = new Date();
	if((document.frmEditConsumer.txtYear.value < 1900 || document.frmEditConsumer.txtYear.value > today.getFullYear()))
	{
		alert("Invalid Year");
		document.frmEditConsumer.txtYear.focus();
		document.frmEditConsumer.txtYear.select();		
		return false;
	}

// Email Check Valid
	if(!checkEmailAddress(document.frmEditConsumer.txtEmail.value))
	{
		document.frmEditConsumer.txtEmail.focus();
		document.frmEditConsumer.txtEmail.select();		
		return false;
	}
	
// Password IS Alpha Numeric check
	if(!isValidAlphaNumeric(document.frmEditConsumer.txtPassword.value,"Password"))
	{
		document.frmEditConsumer.txtPassword.focus();
		document.frmEditConsumer.txtPassword.select();		
		return false;
	}

// Password length check
	if(document.frmEditConsumer.txtPassword.value.length < 6)
	{
		alert("Password must be atleast 6 characters long");
		document.frmEditConsumer.txtPassword.focus();
		document.frmEditConsumer.txtPassword.select();		
		return false;
	}

// Match Re Password
	if(document.frmEditConsumer.txtPassword.value != document.frmEditConsumer.txtRePassword.value){
		alert("Password does not matched");
		document.frmEditConsumer.txtPassword.value = "";
		document.frmEditConsumer.txtRePassword.value = "";
		document.frmEditConsumer.txtPassword.focus();
		return false;
	}	

// Activation IS Alpha Numeric check
	if(!isValidAlphaNumeric(document.frmEditConsumer.txtActivationCode.value,"Activation Code"))
	{
		document.frmEditConsumer.txtActivationCode.focus();
		document.frmEditConsumer.txtActivationCode.select();		
		return false;
	}

// Year is Numeric
	if(!isValidNumeric(document.frmEditConsumer.txtYearDateCreated.value,"Year"))
	{
	document.frmEditConsumer.txtYearDateCreated.focus();
	document.frmEditConsumer.txtYearDateCreated.select();		
	return false;
	}

// Year is valid check

	if((document.frmEditConsumer.txtYearDateCreated.value < 1900 || document.frmEditConsumer.txtYearDateCreated.value > today.getFullYear()))
	{
		alert("Invalid Year");
		document.frmEditConsumer.txtYearDateCreated.focus();
		document.frmEditConsumer.txtYearDateCreated.select();		
		return false;
	}

return true;
}
