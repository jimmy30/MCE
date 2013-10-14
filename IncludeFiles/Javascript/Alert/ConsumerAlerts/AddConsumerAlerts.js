
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){
// Counry Name
	if(!(document.frmAddConsumerAlert.rdoCountry[0].checked || document.frmAddConsumerAlert.rdoCountry[1].checked))
	{
		alert("Please select counrty");
		document.frmAddConsumerAlert.rdoCountry[0].focus();
		return false;
	}

	if(!(document.frmAddConsumerAlert.chkAdd.checked || document.frmAddConsumerAlert.chkModify.checked))
	{
		alert("Please specify action");
		document.frmAddConsumerAlert.chkAdd.focus();
		return false;
	}
	if(!(document.frmAddConsumerAlert.rdoStatus[0].checked || document.frmAddConsumerAlert.rdoStatus[1].checked))
	{
		alert("Please select status");
		document.frmAddConsumerAlert.rdoStatus[0].focus();
		return false;
	}

return true;
}
function chhCountry(chk)
{
	if(chk==-1)
		document.frmAddConsumerAlert.cmbCountryRegion.disabled = true;
	else if(chk==0)
		document.frmAddConsumerAlert.cmbCountryRegion.disabled = false;	
}
