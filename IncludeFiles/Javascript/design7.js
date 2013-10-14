////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//CONSTANTS 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var MAX_IMAGE_RESULTS=10; 
var MAX_TEXT_RESULTS=10;
var MAX_AUDIO_RESULTS=10;
var MAX_VIDEO_RESULTS=10;


var MAX_IMAGE_RESULTS_LIMIT=1000; 
var MAX_TEXT_RESULTS_LIMIT=1000; 
var MAX_AUDIO_RESULTS_LIMIT=1000; 
var MAX_VIDEO_RESULTS_LIMIT=1000; 


var MAX_IMAGE_TITLE_LENGTH=15; 
var MAX_AUDIO_TITLE_LENGTH=15; 
var MAX_VIDEO_TITLE_LENGTH=15; 

var WARNING_IMAGE_PATH="/ImageFiles/Common/Warning.gif";
var TOOLTIP_SPECIAL_CHARACTERS="'";
var intStatus=0;
var intSearchStatus=0;
var intSettingStatus=0;

//Image Tags 
var IMAGE_START_TAG="[IMAGE_START_TAG]";
var IMAGE_END_TAG="[/IMAGE_END_TAG]"; 
var IMAGE_START_PAGE_TAG="[IMAGE_START_PAGE_TAG]";
var IMAGE_END_PAGE_TAG="[/IMAGE_END_PAGE_TAG]";
var IMAGE_START_QUERY_TAG="[IMAGE_START_QUERY_TAG]";
var IMAGE_END_QUERY_TAG="[/IMAGE_END_QUERY_TAG]";
var IMAGE_START_SEARCHENGINES_TAG="[IMAGE_START_SEARCHENGINES_TAG]";
var IMAGE_END_SEARCHENGINES_TAG="[/IMAGE_END_SEARCHENGINES_TAG]";
var IMAGE_START_CONTENTTYPES_TAG="[IMAGE_START_CONTENTTYPES_TAG]";
var IMAGE_END_CONTENTTYPES_TAG="[/IMAGE_END_CONTENTTYPES_TAG]";


//Text Tags 
var TEXT_START_TAG="[TEXT_START_TAG]";
var TEXT_END_TAG="[/TEXT_END_TAG]"; 
var TEXT_START_PAGE_TAG="[TEXT_START_PAGE_TAG]";
var TEXT_END_PAGE_TAG="[/TEXT_END_PAGE_TAG]";
var TEXT_START_QUERY_TAG="[TEXT_START_QUERY_TAG]";
var TEXT_END_QUERY_TAG="[/TEXT_END_QUERY_TAG]";
var TEXT_START_SEARCHENGINES_TAG="[TEXT_START_SEARCHENGINES_TAG]";
var TEXT_END_SEARCHENGINES_TAG="[/TEXT_END_SEARCHENGINES_TAG]";


//VIDEO Tags 
var VIDEO_START_TAG="[VIDEO_START_TAG]";
var VIDEO_END_TAG="[/VIDEO_END_TAG]"; 
var VIDEO_START_PAGE_TAG="[VIDEO_START_PAGE_TAG]";
var VIDEO_END_PAGE_TAG="[/VIDEO_END_PAGE_TAG]";
var VIDEO_START_QUERY_TAG="[VIDEO_START_QUERY_TAG]";
var VIDEO_END_QUERY_TAG="[/VIDEO_END_QUERY_TAG]";
var VIDEO_START_SEARCHENGINES_TAG="[VIDEO_START_SEARCHENGINES_TAG]";
var VIDEO_END_SEARCHENGINES_TAG="[/VIDEO_END_SEARCHENGINES_TAG]";


//AUDIO Tags 
var AUDIO_START_TAG="[AUDIO_START_TAG]";
var AUDIO_END_TAG="[/AUDIO_END_TAG]"; 
var AUDIO_START_PAGE_TAG="[AUDIO_START_PAGE_TAG]";
var AUDIO_END_PAGE_TAG="[/AUDIO_END_PAGE_TAG]";
var AUDIO_START_QUERY_TAG="[AUDIO_START_QUERY_TAG]";
var AUDIO_END_QUERY_TAG="[/AUDIO_END_QUERY_TAG]";
var AUDIO_START_SEARCHENGINES_TAG="[AUDIO_START_SEARCHENGINES_TAG]";
var AUDIO_END_SEARCHENGINES_TAG="[/AUDIO_END_SEARCHENGINES_TAG]";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//GLOBAL VARIABLE 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
var SELECTED_SEARCH_TAB="IMAGE"; 
var G_PLAYER_WINDOW_HANDLE=""; 


/*******************************************************************************************************************
Name				: openAudioPlayer()
Description			: 
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	19-06-2006       1.00
*********************************************************************************************************************/
function openAudioPlayer(pUrl)
{
	
	///alert(detectReal());
	
	// Window Player 
	/*
	var strHTML=" <HTML>"; 
	strHTML=strHTML + " <HEAD>";
	strHTML=strHTML + " <TITLE>Embedded Windows Media Player 6.4 Control</TITLE> ";
	strHTML=strHTML + " </HEAD>";
	strHTML=strHTML + " <BODY>";
	strHTML=strHTML + " <OBJECT ID='MediaPlayer' WIDTH=320 HEIGHT=240 "; 
	strHTML=strHTML + "	CLASSID='CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95' ";

	strHTML=strHTML + " STANDBY='Loading Windows Media Player components...'";	
	strHTML=strHTML + " TYPE='application/x-oleobject' ";
	strHTML=strHTML + " CODEBASE='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112'>";
	strHTML=strHTML + " <PARAM name='autoStart' value='True'> ";
	strHTML=strHTML + " <PARAM name='filename' value='" + pUrl +"'>";	
	strHTML=strHTML + " <PARAM name='ShowControls' value='true'";	
	strHTML=strHTML + " <EMBED TYPE='application/x-mplayer2'";
	strHTML=strHTML + " SRC='" + pUrl +"'" ;
	strHTML=strHTML + " NAME='MediaPlayer' ";
	strHTML=strHTML + " WIDTH=320";
	strHTML=strHTML + " HEIGHT=240>" ;
	strHTML=strHTML + " </EMBED>";
	strHTML=strHTML + " </OBJECT>";
	strHTML=strHTML + " </BODY>";
	strHTML=strHTML + " </HTML>";
	*/

	
	// Real Player
	
	/*
	var strHTML=" <HTML>"; 
	strHTML=strHTML + " <HEAD>";
	strHTML=strHTML + " <TITLE></TITLE> ";
	strHTML=strHTML + " </HEAD>";
	strHTML=strHTML + " <BODY>";
	
	strHTML=strHTML + " <OBJECT ID=RVOCX CLASSID ='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' WIDTH='320' HEIGHT='240'>";
	strHTML=strHTML + " <PARAM name='src' value='" + pUrl + "'>";
	strHTML=strHTML + " <PARAM name='autostart' value='true'>";
	strHTML=strHTML + " <PARAM name='controls' value='all'>";
	strHTML=strHTML + " <PARAM name='console' value='video'>";
	strHTML=strHTML + " <EMBED TYPE='audio/x-pn-realaudio-plugin'";
	strHTML=strHTML + " SRC='"+ pUrl + "'";
	strHTML=strHTML + " WIDTH='390'";
	strHTML=strHTML + " HEIGHT='200'";
	strHTML=strHTML + " AUTOSTART='true'";
	strHTML=strHTML + " CONTROLS='imagewindow'";
	strHTML=strHTML + " CONSOLE='video'>";
	strHTML=strHTML + " </EMBED>";
	strHTML=strHTML + " </OBJECT>";
	strHTML=strHTML + " </BODY>";
	strHTML=strHTML + " </HTML>";
	*/
	
	/*
	var strHTML=""; 
	strHTML=strHTML + " <object id='myMovie' classid='CLSID:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' height='250' width='540'>";
	strHTML=strHTML + " <param name='controls' value='ImageWindow'>";
	strHTML=strHTML + " <param name='console' value='_master'>";
	strHTML=strHTML + " <param name='center' value='true'>";
	strHTML=strHTML + " <embed name='myMovie' src='http://realmedia.uic.edu/ramgen/itltv/bbintro.30jan02.smil?embed' height='250' width='540' nojava='true' controls='ImageWindow' console='_master' center='true' pluginspage='http://www.real.com/'></embed>";
	strHTML=strHTML + "</object>";

	strHTML=strHTML + "<br>";

	strHTML=strHTML + " <object id='myMovie' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='540' height='100'>";
	strHTML=strHTML + " <param name='src' value='rtsp://realmedia.uic.edu/itltv/bbintro.30jan02.smil'>";
	strHTML=strHTML + " <param name='console' value='video1'>";
	strHTML=strHTML + " <param name='controls' value='All'>";
	strHTML=strHTML + " <param name='autostart' value='false'>";
	strHTML=strHTML + " <param name='loop' value='false'>";
	strHTML=strHTML + " <embed name='myMovie' src='http://realmedia.uic.edu/ramgen/itltv/bbintro.30jan02.smil?embed' height='100' width='540' autostart='false' loop='false' nojava='true' console='video1' controls='All'></embed>";
	strHTML=strHTML + " <noembed><a href='http://realmedia.uic.edu/ramgen/itltv/bbintro.30jan02.smil'>Play first clip</a></noembed>";
	strHTML=strHTML + " </object>";

	strHTML=strHTML + " <br>";
	
	strHTML=strHTML + " <object id='myMovie' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='540' height='36'>";
	strHTML=strHTML + " <param name= 'src' value='rtsp://realmedia.uic.edu/itltv/bbtips.6feb02.smi'>";
	strHTML=strHTML + " <param name='console' value='video2'>";
	strHTML=strHTML + " <param name='controls' value='ControlPanel'>";
	strHTML=strHTML + " <param name='autostart' value='false'>";
	strHTML=strHTML + " <param name='loop' value='false'>";
	strHTML=strHTML + " <embed name='myMovie' src='http://realmedia.uic.edu/ramgen/itltv/bbtips.6feb02.smi?embed' height='36' width='540' autostart='false' loop='false' nojava='true' console='video2' controls='ControlPanel'></embed>";
	strHTML=strHTML + "<noembed><a href='http://realmedia.uic.edu/ramgen/itltv/bbtips.6feb02.smi'>Play second clip</a></noembed>";
	strHTML=strHTML	+ "</object>";
	
	*/



	/*
	var strHTML=""; 
	strHTML=strHTML + " <object id='myMovie' classid='CLSID:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' height='250' width='540'>";
	strHTML=strHTML + " <param name='controls' value='ImageWindow'>";
	strHTML=strHTML + " <param name='console' value='_master'>";
	strHTML=strHTML + " <param name='center' value='true'>";
	//strHTML=strHTML + " <param name='autostart' value='true'>";
	strHTML=strHTML + " <embed name='myMovie' src='" + pUrl+ "' height='250' width='540' nojava='true' controls='ImageWindow' console='_master' center='true' pluginspage='http://www.real.com/'></embed>";
	strHTML=strHTML + "</object>";

	strHTML=strHTML + "<br>";

	strHTML=strHTML + " <object id='myMovie' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='540' height='100'>";
	strHTML=strHTML + " <param name='src' value='"+ pUrl +"'>";
	strHTML=strHTML + " <param name='console' value='video1'>";
	strHTML=strHTML + " <param name='controls' value='All'>";
	strHTML=strHTML + " <param name='autostart' value='true'>";
	strHTML=strHTML + " <param name='loop' value='false'>";
	strHTML=strHTML + " <embed name='myMovie' src='" + pUrl + "' height='100' width='540' autostart='false' loop='false' nojava='true' console='video1' controls='All'></embed>";
	strHTML=strHTML + " <noembed><a href='http://realmedia.uic.edu/ramgen/itltv/bbintro.30jan02.smil'>Play first clip</a></noembed>";
	strHTML=strHTML + " </object>";

	strHTML=strHTML + " <br>";
	
	strHTML=strHTML + " <object id='myMovie' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA' width='540' height='36'>";
	strHTML=strHTML + " <param name= 'src' value='" + pUrl+ "'>";
	strHTML=strHTML + " <param name='console' value='video2'>";
	strHTML=strHTML + " <param name='controls' value='ControlPanel'>";
	strHTML=strHTML + " <param name='autostart' value='true'>";
	strHTML=strHTML + " <param name='loop' value='false'>";
	strHTML=strHTML + " <embed name='myMovie' src='" + pUrl +  "' height='36' width='540' autostart='false' loop='false' nojava='true' console='video2' controls='ControlPanel'></embed>";
	strHTML=strHTML + "<noembed><a href='http://realmedia.uic.edu/ramgen/itltv/bbtips.6feb02.smi'>Play second clip</a></noembed>";
	strHTML=strHTML	+ "</object>";
	

	*/
	/*
	Dialog.alert(strHTML, 
				        {windowParameters: {width:600, height:450}, okLabel: "close", 
						    ok:function(win) {win.getElementById('MediaPlayer').controls.stop();}
						    });
	*/
	
	if (G_PLAYER_WINDOW_HANDLE=="")
	{
		if (detectReal()==true)
		{
			G_PLAYER_WINDOW_HANDLE= window.open ("RealPlayer.php?Url=" + pUrl, "mywindow","location=0,status=0,scrollbars=0,width=600,height=425");
		}
		else
		{
			G_PLAYER_WINDOW_HANDLE= window.open ("MediaPlayer.php?Url=" + pUrl, "mywindow","location=0,status=0,scrollbars=0,width=400,height=300");
			
		}	
	}	
	else
	{
		G_PLAYER_WINDOW_HANDLE.close();
		if (detectReal()==true)
		{
			G_PLAYER_WINDOW_HANDLE= window.open ("RealPlayer.php?Url=" + pUrl, "mywindow","location=0,status=0,scrollbars=0,width=600,height=425");
		}
		else
		{
			G_PLAYER_WINDOW_HANDLE= window.open ("MediaPlayer.php?Url=" + pUrl, "mywindow","location=0,status=0,scrollbars=0,width=400,height=300");
			
		}	
		
	}	

	
	/*
		var win = new Window('modal_window', {className: "dialog", title: "Ruby on Rails",top:100, left:100,  width:
		400, height:400, zIndex:150, opacity:1, resizable: true})
		win.getContent().innerHTML = strHTML;
		win.setDestroyOnClose();
		win.show();	
	*/	
	return false;
}

/*******************************************************************************************************************
Name				: OpenGoogleMapDialog()
Description			: 
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	06-06-2006       1.00
*********************************************************************************************************************/
function OpenGoogleMapDialog()
{
	OpenGoogleAlertDialog("");
}

