
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm(){
// Counry Name
	if(!(document.frmEditConsumerAlert.rdoCountry[0].checked || document.frmEditConsumerAlert.rdoCountry[1].checked))
	{
		alert("Please select counrty");
		document.frmEditConsumerAlert.rdoCountry[0].focus();
		return false;
	}

	if(!(document.frmEditConsumerAlert.chkAdd.checked || document.frmEditConsumerAlert.chkModify.checked))
	{
		alert("Please specify action");
		document.frmEditConsumerAlert.chkAdd.focus();
		return false;
	}
	if(!(document.frmEditConsumerAlert.rdoStatus[0].checked || document.frmEditConsumerAlert.rdoStatus[1].checked))
	{
		alert("Please select status");
		document.frmEditConsumerAlert.rdoStatus[0].focus();
		return false;
	}

return true;
}
function chhCountry(chk)
{
	if(chk==-1)
		document.frmEditConsumerAlert.cmbCountryRegion.disabled = true;
	else if(chk==0)
		document.frmEditConsumerAlert.cmbCountryRegion.disabled = false;	
}
