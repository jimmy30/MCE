
var waitWin;
function decode(str) 
{
    return unescape(str.replace(/\+/g, " "));
}




function ShowWaitDlg()
{
	var url = "/IncludeFiles/" + strSkin + "/HTML/ProgressBar.html";
	var attr = "dialogHeight:120px;dialogWidth:300px;status:no;help:no;resizable:yes;";
	waitWin = window.showModelessDialog(url, "Wait",attr);
}


function OpenWindow(pUrl)
{
	alert(pUrl);
	
	//strUrl=''+pUrl + '';
	//alert(strUrl);
	window.open('a.htm', 'dummyname', 'height=480,width=640', false);
	//window.open ("http://www.yahoo.com","mywindow");
	 alert("I am called");
	//myRef = window.open(strUrl,'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0');
	//window.open(pUrl,'mywindow','width=400,height=200') 
	return false;
}

function URLencode(strUrl) 
{
	return escape(strUrl);
/*    return escape(strUrl).
				replace(/\+/g, '%2B').
					replace(/\"/g,'%22').
						replace(/\'/g, '%27').
							replace(/\//g,'%2F');*/
 }
 
 function encode(str) 
 {
	/* alert(str)
	var result = "";
	
	for (i = 0; i < str.length; i++) 
	{
		if (str.charAt(i) == " ") result += "+";
		else result += str.charAt(i);
	}*/
 }