function OpenGoogleAlertDialog(XMLstr) 
{
		
		//var strHTML=" <img src='ImageFiles/Common/Google_Map.JPG' width=380 height=340> "; 
		javascript:dlg.show();
		loadMap();
		/*
		Dialog.alert(strHTML, 
				        {windowParameters: {width:400, height:400}, okLabel: "close", 
						    ok:function(win) {debug("validate alert panel")}
						    });
		
		*/
}
function EnableDisableSearchEng()
{
	// 	Image
	if(document.getElementById('chkImage').checked==true && document.getElementById('chkText').checked==false && document.getElementById('chkAudio').checked==false && document.getElementById('chkVideo').checked==false)
	{

		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="IMAGE" 
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=true 
			document.getElementById('chkGrouper').checked=false
			
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=true; 
			document.getElementById('hplAudio').disabled=true; 
			document.getElementById('hplVideo').disabled=true;
			
			ShowSearchResults();

		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=true 
			document.getElementById('chkGrouper').checked=false
		}
	}	
	// Text
	else if(document.getElementById('chkImage').checked==false && document.getElementById('chkText').checked==true && document.getElementById('chkAudio').checked==false && document.getElementById('chkVideo').checked==false)
	{
		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=false
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=false 
			document.getElementById('chkGrouper').checked=false

			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			document.getElementById('hplVideo').disabled=true;
			SELECTED_SEARCH_TAB="TEXT"

			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=false
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=false 
			document.getElementById('chkGrouper').checked=false
		}
	}
	// Audio
	else if(document.getElementById('chkImage').checked==false && document.getElementById('chkText').checked==false && document.getElementById('chkAudio').checked==true && document.getElementById('chkVideo').checked==false)
	{
	
		
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="AUDIO"
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=false 
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=true; 
			document.getElementById('hplAudio').disabled=false; 
			document.getElementById('hplVideo').disabled=true;
			ShowSearchResults();
		}
		else
		{	
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=false 
			document.getElementById('chkGrouper').checked=false
			
		}
		
				
	}
	// Video
	else if(document.getElementById('chkImage').checked==false && document.getElementById('chkText').checked==false && document.getElementById('chkAudio').checked==false && document.getElementById('chkVideo').checked==true)
	{
		
		
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="VIDEO"
			changeSearchResultTab('VIDEO');
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=false 
			document.getElementById('chkGrouper').checked=true
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=true; 
			document.getElementById('hplAudio').disabled=true; 
			document.getElementById('hplVideo').disabled=false;
			
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=false 
			document.getElementById('chkGrouper').checked=true
		}
	}
	// Image, Text
	else if(document.getElementById('chkImage').checked==true && document.getElementById('chkText').checked==true && document.getElementById('chkAudio').checked==false && document.getElementById('chkVideo').checked==false)
	{
		
		if(document.getElementById("txtQuery").value!="")
		{
			
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=true 
			document.getElementById('chkGrouper').checked=false
			
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			document.getElementById('hplVideo').disabled=true;
			SELECTED_SEARCH_TAB="IMAGE" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=true 
			document.getElementById('chkGrouper').checked=false
		}
	}
	// Image, Audio
	else if(document.getElementById('chkImage').checked==true && document.getElementById('chkText').checked==false && document.getElementById('chkAudio').checked==true && document.getElementById('chkVideo').checked==false)
	{
		

		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=true; 
			document.getElementById('hplAudio').disabled=false; 
			document.getElementById('hplVideo').disabled=true;
			SELECTED_SEARCH_TAB="IMAGE" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=false
		}
	}
	// Image, Video
	else if(document.getElementById('chkImage').checked==true && document.getElementById('chkText').checked==false && document.getElementById('chkAudio').checked==false && document.getElementById('chkVideo').checked==true)
	{
		
		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=true
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=true; 
			document.getElementById('hplAudio').disabled=true; 
			document.getElementById('hplVideo').disabled=false;
			SELECTED_SEARCH_TAB="IMAGE" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=true
		}
	}
	// Text, Audio
	else if(document.getElementById('chkImage').checked==false && document.getElementById('chkText').checked==true && document.getElementById('chkAudio').checked==true && document.getElementById('chkVideo').checked==false)
	{
		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			document.getElementById('hplVideo').disabled=true;
			SELECTED_SEARCH_TAB="TEXT" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=false
		}
				
	}
	// Text, Video
	else if(document.getElementById('chkImage').checked==false && document.getElementById('chkText').checked==true && document.getElementById('chkAudio').checked==false && document.getElementById('chkVideo').checked==true)
	{
		
		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=false
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			document.getElementById('hplVideo').disabled=false;
			SELECTED_SEARCH_TAB="TEXT" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=false
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=false
		}
	}
	// Audio, Video
	else if(document.getElementById('chkImage').checked==false && document.getElementById('chkText').checked==false && document.getElementById('chkAudio').checked==true && document.getElementById('chkVideo').checked==true)
	{
		
		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=true; 
			document.getElementById('hplAudio').disabled=false; 
			document.getElementById('hplVideo').disabled=false;
			SELECTED_SEARCH_TAB="AUDIO" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=false
		}
	}
	// Image, Text, Audio
	else if(document.getElementById('chkImage').checked==true && document.getElementById('chkText').checked==true && document.getElementById('chkAudio').checked==true && document.getElementById('chkVideo').checked==false)
	{
		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=true
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			document.getElementById('hplVideo').disabled=true;
			SELECTED_SEARCH_TAB="IMAGE" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=true
		}
	}
	// Image, Text, Video
	else if(document.getElementById('chkImage').checked==true && document.getElementById('chkText').checked==true && document.getElementById('chkAudio').checked==false && document.getElementById('chkVideo').checked==true)
	{
		if(document.getElementById("txtQuery").value!="")
		{

			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			document.getElementById('hplVideo').disabled=false;
			SELECTED_SEARCH_TAB="IMAGE" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=false
			
		}
	}
	// Image, Audio, Video
	else if(document.getElementById('chkImage').checked==true && document.getElementById('chkText').checked==false && document.getElementById('chkAudio').checked==true && document.getElementById('chkVideo').checked==true)
	{
		
		if(document.getElementById("txtQuery").value!="")
		{		
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=true; 
			document.getElementById('hplAudio').disabled=false; 
			document.getElementById('hplVideo').disabled=false;
			SELECTED_SEARCH_TAB="IMAGE" 	
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=false
			document.getElementById('chkMsn').checked=false
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=false
		}
	}
	// Text, Audio, Video
	else if(document.getElementById('chkImage').checked==false && document.getElementById('chkText').checked==true && document.getElementById('chkAudio').checked==true && document.getElementById('chkVideo').checked==true)
	{
		
		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			document.getElementById('hplVideo').disabled=false;
			SELECTED_SEARCH_TAB="TEXT" 	
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=false
			document.getElementById('chkGrouper').checked=false
		}
	}
	// Image, Text, Audio, Video
	else if(document.getElementById('chkImage').checked==true && document.getElementById('chkText').checked==true && document.getElementById('chkAudio').checked==true && document.getElementById('chkVideo').checked==true)
	{
		if(document.getElementById("txtQuery").value!="")
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=false
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			document.getElementById('hplVideo').disabled=false;
			SELECTED_SEARCH_TAB="IMAGE" 
			ShowSearchResults();
		}
		else
		{
			document.getElementById('chkYahoo').checked=true
			document.getElementById('chkGoogle').checked=true
			document.getElementById('chkMsn').checked=true
			document.getElementById('chkFlickr').checked=true
			document.getElementById('chkGrouper').checked=false
		}
	}

	else
	{
		document.getElementById('chkYahoo').checked=false
		document.getElementById('chkGoogle').checked=false
		document.getElementById('chkMsn').checked=false
		document.getElementById('chkFlickr').checked=false
		document.getElementById('chkGrouper').checked=false
	}

}
/*******************************************************************************************************************
Name				: ImageContentCheckBoxChange().
Description			: This function is called whenever user click on Image CheckBox
Input Parameters	: 
Returns				: string of all selected Search Engines
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	01-06-2006       1.00
*********************************************************************************************************************/
function ImageContentCheckBoxChange()
{

	EnableDisableSearchEng();
	if(document.getElementById("divSearchResults").style.visibility=="visible")
	{

		
			
			if (document.getElementById('chkImage').checked==true)
			{
				document.getElementById('hplImage').disabled=false 
				
			}
			else
			{
				document.getElementById('hplImage').disabled=true; 
			}
	}
}
/*******************************************************************************************************************
Name				: TextContentCheckBoxChange().
Description			: This function is called whenever user click on Text CheckBox
Input Parameters	: 
Returns				: string of all selected Search Engines
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	01-06-2006       1.00
*********************************************************************************************************************/
function TextContentCheckBoxChange()
{
	EnableDisableSearchEng();
	if(document.getElementById("divSearchResults").style.visibility=="visible")
	{
		if (document.getElementById('chkText').checked==true)
		{
			document.getElementById('hplText').disabled=false; 
		}
		else
		{
			document.getElementById('hplText').disabled=true; 
		}
	}
}
/*******************************************************************************************************************
Name				: TextContentCheckBoxChange().
Description			: This function is called whenever user click on Audio CheckBox
Input Parameters	: 
Returns				: string of all selected Search Engines
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	01-06-2006       1.00
*********************************************************************************************************************/
function AudioContentCheckBoxChange()
{

	EnableDisableSearchEng();
	if(document.getElementById("divSearchResults").style.visibility=="visible")
	{
		if (document.getElementById('chkAudio').checked==true)
		{
			document.getElementById('hplAudio').disabled=false; 
		}
		else
		{
			document.getElementById('hplAudio').disabled=true; 
		}
	}
}
/*******************************************************************************************************************
Name				: TextContentCheckBoxChange().
Description			: This function is called whenever user click on Video CheckBox
Input Parameters	: 
Returns				: string of all selected Search Engines
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	01-06-2006       1.00
*********************************************************************************************************************/
function VideoContentCheckBoxChange()
{
	EnableDisableSearchEng();
	if(document.getElementById("divSearchResults").style.visibility=="visible")
	{
		if (document.getElementById('chkVideo').checked==true)
		{
			document.getElementById('hplVideo').disabled=false; 
		}
		else
		{
			document.getElementById('hplVideo').disabled=true; 
		}
	}
}
/*******************************************************************************************************************
Name				: getSelectedSearchEngines().
Description			: This function is called when user click on Search Button 
Input Parameters	: 
Returns				: string of all selected Search Engines
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	25-05-2006       1.00
*********************************************************************************************************************/
function ShowSearchResults()
{
	//var oEditor = FCKeditorAPI.GetInstance('FCKeditor1') ;
	
	
	if(getSelectedContentTypes()=="")
	{
		
		alert("Please select atleast one content type");
	}
	else
	{
	
		if(getSelectedSearchEngines()!="")
		{
			if(document.getElementById("txtQuery").value!="")
			{
				intSearchStatus=1;	
				intSettingStatus=1;
				document.getElementById("divSearchResults").style.visibility="visible";
				ChangeResultType(SELECTED_SEARCH_TAB);
				//document.getElementById('hplImage').disabled=true; 
			}
			else
			{
				alert("Please enter search criteria");
			}	
		}
		else
		{
			alert("Please select atleast one search Engine from Settings");
			
		}	
	}	
}

/*******************************************************************************************************************
Name				: getSelectedSearchEngines().
Description			: This function is used to retrieve string of all selected search engines
Input Parameters	: 
Returns				: string of all selected Search Engines
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	18-05-2006       1.00
*********************************************************************************************************************/
function getSelectedSearchEngines()
{
	
	var intCount=0;
	var strSearchEngines=""; 
	
	if (document.getElementById("chkYahoo").checked==true)
	{
		
		if (intCount==0)
		{
			
			strSearchEngines=strSearchEngines+"YAHOO"
		}
		else
		{
			strSearchEngines=strSearchEngines+ "," + "YAHOO";
			
		}
		intCount++;
	}
	
	if (document.getElementById("chkGoogle").checked==true)
	{

		if (intCount==0)
		{
			//alert('test');			
			strSearchEngines=strSearchEngines+"GOOGLE"
		}
		else
		{
			strSearchEngines=strSearchEngines+ "," + "GOOGLE";
			
		}
		intCount++;
		
	}
	
	if (document.getElementById("chkMsn").checked==true)
	{
		if (intCount==0)
		{
			
			strSearchEngines=strSearchEngines+"MSN"
		}
		else
		{
			strSearchEngines=strSearchEngines+ "," + "MSN";
			
		}
		intCount++;
	}

	if (document.getElementById("chkFlickr").checked==true)
	{
		if (intCount==0)
		{
			
			strSearchEngines=strSearchEngines+"FLICKR"
		}
		else
		{
			strSearchEngines=strSearchEngines+ "," + "FLICKR";
			
		}
		intCount++;
	}
	if (document.getElementById("chkGrouper").checked==true)
	{
		if (intCount==0)
		{
			
			strSearchEngines=strSearchEngines+"GROUPER"
		}
		else
		{
			strSearchEngines=strSearchEngines+ "," + "GROUPER";
			
		}
		intCount++;
	}
	return strSearchEngines
}



/*******************************************************************************************************************
Name				: getSelectedContentTypes().
Description			: This function is used to retrieve string of all selected search engines
Input Parameters	: 
Returns				: string of all selected Search Engines
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	01-06-2006       1.00
*********************************************************************************************************************/
function getSelectedContentTypes()
{
	var intCount=0;
	var strContentTypes=""; 

	if (document.getElementById("chkImage").checked==true)
	{
		
		if (intCount==0)
		{
			
			strContentTypes=strContentTypes+"IMAGE";
		}
		else
		{
			strContentTypes=strContentTypes+ "," + "IMAGE";
			
		}
		intCount++;
	}
	
	if (document.getElementById("chkText").checked==true)
	{
		if (intCount==0)
		{
			
			strContentTypes=strContentTypes+"TEXT"
		}
		else
		{
			strContentTypes=strContentTypes+ "," + "TEXT";
			
		}
		intCount++;
		
	}
	
	if (document.getElementById("chkAudio").checked==true)
	{
		if (intCount==0)
		{
			
			strContentTypes=strContentTypes+"AUDIO"
		}
		else
		{
			strContentTypes=strContentTypes+ "," + "AUDIO";
			
		}
		intCount++;
	}

	if (document.getElementById("chkVideo").checked==true)
	{
		if (intCount==0)
		{
			
			strContentTypes=strContentTypes+"VIDEO"
		}
		else
		{
			strContentTypes=strContentTypes+ "," + "VIDEO";
			
		}
		intCount++;
	}
	
	
	return strContentTypes
}

/*******************************************************************************************************************
Name				: getNextImageResults().
Description			: This function is used to to retrieve next image results
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	25-05-2006       1.00
*********************************************************************************************************************/

function getNextImageResults(pStartIndex)
{
	document.getElementById("hdnImageStartIndex").value=(parseInt(document.getElementById("hdnImageStartIndex").value)+MAX_IMAGE_RESULTS);
	getImageResults(parseInt(document.getElementById("hdnImageStartIndex").value));
	return false;
}

/*******************************************************************************************************************
Name				: getPreviousImageResults().
Description			: This function is used to to retrieve next image results
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-06-2006       1.00
*********************************************************************************************************************/

function getPreviousImageResults()
{
	if (document.getElementById("hdnImageStartIndex").value>1)
	{
		document.getElementById("hdnImageStartIndex").value=(parseInt(document.getElementById("hdnImageStartIndex").value)-MAX_IMAGE_RESULTS);
		getImageResults(parseInt(document.getElementById("hdnImageStartIndex").value));
	}
	else
	{
		//document.getElementById("hplImagePrevious").disabled =true;
	}
	return false;
}


