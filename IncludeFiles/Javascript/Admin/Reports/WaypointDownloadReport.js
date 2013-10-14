
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm()
{
	
// Day From Date
	if(document.getElementById("cmbFromDay").value==0)
	{
		alert("Please Select From Date Properly");
		document.getElementById("cmbFromDay").focus();
		return false;
	}

// Month From Date
	if(document.getElementById("cmbFromMonth").value==0)
	{
		alert("Please Select From Date Properly");
		document.getElementById("cmbFromMonth").focus();
		return false;
	}

// Year From Date
	if(document.getElementById("txtFromYear").value=='' || document.getElementById("txtFromYear").value=='[Year]')
	{
		alert("Please enter From Date Properly");
		document.getElementById("txtFromYear").focus();
		return false;
	}

// Day To Date
	if(document.getElementById("cmbToDay").value==0)
	{
		alert("Please Select To Date Properly");
		document.getElementById("cmbToDay").focus();
		return false;
	}

// Month To Date
	if(document.getElementById("cmbToMonth").value==0)
	{
		alert("Please Select To Date Properly");
		document.getElementById("cmbToMonth").focus();
		return false;
	}

// Year To Date
	if(document.getElementById("txtToYear").value=='' || document.getElementById("txtToYear").value=='[Year]')
	{
		alert("Please enter To Date Properly");
		document.getElementById("txtToYear").focus();
		return false;
	}

// Year is valid check
	var today = new Date();
	if((document.getElementById("txtFromYear").value < 1900 || document.getElementById("txtFromYear").value > today.getFullYear()))
	{
		alert("Invalid Year");
		document.getElementById("txtFromYear").focus();
		document.getElementById("txtFromYear").select();		
		return false;
	}

// Year is valid check
	var today = new Date();
	if((document.getElementById("txtToYear").value < 1900 || document.getElementById("txtToYear").value > today.getFullYear()))
	{
		alert("Invalid Year");
		document.getElementById("txtToYear").focus();
		document.getElementById("txtToYear").select();		
		return false;
	}


return true;
}
