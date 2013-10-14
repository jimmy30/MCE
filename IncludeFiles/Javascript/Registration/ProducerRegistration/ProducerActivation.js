
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm()
{
// Email
	if(document.getElementById("txtEmail").value=='')
	{
		alert("Please enter Email Address");
		document.getElementById("txtEmail").focus();
		return false;
	}

// ActivationCode
	if(document.getElementById("txtCode").value=='')
	{
		alert("Please enter Activation Code");
		document.getElementById("txtCode").focus();
		return false;
	}

// Email Check Valid
	if(!checkEmailAddress(document.getElementById("txtEmail").value))
	{
		document.getElementById("txtEmail").focus();
		document.getElementById("txtEmail").select();		
		return false;
	}
return true;
}
