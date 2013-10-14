var MAX_TEXT_RESULTS=10;
var MAX_TEXT_RESULTS_LIMIT=1000; 
var MAX_TEXT_TITLE_LENGTH=15; 

function getTextResults(pStartIndex)
{
	document.getElementById("loading").style.display = 'inline';			
	document.getElementById("focus").focus();	
	
	var strSearchEngines="YAHOO";
	var intStartIndex=pStartIndex;
	//var intNumberOfRecords=10;
		var xmlhttp = GetHttpRequestObject();
		try
		{	
			var url="SearchService/TextXml.php?Query=" +document.getElementById("txtSearch").value+"&StartIndex="+intStartIndex+"&NoOfResults="+MAX_TEXT_RESULTS+"&SearchEngines="+strSearchEngines ;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange=function() 
			{
				if (xmlhttp.readyState==4) 
			 	{
				   	var reply = xmlhttp.responseText;

					tempValid = true
					
					XmlParseTextData(reply);
	  			}		
			}
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  
			xmlhttp.send(null);
			return "abc";
			
		}
		catch(e)
		{
			alert(e.description);
		}
		
	
}

function XmlParseTextData(XMLstr)
{
	
	var rootNode = "";
	var intNoOfRecords="";
	var strUrl;
	var strUrlToShow;
	var strTitle;
	var strSummary; 
	var strSearchEngine="";
	var intNoOfCols=8;
	var intMaxSummaryLength=200;
	var intMaxUrlLength=60;
	
	// Caching Variables 
	var strOldString=""; 
	var intStart=0;
	var intEnd=0;

	
	var strHtml="<table cellspacing=0 cellpadding=0 border=0><tr><td height=10></tr>";

	if (window.ActiveXObject)
	{
		var XMLDoc =new ActiveXObject("Microsoft.XMLDOM");
		try 
		{	
			XMLDoc.async = "false";
			
			if(XMLDoc.loadXML(XMLstr)==true)
			{
				rootNode=XMLDoc.documentElement;
				intNoOfRecords=rootNode.selectSingleNode("TotalResult").text;
				if (intNoOfRecords>0)
				{
						
				
						for(i=0;i< intNoOfRecords;i++)	
						{
							
							strTitle=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(0).text;
							strSummary=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(1).text;
							strSummary=strSummary.substring(0,intMaxSummaryLength);
												
							strUrl=decode(rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(2).text);
							strHtml=strHtml+"<tr><td width=5></td><td align=right class='RegistrationBodyText'><b>Title:</b></td><td width=5></td>"+ "<td align=left><font size=2 face='arial'>" +strTitle + "</font></td></tr>";				
							strHtml=strHtml+"<tr><td></td><td align=right valign=top class='RegistrationBodyText'><b>Summary:</b></td><td width=5></td>"+ "<td align=left><font size=2 face='arial'>" +strSummary + "</font></td></tr>";				
							
							//strHtml=strHtml+"<tr><td></td><td align=right><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a onclick=OpenWindow('" + strUrl+"') href=" +strUrl +" >"+ strUrl+ "</a></td></tr>";				
								
							if (strUrl.length<intMaxUrlLength)
							{
								strUrlToShow= strUrl;
							}
							else
							{
								strUrlToShow= strUrl.substring(0,intMaxUrlLength)+"......";
							}
//							strUrl="http://"+strUrl;					
							//strHtml=strHtml+"<tr><td></td><td align=right><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a onclick=\"return OpenWindow('" + strUrl+"')\" href="+strUrl+">"+ strUrlToShow+ "</a></td></tr>";				
							strHtml=strHtml+"<tr><td></td><td align=right class='RegistrationBodyText'><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a href="+strUrl+" target='blank'>"+ strUrlToShow+ "</a></td></tr>";				
							strHtml=strHtml+"<tr><td colspan=2 height=15></td></tr>";

	
						}
					
						if (parseInt(document.getElementById("hdnTextStartIndex").value)>1)
						strHtml=strHtml+"<tr><td colspan=4 height=30 align=right><a href='#' onClick='javascript:return getPreviousTextResults()' class='LinkSmall'>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextTextResults()' class='LinkSmall'>Next</a></td></tr> ";
						else
						strHtml=strHtml+"<tr><td colspan=4 height=30 align=right><a href='#' onClick='javascript:return getPreviousTextResults()' class='LinkSmall' disabled>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextTextResults()' class='LinkSmall'>Next</a></td></tr> ";
						strHtml=strHtml+"</table>";
						document.getElementById("divResults").style.visibility="visible";
						document.getElementById("divResults").innerHTML=strHtml;
					
					
				}
				else
				{
					document.getElementById("divResults").style.visibility="visible";
					document.getElementById("divResults").innerHTML="<div class='RegistrationBodyText' align='center'><b>No Result Found</b></div><br>";
				}
				document.getElementById("loading").style.display="none";
			}
		}
		catch(e)
		{
			//showSearchResultsError("Sorry, we was not able to complete your request","ERROR");
		}
	}
	
	// firefox
	else
	{
		var XMLDoc =  new DOMParser();
		try 
		{	
			XMLDoc.async = "false";
			var xmlDocoment = XMLDoc.parseFromString(XMLstr, "application/xml");
			var strSearchResults = xmlDocoment.getElementsByTagName('SearchResults');
			intNoOfRecords=strSearchResults[0].getElementsByTagName('TotalResult')[0].textContent;		
				if (intNoOfRecords>0)
				{
					for(i=0;i< intNoOfRecords;i++)	
					{
						var strResult = xmlDocoment.getElementsByTagName('Result');
						strTitle=strResult[i].getElementsByTagName('Title')[0].textContent;
						strSummary=strResult[i].getElementsByTagName('Summary')[0].textContent;
						strSummary=strSummary.substring(0,intMaxSummaryLength);
						strUrl=decode(strResult[i].getElementsByTagName('Url')[0].textContent);
						strSearchEngine=strResult[i].getElementsByTagName('SearchEngine')[0].textContent;		
						strHtml=strHtml+"<tr><td width=5></td><td align=right><b>Title:</b></td><td width=5></td>"+ "<td align=left>" +strTitle + "</td></tr>";				
						strHtml=strHtml+"<tr><td></td><td align=right valign=top><b>Summary:</b></td><td width=5></td>"+ "<td align=left>" +strSummary + "</td></tr>";				
						//strHtml=strHtml+"<tr><td></td><td align=right><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a onclick=OpenWindow('" + strUrl+"') href=" +strUrl +" >"+ strUrl+ "</a></td></tr>";				
		
						if (strUrl.length<intMaxUrlLength)
						{
							strUrlToShow= strUrl;
						}
						else
						{
							strUrlToShow= strUrl.substring(0,intMaxUrlLength)+"......";
						}
						//strHtml=strHtml+"<tr><td></td><td align=right><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a onclick=\"return OpenWindow('" + strUrl+"')\" href="+strUrl+">"+ strUrlToShow+ "</a></td></tr>";				
						strHtml=strHtml+"<tr><td></td><td align=right><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a href="+strUrl+" target='blank'>"+ strUrlToShow+ "</a></td></tr>";			
						strHtml=strHtml+"<tr><td colspan=2 height=15></td></tr>";
					}
					if (parseInt(document.getElementById("hdnTextStartIndex").value)>1)
					{
						strHtml=strHtml+"<tr><td colspan=4 height=30 align=right><a href='#' onClick='javascript:return getPreviousTextResults()' class='LinkSmall'>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextTextResults()' class='LinkSmall'>Next</a></td></tr> ";
					}
					else
					{
						strHtml=strHtml+"<tr><td colspan=4 height=30 align=right><a href='#' onClick='javascript:return getPreviousTextResults()' class='LinkSmall' disabled>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextTextResults()' class='LinkSmall'>Next</a></td></tr> ";
					}
					strHtml=strHtml+"</table>";
					document.getElementById("divResults").style.visibility="visible";
					document.getElementById("divResults").innerHTML=strHtml;
				}
				else
				{
					document.getElementById("divResults").style.visibility="visible";
					document.getElementById("divResults").innerHTML="&nbsp;<b>No Result Found</b>";
				}
			
				
		}
		
		catch(e)
		{
			//showSearchResultsError("Sorry, we was not able to complete your request","ERROR");
		}		
		
	}
	

}			

function getPreviousTextResults(pStartIndex)
{
	
	if (parseInt(document.getElementById("hdnTextStartIndex").value)>1)
	{
		document.getElementById("hdnTextStartIndex").value=(parseInt(document.getElementById("hdnTextStartIndex").value)-MAX_TEXT_RESULTS);
		getTextResults(parseInt(document.getElementById("hdnTextStartIndex").value));
	}
	else
	{
		//-TODO DISABLE PREVIOUS lINK 
	}	
	return false;
}

function getNextTextResults(pStartIndex)
{
	document.getElementById("hdnTextStartIndex").value=(parseInt(document.getElementById("hdnTextStartIndex").value)+MAX_TEXT_RESULTS);
	getTextResults(parseInt(document.getElementById("hdnTextStartIndex").value));
	return false;
}

function GetHttpRequestObject()
{ 
	var objXMLHttp=null;
	if (window.XMLHttpRequest)
	{
		objXMLHttp = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objXMLHttp;
} 