/*******************************************************************************************************************
Name				: getImageResults().
Description			: This function is used to to retrieve Image results using xmlHttp object.
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-06-2006       1.00
*********************************************************************************************************************/
function getImageResults(pStartIndex)
{
	var strSearchEngines="";
	var intStartIndex=pStartIndex;
	//var intNumberOfRecords=10;
	var xmlhttp =GetHttpRequestObject();
	
	strContentTypes= new String();
	strContentTypes=getSelectedContentTypes();
	if (strContentTypes.indexOf("IMAGE")!=-1)
	{

		//var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		try
		{	
			document.getElementById("divResults").style.visibility="visible";
			document.getElementById("divResults").innerHTML="&nbsp;<b>Loading....</b><img src=/imageFiles/"+ strSkin+ "/busy.gif width=16 height=16>";

			strSearchEngines=getSelectedSearchEngines();

			var url="/SearchService/ImageXml.php?Query=" +document.getElementById("txtQuery").value+"&StartIndex="+intStartIndex+"&NoOfResults=" +MAX_IMAGE_RESULTS + "&SearchEngines=" + strSearchEngines;
	
			
			xmlhttp.onreadystatechange=function() 
			{
				if (xmlhttp.readyState==4) 
			 	{
				   	var reply = xmlhttp.responseText;
					tempValid = true;

					XmlParseImageData(reply);
	  			}		
			};
			xmlhttp.open("GET", url, true);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp.send(null);
			//return "abc";
		}
		catch(e)
		{
			//HideWaitDlg()
			alert(e.description);
		}
	}	
}

		
/*******************************************************************************************************************
Name				: XmlParseImageData
Description			: This function is used to Parse the XML string which is returned from ImageXml file through xmlHTTP
Input Parameters	: XML string
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/
function XmlParseImageData(XMLstr)
{
//	var XMLDoc =new ActiveXObject("Microsoft.XMLDOM");
	//var XMLDoc =GetXmlHttpObject();
	var rootNode = "";
	var intNoOfRecords="";
		
	var strTitle;
	var strSummary;
	var strUrl;
	var strClickUrl;
	var strRefererUrl;
	var lngFileSize;
	var strFileFormat;
	var lngHeight;
	var lngWidth;
	var strSearchEngine="";
	var strToolTip="";
	
	// CACHE variables
	var strOldString=""; 
	var intStart=0;
	var intEnd=0;
	
	
	var intNoOfCols=8;
	
	// Current selected Tab is not Image then exit from this function 	
	if (SELECTED_SEARCH_TAB!="IMAGE")
	{
		return; 
	}
	
	var strHtml="<div id='container'> <table cellspacing=0 cellpadding=0 border=0>";

	if (window.ActiveXObject)
	{
		var XMLDoc=new ActiveXObject("Microsoft.XMLDOM");
		try 
		{	
			XMLDoc.async = "false";
			if(XMLDoc.loadXML(XMLstr)==true)
			{
				rootNode=XMLDoc.documentElement;
				try 
				{
					intNoOfRecords=rootNode.selectSingleNode("TotalResult").text;
						if(intNoOfRecords>0)
						{
							for(i=0;i< intNoOfRecords;i++)	
							{
								
								strToolTip="";
								if (i==0 || i%intNoOfCols==0)
								{
									strHtml=strHtml+"<tr><td width=5></td>";
								}
								
								
								strTitle=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(0).text;
			
								if (strTitle.length>MAX_IMAGE_TITLE_LENGTH)
								{
									strTitle= strTitle.substring(0,MAX_IMAGE_TITLE_LENGTH)+"...";
								}
								
								strUrl=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(2).text;
								strUrl=decode(strUrl);
								strFileFormat=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(6).text;
								lngHeight=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(7).text;					
								lngWidth=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(8).text;					
								strSearchEngine=" [ "+rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(10).text+" ] ";					
								
								strToolTip=strToolTip+"<table cellpadding=0 cellspacing=0 border=0>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>Title:<td>" + encodeToolTipText(strTitle) + "</td></tr>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>File Format:</td><td>"+strFileFormat+"</td></tr>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>Height:</td><td>"+lngHeight+"</td></tr>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>Width:</td><td>"+lngWidth+"</td></tr>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>Search Engine:</td><td>"+strSearchEngine+"</td></tr>";
								strToolTip=strToolTip+"</table>";
								
								strHtml=strHtml+"<td align=center>"+ "<img src="+ strUrl+ " height=75 width=75>" + "</br>" + "<a  href='#' class=LinkSmall onClick=\"return AddImageToEditor('"+strUrl+"')\"  onMouseover=\"ddrivetip('"+strToolTip+ "',225 )\" onMouseout='hideddrivetip()'  >Add"+strSearchEngine+"</a></td>";				
								strHtml=strHtml+"<td width=5></td>"
								if (i!=0 && i%((intNoOfCols-1) + i + 1)==0)
								{
									strHtml=strHtml+"</tr> <tr><td height=10></td></tr>";
								}
								///alert(strTitle + ":" +strSummary + ":" +strUrl + ":" + strClickUrl + ":" + strRefererUrl + ":" + lngFileSize + ":" +strFileFormat + ":" + lngHeight + ":" + lngWidth)
							}
									
							strHtml=strHtml+"</tr>";
			
							if (parseInt(document.getElementById("hdnImageStartIndex").value)>1)
							{
								strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a  id='hplImagePrevious' name='hplImagePrevious' href='#'  onClick='javascript:return getPreviousImageResults()' class='LinkSmall'  >Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a id='hplImageNext' href='#' OnClick='javascript:return getNextImageResults()' class='LinkSmall'>Next</a></td></tr>";
							}
							else
							{
								strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a id='hplImagePrevious' name='hplImagePrevious' href='#'  onClick='javascript:return getPreviousImageResults()' class='LinkSmall' disabled>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a id='hplImageNext' href='#' OnClick='javascript:return getNextImageResults()' class='LinkSmall'>Next</a></td></tr>";
							}	
						
							strHtml=strHtml+"</div></table>";
							document.getElementById("divResults").style.visibility="visible";
							document.getElementById("divResults").innerHTML=strHtml;
						}
						else
						{
							//strHtml=strHtml+"</tr>";
							//strHtml=strHtml+"<td>";
							document.getElementById("divResults").style.visibility="visible";
							document.getElementById("divResults").innerHTML="&nbsp;<b>No Result Found</b>";
							/*
							strCacheData= new String(document.getElementById("txtCache").value+ "");
							document.getElementById("txtCache").value="&nbsp;<b>No Result Found</b>";
							*/
						}
						
						
						
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//START CACHE IMAGE RESULTS
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						 strCacheData= new String(document.getElementById("txtCache").value+ "");
						if( strCacheData.indexOf(IMAGE_START_TAG)==-1)
						{
							
							document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_PAGE_TAG + document.getElementById("hdnImageStartIndex").value + IMAGE_END_PAGE_TAG;
							document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_QUERY_TAG + document.getElementById("txtQuery").value + IMAGE_END_QUERY_TAG;
							document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_SEARCHENGINES_TAG + getSelectedSearchEngines() + IMAGE_END_SEARCHENGINES_TAG;
							//document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_CONTENTTYPES_TAG + getSelectedContentTypes() + IMAGE_END_CONTENTTYPES_TAG;
							document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_TAG + strHtml + IMAGE_END_TAG;					
						}
						else
						{
								// Replace Page Number 
								intStart=strCacheData.indexOf(IMAGE_START_PAGE_TAG)+IMAGE_START_PAGE_TAG.length;
								intEnd=strCacheData.indexOf(IMAGE_END_PAGE_TAG);
								strOldString=IMAGE_START_PAGE_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_PAGE_TAG;
								strCacheData=strCacheData.replace(strOldString,(IMAGE_START_PAGE_TAG+ document.getElementById("hdnImageStartIndex").value + IMAGE_END_PAGE_TAG))
								
								// Replace Query 
								intStart=strCacheData.indexOf(IMAGE_START_QUERY_TAG)+IMAGE_START_QUERY_TAG.length;
								intEnd=strCacheData.indexOf(IMAGE_END_QUERY_TAG);
								strOldString=IMAGE_START_QUERY_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_QUERY_TAG;
								strCacheData=strCacheData.replace(strOldString,( IMAGE_START_QUERY_TAG + document.getElementById("txtQuery").value + IMAGE_END_QUERY_TAG) )
								
								
								//Replace Search Engine String  
								intStart=strCacheData.indexOf(IMAGE_START_SEARCHENGINES_TAG)+IMAGE_START_SEARCHENGINES_TAG.length;
								intEnd=strCacheData.indexOf(IMAGE_END_SEARCHENGINES_TAG);
								strOldString=IMAGE_START_SEARCHENGINES_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_SEARCHENGINES_TAG;
								strCacheData=strCacheData.replace(strOldString,( IMAGE_START_SEARCHENGINES_TAG + getSelectedSearchEngines() + IMAGE_END_SEARCHENGINES_TAG) );
								
								//Replace ContentTypes  
								//intStart=strCacheData.indexOf(IMAGE_START_CONTENTTYPES_TAG)+IMAGE_START_CONTENTTYPES_TAG.length;
								///intEnd=strCacheData.indexOf(IMAGE_END_CONTENTTYPES_TAG);
								//strOldString=IMAGE_START_CONTENTTYPES_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_CONTENTTYPES_TAG;
								//strCacheData=strCacheData.replace(strOldString,( IMAGE_START_CONTENTTYPES_TAG + getSelectedSearchEngines() + IMAGE_END_CONTENTTYPES_TAG) );
								
								// Replace Cache Data 
								intStart=strCacheData.indexOf(IMAGE_START_TAG)+IMAGE_START_TAG.length;
								intEnd=strCacheData.indexOf(IMAGE_END_TAG);
								strOldString=IMAGE_START_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_TAG;
								strCacheData=strCacheData.replace(strOldString,(IMAGE_START_TAG + strHtml + IMAGE_END_TAG))
								
								document.getElementById("txtCache").value=strCacheData;
						}
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//END CACHE IMAGE RESULTS
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
						
				}
				catch(e)	
				{
					showSearchResultsError("Sorry, No results found ","WARNING");
				}
	
			}
			else
			{
				showSearchResultsError("Error occured while retrieving results","ERROR");
			}	
		}
		catch(e)
		{
			showSearchResultsError("We was not able to complete your request","ERROR");
		}
	}

	// Firefox 
	else
	{
		var XMLDoc =  new DOMParser();

		
		try 
		{	
			XMLDoc.async = "false";
				var xmlDocoment = XMLDoc.parseFromString(XMLstr, "application/xml");
				try 
				{
					var strSearchResults = xmlDocoment.getElementsByTagName('SearchResults');
					intNoOfRecords=strSearchResults[0].getElementsByTagName('TotalResult')[0].textContent;		
						if(intNoOfRecords>0)
						{
							for(i=0;i< intNoOfRecords;i++)	
							{
								
								strToolTip="";
								if (i==0 || i%intNoOfCols==0)
								{
									strHtml=strHtml+"<tr><td width=5></td>";
								}
								
								
								var strResult = xmlDocoment.getElementsByTagName('Result');
								strTitle=strResult[i].getElementsByTagName('Title')[0].textContent;
								if (strTitle.length>MAX_IMAGE_TITLE_LENGTH)
								{
									strTitle= strTitle.substring(0,MAX_IMAGE_TITLE_LENGTH)+"...";
								}
								strUrl=strResult[i].getElementsByTagName('Url')[0].textContent;
								strUrl=decode(strUrl);
								strFileFormat=strResult[i].getElementsByTagName('FileFormat')[0].textContent;
								lngHeight=strResult[i].getElementsByTagName('Height')[0].textContent;
								lngWidth=strResult[i].getElementsByTagName('Width')[0].textContent;
								strSearchEngine=" [ "+ strResult[i].getElementsByTagName('SearchEngine')[0].textContent+" ] ";	
								strToolTip=strToolTip+"<table cellpadding=0 cellspacing=0 border=0>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>Title:<td>" + encodeToolTipText(strTitle) + "</td></tr>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>File Format:</td><td>"+strFileFormat+"</td></tr>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>Height:</td><td>"+lngHeight+"</td></tr>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>Width:</td><td>"+lngWidth+"</td></tr>";
								strToolTip=strToolTip+"<tr class=ToolTipText><td>Search Engine:</td><td>"+strSearchEngine+"</td></tr>";
								strToolTip=strToolTip+"</table>";
								strHtml=strHtml+"<td align=center>"+ "<img src="+ strUrl+ " height=75 width=75>" + "</br>" + "<a  href='a.php' class=LinkSmall onClick=\"return AddImageToEditor('"+strUrl+"')\"  onMouseover=\"ddrivetip('"+strToolTip+ "',225 )\" onMouseout='hideddrivetip()'  >Add"+strSearchEngine+"</a></td>";				
								strHtml=strHtml+"<td width=5></td>"
								if (i!=0 && i%((intNoOfCols-1) + i + 1)==0)
								{
									strHtml=strHtml+"</tr> <tr><td height=10></td></tr>";
								}
								///alert(strTitle + ":" +strSummary + ":" +strUrl + ":" + strClickUrl + ":" + strRefererUrl + ":" + lngFileSize + ":" +strFileFormat + ":" + lngHeight + ":" + lngWidth)
							}
							strHtml=strHtml+"</tr>";
							if (parseInt(document.getElementById("hdnImageStartIndex").value)>1)
							{
								strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a  id='hplImagePrevious' name='hplImagePrevious' href='#'  onClick='javascript:return getPreviousImageResults()' class='LinkSmall'  >Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a id='hplImageNext' href='#' OnClick='javascript:return getNextImageResults()' class='LinkSmall'>Next</a></td></tr>";
							}
							else
							{
								strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a id='hplImagePrevious' name='hplImagePrevious' href='#'  onClick='javascript:return getPreviousImageResults()' class='LinkSmall' disabled>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a id='hplImageNext' href='#' OnClick='javascript:return getNextImageResults()' class='LinkSmall'>Next</a></td></tr>";
							}	
						
							strHtml=strHtml+"</div></table>";
							document.getElementById("divResults").style.visibility="visible";
							document.getElementById("divResults").innerHTML=strHtml;
						}
						else
						{
							//strHtml=strHtml+"</tr>";
							//strHtml=strHtml+"<td>";
							document.getElementById("divResults").style.visibility="visible";
							document.getElementById("divResults").innerHTML="&nbsp;<b>No Result Found</b>";
							/*
							strCacheData= new String(document.getElementById("txtCache").value+ "");
							document.getElementById("txtCache").value="&nbsp;<b>No Result Found</b>";
							*/
						}
						
						
						
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//START CACHE IMAGE RESULTS
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						 strCacheData= new String(document.getElementById("txtCache").value+ "");
						if( strCacheData.indexOf(IMAGE_START_TAG)==-1)
						{
							
							document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_PAGE_TAG + document.getElementById("hdnImageStartIndex").value + IMAGE_END_PAGE_TAG;
							document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_QUERY_TAG + document.getElementById("txtQuery").value + IMAGE_END_QUERY_TAG;
							document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_SEARCHENGINES_TAG + getSelectedSearchEngines() + IMAGE_END_SEARCHENGINES_TAG;
							//document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_CONTENTTYPES_TAG + getSelectedContentTypes() + IMAGE_END_CONTENTTYPES_TAG;
							document.getElementById("txtCache").value=document.getElementById("txtCache").value + IMAGE_START_TAG + strHtml + IMAGE_END_TAG;					
						}
						else
						{
								// Replace Page Number 
								intStart=strCacheData.indexOf(IMAGE_START_PAGE_TAG)+IMAGE_START_PAGE_TAG.length;
								intEnd=strCacheData.indexOf(IMAGE_END_PAGE_TAG);
								strOldString=IMAGE_START_PAGE_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_PAGE_TAG;
								strCacheData=strCacheData.replace(strOldString,(IMAGE_START_PAGE_TAG+ document.getElementById("hdnImageStartIndex").value + IMAGE_END_PAGE_TAG))
								
								// Replace Query 
								intStart=strCacheData.indexOf(IMAGE_START_QUERY_TAG)+IMAGE_START_QUERY_TAG.length;
								intEnd=strCacheData.indexOf(IMAGE_END_QUERY_TAG);
								strOldString=IMAGE_START_QUERY_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_QUERY_TAG;
								strCacheData=strCacheData.replace(strOldString,( IMAGE_START_QUERY_TAG + document.getElementById("txtQuery").value + IMAGE_END_QUERY_TAG) )
								
								
								//Replace Search Engine String  
								intStart=strCacheData.indexOf(IMAGE_START_SEARCHENGINES_TAG)+IMAGE_START_SEARCHENGINES_TAG.length;
								intEnd=strCacheData.indexOf(IMAGE_END_SEARCHENGINES_TAG);
								strOldString=IMAGE_START_SEARCHENGINES_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_SEARCHENGINES_TAG;
								strCacheData=strCacheData.replace(strOldString,( IMAGE_START_SEARCHENGINES_TAG + getSelectedSearchEngines() + IMAGE_END_SEARCHENGINES_TAG) );
								
								//Replace ContentTypes  
								//intStart=strCacheData.indexOf(IMAGE_START_CONTENTTYPES_TAG)+IMAGE_START_CONTENTTYPES_TAG.length;
								///intEnd=strCacheData.indexOf(IMAGE_END_CONTENTTYPES_TAG);
								//strOldString=IMAGE_START_CONTENTTYPES_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_CONTENTTYPES_TAG;
								//strCacheData=strCacheData.replace(strOldString,( IMAGE_START_CONTENTTYPES_TAG + getSelectedSearchEngines() + IMAGE_END_CONTENTTYPES_TAG) );
								
								// Replace Cache Data 
								intStart=strCacheData.indexOf(IMAGE_START_TAG)+IMAGE_START_TAG.length;
								intEnd=strCacheData.indexOf(IMAGE_END_TAG);
								strOldString=IMAGE_START_TAG + strCacheData.substring(intStart,intEnd) + IMAGE_END_TAG;
								strCacheData=strCacheData.replace(strOldString,(IMAGE_START_TAG + strHtml + IMAGE_END_TAG))
								
								document.getElementById("txtCache").value=strCacheData;
						}
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//END CACHE IMAGE RESULTS
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						
				}
				catch(e)	
				{
					showSearchResultsError("Sorry, No results found ","WARNING");
				}
	
			//}
			/*else
			{
				showSearchResultsError("Error occured while retrieving results","ERROR");
			}*/	
		}
		catch(e)
		{
			showSearchResultsError("We was not able to complete your request","ERROR");
		}
	}
	changeSearchResultTab('IMAGE');
}		
		
/*******************************************************************************************************************
Name				: AddImageToEditor(pUrl)
Description			: This function is used to add Image Tag to Editor 
Input Parameters	: Url of the image which is to be inserted into Editor 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2005       1.00
*********************************************************************************************************************/
function AddImageToEditor(pUrl)
{
	
	objEditorInstance.InsertHtml("<img src="+ pUrl + " width=75 height=75>");
	return false;
}


/*******************************************************************************************************************
Name				: getNextVideoResults().
Description			: This function is used to to retrieve next image results
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	25-05-2006       1.00
*********************************************************************************************************************/

function getNextVideoResults(pStartIndex)
{
	
	document.getElementById("hdnVideoStartIndex").value=(parseInt(document.getElementById("hdnVideoStartIndex").value)+MAX_VIDEO_RESULTS);
	getVideoResults(parseInt(document.getElementById("hdnVideoStartIndex").value));
	return false;
}

/*******************************************************************************************************************
Name				: getPreviousVideoResults().
Description			: This function is used to to retrieve Previous Video results
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-06-2006       1.00
*********************************************************************************************************************/

