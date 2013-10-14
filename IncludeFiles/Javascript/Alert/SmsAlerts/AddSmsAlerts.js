
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){
// Counry Name
	if(!(document.frmAddSmsAlert.rdoCountry[0].checked || document.frmAddSmsAlert.rdoCountry[1].checked))
	{
		alert("Please select counrty");
		document.frmAddSmsAlert.rdoCountry[0].focus();
		return false;
	}

	if(!(document.frmAddSmsAlert.chkAdd.checked || document.frmAddSmsAlert.chkModify.checked))
	{
		alert("Please specify action");
		document.frmAddSmsAlert.chkAdd.focus();
		return false;
	}
	if(!(document.frmAddSmsAlert.rdoStatus[0].checked || document.frmAddSmsAlert.rdoStatus[1].checked))
	{
		alert("Please select status");
		document.frmAddSmsAlert.rdoStatus[0].focus();
		return false;
	}

return true;
}
function chhCountry(chk)
{
	if(chk==-1)
		document.frmAddSmsAlert.cmbCountryRegion.disabled = true;
	else if(chk==0)
		document.frmAddSmsAlert.cmbCountryRegion.disabled = false;	
}
