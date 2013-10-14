
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm()
{
// Email
	if(trim(document.getElementById("txtEmail").value)=='')
	{
		alert("Please enter Email Address");
		document.getElementById("txtEmail").focus();
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