function getPreviousVideoResults()
{
	if (document.getElementById("hdnVideoStartIndex").value>1)
	{
		document.getElementById("hdnVideoStartIndex").value=(parseInt(document.getElementById("hdnVideoStartIndex").value)-MAX_VIDEO_RESULTS);
		getVideoResults(parseInt(document.getElementById("hdnVideoStartIndex").value));
		
	}
	else
	{
		//TODO- DISABLE PREVIOUS LINK 
	}
	return false;
}


		
/*******************************************************************************************************************
Name				: getVideoResults()
Description			: This function is used to retrieve Video results from VideoXml file using xmlHttp object 
Input Parameters	: XML string
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		
function getVideoResults(pStartIndex)
{
	
	var strSearchEngines="";
	var intStartIndex=pStartIndex;
	
	strContentTypes= new String();
	strContentTypes=getSelectedContentTypes();
	if (strContentTypes.indexOf("VIDEO")!=-1)
	{
		var xmlhttp = GetHttpRequestObject();
		try
		{	
			document.getElementById("divResults").style.visibility="visible";
			document.getElementById("divResults").innerHTML="&nbsp;<b>Loading....</b><img src=/imageFiles/"+ strSkin+ "/busy.gif width=16 height=16>";
			
			strSearchEngines=getSelectedSearchEngines();
			
			var url="SearchService/VideoXml.php?Query=" +document.getElementById("txtQuery").value+"&StartIndex="+ intStartIndex+ "&NoOfResults="+MAX_VIDEO_RESULTS+"&SearchEngines="+strSearchEngines;
			
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange=function() 
			{
				if (xmlhttp.readyState==4) 
			 	{
				   	var reply = xmlhttp.responseText;
					
					tempValid = true
					XmlParseVideoData(reply);
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
}
		
		
/*******************************************************************************************************************
Name				: XmlParseVideoData(XMLstr).
Description			: This function is used to Parse the XML string returned by VideoXML file using xmlHTTP object 
Input Parameters	: XML string
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/
function XmlParseVideoData(XMLstr)
{
	//var XMLDoc =new ActiveXObject("Microsoft.XMLDOM");
	var rootNode = "";
	var intNoOfRecords="";
		
	var strTitle;
	var strSummary;
	var strUrl;
	var strClickUrl;
	var strRefererUrl;
	var lngFileSize;
	var strFileFormat;
	var lngHeight;
	var lngWidth;
	var strThumbnail;
	var strThumbnailUrl;
	var strSearchEngine; 
	var strToolTip=""; 
	var intNoOfCols=8;
	
	// CACHE variables
	var strOldString=""; 
	var intStart=0;
	var intEnd=0;
	
	
	// Current selected Tab is not VIDEO then exit from this function 	
	if (SELECTED_SEARCH_TAB!="VIDEO")
	{
		return; 
	}
	
	var strHtml="<table cellspacing=0 cellpadding=0 border=0>";
	if (window.ActiveXObject)
	{
		var XMLDoc=new ActiveXObject("Microsoft.XMLDOM");
		try 
		{	

			XMLDoc.async = "false";
			if(XMLDoc.loadXML(XMLstr)==true)
			{
				try 
				{
					rootNode=XMLDoc.documentElement;
					intNoOfRecords=rootNode.selectSingleNode("TotalResult").text;
					
					if(intNoOfRecords>0)
					{
						for(i=0;i< intNoOfRecords;i++)	
						{
							strToolTip="";
							if (i==0 || i%intNoOfCols==0)
							{
								strHtml=strHtml+"<tr><td width=5></td>";
							}
							
							strTitle=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(0).text;
							if (strTitle.length>MAX_IMAGE_TITLE_LENGTH)
							{
								strTitle= strTitle.substring(0,MAX_VIDEO_TITLE_LENGTH)+"...";
							}
							
							strUrl=decode(rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(2).text);
						
							lngFileSize=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(5).text
							strFileFormat=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(6).text
							lngHeight=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(7).text
							lngWidth=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(8).text
							//alert(rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(13).text);
							strThumbnail="<" + decode(rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(12).text) +">";
							//alert(decode(rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(13).text));
							strThumbnailUrl="'" + decode(rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(13).text) +"'";
							strSearchEngine=" ["+ rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(14).text + "]";
							
							strToolTip=strToolTip+"<table cellpadding=0 cellspacing=0 border=0>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Title:<td>" + encodeToolTipText(strTitle) + "</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>File Size:<td>" + lngFileSize + "</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>File Format:</td><td>"+strFileFormat+"</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Height:</td><td>"+lngHeight+"</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Width:</td><td>"+lngWidth+"</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Search Engine:</td><td>"+strSearchEngine+"</td></tr>";
							strToolTip=strToolTip+"</table>";
							
							strHtml=strHtml + "<td align=center><a href='#' onclick=\"javascript:return openAudioPlayer('" + strUrl +  "')\" >"   + strThumbnail + "</a></br>" + "<a  class=LinkSmall onClick=\"AddVideoToEditor('"+ strUrl+ "'," + strThumbnailUrl+")\" onMouseover=\"ddrivetip('"+strToolTip+ "',225 )\" onMouseout='hideddrivetip()'  > Add" + strSearchEngine+ "</a></td>";
							//strHtml=strHtml + "<td align=center><a href='" + strUrl + "' >"   + strThumbnail + "</a></br>" + "<a  class=LinkSmall onClick=\"AddVideoToEditor('"+ strUrl+ "'," + strThumbnailUrl+")\" onMouseover=\"ddrivetip('"+strToolTip+ "',225 )\" onMouseout='hideddrivetip()'  > Add" + strSearchEngine+ "</a></td>";
							
							
							strHtml=strHtml+"<td width=5></td>"
							if (i!=0 && i%((intNoOfCols-1) + i + 1)==0)
							{
								strHtml=strHtml+"</tr> <tr><td height=10></td></tr>";
							}
						}
						strHtml=strHtml+"</tr>";
						
						if (parseInt(document.getElementById("hdnVideoStartIndex").value)>1)
							strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a href='' onClick='javascript:return getPreviousVideoResults()' class='LinkSmall'>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextVideoResults()' class='LinkSmall'>Next</a></td></tr>";
						else
							strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a href='' onClick='javascript:return getPreviousVideoResults()' class='LinkSmall' disabled>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextVideoResults()' class='LinkSmall'>Next</a></td></tr>";
								
						strHtml=strHtml+"</table>";
						document.getElementById("divResults").style.visibility="visible";
						document.getElementById("divResults").innerHTML=strHtml;
					}
					else
					{
						document.getElementById("divResults").style.visibility="visible";
						document.getElementById("divResults").innerHTML="&nbsp;<b>No Result Found</b>";
					}
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//START CACHE VIDEO RESULTS
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					 strCacheData= new String(document.getElementById("txtCache").value+ "");
					 
					 // we will check that wheteher VideoData is already cached or not . 
					 //	if Already cached then replace that data with new values 
					 // else we will just save VideoData in Cache 
					 
					 
					if( strCacheData.indexOf(VIDEO_START_TAG)==-1)
					{
						// Since No VideoData is Saved on the Cache so save it in Cache 	
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + VIDEO_START_PAGE_TAG + document.getElementById("hdnVideoStartIndex").value + VIDEO_END_PAGE_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + VIDEO_START_QUERY_TAG + document.getElementById("txtQuery").value + VIDEO_END_QUERY_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + VIDEO_START_SEARCHENGINES_TAG + getSelectedSearchEngines() + VIDEO_END_SEARCHENGINES_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + VIDEO_START_TAG + strHtml + VIDEO_END_TAG;					
					}
					else
					{
							// Since VideoData is already saved into cache so we will replace exisiting Data with new Data 
						
							// Extract PageNumber from Cache and then replace with new PageNumber 	
							intStart=strCacheData.indexOf(VIDEO_START_PAGE_TAG)+VIDEO_START_PAGE_TAG.length;
							intEnd=strCacheData.indexOf(VIDEO_END_PAGE_TAG);
							strOldString=VIDEO_START_PAGE_TAG+strCacheData.substring(intStart,intEnd)+VIDEO_END_PAGE_TAG ;
							strCacheData=strCacheData.replace(strOldString,(VIDEO_START_PAGE_TAG + document.getElementById("hdnVideoStartIndex").value + VIDEO_END_PAGE_TAG))
							
							// Extract Search Query from Cache and then replace with new Search Query 
							intStart=strCacheData.indexOf(VIDEO_START_QUERY_TAG)+VIDEO_START_QUERY_TAG.length;
							intEnd=strCacheData.indexOf(VIDEO_END_QUERY_TAG);
							strOldString=VIDEO_START_QUERY_TAG +strCacheData.substring(intStart,intEnd)+VIDEO_END_QUERY_TAG;
							strCacheData=strCacheData.replace(strOldString,(VIDEO_START_QUERY_TAG +document.getElementById("txtQuery").value +VIDEO_END_QUERY_TAG))
							
							// Extract SearchEngines from Cache and then replace with new SearchEngines 
							intStart=strCacheData.indexOf(VIDEO_START_QUERY_TAG)+VIDEO_START_SEARCHENGINES_TAG.length;
							intEnd=strCacheData.indexOf(VIDEO_END_SEARCHENGINES_TAG);
							strOldString=VIDEO_START_QUERY_TAG +strCacheData.substring(intStart,intEnd)+VIDEO_END_SEARCHENGINES_TAG;
							strCacheData=strCacheData.replace(strOldString,(VIDEO_START_SEARCHENGINES_TAG +getSelectedSearchEngines() +VIDEO_END_SEARCHENGINES_TAG))
							
							// Extract html from Cache and then replace with new HTML
							intStart=strCacheData.indexOf(VIDEO_START_TAG)+VIDEO_START_TAG.length;
							intEnd=strCacheData.indexOf(VIDEO_END_TAG);
							strOldString=VIDEO_START_TAG +strCacheData.substring(intStart,intEnd) + VIDEO_END_TAG;
							strCacheData=strCacheData.replace(strOldString,(VIDEO_START_TAG+ strHtml + VIDEO_END_TAG))
							
							
							
							// Save Updated Data on CACHE 
							document.getElementById("txtCache").value=strCacheData;
					}
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//END CACHE IMAGE RESULTS
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				}
				
				catch(e)	
				{
					showSearchResultsError("Sorry, No results found ","WARNING");
				}
			}
			else
			{
				showSearchResultsError("Error occured while retrieving results ","ERROR");
			}	
		}
		catch(e)
		{
			showSearchResultsError("We was not able to complete your request","ERROR");
		}
	}
	else
	{
		var XMLDoc =  new DOMParser();
		try 
		{	
			XMLDoc.async = "false";
				try 
				{
					var xmlDocoment = XMLDoc.parseFromString(XMLstr, "application/xml");
					var strSearchResults = xmlDocoment.getElementsByTagName('SearchResults');
					intNoOfRecords=strSearchResults[0].getElementsByTagName('TotalResult')[0].textContent;		
							
					if(intNoOfRecords>0)
					{
						for(i=0;i< intNoOfRecords;i++)	
						{
							strToolTip="";
							if (i==0 || i%intNoOfCols==0)
							{
								strHtml=strHtml+"<tr><td width=5></td>";
							}
							var strResult = xmlDocoment.getElementsByTagName('Result');
							strTitle=strResult[i].getElementsByTagName('Title')[0].textContent;
							if (strTitle.length>MAX_IMAGE_TITLE_LENGTH)
							{
								strTitle= strTitle.substring(0,MAX_VIDEO_TITLE_LENGTH)+"...";
							}
							strUrl=decode(strResult[i].getElementsByTagName('Url')[0].textContent);
							lngFileSize=strResult[i].getElementsByTagName('FileSize')[0].textContent;
							strFileFormat=strResult[i].getElementsByTagName('FileFormat')[0].textContent;
							lngHeight=strResult[i].getElementsByTagName('Height')[0].textContent;
							lngWidth=strResult[i].getElementsByTagName('Width')[0].textContent;
							
							strThumbnail="<" + strResult[i].getElementsByTagName('Thumbnail')[0].textContent +">";
							strThumbnailUrl="'" + decode(strResult[i].getElementsByTagName('ThumbnailUrl')[0].textContent) +"'";
							strSearchEngine=" ["+  strResult[i].getElementsByTagName('SearchEngine')[0].textContent + "]";
							
							strToolTip=strToolTip+"<table cellpadding=0 cellspacing=0 border=0>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Title:<td>" + encodeToolTipText(strTitle) + "</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>File Size:<td>" + lngFileSize + "</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>File Format:</td><td>"+strFileFormat+"</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Height:</td><td>"+lngHeight+"</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Width:</td><td>"+lngWidth+"</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Search Engine:</td><td>"+strSearchEngine+"</td></tr>";
							strToolTip=strToolTip+"</table>";
							
							strHtml=strHtml + "<td align=center><a href='#' onclick=\"javascript:return openAudioPlayer('" + strUrl +  "')\" >"   + strThumbnail + "</a></br>" + "<a  class=LinkSmall onClick=\"AddVideoToEditor('"+ strUrl+ "'," + strThumbnailUrl+")\" onMouseover=\"ddrivetip('"+strToolTip+ "',225 )\" onMouseout='hideddrivetip()'  > Add" + strSearchEngine+ "</a></td>";
							//strHtml=strHtml + "<td align=center><a href='" + strUrl + "' >"   + strThumbnail + "</a></br>" + "<a  class=LinkSmall onClick=\"AddVideoToEditor('"+ strUrl+ "'," + strThumbnailUrl+")\" onMouseover=\"ddrivetip('"+strToolTip+ "',225 )\" onMouseout='hideddrivetip()'  > Add" + strSearchEngine+ "</a></td>";
							
							
							strHtml=strHtml+"<td width=5></td>"
							if (i!=0 && i%((intNoOfCols-1) + i + 1)==0)
							{
								strHtml=strHtml+"</tr> <tr><td height=10></td></tr>";
							}
						}
						strHtml=strHtml+"</tr>";
						
						if (parseInt(document.getElementById("hdnVideoStartIndex").value)>1)
							strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a href='' onClick='javascript:return getPreviousVideoResults()' class='LinkSmall'>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextVideoResults()' class='LinkSmall'>Next</a></td></tr>";
						else
							strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a href='' onClick='javascript:return getPreviousVideoResults()' class='LinkSmall' disabled>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextVideoResults()' class='LinkSmall'>Next</a></td></tr>";
								
						strHtml=strHtml+"</table>";
						document.getElementById("divResults").style.visibility="visible";
						document.getElementById("divResults").innerHTML=strHtml;
					}
					else
					{
						document.getElementById("divResults").style.visibility="visible";
						document.getElementById("divResults").innerHTML="&nbsp;<b>No Result Found</b>";
					}
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//START CACHE VIDEO RESULTS
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					 strCacheData= new String(document.getElementById("txtCache").value+ "");
					 
					 // we will check that wheteher VideoData is already cached or not . 
					 //	if Already cached then replace that data with new values 
					 // else we will just save VideoData in Cache 
					 
					 
					if( strCacheData.indexOf(VIDEO_START_TAG)==-1)
					{
						// Since No VideoData is Saved on the Cache so save it in Cache 	
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + VIDEO_START_PAGE_TAG + document.getElementById("hdnVideoStartIndex").value + VIDEO_END_PAGE_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + VIDEO_START_QUERY_TAG + document.getElementById("txtQuery").value + VIDEO_END_QUERY_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + VIDEO_START_SEARCHENGINES_TAG + getSelectedSearchEngines() + VIDEO_END_SEARCHENGINES_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + VIDEO_START_TAG + strHtml + VIDEO_END_TAG;					
					}
					else
					{
							// Since VideoData is already saved into cache so we will replace exisiting Data with new Data 
						
							// Extract PageNumber from Cache and then replace with new PageNumber 	
							intStart=strCacheData.indexOf(VIDEO_START_PAGE_TAG)+VIDEO_START_PAGE_TAG.length;
							intEnd=strCacheData.indexOf(VIDEO_END_PAGE_TAG);
							strOldString=VIDEO_START_PAGE_TAG+strCacheData.substring(intStart,intEnd)+VIDEO_END_PAGE_TAG ;
							strCacheData=strCacheData.replace(strOldString,(VIDEO_START_PAGE_TAG + document.getElementById("hdnVideoStartIndex").value + VIDEO_END_PAGE_TAG))
							
							// Extract Search Query from Cache and then replace with new Search Query 
							intStart=strCacheData.indexOf(VIDEO_START_QUERY_TAG)+VIDEO_START_QUERY_TAG.length;
							intEnd=strCacheData.indexOf(VIDEO_END_QUERY_TAG);
							strOldString=VIDEO_START_QUERY_TAG +strCacheData.substring(intStart,intEnd)+VIDEO_END_QUERY_TAG;
							strCacheData=strCacheData.replace(strOldString,(VIDEO_START_QUERY_TAG +document.getElementById("txtQuery").value +VIDEO_END_QUERY_TAG))
							
							// Extract SearchEngines from Cache and then replace with new SearchEngines 
							intStart=strCacheData.indexOf(VIDEO_START_QUERY_TAG)+VIDEO_START_SEARCHENGINES_TAG.length;
							intEnd=strCacheData.indexOf(VIDEO_END_SEARCHENGINES_TAG);
							strOldString=VIDEO_START_QUERY_TAG +strCacheData.substring(intStart,intEnd)+VIDEO_END_SEARCHENGINES_TAG;
							strCacheData=strCacheData.replace(strOldString,(VIDEO_START_SEARCHENGINES_TAG +getSelectedSearchEngines() +VIDEO_END_SEARCHENGINES_TAG))
							
							// Extract html from Cache and then replace with new HTML
							intStart=strCacheData.indexOf(VIDEO_START_TAG)+VIDEO_START_TAG.length;
							intEnd=strCacheData.indexOf(VIDEO_END_TAG);
							strOldString=VIDEO_START_TAG +strCacheData.substring(intStart,intEnd) + VIDEO_END_TAG;
							strCacheData=strCacheData.replace(strOldString,(VIDEO_START_TAG+ strHtml + VIDEO_END_TAG))
							
							
							
							// Save Updated Data on CACHE 
							document.getElementById("txtCache").value=strCacheData;
					}
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//END CACHE IMAGE RESULTS
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				}
				
				catch(e)	
				{
					showSearchResultsError("Sorry, No results found ","WARNING");
				}
		
		}
		catch(e)
		{
			showSearchResultsError("We was not able to complete your request","ERROR");
		}
	}
	
	changeSearchResultTab('VIDEO');
}		
		
/*******************************************************************************************************************
Name				: AddVideoToEditor(pUrl,pThumbnail)
Description			: This function is used add Video(Video Thumbnail and Video Link) to Editor 
Input Parameters	: pUrl of Video file ,pThumbnail of the video file 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/

function AddVideoToEditor(pUrl,pThumbnail)
{
	//var strVideoImagePath="/UserFiles/Image/video.jpg";
	var strVideoImagePath=pThumbnail;
	var strHeight=75;
	var strWidth=75;
	
	var strTwoExt = pUrl.substr(pUrl.length-2,pUrl.length);
	var strThreeExt= pUrl.substr(pUrl.length-3,pUrl.length);
	var strFourExt = pUrl.substr(pUrl.length-4,pUrl.length);
	
	var arrTwoExt = new Array('rm');
	var arrThreeExt = new Array('wmv','mp3','avi','mpg','asx','ram','mov');
	var arrFourExt = new Array('mpeg','flv','mp4');
	var blnStatus=false;
	if (blnStatus==false)
	{
		for (i=0;i<arrTwoExt.length;i++)
		{
			if (strTwoExt==arrTwoExt[i])	
			{
				//blnStatus=true;
				objEditorInstance.InsertHtml("<a href='" + decode(pUrl) +"'><img src="+ strVideoImagePath + " width=" + strWidth + " height=" +strHeight +"></a>");
				return false;
			}
		}
	}
	if (blnStatus==false)
	{
		for (j=0;j<arrThreeExt.length;j++)
		{
			if (strThreeExt==arrThreeExt[j])	
			{
				blnStatus=true;
				objEditorInstance.InsertHtml("<a href='" + pUrl +"'><img src="+ strVideoImagePath + " width=" + strWidth + " height=" +strHeight +"></a>");
				return false;
			}
		}
	}
	if (blnStatus==false)
	{
	
		for (k=0;k<arrFourExt.length;k++)
		{
			if (strFourExt==arrFourExt[k])	
			{
				blnStatus=true;
				objEditorInstance.InsertHtml("<a href='" + pUrl +"'><img src="+ strVideoImagePath + " width=" + strWidth + " height=" +strHeight +"></a>");
				return false;
			}
		}
	}
	if (blnStatus==false)
	{

		alert('Format not supported');

	}
	
	
}
		

/*******************************************************************************************************************
Name				: getNextAudioResults().
Description			: This function is used to to retrieve next Audio results
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	25-05-2006       1.00
*********************************************************************************************************************/
function getNextAudioResults(pStartIndex)
{
	document.getElementById("hdnAudioStartIndex").value=(parseInt(document.getElementById("hdnAudioStartIndex").value)+MAX_AUDIO_RESULTS);
	getAudioResults(parseInt(document.getElementById("hdnAudioStartIndex").value));
	return false;
}

