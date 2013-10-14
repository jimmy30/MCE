
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm()
{
// Old Password
	if(trim(document.getElementById("txtOldPassword").value)=='')
	{
		alert("Please enter Old Password");
		document.getElementById("txtOldPassword").focus();
		return false;
	}

// New Password
	if(trim(document.getElementById("txtNewPassword").value)=='')
	{
		alert("Please enter New Password");
		document.getElementById("txtNewPassword").focus();
		return false;
	}
// Re-Password
	if(trim(document.getElementById("txtRePassword").value)=='')
	{
		alert("Please Re-enter Password");
		document.getElementById("txtRePassword").focus();
		return false;
	}

// New Password length check
	if(document.getElementById("txtNewPassword").value.length < 6)
	{
		alert("Password must be atleast 6 characters long");
		document.getElementById("txtNewPassword").focus();
		document.getElementById("txtNewPassword").select();		
		return false;
	}

// Old Password 
	if(!isValidPassword(document.getElementById("txtOldPassword").value,'Old Password'))
	{
		document.getElementById("txtOldPassword").focus();
		document.getElementById("txtOldPassword").select();		
		return false;
	}

// New Password 
	if(!isValidPassword(document.getElementById("txtNewPassword").value,'New Password'))
	{
		document.getElementById("txtNewPassword").focus();
		document.getElementById("txtNewPassword").select();		
		return false;
	}

// Match Re Password
	if(document.getElementById("txtNewPassword").value != document.getElementById("txtRePassword").value){
		alert("Password does not matched");
		document.getElementById("txtNewPassword").value = "";
		document.getElementById("txtRePassword").value = "";
		document.getElementById("txtNewPassword").focus();
		return false;
	}	

return true;
}
