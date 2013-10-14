
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateFormLogin()
{
// Email
	if(trim(document.getElementById("txtEmail").value)=='')
	{
		alert("Please enter UserName Address");
		document.getElementById("txtEmail").focus();
		return false;
	}

// Password
	if(trim(document.getElementById("txtPassword").value)=='')
	{
		alert("Please enter Password");
		document.getElementById("txtPassword").focus();
		return false;
	}
// Email Check Valid
	if(!checkEmailAddress(document.getElementById("txtEmail").value))
	{
		document.getElementById("txtEmail").focus();
		document.getElementById("txtEmail").select();		
		return false;
	}
// Password 
	if(!isValidPassword(document.getElementById("txtPassword").value,'Password'))
	{
		document.getElementById("txtPassword").focus();
		document.getElementById("txtPassword").select();		
		return false;
	}
	
return true;
}