/*******************************************************************************************************************
Name				: getPreviousImageResults().
Description			: This function is used to to retrieve next image results
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-06-2006       1.00
*********************************************************************************************************************/

function getPreviousAudioResults()
{
	if (document.getElementById("hdnAudioStartIndex").value>1)
	{
		document.getElementById("divResults").style.visibility="visible";
		document.getElementById("divResults").innerHTML="<b>&nbsp;&nbsp;&nbsp;Error occured while retrieving results</b>";
		
	}
	else
	{
		//TODO- DISABLE PREVIOUS LINK 
	}
	return false;
}

/*******************************************************************************************************************
Name				: getAudioResults()
Description			: This function is used to retrieve Image results from ImageXml using xmlHTTP objects 
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		

function getAudioResults(pStartIndex)
{
	
	var strSearchEngines="";
	var intStartIndex=pStartIndex;
	//var intNumberOfRecords=10;
	
	strContentTypes= new String();
	strContentTypes=getSelectedContentTypes();
	if (strContentTypes.indexOf("AUDIO")!=-1)
	{
		var xmlhttp = GetHttpRequestObject();
		try
		{	
			document.getElementById("divResults").style.visibility="visible";
			document.getElementById("divResults").innerHTML="&nbsp;<b>Loading....</b><img src=/imageFiles/"+ strSkin+ "/busy.gif width=16 height=16>";
	
			strSearchEngines=getSelectedSearchEngines();
			var url="SearchService/AudioXml.php?Query=" +document.getElementById("txtQuery").value+"&StartIndex="+intStartIndex+"&NoOfResults="+MAX_AUDIO_RESULTS+"&SearchEngines="+strSearchEngines ;
	
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange=function() 
			{
				if (xmlhttp.readyState==4) 
			 	{
				   	var reply = xmlhttp.responseText;

					tempValid = true
					XmlParseAudioData(reply);
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
}
		
/*******************************************************************************************************************
Name				: XmlParseAudioData(XMLstr)
Description			: This function is used to parse XML data which is obtained from ImageXML using xmlHTTP object 
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		
function XmlParseAudioData(XMLstr)
{
	//var XMLDoc =new ActiveXObject("Microsoft.XMLDOM");
	var rootNode="";
	var intNoOfRecords="";
	var strUrl="";
	var strSearchEngine="";
	var strTitle="";
	var lngFileSize=0;
	var strFileFormat="";
	var lngDuration=0;
	var strCopyRight=""; 
	var strToolTip=""; 	
	var intNoOfCols=8; 
	
	// CACHE variables
	var strOldString=""; 
	var intStart=0;
	var intEnd=0;
	
	
	// Current selected Tab is not  then exit from this function 	
	if (SELECTED_SEARCH_TAB!="AUDIO")
	{
		return; 
	}
	
	var strHtml="<table cellspacing=0 cellpadding=0 border=0>";
	if (window.ActiveXObject)
	{
		var XMLDoc =new ActiveXObject("Microsoft.XMLDOM");
		try 
		{	
			XMLDoc.async = "false";
			if(XMLDoc.loadXML(XMLstr)==true)
			{
				try 
				{
					rootNode=XMLDoc.documentElement;
					intNoOfRecords=rootNode.selectSingleNode("TotalResult").text;
					if (intNoOfRecords>0)
					{
						for(i=0;i<intNoOfRecords;i++)	
						{
							strToolTip="";
							
							if (i==0 || i%intNoOfCols==0)
							{
								strHtml=strHtml+"<tr><td width=5></td>";
							}
							strUrl=decode(rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(2).text);
							
							
							strTitle=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(0).text; 
							
							if (strTitle.length>MAX_AUDIO_TITLE_LENGTH)
							{
								strTitle= strTitle.substring(0,MAX_AUDIO_TITLE_LENGTH)+"...";
							}
						
							lngFileSize=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(5).text; 
							strFileFormat=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(6).text; 
							lngDuration=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(7).text; 
							strSearchEngine="[ " + rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(10).text +"]";
							
							// ToolTip Html 
							strToolTip=strToolTip+"<table cellpadding=0 cellspacing=0 border=0>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Title:<td>" + encodeToolTipText(strTitle) + "</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>File Size:<td>" + lngFileSize + "</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>File Format:</td><td>"+ strFileFormat+"</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Duration:</td><td>"+lngDuration+"</td></tr>";
							strToolTip=strToolTip+"<tr class=ToolTipText><td>Search Engine:</td><td>"+strSearchEngine+"</td></tr>";
							strToolTip=strToolTip+"</table>";
						
							
							//alert("<td align=center>"+ "<img src=/UserFiles/Image/Audio.jpg height=75 width=75>" + "</br>" + "<a href='#' class='LinkSmall' onClick=\"return AddAudioToEditor('"+strUrl+"')\"  onMouseover=\"ddrivetip('"+strToolTip+"' ,225)\" onMouseout='hideddrivetip()' >Add"+strSearchEngine+"</a></td>");
							
							strHtml=strHtml+"<td align=center>"+ "<a href='#' onclick=\"javascript:return openAudioPlayer('" + strUrl +  "')\"> <img  src=/UserFiles/Image/Audio.jpg height=75 width=75></a>" + "</br>" + "<a href='#' class='LinkSmall' onClick=\"return AddAudioToEditor('"+strUrl+"')\"  onMouseover=\"ddrivetip('"+strToolTip+"' ,225)\" onMouseout='hideddrivetip()' >Add"+strSearchEngine+"</a></td>";
							//strHtml=strHtml+"<td align=center>"+ "<img src=/UserFiles/Image/Audio.jpg height=75 width=75>" + "</br>" + "<a href='a.php' class=LinkSmall onClick=\"return AddAudioToEditor('"+strUrl+"')\" >Add"+strSearchEngine+"</a></td>";
							strHtml=strHtml+"<td width=5></td>"
							if (i!=0 && i%((intNoOfCols-1) + i + 1)==0)
							{
								strHtml=strHtml+"</tr> <tr><td height=10></td></tr>";
							}
						}
						strHtml=strHtml+"</tr>";
						
						if (parseInt(document.getElementById("hdnAudioStartIndex").value)>1)
							strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a href='' onClick='javascript:return getPreviousAudioResults()' class='LinkSmall'>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextAudioResults()' class='LinkSmall'>Next</a></td></tr>";
						else
							strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a href='' onClick='javascript:return getPreviousAudioResults()' class='LinkSmall' disabled>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextAudioResults()' class='LinkSmall'>Next</a></td></tr>";
							
						
						strHtml=strHtml+"</table>";
						document.getElementById("divResults").style.visibility="visible";
						document.getElementById("divResults").innerHTML=strHtml;
					}
					else
					{
						document.getElementById("divResults").style.visibility="visible";
						document.getElementById("divResults").innerHTML="&nbsp;<b>No Result Found</b>";
					}
					
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//START CACHE AUDIO RESULTS
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					 strCacheData= new String(document.getElementById("txtCache").value+ "");
					 
					 // we will check that wheteher AudioData is already cached or not . 
					 //	if Already cached then replace that data with new values 
					 // else we will just save AudioData in Cache 
					if( strCacheData.indexOf(AUDIO_START_TAG)==-1)
					{
						// Since No VideoData is Saved on the Cache so save it in Cache 	
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + AUDIO_START_PAGE_TAG + document.getElementById("hdnAudioStartIndex").value + AUDIO_END_PAGE_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + AUDIO_START_QUERY_TAG + document.getElementById("txtQuery").value + AUDIO_END_QUERY_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + AUDIO_START_SEARCHENGINES_TAG +getSelectedSearchEngines() + AUDIO_END_SEARCHENGINES_TAG;
						document.getElementById("txtCache").value=document.getElementById("txtCache").value + AUDIO_START_TAG + strHtml + AUDIO_END_TAG;					
					}
					else
					{
							// Since VideoData is already saved into cache so we will replace exisiting Data with new Data 
						
							// Extract PageNumber from Cache and then replace with new PageNumber 	
							intStart=strCacheData.indexOf(AUDIO_START_PAGE_TAG)+AUDIO_START_PAGE_TAG.length;
							intEnd=strCacheData.indexOf(AUDIO_END_PAGE_TAG);
							strOldString=AUDIO_START_PAGE_TAG+strCacheData.substring(intStart,intEnd)+AUDIO_END_PAGE_TAG ;
							strCacheData=strCacheData.replace(strOldString,(AUDIO_START_PAGE_TAG + document.getElementById("hdnAudioStartIndex").value + AUDIO_END_PAGE_TAG))
							
							// Extract Search Query from Cache and then replace with new Search Query 
							intStart=strCacheData.indexOf(AUDIO_START_QUERY_TAG)+AUDIO_START_QUERY_TAG.length;
							intEnd=strCacheData.indexOf(AUDIO_END_QUERY_TAG);
							strOldString=AUDIO_START_QUERY_TAG +strCacheData.substring(intStart,intEnd)+AUDIO_END_QUERY_TAG;
							strCacheData=strCacheData.replace(strOldString,(AUDIO_START_QUERY_TAG +document.getElementById("txtQuery").value +AUDIO_END_QUERY_TAG))
							
							// Extract SearchEngines String from Cache and then replace with new SearchEngines String 
							intStart=strCacheData.indexOf(AUDIO_START_SEARCHENGINES_TAG)+AUDIO_START_SEARCHENGINES_TAG.length;
							intEnd=strCacheData.indexOf(AUDIO_END_SEARCHENGINES_TAG);
							strOldString=AUDIO_START_SEARCHENGINES_TAG +strCacheData.substring(intStart,intEnd)+AUDIO_END_SEARCHENGINES_TAG;
							strCacheData=strCacheData.replace(strOldString,(AUDIO_START_SEARCHENGINES_TAG +getSelectedSearchEngines() +AUDIO_END_SEARCHENGINES_TAG))
							
							
							// Extract html from Cache and then replace with new HTML
							intStart=strCacheData.indexOf(AUDIO_START_TAG)+AUDIO_START_TAG.length;
							intEnd=strCacheData.indexOf(AUDIO_END_TAG);
							strOldString=AUDIO_START_TAG +strCacheData.substring(intStart,intEnd) + AUDIO_END_TAG;
							strCacheData=strCacheData.replace(strOldString,(AUDIO_START_TAG+ strHtml + AUDIO_END_TAG))
							
							// Save Updated Data on CACHE 
							document.getElementById("txtCache").value=strCacheData;
					}
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//END CACHE IMAGE RESULTS
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				}
				catch(e)
				{
					showSearchResultsError("Sorry, No results found ","WARNING");
				}
					
			}
			else
			{
				showSearchResultsError("Error occured while retrieving results","ERROR");
			}	
		}
		catch(e)
		{
			showSearchResultsError("We was notable to complete your request","ERROR");
		}
	}
	// Firefox
	else
	{
		var XMLDoc =  new DOMParser();
		try 
		{	
			XMLDoc.async = "false";
			try 
			{
				var xmlDocoment = XMLDoc.parseFromString(XMLstr, "application/xml");
				var strSearchResults = xmlDocoment.getElementsByTagName('SearchResults');
				intNoOfRecords=strSearchResults[0].getElementsByTagName('TotalResult')[0].textContent;		

				if (intNoOfRecords>0)
				{
					for(i=0;i<intNoOfRecords;i++)	
					{
						var strResult = xmlDocoment.getElementsByTagName('Result');
						strToolTip="";
						
						if (i==0 || i%intNoOfCols==0)
						{
							strHtml=strHtml+"<tr><td width=5></td>";
						}
						strUrl=decode(strResult[i].getElementsByTagName('Url')[0].textContent);
						
						
						strTitle=strResult[i].getElementsByTagName('Title')[0].textContent; 
						
						if (strTitle.length>MAX_AUDIO_TITLE_LENGTH)
						{
							strTitle= strTitle.substring(0,MAX_AUDIO_TITLE_LENGTH)+"...";
						}
					
						lngFileSize=strResult[i].getElementsByTagName('FileSize')[0].textContent;
						strFileFormat=strResult[i].getElementsByTagName('FileFormat')[0].textContent;
						lngDuration=strResult[i].getElementsByTagName('Duration')[0].textContent;
						strSearchEngine="[ " + strResult[i].getElementsByTagName('SearchEngine')[0].textContent +"]";
						
						// ToolTip Html 
						strToolTip=strToolTip+"<table cellpadding=0 cellspacing=0 border=0>";
						strToolTip=strToolTip+"<tr class=ToolTipText><td>Title:<td>" + encodeToolTipText(strTitle) + "</td></tr>";
						strToolTip=strToolTip+"<tr class=ToolTipText><td>File Size:<td>" + lngFileSize + "</td></tr>";
						strToolTip=strToolTip+"<tr class=ToolTipText><td>File Format:</td><td>"+ strFileFormat+"</td></tr>";
						strToolTip=strToolTip+"<tr class=ToolTipText><td>Duration:</td><td>"+lngDuration+"</td></tr>";
						strToolTip=strToolTip+"<tr class=ToolTipText><td>Search Engine:</td><td>"+strSearchEngine+"</td></tr>";
						strToolTip=strToolTip+"</table>";
					
						
						//alert("<td align=center>"+ "<img src=/UserFiles/Image/Audio.jpg height=75 width=75>" + "</br>" + "<a href='#' class='LinkSmall' onClick=\"return AddAudioToEditor('"+strUrl+"')\"  onMouseover=\"ddrivetip('"+strToolTip+"' ,225)\" onMouseout='hideddrivetip()' >Add"+strSearchEngine+"</a></td>");
						
						strHtml=strHtml+"<td align=center>"+ "<a href='#' onclick=\"javascript:return openAudioPlayer('" + strUrl +  "')\"> <img  src=/UserFiles/Image/Audio.jpg height=75 width=75></a>" + "</br>" + "<a href='#' class='LinkSmall' onClick=\"return AddAudioToEditor('"+strUrl+"')\"  onMouseover=\"ddrivetip('"+strToolTip+"' ,225)\" onMouseout='hideddrivetip()' >Add"+strSearchEngine+"</a></td>";
						//strHtml=strHtml+"<td align=center>"+ "<img src=/UserFiles/Image/Audio.jpg height=75 width=75>" + "</br>" + "<a href='a.php' class=LinkSmall onClick=\"return AddAudioToEditor('"+strUrl+"')\" >Add"+strSearchEngine+"</a></td>";
						strHtml=strHtml+"<td width=5></td>"
						if (i!=0 && i%((intNoOfCols-1) + i + 1)==0)
						{
							strHtml=strHtml+"</tr> <tr><td height=10></td></tr>";
						}
					}
					strHtml=strHtml+"</tr>";
					
					if (parseInt(document.getElementById("hdnAudioStartIndex").value)>1)
					{
						strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a href='' onClick='javascript:return getPreviousAudioResults()' class='LinkSmall'>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextAudioResults()' class='LinkSmall'>Next</a></td></tr>";
					}
					else
					{
						strHtml=strHtml+"<tr><td  height=30 colspan="+((intNoOfCols*2)+1) +" align='right'><a href='' onClick='javascript:return getPreviousAudioResults()' class='LinkSmall' disabled>Previous</a>" + "&nbsp;&nbsp;&nbsp;" + "<a href='#' OnClick='javascript:return getNextAudioResults()' class='LinkSmall'>Next</a></td></tr>";
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
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//START CACHE AUDIO RESULTS
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				 strCacheData= new String(document.getElementById("txtCache").value+ "");
				 
				 // we will check that wheteher AudioData is already cached or not . 
				 //	if Already cached then replace that data with new values 
				 // else we will just save AudioData in Cache 
				if( strCacheData.indexOf(AUDIO_START_TAG)==-1)
				{
					// Since No VideoData is Saved on the Cache so save it in Cache 	
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + AUDIO_START_PAGE_TAG + document.getElementById("hdnAudioStartIndex").value + AUDIO_END_PAGE_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + AUDIO_START_QUERY_TAG + document.getElementById("txtQuery").value + AUDIO_END_QUERY_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + AUDIO_START_SEARCHENGINES_TAG +getSelectedSearchEngines() + AUDIO_END_SEARCHENGINES_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + AUDIO_START_TAG + strHtml + AUDIO_END_TAG;					
				}
				else
				{
						// Since VideoData is already saved into cache so we will replace exisiting Data with new Data 
					
						// Extract PageNumber from Cache and then replace with new PageNumber 	
						intStart=strCacheData.indexOf(AUDIO_START_PAGE_TAG)+AUDIO_START_PAGE_TAG.length;
						intEnd=strCacheData.indexOf(AUDIO_END_PAGE_TAG);
						strOldString=AUDIO_START_PAGE_TAG+strCacheData.substring(intStart,intEnd)+AUDIO_END_PAGE_TAG ;
						strCacheData=strCacheData.replace(strOldString,(AUDIO_START_PAGE_TAG + document.getElementById("hdnAudioStartIndex").value + AUDIO_END_PAGE_TAG))
						
						// Extract Search Query from Cache and then replace with new Search Query 
						intStart=strCacheData.indexOf(AUDIO_START_QUERY_TAG)+AUDIO_START_QUERY_TAG.length;
						intEnd=strCacheData.indexOf(AUDIO_END_QUERY_TAG);
						strOldString=AUDIO_START_QUERY_TAG +strCacheData.substring(intStart,intEnd)+AUDIO_END_QUERY_TAG;
						strCacheData=strCacheData.replace(strOldString,(AUDIO_START_QUERY_TAG +document.getElementById("txtQuery").value +AUDIO_END_QUERY_TAG))
						
						// Extract SearchEngines String from Cache and then replace with new SearchEngines String 
						intStart=strCacheData.indexOf(AUDIO_START_SEARCHENGINES_TAG)+AUDIO_START_SEARCHENGINES_TAG.length;
						intEnd=strCacheData.indexOf(AUDIO_END_SEARCHENGINES_TAG);
						strOldString=AUDIO_START_SEARCHENGINES_TAG +strCacheData.substring(intStart,intEnd)+AUDIO_END_SEARCHENGINES_TAG;
						strCacheData=strCacheData.replace(strOldString,(AUDIO_START_SEARCHENGINES_TAG +getSelectedSearchEngines() +AUDIO_END_SEARCHENGINES_TAG))
						
						
						// Extract html from Cache and then replace with new HTML
						intStart=strCacheData.indexOf(AUDIO_START_TAG)+AUDIO_START_TAG.length;
						intEnd=strCacheData.indexOf(AUDIO_END_TAG);
						strOldString=AUDIO_START_TAG +strCacheData.substring(intStart,intEnd) + AUDIO_END_TAG;
						strCacheData=strCacheData.replace(strOldString,(AUDIO_START_TAG+ strHtml + AUDIO_END_TAG))
						
						// Save Updated Data on CACHE 
						document.getElementById("txtCache").value=strCacheData;
				}
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//END CACHE IMAGE RESULTS
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			}
			catch(e)
			{
				showSearchResultsError("Sorry, No results found ","WARNING");
			}
		}
		catch(e)
		{
			showSearchResultsError("We was notable to complete your request","ERROR");
		}
	}
	
	changeSearchResultTab('AUDIO');
}		

/*******************************************************************************************************************
Name				: AddAudioToEditor(pUrl)
Description			: This function is used to insert Audio file into editor 
Input Parameters	: pUrk is url of the Audio file which is to be inserted into editor 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		
function AddAudioToEditor(pUrl)
{
	var strVideoImagePath="/UserFiles/Image/Audio.jpg";
	var strHeight=75;
	var strWidth=75;
	
	var strTwoExt = pUrl.substr(pUrl.length-2,pUrl.length);
	var strThreeExt= pUrl.substr(pUrl.length-3,pUrl.length);
	var strFourExt = pUrl.substr(pUrl.length-4,pUrl.length);
	
	var arrTwoExt = new Array('rm');
	var arrThreeExt = new Array('wav','mp3','avi','mpg','asx','ram');
	var arrFourExt = new Array('mpeg','flv');
	var blnStatus=false;
	if (blnStatus==false)
	{
		for (i=0;i<arrTwoExt.length;i++)
		{
			if (strTwoExt==arrTwoExt[i])	
			{
				blnStatus=true;
				objEditorInstance.InsertHtml("<a href='" + pUrl +"'><img src="+ strVideoImagePath + " width=" + strWidth + " height=" +strHeight +"></a>");
				return false;
			}
		}
	}
	if (blnStatus==false)
	{
		for (j=0;j<arrThreeExt.length;j++)
		{
			if (strThreeExt==arrThreeExt[j])	
			{
				blnStatus=true;
				objEditorInstance.InsertHtml("<a href='" + pUrl +"'><img src="+ strVideoImagePath + " width=" + strWidth + " height=" +strHeight +"></a>");
				return false;
			}
		}
	}
	if (blnStatus==false)
	{
	
		for (k=0;k<arrFourExt.length;k++)
		{
			if (strFourExt==arrFourExt[k])	
			{
				blnStatus=true;
				objEditorInstance.InsertHtml("<a href='" + pUrl +"'><img src="+ strVideoImagePath + " width=" + strWidth + " height=" +strHeight +"></a>");
				return false;
			}
		}
	}
	if (blnStatus==false)
	{
		alert('Format not supported');

	}
	
	
}
////////////////////////////////////////////////
/*******************************************************************************************************************
Name				: getNextTextResults().
Description			: This function is used to to retrieve next Text results
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	25-05-2006       1.00
*********************************************************************************************************************/

