
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){
// Counry Name
	if(!(document.frmEditSmsAlert.rdoCountry[0].checked || document.frmEditSmsAlert.rdoCountry[1].checked))
	{
		alert("Please select counrty");
		document.frmEditSmsAlert.rdoCountry[0].focus();
		return false;
	}

	if(!(document.frmEditSmsAlert.chkAdd.checked || document.frmEditSmsAlert.chkModify.checked))
	{
		alert("Please specify action");
		document.frmEditSmsAlert.chkAdd.focus();
		return false;
	}
	if(!(document.frmEditSmsAlert.rdoStatus[0].checked || document.frmEditSmsAlert.rdoStatus[1].checked))
	{
		alert("Please select status");
		document.frmEditSmsAlert.rdoStatus[0].focus();
		return false;
	}

return true;
}
function chhCountry(chk)
{
	if(chk==-1)
		document.frmEditSmsAlert.cmbCountryRegion.disabled = true;
	else if(chk==0)
		document.frmEditSmsAlert.cmbCountryRegion.disabled = false;	
}
