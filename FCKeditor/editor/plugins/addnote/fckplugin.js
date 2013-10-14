// Register the related command.
var FCKAddNote = function(name) { 
    this.Name = name; 
}

function removeBR(input) {
	var output = "";
	for (var i = 0; i < input.length; i++) {
		if ((input.charCodeAt(i) == 13) && (input.charCodeAt(i + 1) == 10)) {
			i++;
			output += " ";
		}else {
			output += input.charAt(i);
   		}
	}
	return output;
}

FCKSelection.GetSelectedHTML = function() {
	if( FCKBrowserInfo.IsIE) {
		var oRange = FCK.EditorDocument.selection.createRange() ;
		//if an object like a table is deleted, the call to GetType before getting again a range returns Control
		switch ( this.GetType() ) {
			case 'Control' :
			return oRange.item(0).outerHTML;

			case 'None' :
			return '' ;

			default :
			return oRange.htmlText ;
		}
	}
	if ( FCKBrowserInfo.IsGecko ) {
		var oSelection = FCK.EditorWindow.getSelection();
		//Gecko doesn't provide a function to get the innerHTML of a selection,
		//so we must clone the selection to a temporary element and check that innerHTML
		var e = FCK.EditorDocument.createElement( 'DIV' );
		for ( var i = 0 ; i < oSelection.rangeCount ; i++ ) {
			e.appendChild( oSelection.getRangeAt(i).cloneContents() );
		}
		return e.innerHTML;
	}
} 

FCKAddNote.prototype.Execute = function() {
	alert('Add Note Button is under construction');
	exit();
	if ( !FCKSelection.GetSelectedHTML() ) { 				/* no selection has been made */
		//alert (FCKLang.MakeCaseChangeSelection);
		return;
	}
	var html ='';
	if( FCKBrowserInfo.IsIE) {								/* IE uses the clipboard (much faster) */
		window.clipboardData.clearData();					/* clean the clipboard, before we start */
		FCK.EditorDocument.execCommand('copy');				/* put the selected area on the clipboard */
		html += FCK.GetClipboardHTML();						/* dump the selected html from the clipboard into var html */
	} else{
		html += removeBR(FCKSelection.GetSelectedHTML());	/* remove linefeeds and put the selected html into var html */
	}
	if (html.toLowerCase() == html) {
	   html = html.toUpperCase();
	}else {
	   html = html.toLowerCase();
	}
	FCK.InsertHtml( html );								// dump the tag in the editor
} 


// manage the plugins' button behavior 
FCKAddNote.prototype.GetState = function() { 
  return FCK_TRISTATE_OFF; 
  // default behavior, sometimes you wish to have some kind of if statement here 
}

// Register the related command. 
FCKCommands.RegisterCommand( 'addnote', new FCKAddNote('addnote'));

// Create the "MakeAbbr" toolbar button.
var oAddNote = new FCKToolbarButton( 'addnote' ) ;
oAddNote.IconPath = FCKConfig.PluginsPath + 'addnote/preview.gif' ;
FCKToolbarItems.RegisterItem( 'addnote', oAddNote ) ;