function getNextTextResults(pStartIndex)
{
	document.getElementById("hdnTextStartIndex").value=(parseInt(document.getElementById("hdnTextStartIndex").value)+MAX_TEXT_RESULTS);
	getTextResults(parseInt(document.getElementById("hdnTextStartIndex").value));
	return false;
}

/*******************************************************************************************************************
Name				: getPreviousTextResults().
Description			: This function is used to to retrieve next Text results
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	25-05-2006       1.00
*********************************************************************************************************************/

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



/*******************************************************************************************************************
Name				: getAudioResults()
Description			: This function is used to retrieve Image results from ImageXml using xmlHTTP objects 
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		

function getTextResults(pStartIndex)
{

	var strSearchEngines="";
	var intStartIndex=pStartIndex;
	//var intNumberOfRecords=10;
	strContentTypes= new String();
	strContentTypes=getSelectedContentTypes();
	if (strContentTypes.indexOf("TEXT")!=-1)
	{
		
		var xmlhttp = GetHttpRequestObject();
		
		try
		{	
				
			document.getElementById("divResults").style.visibility="visible";
			document.getElementById("divResults").innerHTML="&nbsp;<b>Loading....</b><img src=/imageFiles/"+ strSkin+ "/busy.gif width=16 height=16>";
			strSearchEngines=getSelectedSearchEngines();

			var url="SearchService/TextXml.php?Query=" +document.getElementById("txtQuery").value+"&StartIndex="+intStartIndex+"&NoOfResults="+MAX_TEXT_RESULTS+"&SearchEngines="+strSearchEngines ;

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
}
		
/*******************************************************************************************************************
Name				: XmlParseAudioData(XMLstr)
Description			: This function is used to parse XML data which is obtained from ImageXML using xmlHTTP object 
Input Parameters	: 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		
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

	// Current selected Tab is not  then exit from this function 	
	if (SELECTED_SEARCH_TAB!="TEXT")
	{
		return; 
	}
	
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
				//alert(XMLstr);
				if (intNoOfRecords>0)
				{
						
					strTitle=rootNode.selectSingleNode("SearchResults").childNodes.item(0).childNodes.item(0).text;	
					if (strTitle!="Sorry, no results were found on this query")
					{
						for(i=0;i< intNoOfRecords;i++)	
						{
							
							strTitle=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(0).text;
					
							strSummary=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(1).text;
							strSummary=strSummary.substring(0,intMaxSummaryLength);
							
							//strSearchEngine=rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(7).text;		
							strSearchEngine="";
							strUrl=decode(rootNode.selectSingleNode("SearchResults").childNodes.item(i).childNodes.item(2).text);
								
							strHtml=strHtml+"<tr><td width=5></td><td align=right><b>Title:</b></td><td width=5></td>"+ "<td align=left>" +strTitle + "</td></tr>";				
							strHtml=strHtml+"<tr><td></td><td align=right valign=top><b>Summary:</b></td><td width=5></td>"+ "<td align=left>" +strSummary + "</td></tr>";				
							//strHtml=strHtml+"<tr><td ></td><td width=110 align=right valign=topt><b>Search Engine:</b></td><td width=5></td>"+ "<td align=left>" +strSearchEngine + "</td></tr>";				
							//strHtml=strHtml+"<tr><td></td><td align=right><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a onclick=OpenWindow('" + strUrl+"') href=" +strUrl +" >"+ strUrl+ "</a></td></tr>";				
	
							if (strUrl.length<intMaxUrlLength)
							{
								strUrlToShow= strUrl;
							}
							else
							{
								strUrlToShow= strUrl.substring(0,intMaxUrlLength)+"......";
							}
							strUrl="http://"+strUrl;					
							//strHtml=strHtml+"<tr><td></td><td align=right><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a onclick=\"return OpenWindow('" + strUrl+"')\" href="+strUrl+">"+ strUrlToShow+ "</a></td></tr>";				
							strHtml=strHtml+"<tr><td></td><td align=right><b>URL:</b></td><td width=5></td>"+ "<td align=left>"+"<a href="+strUrl+" target='blank'>"+ strUrlToShow+ "</a></td></tr>";				
							strHtml=strHtml+"<tr><td colspan=2 height=15></td></tr>";
							
	
						}
					
						if (parseInt(document.getElementById("hdnAudioStartIndex").value)>1)
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
						document.getElementById("divResults").innerHTML="&nbsp;<b>No Result Found</b>";
					}
					
				}
				else
				{
					document.getElementById("divResults").style.visibility="visible";
					document.getElementById("divResults").innerHTML="&nbsp;<b>No Result Found</b>";
				}
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//START CACHE TEXT RESULTS
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				 strCacheData= new String(document.getElementById("txtCache").value+ "");
				 
				 // we will check that wheteher Text Data is already cached  or not . 
				 //	if Already cached then replace that data with new values 
				 // else we will just save Text Data in Cache 
				 
				 
				if( strCacheData.indexOf(TEXT_START_TAG)==-1)
				{
					// Since No Text Data is Saved on the Cache so save it on Cache 	
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + TEXT_START_PAGE_TAG + document.getElementById("hdnTextStartIndex").value + TEXT_END_PAGE_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + TEXT_START_QUERY_TAG + document.getElementById("txtQuery").value + TEXT_END_QUERY_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + TEXT_START_SEARCHENGINES_TAG+ getSelectedSearchEngines() + TEXT_END_SEARCHENGINES_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + TEXT_START_TAG + strHtml + TEXT_END_TAG;					
				}
				else
				{
						// Since Text Data is already saved so we will replace exisiting Data with new Data 
					
						// Extract PageNumber from Cache and then replace with new PageNumber 	
						intStart=strCacheData.indexOf(TEXT_START_PAGE_TAG)+TEXT_START_PAGE_TAG.length;
						intEnd=strCacheData.indexOf(TEXT_END_PAGE_TAG);
						strOldString=TEXT_START_PAGE_TAG+strCacheData.substring(intStart,intEnd)+TEXT_END_PAGE_TAG ;
						strCacheData=strCacheData.replace(strOldString,(TEXT_START_PAGE_TAG + document.getElementById("hdnTextStartIndex").value + TEXT_END_PAGE_TAG))
						
						// Extract Search Query from Cache and then replace with new Search Query 
						intStart=strCacheData.indexOf(TEXT_START_QUERY_TAG)+TEXT_START_QUERY_TAG.length;
						intEnd=strCacheData.indexOf(TEXT_END_QUERY_TAG);
						strOldString=TEXT_START_QUERY_TAG +strCacheData.substring(intStart,intEnd)+TEXT_END_QUERY_TAG;
						strCacheData=strCacheData.replace(strOldString,(TEXT_START_QUERY_TAG +document.getElementById("txtQuery").value +TEXT_END_QUERY_TAG))
	
						// Extract SearchEngine String from Cache and then replace with new SearchEngineString 
						intStart=strCacheData.indexOf(TEXT_START_SEARCHENGINES_TAG)+TEXT_START_SEARCHENGINES_TAG.length;
						intEnd=strCacheData.indexOf(TEXT_END_SEARCHENGINES_TAG);
						strOldString=TEXT_START_SEARCHENGINES_TAG +strCacheData.substring(intStart,intEnd)+TEXT_END_SEARCHENGINES_TAG;
						strCacheData=strCacheData.replace(strOldString,(TEXT_START_SEARCHENGINES_TAG +getSelectedSearchEngines() +TEXT_END_SEARCHENGINES_TAG))
	
						
						// Extract html from Cache and then replace with new HTML
						intStart=strCacheData.indexOf(TEXT_START_TAG)+TEXT_START_TAG.length;
						intEnd=strCacheData.indexOf(TEXT_END_TAG);
						strOldString=TEXT_START_TAG +strCacheData.substring(intStart,intEnd) + TEXT_END_TAG;
						strCacheData=strCacheData.replace(strOldString,(TEXT_START_TAG+ strHtml + TEXT_END_TAG))
						
						// Save Updated Data on CACHE 
						document.getElementById("txtCache").value=strCacheData;
				}
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//END CACHE IMAGE RESULTS
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}
			else
			{
				showSearchResultsError("Sorry,Error occured while retrieving results","ERROR");
			}	
		}
		catch(e)
		{
			showSearchResultsError("Sorry, we was not able to complete your request","ERROR");
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
						//strHtml=strHtml+"<tr><td ></td><td width=110 align=right valign=topt><b>Search Engine:</b></td><td width=5></td>"+ "<td align=left>" +strSearchEngine + "</td></tr>";				
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
					if (parseInt(document.getElementById("hdnAudioStartIndex").value)>1)
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
			
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//START CACHE TEXT RESULTS
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				 strCacheData= new String(document.getElementById("txtCache").value+ "");
				 
				 // we will check that wheteher Text Data is already cached  or not . 
				 //	if Already cached then replace that data with new values 
				 // else we will just save Text Data in Cache 
				 
				 
				if( strCacheData.indexOf(TEXT_START_TAG)==-1)
				{
					// Since No Text Data is Saved on the Cache so save it on Cache 	
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + TEXT_START_PAGE_TAG + document.getElementById("hdnTextStartIndex").value + TEXT_END_PAGE_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + TEXT_START_QUERY_TAG + document.getElementById("txtQuery").value + TEXT_END_QUERY_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + TEXT_START_SEARCHENGINES_TAG+ getSelectedSearchEngines() + TEXT_END_SEARCHENGINES_TAG;
					document.getElementById("txtCache").value=document.getElementById("txtCache").value + TEXT_START_TAG + strHtml + TEXT_END_TAG;					
				}
				else
				{
						// Since Text Data is already saved so we will replace exisiting Data with new Data 
					
						// Extract PageNumber from Cache and then replace with new PageNumber 	
						intStart=strCacheData.indexOf(TEXT_START_PAGE_TAG)+TEXT_START_PAGE_TAG.length;
						intEnd=strCacheData.indexOf(TEXT_END_PAGE_TAG);
						strOldString=TEXT_START_PAGE_TAG+strCacheData.substring(intStart,intEnd)+TEXT_END_PAGE_TAG ;
						strCacheData=strCacheData.replace(strOldString,(TEXT_START_PAGE_TAG + document.getElementById("hdnTextStartIndex").value + TEXT_END_PAGE_TAG))
						
						// Extract Search Query from Cache and then replace with new Search Query 
						intStart=strCacheData.indexOf(TEXT_START_QUERY_TAG)+TEXT_START_QUERY_TAG.length;
						intEnd=strCacheData.indexOf(TEXT_END_QUERY_TAG);
						strOldString=TEXT_START_QUERY_TAG +strCacheData.substring(intStart,intEnd)+TEXT_END_QUERY_TAG;
						strCacheData=strCacheData.replace(strOldString,(TEXT_START_QUERY_TAG +document.getElementById("txtQuery").value +TEXT_END_QUERY_TAG))
	
						// Extract SearchEngine String from Cache and then replace with new SearchEngineString 
						intStart=strCacheData.indexOf(TEXT_START_SEARCHENGINES_TAG)+TEXT_START_SEARCHENGINES_TAG.length;
						intEnd=strCacheData.indexOf(TEXT_END_SEARCHENGINES_TAG);
						strOldString=TEXT_START_SEARCHENGINES_TAG +strCacheData.substring(intStart,intEnd)+TEXT_END_SEARCHENGINES_TAG;
						strCacheData=strCacheData.replace(strOldString,(TEXT_START_SEARCHENGINES_TAG +getSelectedSearchEngines() +TEXT_END_SEARCHENGINES_TAG))
	
						
						// Extract html from Cache and then replace with new HTML
						intStart=strCacheData.indexOf(TEXT_START_TAG)+TEXT_START_TAG.length;
						intEnd=strCacheData.indexOf(TEXT_END_TAG);
						strOldString=TEXT_START_TAG +strCacheData.substring(intStart,intEnd) + TEXT_END_TAG;
						strCacheData=strCacheData.replace(strOldString,(TEXT_START_TAG+ strHtml + TEXT_END_TAG))
						
						// Save Updated Data on CACHE 
						document.getElementById("txtCache").value=strCacheData;
				}
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//END CACHE IMAGE RESULTS
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			//}
		}
		catch(e)
		{
			showSearchResultsError("Sorry, we was not able to complete your request","ERROR");
		}		
	}
	changeSearchResultTab('TEXT');
}		

/*******************************************************************************************************************
Name				: AddAudioToEditor(pUrl)
Description			: This function is used to insert Audio file into editor 
Input Parameters	: pUrk is url of the Audio file which is to be inserted into editor 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		
function AddTextToEditor(pUrl)
{
	var strVideoImagePath="/UserFiles/Image/Audio.jpg";
	var strHeight=75;
	var strWidth=75;
	objEditorInstance.InsertHtml("<a href='" + pUrl +"'><img src="+ strVideoImagePath + " width=" + strWidth + " height=" +strHeight +"></a>");
	return false;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/*******************************************************************************************************************
Name				: ChangeResultType(strResultType)
Description			: This function is used to change Search Results type  
Input Parameters	: strResultType is the new result Type 
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		
function ChangeResultType(strResultType)
{

	var intStart=0;
	var intEnd=0;
	var intPage=0;
	var strQuery="";
	var strImagePath="ImageFiles/" + strSkin;
	var strSearchEngines="";
	var strContentTypes="";	
	
	if (strResultType=='VIDEO')
	{	
		strContentTypes= new String();
		strContentTypes=getSelectedContentTypes();
		
		if (strContentTypes.indexOf("VIDEO")!=-1)
		{
			SELECTED_SEARCH_TAB="VIDEO";
			document.getElementById("divResults").innerHTML="<b>Video Results</b></br><img  alt='Product2' id='product_id' src='images/Skype.jpg' height=75 width=75 /> ";

			document.getElementById("hplVideo").className="TabBottomTextHightLight";
			document.getElementById("tdVideo").setAttribute('background',strImagePath+ "/" + 'Tag_Bottom_HighLighted.gif');
			
			document.getElementById("hplAudio").className="TabBottomText";
			document.getElementById("tdAudio").setAttribute('background',strImagePath+ "/" + 'Tag_Bottom.gif');

			document.getElementById("hplText").className="TabBottomText";
			document.getElementById("tdText").setAttribute('background',strImagePath+ "/" +'Tag_Bottom.gif');

			document.getElementById("hplImage").className="TabBottomText";
			document.getElementById("tdImage").setAttribute('background',strImagePath+ "/"+'Tag_Bottom.gif');
		
			
			//////////////////////////////////////////////////////////////////////////////////////
			/// Start Cahe Logic 
			///////////////////////////////////////////////////////////////////////////////////////
	  	   	strCacheData= new String(document.getElementById("txtCache").value+ "");
	  	    // check if Videodata exists in Cache if not then load from server 
			if( strCacheData.indexOf(VIDEO_START_TAG)==-1)
			{
				//VideoData does not exists in Cache so load it from Server 
				//alert("Loading from Server");
				getVideoResults(parseInt(document.getElementById("hdnVideoStartIndex").value));
			}
			else
			{
				// VideoData exists in Cache but now we have to make sure that it has same 
				//PageNumber,Search Query  and Search Engines as  required 
				
				// Extract PageNo from Cache
				intStart=strCacheData.indexOf(VIDEO_START_PAGE_TAG)+VIDEO_START_PAGE_TAG.length;
				intEnd=strCacheData.indexOf(VIDEO_END_PAGE_TAG);
				intPage=parseInt(strCacheData.substring(intStart,intEnd));
				
				// Extract search Engines 
				intStart=strCacheData.indexOf(VIDEO_START_SEARCHENGINES_TAG)+VIDEO_START_SEARCHENGINES_TAG.length;
				intEnd=strCacheData.indexOf(VIDEO_END_SEARCHENGINES_TAG);
				strSearchEngines=strCacheData.substring(intStart,intEnd);
								
				
				// Extract Search Query from Cache 					
				intStart=strCacheData.indexOf(VIDEO_START_QUERY_TAG)+VIDEO_START_QUERY_TAG.length;
				intEnd=strCacheData.indexOf(VIDEO_END_QUERY_TAG);
				strQuery=strCacheData.substring(intStart,intEnd);
				
				
				// Check if Text Cache Data has same PageNumber and Search Query as we we required 
				if (parseInt(document.getElementById("hdnVideoStartIndex").value)==intPage && strQuery==document.getElementById("txtQuery").value  && strSearchEngines == getSelectedSearchEngines())
				{					
				
					// Cache Data has same Page Number,Search Query  and SearchEngines as required... .Load it from Cache
					//alert("Loading from Client");
					intStart=strCacheData.indexOf(VIDEO_START_TAG)+VIDEO_START_TAG.length;
					intEnd=strCacheData.indexOf(VIDEO_END_TAG);
					strCacheData=strCacheData.substring(intStart,intEnd);
					document.getElementById("divResults").style.visibility="visible";
					document.getElementById("divResults").innerHTML=strCacheData;
				}
				else
				{
					//PageNumber or  Search Query or search Engines are not same as required so load from Server 
					//alert("Loading from Server2");
					getVideoResults(parseInt(document.getElementById("hdnVideoStartIndex").value));
				}	
				
			}	
			//////////////////////////////////////////////////////////////////////////////////////
			/// Start Cahe Loagic 
			///////////////////////////////////////////////////////////////////////////////////////
		}	

	}
	else if (strResultType=='AUDIO')
	{
		strContentTypes= new String();
		strContentTypes=getSelectedContentTypes();
		if (strContentTypes.indexOf("AUDIO")!=-1)
		{
			
			SELECTED_SEARCH_TAB="AUDIO";
			
			document.getElementById("divResults").innerHTML="<b>Audio Results</b>";

			document.getElementById("hplAudio").className="TabBottomTextHightLight";
			document.getElementById("tdAudio").setAttribute('background',strImagePath + "/" +'Tag_Bottom_HighLighted.gif');


			document.getElementById("hplVideo").className="TabBottomText";
			document.getElementById("tdVideo").setAttribute('background',strImagePath + "/" + 'Tag_Bottom.gif');
		
			
			document.getElementById("hplText").className="TabBottomText";
			document.getElementById("tdText").setAttribute('background',strImagePath + "/" +'Tag_Bottom.gif');

			document.getElementById("hplImage").className="TabBottomText";
			document.getElementById("tdImage").setAttribute('background',strImagePath+ "/" +'Tag_Bottom.gif');
			
			//////////////////////////////////////////////////////////////////////////////////////
			/// Start Audio Cache Logic 
			///////////////////////////////////////////////////////////////////////////////////////
	  	   	strCacheData= new String(document.getElementById("txtCache").value+ "");
	  	    // check if Videodata exists in Cache if not then load from server 
			if( strCacheData.indexOf(AUDIO_START_TAG)==-1)
			{
				//AudioData does not exists in Cache so load it from Server 
				//alert("Loading from Server");
				getAudioResults(parseInt(document.getElementById("hdnAudioStartIndex").value));
			}
			else
			{
				// AudioData exists in Cache but now we have to make sure that it has same 
				//PageNumber,SearchQuery and searchEngines String as required 
				
				// Extract PageNo from Cache
				intStart=strCacheData.indexOf(AUDIO_START_PAGE_TAG)+AUDIO_START_PAGE_TAG.length;
				intEnd=strCacheData.indexOf(AUDIO_END_PAGE_TAG);
				intPage=parseInt(strCacheData.substring(intStart,intEnd));
				
				// Extract Search Query from Cache 					
				intStart=strCacheData.indexOf(AUDIO_START_QUERY_TAG)+AUDIO_START_QUERY_TAG.length;
				intEnd=strCacheData.indexOf(AUDIO_END_QUERY_TAG);
				strQuery=strCacheData.substring(intStart,intEnd);
				
				// Extract SearchEngines String from Cache 					
				intStart=strCacheData.indexOf(AUDIO_START_SEARCHENGINES_TAG)+AUDIO_START_SEARCHENGINES_TAG.length;
				intEnd=strCacheData.indexOf(AUDIO_END_SEARCHENGINES_TAG);
				strSearchEngines=strCacheData.substring(intStart,intEnd);
				
				
				// Check if Text Cache Data has same PageNumber,SearchQuery  and SearchEngines String as required 
				if (parseInt(document.getElementById("hdnAudioStartIndex").value)==intPage && strQuery==document.getElementById("txtQuery").value  && strSearchEngines==getSelectedSearchEngines())
				{					
				
					// Cache Data has same PageNumber,SearchQuery and SearchEngines as required... .Load it from Cache
					//alert("Loading from Client");
					intStart=strCacheData.indexOf(AUDIO_START_TAG)+AUDIO_START_TAG.length;
					intEnd=strCacheData.indexOf(AUDIO_END_TAG);
					strCacheData=strCacheData.substring(intStart,intEnd);
					document.getElementById("divResults").style.visibility="visible";
					document.getElementById("divResults").innerHTML=strCacheData;
				}
				else
				{
					//PageNumber and Search Query is not same as required so load from Server 
					//alert("Loading from Server2");
					getAudioResults(parseInt(document.getElementById("hdnAudioStartIndex").value));
				}	
				
			}	
			//////////////////////////////////////////////////////////////////////////////////////
			/// End Cache Logic 
			///////////////////////////////////////////////////////////////////////////////////////
		}	

	}
	else if (strResultType=='TEXT')
	{
		
		strContentTypes= new String();
		strContentTypes=getSelectedContentTypes();
		if (strContentTypes.indexOf("TEXT")!=-1)
		{
			SELECTED_SEARCH_TAB="TEXT";
			document.getElementById("divResults").innerHTML="<b>Text Results</b>";

			document.getElementById("hplText").className="TabBottomTextHightLight";
			document.getElementById("tdText").setAttribute('background',strImagePath+ "/" +'Tag_Bottom_HighLighted.gif');

			document.getElementById("hplAudio").className="TabBottomText";
			document.getElementById("tdAudio").setAttribute('background',strImagePath + "/" +'Tag_Bottom.gif');

			document.getElementById("hplVideo").className="TabBottomText";
			document.getElementById("tdVideo").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');

			document.getElementById("hplImage").className="TabBottomText";
			document.getElementById("tdImage").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
			
			//////////////////////////////////////////////////////////////////////////////////////
			/// Start Cache Loagic 
			///////////////////////////////////////////////////////////////////////////////////////
	  	   strCacheData= new String(document.getElementById("txtCache").value+ "");
	  	    // check if Text data exists in Cache if not then load from server 
			if( strCacheData.indexOf(TEXT_START_TAG)==-1)
			{
				// Text Data does not exists in Cache so load it from Server 
				//alert("Loading from Server");
				getTextResults(parseInt(document.getElementById("hdnTextStartIndex").value));
			}
			else
			{
				// Text Data exists in Cache but now we have to make sure that it has same 
				//PageNumber,SearchQuery and SearchEngines as required 
				
				// Extract PageNo from Cache
				intStart=strCacheData.indexOf(TEXT_START_PAGE_TAG)+TEXT_START_PAGE_TAG.length;
				intEnd=strCacheData.indexOf(TEXT_END_PAGE_TAG);
				intPage=parseInt(strCacheData.substring(intStart,intEnd));
				
				// Extract Search Query from Cache 					
				intStart=strCacheData.indexOf(TEXT_START_QUERY_TAG)+TEXT_START_QUERY_TAG.length;
				intEnd=strCacheData.indexOf(TEXT_END_QUERY_TAG);
				strQuery=strCacheData.substring(intStart,intEnd);
				
				// Extract SearchEngines String from Cache 					
				intStart=strCacheData.indexOf(TEXT_START_SEARCHENGINES_TAG)+TEXT_START_SEARCHENGINES_TAG.length;
				intEnd=strCacheData.indexOf(TEXT_END_SEARCHENGINES_TAG);
				strSearchEngines=strCacheData.substring(intStart,intEnd);
				
				
				// Check if Text Cache Data has same PageNumber and Search Query as we we required 
				if (parseInt(document.getElementById("hdnTextStartIndex").value)==intPage && strQuery==document.getElementById("txtQuery").value && strSearchEngines==getSelectedSearchEngines() )
				{					
				
					// Cache Data has same Page Number and Search Query as required... .Load it from Cache
					//alert("Loading from Client");
					intStart=strCacheData.indexOf(TEXT_START_TAG)+TEXT_START_TAG.length;
					intEnd=strCacheData.indexOf(TEXT_END_TAG);
					strCacheData=strCacheData.substring(intStart,intEnd);
					document.getElementById("divResults").style.visibility="visible";
					document.getElementById("divResults").innerHTML=strCacheData;
				}
				else
				{
					//PageNumber and Search Query is not same as required so load from Server 
					//alert("Loading from Server2");
					getTextResults(parseInt(document.getElementById("hdnTextStartIndex").value));
				}	
				
			}	
			//////////////////////////////////////////////////////////////////////////////////////
			/// Start Cahe Loagic 
			///////////////////////////////////////////////////////////////////////////////////////
		}	
	}
	else if (strResultType=='IMAGE')
	{

		strContentTypes= new String();

		strContentTypes=getSelectedContentTypes();
		if (strContentTypes.indexOf("IMAGE")!=-1)
		{

			SELECTED_SEARCH_TAB="IMAGE";	
					
			document.getElementById("divResults").innerHTML="<b>Image Results</b>";

			document.getElementById("hplImage").className="TabBottomTextHightLight";
			document.getElementById("tdImage").setAttribute('background',strImagePath+"/"+'Tag_Bottom_HighLighted.gif');
			
			document.getElementById("hplText").className="TabBottomText";
			document.getElementById("tdText").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');

			document.getElementById("hplAudio").className="TabBottomText";
			document.getElementById("tdAudio").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');

			document.getElementById("hplVideo").className="TabBottomText";
			document.getElementById("tdVideo").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
			
			//////////////////////////////////////////////////////////////////////////////////////
			/// Start Cache Logic 
			///////////////////////////////////////////////////////////////////////////////////////
			
	  	    strCacheData= new String(document.getElementById("txtCache").value+ "");
	  	    // check if image data exists in Cache if not then load from server 
			if( strCacheData.indexOf(IMAGE_START_TAG)==-1)
			{

				// Image Data does not exists in Cacahe so load it from Server 
				//alert("Loading from Server");
							
				getImageResults(parseInt(document.getElementById("hdnImageStartIndex").value));
			}
			else
			{
				// Image Data exists in Cache but now we have to check that whetther has same PageNumber,SearchQuery,SearchEngines and ContentTypes as required 
				

				// Extract PageNo from Cache
				intStart=strCacheData.indexOf(IMAGE_START_PAGE_TAG)+IMAGE_START_PAGE_TAG.length;
				intEnd=strCacheData.indexOf(IMAGE_END_PAGE_TAG);
				intPage=parseInt(strCacheData.substring(intStart,intEnd));
				
				// Extract Search Query from Cache 					
				intStart=strCacheData.indexOf(IMAGE_START_QUERY_TAG)+IMAGE_START_QUERY_TAG.length;
				intEnd=strCacheData.indexOf(IMAGE_END_QUERY_TAG);
				strQuery=strCacheData.substring(intStart,intEnd);
				
				// Extract SearchEngines 
				intStart=strCacheData.indexOf(IMAGE_START_SEARCHENGINES_TAG)+IMAGE_START_SEARCHENGINES_TAG.length;
				intEnd=strCacheData.indexOf(IMAGE_END_SEARCHENGINES_TAG);
				strSearchEngines=strCacheData.substring(intStart,intEnd);

				// Extract ContentTypes
				//intStart=strCacheData.indexOf(IMAGE_START_CONTENTTYPES_TAG)+IMAGE_START_CONTENTTYPES_TAG.length;
				//intEnd=strCacheData.indexOf(IMAGE_END_CONTENTTYPES_TAG);
				//strContentTypes=strCacheData.substring(intStart,intEnd);
				
				// Check CacheData has same PageNo,SearchQuery,SearchEngines and ContentTypes as required  
				//if (parseInt(document.getElementById("hdnImageStartIndex").value)==intPage && strQuery==document.getElementById("txtQuery").value  && strSearchEngines==getSelectedSearchEngines() &&  strContentTypes ==getSelectedContentTypes())
				
				if (parseInt(document.getElementById("hdnImageStartIndex").value)==intPage && strQuery==document.getElementById("txtQuery").value  && strSearchEngines==getSelectedSearchEngines())
				{					
				
					// Cache Data has same PageNumber, Search Query and SearchEngines as requested so load it from Cache 
					//alert("Loading from Client");
					intStart=strCacheData.indexOf(IMAGE_START_TAG)+IMAGE_START_TAG.length;
					intEnd=strCacheData.indexOf(IMAGE_END_TAG);
					strCacheData=strCacheData.substring(intStart,intEnd);
					document.getElementById("divResults").style.visibility="visible";
					document.getElementById("divResults").innerHTML=strCacheData;
				}
				else
				{
					// Image Cache Data is not same as PageNumber and Search Query we are   requesting so load it from Server 
					//alert("Loading from Server2");
					
					getImageResults(parseInt(document.getElementById("hdnImageStartIndex").value));
				}	
				//////////////////////////////////////////////////////////////////////////////////////
				/// Start Cahe Loagic 
				///////////////////////////////////////////////////////////////////////////////////////
			}
		}
	}
	return false;
}

/*******************************************************************************************************************
Name				: showSearchResultsError()
Description			: This function is used to change Search Results type  
Input Parameters	: pErrorMessage Error message which is to be displayed 
						pErrorType Type of erorr(Error, Warning,Notice etc )
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	02-06-2006       1.00
*********************************************************************************************************************/		
function showSearchResultsError(pErrorMessage,pErrorType) 
{
	var strImagePath="";
	
	if (pErrorType=="WARNING")
	{
		strImagePath=WARNING_IMAGE_PATH;
	}
	else
	{
		//TODO- check other cases 
		strImagePath=WARNING_IMAGE_PATH;
	}
	
	var strErrHTML="<table  height=40 cellspacing=0 cellpadding=0 border=1>"; 
				strErrHTML=strErrHTML+"<tr bgcolor='#ffffae'>";
				strErrHTML=strErrHTML+"<td width='670'>";
				strErrHTML=strErrHTML+"<table cellspacing=0 cellpadding=0 border=0>";
				strErrHTML=strErrHTML+"<tr><td  width=5></td>";
				strErrHTML=strErrHTML+"<td><img src='" + strImagePath + "' width=15 height=15></td><td width=0></td>";
				strErrHTML=strErrHTML+"<td align=left class='ErrorBoxText'>&nbsp;&nbsp; "+ pErrorMessage + " </td>"
				strErrHTML=strErrHTML+"</tr></table>";
				strErrHTML=strErrHTML+"</td></tr></table>";
			
	
	
	document.getElementById("divResults").style.visibility="visible";
	document.getElementById("divResults").innerHTML=strErrHTML;
}

