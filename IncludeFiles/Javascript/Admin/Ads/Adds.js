
/////////////////////////////////////////////////////////////////////
////////////////////// Not Null Checks /////////////////////////////
/////////////////////////////////////////////////////////////////////

function ValidateForm()
{

// Email

	if(document.getElementById("txtAdsName").value=='')
	{
		alert("Please enter Add name");
		document.getElementById("txtAdsName").focus();
		return false;
	}
/*	if(document.getElementById("cmbYear").value=='')
	{
		alert("Please enter year");
		document.getElementById("cmbYear").focus();
		return false;
	}*/
	if(document.getElementById("txtAdsDescription").value=='')
	{
		alert("Please enter Add description");
		document.getElementById("txtAdsDescription").focus();
		return false;
	}
	
/*	if(document.getElementById("txtAdsImgage").value!="")
	{
	
		if(!chkExt(document.getElementById("txtAdsImgage").value))
		{

			document.getElementById("txtAdsImgage").focus();
			document.getElementById("txtAdsImgage").select();
			return false;
		}
		
	}
	
	
	if(document.getElementById("txtAdsImgage").value=='')
	{
		alert("Please select image");
		document.getElementById("txtAdsImgage").focus();

		return false;
	}*/
	
	var chkStatus=0;
	for(var p=0;p<document.frmAddAds.chkPage.length;p++)
	{
		
		if(document.frmAddAds.chkPage[p].checked)
		chkStatus=1;
	}
	
	if(!chkStatus)
	{
		alert("Please select file");
		document.getElementById("chkPage").focus();
		return false;
	}
	
	// Year is Numeric
	if(!isValidNumeric(document.frmAddAds.cmbYear.value,"Year"))
	{
	document.frmAddAds.cmbYear.focus();
	document.frmAddAds.cmbYear.select();		
	return false;
	}
return true;
}

function EditValidateForm()
{

// Email

	if(document.getElementById("txtAdsName").value=='')
	{
		alert("Please enter Add name");
		document.getElementById("txtAdsName").focus();
		return false;
	}
/*	if(document.getElementById("cmbYear").value=='')
	{
		alert("Please enter year");
		document.getElementById("cmbYear").focus();
		return false;
	}
	*/
	if(document.getElementById("txtAdsDescription").value=='')
	{
		alert("Please enter Add description");
		document.getElementById("txtAdsDescription").focus();
		return false;
	}

/*	if(document.getElementById("chkPage").value=='')
	{
		alert("Please select file");
		document.getElementById("chkPage").focus();
		return false;
	}
	
	if(document.getElementById("txtAdsImgage").value!="")
	{
	
		if(!chkExt(document.getElementById("txtAdsImgage").value))
		{

			document.getElementById("txtAdsImgage").focus();
			document.getElementById("txtAdsImgage").select();
			return false;
		}
	}
*/
	var chkStatus=0;
	for(var p=0;p<document.frmEditAds.chkPage.length;p++)
	{
		
		if(document.frmEditAds.chkPage[p].checked)
		chkStatus=1;
	}
	
	if(!chkStatus)
	{
		alert("Please select file");
		document.getElementById("chkPage").focus();
		return false;
	}


	// Year is Numeric
	if(!isValidNumeric(document.frmEditAds.cmbYear.value,"Year"))
	{
		document.frmEditAds.cmbYear.focus();
		document.frmEditAds.cmbYear.select();		
		return false;
	}
	
return true;
}


function chkExt(str)
{


var extArray= new Array();
extArray[0]="jpg";
extArray[1]="bmp";
extArray[2]="gif";
extArray[3]="png";

var chkExt=0;
	var strExt=str.substr(str.length-3,str.length-(str.length-3));

		for(var i=0;i<extArray.length;i++)
		{
			if(strExt.toLowerCase()==extArray[i])
			{
			chkExt=1;
			}
			
		}
		if(chkExt==0)
		{
			alert("Only .JPG, .GIF, .BMP, .PNG file extensions are supported!");
			return false;
		}
		return true;
}