/*******************************************************************************************************************
Name				: changeSearchResultTab()
Description			: This function is used to change Search Results type  
Input Parameters	: pErrorMessage Error message which is to be displayed 
						pErrorType Type of erorr(Error, Warning,Notice etc )
Returns				: 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	02-08-2006       1.00
*********************************************************************************************************************/		
function changeSearchResultTab(pResultType)
{
	var strImagePath="ImageFiles/" + strSkin;
	
	 if (pResultType.indexOf('IMAGE')!=-1)
	 {

		document.getElementById("hplImage").className="TabBottomTextHightLight";
		document.getElementById("tdImage").setAttribute('background',strImagePath+"/"+'Tag_Bottom_HighLighted.gif');
		
		document.getElementById("hplText").className="TabBottomText";
		document.getElementById("tdText").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	
		document.getElementById("hplAudio").className="TabBottomText";
		document.getElementById("tdAudio").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	
		document.getElementById("hplVideo").className="TabBottomText";
		document.getElementById("tdVideo").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	 }
	 else if(pResultType.indexOf('TEXT')!=-1)
	 {
		document.getElementById("hplImage").className="TabBottomText";
		document.getElementById("tdImage").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	
		document.getElementById("hplText").className="TabBottomTextHightLight";
		document.getElementById("tdText").setAttribute('background',strImagePath+"/"+'Tag_Bottom_HighLighted.gif');
	
		
		document.getElementById("hplAudio").className="TabBottomText";
		document.getElementById("tdAudio").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	
		document.getElementById("hplVideo").className="TabBottomText";
		document.getElementById("tdVideo").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	 }
	 else if (pResultType.indexOf('AUDIO')!=-1)
	 {
		document.getElementById("hplImage").className="TabBottomText";
		document.getElementById("tdImage").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	
		document.getElementById("hplText").className="TabBottomText";
		document.getElementById("tdText").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	
		
		document.getElementById("hplAudio").className="TabBottomTextHightLight";
		document.getElementById("tdAudio").setAttribute('background',strImagePath+"/"+'Tag_Bottom_HighLighted.gif');
	
		document.getElementById("hplVideo").className="TabBottomText";
		document.getElementById("tdVideo").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	 }
	 
	 else if (pResultType.indexOf('VIDEO')!=-1)
	 {
		document.getElementById("hplImage").className="TabBottomText";
		document.getElementById("tdImage").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	
		document.getElementById("hplText").className="TabBottomText";
		document.getElementById("tdText").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
		
		document.getElementById("hplAudio").className="TabBottomText";
		document.getElementById("tdAudio").setAttribute('background',strImagePath+"/"+'Tag_Bottom.gif');
	
		document.getElementById("hplVideo").className="TabBottomTextHightLight";
		document.getElementById("tdVideo").setAttribute('background',strImagePath+"/"+'Tag_Bottom_HighLighted.gif');
	 }
}





/*******************************************************************************************************************
Name				: encodeToolTipText(pStr)
Description			: This function is used to remove special characters from ToolTip Text
Input Parameters	: pStr is the new result Type 
Returns				: encoded text 
Pre assumptions		: 
Post assumptions	: 
____________________________________________________________________________________________________________________
 Created          Action      Remarks            Date           Version
_____________________________________________________________________________________________________________________
	KM            Created     -----------    	12-05-2006       1.00
*********************************************************************************************************************/		
function encodeToolTipText(pText)
{
	strText = new String(pText);
	strText=strText.replace(TOOLTIP_SPECIAL_CHARACTERS,"");
	return strText;
}
function EnableDisableCheck()
{

	// Yahoo
	if (document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==false && document.getElementById('chkMsn').checked==false && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==false)
	{
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();
			
		}	
			
		
	}
	// Google
	else if (document.getElementById('chkGoogle').checked==true && document.getElementById('chkYahoo').checked==false && document.getElementById('chkMsn').checked==false && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==false)
	{
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=false
		document.getElementById('chkImage').disabled=true
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		
		document.getElementById('chkVideo').checked=false
		document.getElementById('chkVideo').disabled=true
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=true; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}	
			
		
	}
	// Msn
	else if (document.getElementById('chkMsn').checked==true && document.getElementById('chkGoogle').checked==false && document.getElementById('chkYahoo').checked==false && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==false)  
	{
			document.getElementById('chkText').checked=true
			document.getElementById('chkText').disabled=false
			
			document.getElementById('chkImage').checked=false
			document.getElementById('chkImage').disabled=true
			
			document.getElementById('chkAudio').checked=false
			document.getElementById('chkAudio').disabled=true
			
			document.getElementById('chkVideo').checked=false
			document.getElementById('chkVideo').disabled=true
			if(document.getElementById("txtQuery").value!="")
		    {
		
				SELECTED_SEARCH_TAB="TEXT"; 
				changeSearchResultTab('TEXT');
				document.getElementById('hplImage').disabled=true; 
				document.getElementById('hplText').disabled=false; 
				document.getElementById('hplVideo').disabled=true; 
				document.getElementById('hplAudio').disabled=true; 
				ShowSearchResults();
			}
			
			
		
	}
	// Flickr
	else if (document.getElementById('chkFlickr').checked==true && document.getElementById('chkMsn').checked==false && document.getElementById('chkGoogle').checked==false && document.getElementById('chkYahoo').checked==false && document.getElementById('chkGrouper').checked==false)
	{
			document.getElementById('chkImage').checked=true
			document.getElementById('chkImage').disabled=false
			
			document.getElementById('chkText').checked=false
			document.getElementById('chkText').disabled=true
			
			document.getElementById('chkAudio').checked=false
			document.getElementById('chkAudio').disabled=true
			
			document.getElementById('chkVideo').checked=false
			document.getElementById('chkVideo').disabled=true
		
			if(document.getElementById("txtQuery").value!="")
			{
				SELECTED_SEARCH_TAB="IMAGE"; 
				changeSearchResultTab('IMAGE');
				document.getElementById('hplImage').disabled=false; 
				document.getElementById('hplText').disabled=true; 
				document.getElementById('hplVideo').disabled=true; 
				document.getElementById('hplAudio').disabled=true; 
				ShowSearchResults();		
			}
			
	}
	// Grouper
	else if (document.getElementById('chkGrouper').checked==true && document.getElementById('chkFlickr').checked==false && document.getElementById('chkMsn').checked==false && document.getElementById('chkGoogle').checked==false && document.getElementById('chkYahoo').checked==false)
	{
		
		/*SELECTED_SEARCH_TAB="VIDEO"; 
		changeSearchResultTab('VIDEO');
		
		
		document.getElementById('hplImage').disabled=true; 
		document.getElementById('hplText').disabled=true; 
		document.getElementById('hplVideo').disabled=false; 
		document.getElementById('hplAudio').disabled=true; 

		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		
		document.getElementById('chkText').checked=false
		document.getElementById('chkText').disabled=true
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		
		document.getElementById('chkImage').checked=false
		document.getElementById('chkImage').disabled=true
		ShowSearchResults();
		*/
	}
	
	// Yahoo and Google
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==true && document.getElementById('chkMsn').checked==false && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==false)
	{
			document.getElementById('chkText').checked=true
			document.getElementById('chkText').disabled=false
			
			document.getElementById('chkImage').checked=true
			document.getElementById('chkImage').disabled=false
			
			document.getElementById('chkAudio').checked=true
			document.getElementById('chkAudio').disabled=false
			
			document.getElementById('chkVideo').checked=true
			document.getElementById('chkVideo').disabled=false	
			if(document.getElementById("txtQuery").value!="")
			{
				SELECTED_SEARCH_TAB="IMAGE"; 
				changeSearchResultTab('IMAGE');
				document.getElementById('hplImage').disabled=false; 
				document.getElementById('hplText').disabled=false; 
				document.getElementById('hplVideo').disabled=false; 
				document.getElementById('hplAudio').disabled=false; 
				ShowSearchResults();
			}
				
		
			
		
	}
	// Yahoo and Msn
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkMsn').checked==true && document.getElementById('chkGoogle').checked==false  && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==false)
	{
			document.getElementById('chkText').checked=true
			document.getElementById('chkText').disabled=false
			
			document.getElementById('chkImage').checked=true
			document.getElementById('chkImage').disabled=false
			
			document.getElementById('chkAudio').checked=true
			document.getElementById('chkAudio').disabled=false
			
			document.getElementById('chkVideo').checked=true
			document.getElementById('chkVideo').disabled=false	

			if(document.getElementById("txtQuery").value!="")
			{
				SELECTED_SEARCH_TAB="IMAGE"; 
				changeSearchResultTab('IMAGE');
				document.getElementById('hplImage').disabled=false; 
				document.getElementById('hplText').disabled=false; 
				document.getElementById('hplVideo').disabled=false; 
				document.getElementById('hplAudio').disabled=false; 
				ShowSearchResults();				
			}
			
		
	}
	// Yahoo and Flickr
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkMsn').checked==false && document.getElementById('chkGoogle').checked==false && document.getElementById('chkGrouper').checked==false)
	{
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false	
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();			
		}
			

	}
	// Yahoo and Grouper
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkGoogle').checked==false && document.getElementById('chkMsn').checked==false && document.getElementById('chkFlickr').checked==false)
	{
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false	
		if(document.getElementById("txtQuery").value!="")
		{
		
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();
		}
		
		
	}
	
	// Google and Msn
	else if(document.getElementById('chkGoogle').checked==true && document.getElementById('chkMsn').checked==true && document.getElementById('chkYahoo').checked==false && document.getElementById('chkGrouper').checked==false && document.getElementById('chkFlickr').checked==false)
	{
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=false
		document.getElementById('chkImage').disabled=true
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=true; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
		

	}
	// Google and Flickr
	else if(document.getElementById('chkGoogle').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkMsn').checked==false && document.getElementById('chkYahoo').checked==false && document.getElementById('chkGrouper').checked==false)
	{
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		
		document.getElementById('chkVideo').checked=false
		document.getElementById('chkVideo').disabled=true	
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');
			
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=true; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
		
		
		
	}
	// Google and Grouper
	else if(document.getElementById('chkGoogle').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkFlickr').checked==false && document.getElementById('chkMsn').checked==false && document.getElementById('chkYahoo').checked==false)
	{
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=false
		document.getElementById('chkImage').disabled=true
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		
		document.getElementById('chkVideo').checked=false
		document.getElementById('chkVideo').disabled=true	
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();		
		}
			

	}
	// Msn and Flickr
	else if(document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGoogle').checked==false && document.getElementById('chkGrouper').checked==false && document.getElementById('chkYahoo').checked==false)
	{
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		
		document.getElementById('chkVideo').checked=false
		document.getElementById('chkVideo').disabled=true	
		if(document.getElementById("txtQuery").value!="")
		{
			
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=true; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
	
	}
	// Msn and Grouper
	else if(document.getElementById('chkMsn').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkGoogle').checked==false && document.getElementById('chkFlickr').checked==false && document.getElementById('chkYahoo').checked==false)
	{
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=false
		document.getElementById('chkImage').disabled=true
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
	}
	
	// flickr and grouper
	else if(document.getElementById('chkGrouper').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkMsn').checked==false && document.getElementById('chkGoogle').checked==false && document.getElementById('chkYahoo').checked==false)
	{

		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		
		document.getElementById('chkText').checked=false
		document.getElementById('chkText').disabled=true
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		if(document.getElementById("txtQuery").value!="")
		{	
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=true; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
	
	}
	// yahoo, google, msn
	
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==true && document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==false)
	{
		
			
			
			document.getElementById('chkText').checked=true
			document.getElementById('chkText').disabled=false
			
			document.getElementById('chkImage').checked=true
			document.getElementById('chkImage').disabled=false
			
			document.getElementById('chkAudio').checked=true
			document.getElementById('chkAudio').disabled=false
			
			document.getElementById('chkVideo').checked=true
			document.getElementById('chkVideo').disabled=false
			if(document.getElementById("txtQuery").value!="")
			{	
	
				SELECTED_SEARCH_TAB="IMAGE"; 
				changeSearchResultTab('IMAGE');
				document.getElementById('hplImage').disabled=false; 
				document.getElementById('hplText').disabled=false; 
				document.getElementById('hplVideo').disabled=false; 
				document.getElementById('hplAudio').disabled=false; 
				ShowSearchResults();			
			}

		
	}
	// yahoo, google, flickr
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==true && document.getElementById('chkMsn').checked==false && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==false)
	{
		
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{	
	
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();	
		}

	}
	
	// yahoo, google, grouprt
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==true && document.getElementById('chkMsn').checked==false && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==true)
	{
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{	
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();	
		}
	}
	
	
	// yahoo, msn, flickr
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==false && document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==false)
	{

		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{	
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();	
		}
	}
	// yahoo, msn, flickr
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==false && document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==true)
	{
	
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();	
		}
	}
	
	// yahoo, flickr, Grouper
	else if(document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==false && document.getElementById('chkMsn').checked==false && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==true)
	{
		
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();
		}	

	}
	
	// Google, Msn, Flickr
	else if(document.getElementById('chkGoogle').checked==true && document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkYahoo').checked==false && document.getElementById('chkGrouper').checked==false)
	{
		
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=false
		document.getElementById('chkVideo').disabled=true		
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		if(document.getElementById("txtQuery").value!="")
		{
	
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=true; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
			
	}
	// Google, Msn, Grouper
	else if(document.getElementById('chkGoogle').checked==true && document.getElementById('chkMsn').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkYahoo').checked==false && document.getElementById('chkFlickr').checked==false)
	{
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=false
		document.getElementById('chkImage').disabled=true
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');	
			document.getElementById('hplImage').disabled=true; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
		
	}
	// Google, Flickr, Grouper
	else if(document.getElementById('chkGoogle').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkYahoo').checked==false && document.getElementById('chkMsn').checked==false)
	{
			
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		if(document.getElementById("txtQuery").value!="")
		{
		
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');		
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
		
	}
	// Msn, Flickr, Grouper
	else if(document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkYahoo').checked==false && document.getElementById('chkGoogle').checked==false)
	{
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');	
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
		
	}
	// Google,Msn, Flickr, Grouper
	else if(document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkYahoo').checked==false && document.getElementById('chkGoogle').checked==true)
	{
				
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="TEXT"; 
			changeSearchResultTab('TEXT');	
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=true; 
			ShowSearchResults();
		}
		
	}
	// Yahoo, Google, Msn, Flickr
	else if(document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==false && document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==true)
	{
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');	
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();
		}
		
	}
	// Yahoo, Google, Msn, Grouper
	else if(document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==false && document.getElementById('chkGrouper').checked==true && document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==true)
	{
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{
		
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');	
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();
		}
		
	}
	// Yahoo, Google, flickr, Grouper
	else if(document.getElementById('chkMsn').checked==false && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==true)
	{
			
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();
		}
		
	}
	// Yahoo, Msn, Flickr, Grouper
	else if(document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==false)
	{
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{
	
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();
		}
		
	}
	// Yahoo,Google,Msn, Flickr, Grouper
	else if(document.getElementById('chkMsn').checked==true && document.getElementById('chkFlickr').checked==true && document.getElementById('chkGrouper').checked==true && document.getElementById('chkYahoo').checked==true && document.getElementById('chkGoogle').checked==true)
	{
		
		document.getElementById('chkText').checked=true
		document.getElementById('chkText').disabled=false
		
		document.getElementById('chkImage').checked=true
		document.getElementById('chkImage').disabled=false
		
		document.getElementById('chkVideo').checked=true
		document.getElementById('chkVideo').disabled=false		
		
		document.getElementById('chkAudio').checked=true
		document.getElementById('chkAudio').disabled=false
		if(document.getElementById("txtQuery").value!="")
		{
			SELECTED_SEARCH_TAB="IMAGE"; 
			changeSearchResultTab('IMAGE');
			document.getElementById('hplImage').disabled=false; 
			document.getElementById('hplText').disabled=false; 
			document.getElementById('hplVideo').disabled=false; 
			document.getElementById('hplAudio').disabled=false; 
			ShowSearchResults();
		}
		
	}
	else
	{
		document.getElementById('hplImage').disabled=true; 
		document.getElementById('hplText').disabled=true; 
		document.getElementById('hplVideo').disabled=true; 
		document.getElementById('hplAudio').disabled=true; 
		
		document.getElementById('chkText').checked=false
		document.getElementById('chkText').disabled=true
		
		document.getElementById('chkImage').checked=false
		document.getElementById('chkImage').disabled=true
		
		document.getElementById('chkVideo').checked=false
		document.getElementById('chkVideo').disabled=true		
		
		document.getElementById('chkAudio').checked=false
		document.getElementById('chkAudio').disabled=true
		
	}
	
	
	
	
	
	
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

