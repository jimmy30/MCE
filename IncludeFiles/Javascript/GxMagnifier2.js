/*
	Google Map Magnifier control from GoogleMappers.com
	Version: 0.95 (BETA)
	Released: 25-Jul-2005
	Compatible with Google Maps API version: 1.0, as of maps.14.js
	This code lives at http://www.googlemappers.com/libraries/gxmagnifier/


	LEGAL:

		The code, which has been nurtured and slaved over, is hereby released
		into to the wild. Feel free to evolve/hack it as you see fit, but please
		always retain a reference in the source code to Richard Kagerer and
		GoogleMappers.com as the original source of the component.

		Use of this software is entirely at your own risk.  There are no warrantees of any
		kind implied, and the author shall not be held liable for any damages whatsoever
		resulting from its use.

	NOTES:

		Eventually a better obfuscated version will be available, in the
		meantime feel free to obfuscate it yourself.

		The code has been tested under MSIE 6.x and Firefox 1.0.x


	DOCUMENTATION:

		Usage:
			- Simplest use:
			map.addControl(new GxMagnifierControl())

			- Slightly more "API-safe" use (but in this case you have to
			write your own code to toggle the magnifier on/off):
			var magnifier = new GxMagnifier(map)

		See online documentation for more.


	CODE CONVENTIONS:

		- What are all these _____SomeFunction() symbols about?  I use UltraEdit32 for Javascript
		editing, which includes a CTAGS implementation.  That means it can generate a function list
		for me of everything in this file.  These funny looking lines are simply there to help
		organize that list for me.

		- Eventually it might be nice to break this file up into several smaller ones to
		help manage things better.

		- The [PRIVATE] and [PUBLIC] markers are to indicate how things should be obfuscated.  It's
		easy to write a program that will pick out such lines and list them.  I haven't yet completed
		marking up the whole file.

		- Function names starting with p_ are private (for the obfuscator, and to remind YOU).

		- Non API-safe calls are generally marked with "// NONAPI " followed by LOW, MED or HIGH


	HOW TO MODIFY:

		- If you want to incorporate fixes/enhancements into the "official" GxMagnifier control,
		please MAKE SURE that the code you're submitting looks correct with a tab size of 2.


	WISHLIST:

		- If the user constantly moves the magnifier around, map tiles may not download.  A delay
		could be implemented when not visible, instead of autorefreshing constantly.  When hidden
		we could just autorefresh when the mouse moves by a great deal (i.e. a whole viewport of the
		magnified map).  Or only autorefresh every x milliseconds.

		- Figure out if there's a memory leak, and if so, if it's from us or from the Google Maps API.
		Try to fix if it it's the former.  Note that this issue seems to be getting better with each
		new release of the maps.x.js file.


	REVISIONS:

    02-Mai-2006, Andre Howe:
    Porting the panning functionality to v2 of Google Maps API 
      (it is still a little buggy and 'bumpy')
    Please have a look in the p_doAutoPan method to make it more smooth.
    Known issues and things todo in the v2 port of GxMagnifier:
    - There are still some old v1 methods to be ported to v2
      o some of the GPoint's are geographical coordinates
         port these GPoint's to GLatLng 
      o panTo -> panBy
      o ... all the ones missed ... :-)  
    
    30-Apr-2006, Eric Daniel:
    Fixed the "Copyright issue for the zoom"
    Fixed a bug with resising the window.

    06-Apr-2006, Andre Howe:
    Ported to v2 of the Google Maps API
        
    04-Apr-2006, Eric Daniel:
    Code has been modified to suit specific needs of the map-module for gallery2

		09-Oct-2005, Richard Kagerer:
		Fixed bug under Internet Explorer where where copyright tag would clutter the magnified map.
		This occurred after a maps.x.js update which changed the "noprint" style name to " noprint".

		03-Aug-2005, Richard Kagerer:
		Added missing declaration for DEFAULT_MAGNIFY_FACTOR, and fixed setMagnification to work
		properly if 0 is given as argument.  Released as 0.93 BETA.

		25-Jul-2005, Richard Kagerer:
		Completed code rewrite to make everything more organized and added new features
		including enabledSyncOverlays.  Released as version 0.9 BETA.

		21-Jul-2005, Richard Kagerer:
		Initial working version created.

*/

function GxMagnifierNamespace() {

	/*************************************************************************************************
	* Browser check
	*************************************************************************************************/

	// Browser-check (currently based on http://www.hypergurl.com/attack.html but I'd like to pull
	// this straight from the GMap library).
	var n4=(document.layers);
	var n6=(document.getElementById&&!document.all);
	var ie=(document.all);
	var o6=(navigator.appName.indexOf("Opera") != -1);

	/*************************************************************************************************
	* GxMagnifier class
	*************************************************************************************************/

	// Constructor
	// - GMap underlyingMap = a reference to the main map
	// - bool makeCopy? can be false to cause a new map to be created
	// - HTMLElement customContainer? can be specified as a target for magnified map
	function GxMagnifierb(underlyingMap, useBlank, customContainer) { // [PUBLIC]

		// Set up default state
		if (useBlank == undefined || useBlank == null) useBlank = false;
		this.p_initDefaults(useBlank, customContainer);

		// Store reference to the underlying map and its container
		this.um = underlyingMap;
		//this.umc = this.um.container;
		this.umc = this.um.b;

		// Create/set up div for the map
		if (customContainer) {
			this.container = customContainer;
			this.p_setupContainerMinimal(); // minimum configuration that must be done on container
		} else {
			this.p_createContainer(); // create new container inside underlying map's container
		}

		// Create and set up the magnified map
		this.p_createMagnifiedMap(useBlank);

		// Bind to events
		this.p_setupListeners();

		// Hide and place in main map bounds
		if (!this.parked) {
			this.hide();
			centerElementOnP(this.container, new GPoint(0,0));
		}

	}

	/*************************************************************************************************
	* GxMagnifier initialization
	*************************************************************************************************/
	function _____INITIALIZATION() {} // [DELETELINE]

	// Called by GxMagnifier constructor to set the GxMagnifier default configuration state
	GxMagnifierb.prototype.p_initDefaults = function(useBlank, customContainer) { // [PRIVATE]

		// ---- These hold the state properties that can be adjusted by user ---------------------------

		// How much to magnify by when autoMagnifyEnabled and mapSyncEnabled are true
		this.magnifyFactor = DEFAULT_MAGNIFY_FACTOR; // [PRIVATE]

		// Update the magnified map when the main map's zoom/position/type are changed
		this.mapSyncEnabled = true; // [PRIVATE]

		// Disable this to set the magnified map to a permenant zoom level.
		// NOTE: If you're setting a permenant zoom level that is zoomed out and your
		// magnified map is crowded with markers, you might want to uncouple the two maps
		// using disableMapSync instead of this setting,
		this.autoMagnifyEnabled = true;

		// Normal mode: Move the magnified map around when the user mouses over the main map
		// Parked mode: Update magnified map center when mouse is moved over main map
		this.mouseTrackingEnabled = true; // [PRIVATE]

		// Normal mode: Pans the main map when the magnifier is visible and is brought to an edge
		// Parked mode: Ignored
		this.autoPanEnabled = false;  // [PRIVATE]

		// Normal mode: Hide the magnified window if the user clicks anywhere in the main map
		// Parked mode: Ignored
		this.autoHideEnabled = true;  // [PRIVATE]

		// Normal mode: After the user clicks the magnified map, the main map is panned to
		// the point clicked and a brief moment is allowed to elapse before the map
		// is zoomed.  Ignored when zooming out (i.e. when this.magnifyFactor is negative).
		// Parked mode: Ignored
		this.panBeforeZoomInEnabled = false;  // [PRIVATE]

		// If prefetching is disabled, the underlying map is NOT updated if it is hidden
		// and zoom/move events occur on the main map (saves bandwidth, at the cost of
		// having to wait for tiles to dowsenload when the magnified map is shown).
		this.prefetchEnabled = false;  // [PRIVATE]

		// Future versions may do more things when the user clicks the magnified map.
		// This setting provides a way for the user to tell us they will do all the click
		// handling themselves.  Automatically true if a custom container is given.
		this.defaultClickHandlerEnabled = (customContainer) ? false : true; // [PRIVATE]

		// Overlay event capturing, to keep the map overlays in sync
		// Enabled by default if we're starting with a copy of the map
		this.overlaySyncEnabled = !useBlank;

		// The width of the magnified map's border
		this.borderWidth = 2;

		// ---- Below, non-user-adjustable properties are initialized ----------------------------------

		this.usingCustomContainer = (customContainer) ? true : false; // [PRIVATE]

		// If parked, we don't move or resize container (e.g. is in docked control mode)
		// Always true if customContainer specified
		this.parked = (customContainer) ? true : false; // [PRIVATE]

		// Initialize static objects
		this.mousePt = new GPoint(); //current X,Y relative to page // [PUBLIC]
		this.mousePtUmc = new GPoint(); // current X,Y relative to main map's container // [PUBLIC]

		// Generate a unique ID used for this GxMagnifier (used to cross-reference overlays
		// if overlaySyncEnabled is true)
		this.GxMagnifierId = Math.round(Math.random() * 1000);
		this.overlayAttributeTagOnOrg = 'GxMagnifier' + this.GxMagnifierId + '_MapOverlay';

		// ---- These lines can be obfuscated out; only here to keep track of object-level variables ---
		this.um = undefined;  // underlying map, set by constructor // [PUBLIC]
		this.umc = undefined; // underlying map container, set by constructor // [PUBLIC]
		this.container = undefined; // magnified map container, set by constructor  // [PUBLIC]
		this.map = undefined; // the magnified map, set by constructor  // [PUBLIC]
		this.loadingMessageContainer = undefined; // [PRIVATE]
		this.mousePt = undefined; // mouse point on page, set in p_onDocMouseMove // [PRIVATE]
		this.mousePtUmc = undefined; // mouse point in main map container // [PRIVATE]
		this.mouseIsInUmc = undefined;  // [PRIVATE]
		this.mouseIsInContainer = undefined; // never set in unparked mode // [PRIVATE]
		this.mouseWasInContainer = undefined; // only set in parked mode [PRIVATE]

}

	// Creates a new container inside the underlying map's container to hold the
	// magnified map.  Requires this.um to be set.  Sets this.container.
	GxMagnifierb.prototype.p_createContainer = function() { // [PRIVATE]

		// Create div element for the magnified map.
		//this.container = this.um.ownerDocument.createElement('div');
		this.container = this.um.b.ownerDocument.createElement('div');

		// Apply minimum set of required properties
		this.p_setupContainerMinimal();

		// Apply other properties
		setCursorC(this.container, "crosshair");
		with (this.container.style) {
			// Keep off screen until we have some positioning information
			left = '-1000px'; top = '-1000px';
			border = this.borderWidth + 'px solid black';
			// Enabling next line seems to cause setCenterLatLng() on the magnified map to
			// behave incorrectly.  That's why -1000 is used above.
			// display = 'none';
		}

		// Add it to the document
		this.umc.appendChild(this.container);
	}

	// Sets up a custom container (keep it to a minimum - we don't want to fool around with user's
	// container any more than we have to).
	// This is also called by gxmCreateContainer() to avoid code duplication.
	GxMagnifierb.prototype.p_setupContainerMinimal = function() {           // [PRIVATE]
		this.container.style.position = 'absolute'; // required for zIndexing
	}

	// Create the magnified GMap.  Sets this.map.
	// - bool makeCopy? determines whether the underlying map should be copied, or whether a
	// new blank map (more API-safe) should be created.
	GxMagnifierb.prototype.p_createMagnifiedMap = function(useBlank) {  // [PRIVATE]

		// Set default size and position
		if (!this.parked) {
			this.setSize(new GSize(this.umc.offsetWidth / 3, this.umc.offsetHeight / 3));
		}

		// Create the map
		//this.map = new GMap(this.container);
		this.map = new GMap2(this.container);

		// Configure the map
		this.p_setupMagnifiedMap();

		// Create "Loading Tiles" message
		this.p_createLoadingMessage();

		// Initially, make it match the current map's Lng/Lat and type, but at the magnified zoom level
		// WARNING: We MUST do these two lines before attempting to add overlays, or the attempt to
		// add them will cause an error.
		//this.p_syncMapTypes(true, true); // force the sync, ignore mapSyncEnabled
		//this.map.centerAndZoom(this.um.getCenterLatLng(), this.p_getNewZoomLevel())
		var zl = this.p_getNewZoomLevel();
		var center = this.um.getCenter();
		var mt = this.um.getCurrentMapType()
		this.map.setCenter(center, zl, mt);

		// Syncronize overlays
		if (this.overlaySyncEnabled) this.syncOverlays();
	}

	// Performs initial setup on the magnified map
	GxMagnifierb.prototype.p_setupMagnifiedMap = function(wasAPICopied) {  // [PRIVATE]

		// Hide the copyright tags in the magnifier (we can already see them on the main map, and they
		// really clutter things up on the magnified view).  Note this doesn't appear to be required if
		// the map was copied via the undocumented map.copy(), but no harm doing it anyway.
		this.container.firstChild.nextSibling.style.display = 'none';
		this.container.firstChild.nextSibling.nextSibling.style.display = 'none';

		// Features
		this.map.disableDragging();
		this.map.disableInfoWindow();
	}

	// Creates the "Loading tiles" div and appends to the magnified map's container.
	// Sets this.loadingMessageContainer.
	GxMagnifierb.prototype.p_createLoadingMessage = function(msg) { // [PRIVATE]
		// Add a message underneath the tiles that will show while they are loading
		//this.loadingMessageContainer = this.map.ownerDocument.createElement('div'); // NONAPI LOW
		this.loadingMessageContainer = this.map.b.ownerDocument.createElement('div'); // NONAPI LOW
		with (this.loadingMessageContainer.style) {
			fontFamily = "Arial, Helvetica, sans-serif";
			fontSize = "10px";
			fontWeight = "bold";
			padding = "1px";
		}
		var dmsg = '<span style="font-size:12pt; font-weight:bold">Loading tiles...</span><br />'
		dmsg += '<span style="color:darkgreen">powered by GxMagnifier from <nobr>googlemappers.com'
		dmsg += '</nobr></span>'
		this.loadingMessageContainer.innerHTML = (msg) ? msg : dmsg
		this.container.appendChild(this.loadingMessageContainer);
	}

	/*************************************************************************************************
	* GxMagnifier event handling
	*************************************************************************************************/
	function _____EVENT_HANDLING() {} // [DELETELINE]

	GxMagnifierb.prototype.p_setupListeners = function() {  // [PRIVATE]

		// Bind map recenter/zoom/type change events.  These is not written inline as the
		// same functionality must be invoked from this.show() if prefetching is off.
		GEvent.bind(this.um, "move", this,
			function() {
				//this.p_cancelDelayedZoom();
				if (this.mapSyncEnabled && !this.parked) this.p_refreshMapLatLng();
			});

		GEvent.bind(this.um, "maptypechanged", this, this.p_syncMapTypes);

		// When the underlying map is zoomed, the cursor is now over a different lat/lng point,
		// so the magnified map must be recentered in addition to being rezoomed.
		GEvent.bind(this.um, "zoomend", this,
			function() {
				this.p_cancelDelayedZoom();
				this.p_refreshMapZoom();
				this.p_refreshMapLatLng();
			});

		// Listen to overlay events
		GEvent.bind(this.um, "addoverlay", this,
			function(o) {
				if (this.overlaySyncEnabled) {
					// alert(this.container.offsetTop + " saw " + this.umc.id + " add overlay ") //for debug
					this.p_addSyncedOverlay(o);
				 }
			});

		GEvent.bind(this.um, "removeoverlay", this,
			function(o) {
				this.p_removeSyncedOverlay(o);
			});

		GEvent.bind(this.um, "clearoverlays", this,
			function() {
				if (this.overlaySyncEnabled) {
					this.map.clearOverlays();
					// would be nice to go and clean up circular references, but Javascript GC should do that
				 }
			});

		// Capture page mouse events
		// Note: Does "document" have to be replaced with "window" for other browsers?
		// GEvent.bindDom(this.map.ownerDocument, "mousemove", this, this.p_onDocMouseMove); // NONAPI MED
		GEvent.bindDom(this.map.b.ownerDocument, "mousemove", this, this.p_onDocMouseMove); // NONAPI MED
		//this.map.b.ownerDocument <==> document.getElementById("map").ownerDocument;
		GEvent.bindDom(this.container, "click", this, this.p_onContainerClick); // NONAPI MED
	}

	// Document mouse move callback
	// Sets this.mousePt, this.mousePtUmc, this.mouseIsInUmc.
	// Note we can't cache the size/position of the map/container, because they can be change without
	// us knowing it (especially in parked mode).
	GxMagnifierb.prototype.p_onDocMouseMove = function(event) {

		if (!this.mouseTrackingEnabled) return;

		// Get mouse coordinates on page and convert to container
		this.mousePt = getMouseCoordinates(event);
		this.mousePtUmc = pageCoordToElement(this.mousePt, this.umc)
		this.mouseIsInUmc = isPtContained(this.mousePtUmc, this.umc);   // more efficient than hitTest

		if (this.parked) {

			this.mouseIsInContainer = hitTest(this.mousePt, this.container);

			// Check if we need to fire a mouseover or mouseout event
			this.p_checkFireMouseEvent();

			// Update Lat/Lng center of magnified map (does rest of validation checks)
			this.p_refreshMapLatLng();

		} else {

			// Move the magnified map window to the correct spot.  It will take care of updating the map.
			this.p_refreshWindowCenter();

		}

	}

	// Should only call when in parked mode
	GxMagnifierb.prototype.p_checkFireMouseEvent = function() {
		if (!this.isVisible()) return;
		if (this.mouseWasInContainer != this.mouseIsInContainer) {
			GEvent.trigger(this, this.mouseIsInContainer ? "mouseover" : "mouseout");
			this.mouseWasInContainer = this.mouseIsInContainer;
		}
	}

	// Magnified map click callback
	GxMagnifierb.prototype.p_onContainerClick = function(event) {

		// Activate listeners
		//GEvent.trigger(this, 'click', this.map.getCenterLatLng());
		GEvent.trigger(this, 'click', this.map.getCenter());

		// Check for internal handling override
		if (!this.defaultClickHandlerEnabled) return;

		// If zooming in, check if we're supposed to do a pan and pause first.
		//if (this.panBeforeZoomInEnabled && this.map.getZoomLevel() < this.um.getZoomLevel()) {
		if (this.panBeforeZoomInEnabled && this.map.getZoom() < this.um.getZoom()) {
      // @todo andreh - port to new api here
			//this.um.recenterOrPanToLatLng(this.map.getCenterLatLng());
			//this.um.panTo(this.map.getCenter());
			this.p_queueDelayedZoom();
		} else {
			//this.um.centerAndZoom(this.map.getCenterLatLng(), this.map.getZoomLevel());
			this.um.setCenter(this.map.getCenter(), this.map.getZoom());
		}

		//Hide magnified map if appropriate
		if (this.autoHideEnabled) this.hide();
	}

	GxMagnifierb.prototype.p_queueDelayedZoom = function() {
		this.p_cancelDelayedZoom();
		GxMagnifierDelayedZoomMap = this.um;
		//var s = 'GxMagnifierDelayedZoom(' + this.umc.id + ', ' + this.map.getZoomLevel() + ');';
		var s = 'GxMagnifierDelayedZoom(' + this.umc.id + ', ' + this.map.getZoom() + ');';
		this.delayedZoom_tmr = setTimeout(s, 300, this.um);
	}

	GxMagnifierb.prototype.p_cancelDelayedZoom = function() {
		if (this.delayedZoom_tmr) clearTimeout(this.delayedZoom_tmr);
		GxMagnifierDelayedZoomMap = undefined;
	}

	// A utility for the user
	GxMagnifierb.prototype.createImage = function(imageSrc) {
		//return createImageC(imageSrc, this.container, this.map.ownerDocument);
		return createImageC(imageSrc, this.container, this.map.b.ownerDocument);
	}

	/*
	// Also just here as utility for user
	GxMagnifierb.prototype.centerElementOn = function(el, pt, borderAdjustment) {
		centerElementOnP(el, pt, borderAdjustment);
	}*/

	/*************************************************************************************************
	* GxMagnifier control
	*************************************************************************************************/
	function _____CONTROL() {} // [DELETELINE]

	GxMagnifierb.prototype.show = function() {
		if (this.isVisible()) return;
		GEvent.trigger(this, "show");
		if (!this.prefetchEnabled) this.p_refreshMap(true);  // make sure map is in right place, force
		this.container.style.visibility = '';
	}

	GxMagnifierb.prototype.hide = function() {
		if (!this.isVisible()) return;
		GEvent.trigger(this, "hide");
		// Note: we can't use display:none as FireFox then will report offsetWidth as 0
		this.container.style.visibility = 'hidden';
		this.p_stopAutoPan();
	}

	// Sets the size of the magnifier window
	GxMagnifierb.prototype.setSize = function(size) {
		this.container.style.width = getBoundedValue(size.width, 5, this.umc.offsetWidth) + 'px';
		this.container.style.height = getBoundedValue(size.height, 5, this.umc.offsetHeight) + 'px';
		// Tell the map its container has resized
		if (this.map) {
			if (!this.parked) this.p_refreshWindowCenter();
		}
	}

	GxMagnifierb.prototype.showLoadingMessage = function(html) {
		this.loadingMessageContainer.style.display = '';
		if (html) this.loadingMessageContainer.innerHTML = html;
	}

	GxMagnifierb.prototype.hideLoadingMessage = function() {
		this.loadingMessageContainer.style.display = 'none';
	}

	// Ignored if using custom container
	GxMagnifierb.prototype.park = function(pt) {
		if (this.usingCustomContainer) return;

		// Center the window on the given point
		if (pt) centerElementOnP(this.container, pt, this.borderWidth);

		// Set up state variables required for being parked
		// If we weren't in parked mode before, then the mouseIsInContainer flag is not
		// up to date.  It must be updated now, or .show() will invoke a p_refreshMapLatLng()
		// with the old value.
		this.mouseIsInContainer = hitTest(this.mousePt, this.container);

		// Enter parked mode
		this.parked = true;

		// Update map to given point
		this.p_centerMapAtUmcCoord(pt);

	}

	// Park the magnifier at the given marker.  Note that it is NOT attached to the marker,
	// and will not move around as the map scrolls.  If you wanted to implement attaching,
	// a new state flag (e.g. attachedToLngLat).
	// Ignored if using custom container
	GxMagnifierb.prototype.parkAtMarker = function(m, offsetLeft, offsetTop) {
		if (this.usingCustomContainer) return;
		if (!offsetLeft) offsetLeft = 0;
		if (!offsetTop) offsetTop = 0;
		// Get anchor pixel of marker.  This is a total hack.  // NONAPI MED
		var markerCenterPx = new GPoint(
			m.iconImage.offsetLeft + m.icon.iconAnchor.x
			+ m.iconImage.offsetParent.offsetLeft
			+ offsetLeft,
			m.iconImage.offsetTop + m.icon.iconAnchor.y
			+ m.iconImage.offsetParent.offsetTop
			+ offsetTop);
		this.park(markerCenterPx);
	}

	GxMagnifierb.prototype.unpark = function(w) {
		if (this.usingCustomContainer) return;
		this.parked = false;
	}

	/*************************************************************************************************
	* GxMagnifier overlay synchronization
	*************************************************************************************************/
	function _____OVERLAY_SYNC() {} // [DELETELINE]

	// Synchronize overlays with those of the main map, by clearing existing ones
	// and rebuilding.  Not efficient.  Intended to be used after making a new map with
	// the makeCopy=false parameter.
	// This was written based on a similar function in the API internals
	GxMagnifierb.prototype.syncOverlays = function() {  // [PUBLIC]
		// Adapted from API internals
		this.map.clearOverlays();
	}

	// Creates a circular reference situation, but Javascript GC should be
	// able to deal with that, even if p_removeSyncedOverlay doesn't get called
	// Returns the newly added overlay
	GxMagnifierb.prototype.p_addSyncedOverlay = function(orgOverlay) {
		// Make a copy
		var ourCopy = orgOverlay.copy(); // NONAPI MED
		// Set a new property on the original that points to our copy
		orgOverlay[this.overlayAttributeTagOnOrg] = ourCopy;
		// Add to our map
		this.map.addOverlay(ourCopy);
		return ourCopy;
	}

	GxMagnifierb.prototype.p_removeSyncedOverlay = function(orgOverlay) {
		try {
			// Get our copy of it
			var attr = this.overlayAttributeTagOnOrg;
			var ourCopy = orgOverlay[attr];
			if (ourCopy) {
				// Break circular reference (do first in case next line fails)
				orgOverlay[attr] = undefined;
				// Remove from our map
				this.map.removeOverlay(ourCopy);
			 }
		} catch (e) {
			// Ignore errors
			// e.g. if our map's clearOverlays was called then removeOverlay()
			// may fail.
		}
	}

	/*************************************************************************************************
	* GxMagnifier refreshing
	*************************************************************************************************/
	function _____REFRESH() {} // [DELETELINE]

	// Especially if using a custom container, the user may have decided to hide
	// it while we "weren't looking".  This function determines if we're visible
	// or not (although the user really should call our show() and hide()).
	GxMagnifierb.prototype.isVisible = function() {
		// If anyone has a better suggestion to this method, I'm all ears
		return (this.container.style.visibility.toLowerCase() != 'hidden')
	}

	// Perform a full refresh of the magnified map's center/zoom/type.
	// Mainly used in response to a show() command if prefetching was off,
	// to set the map to the correct place before it is shown, but also
	// can be called from refresh() or any event handlers that don't
	// care about really fast execution.
	GxMagnifierb.prototype.p_refreshMap = function(force) {
		if (!this.p_okayToRefreshMap(force)) return;
		//this.p_syncMapTypes(force);
		this.p_refreshMapZoom(force);
		this.p_refreshMapLatLng(force); // does its own checks
	}

	// If we're not visible and prefetch is off, then don't do any
	// refreshing on the map unless forced.  Never do any refreshing before
	// this.map is set.
	GxMagnifierb.prototype.p_okayToRefreshMap = function(force) {

		// This validator is called first by all map refresh functions.
		// If we're not visible and prefetch is off, then don't do any
		// refreshing on the map (unless forced).  This helps save bandwidth.
		// Also, never do any refreshing before this.map is set.
		// Also, don't refresh if the container is still sitting at the initial
		// -1000,-1000 position.
		// WARNING: This method is called from the GxMagnifier constructor,
		// (via p_RefreshMapZoom) when only minimal object level variables may be set up.

		return (this.isVisible() || this.prefetchEnabled || force) &&
			(this.map) && (this.container.style.left != '-1000px');
	}

	// Set magnifier map to same type as main map
	// ignoreMapSyncSetting is just for use during startup
	GxMagnifierb.prototype.p_syncMapTypes = function(force, ignoreMapSyncSetting) {
		if (!this.p_okayToRefreshMap(force)) return;
		if (!this.mapSyncEnabled && !ignoreMapSyncSetting) return;
		var zl = this.um.getZoom();
		var center = this.um.getCenter();
		var mt = this.um.getCurrentMapType()
		this.map.setCenter(center, zl, mt);		
	}

	// Set the magnifier zoom to the appropriate level
	GxMagnifierb.prototype.p_refreshMapZoom = function(force) {
		if (!this.p_okayToRefreshMap(force) || !this.mapSyncEnabled
			|| !this.autoMagnifyEnabled) return;
		//this.map.zoomTo(this.p_getNewZoomLevel());
		this.map.setZoom(this.p_getNewZoomLevel());
	}

	GxMagnifierb.prototype.p_getNewZoomLevel = function() {
		// Subtract magnify factor from present zoom level of main map
		// Limit to valid range, and update zoom level
		//var z = this.um.getZoomLevel() - this.magnifyFactor;
		//return getBoundedValue(z, 0, this.map.spec.numZoomLevels); // NONAPI LOW
		
		// @todo - p_getNewZoomLevel
		// numZoomLevels -> getBoundsZoomLevel
		// http://www.mapki.com/wiki/APIv2#Using_map.getBoundsZoomLevel.28.29
		//var bounds = this.GxMagnifier.um.getBounds();
		//var zl = this.GxMagnifier.um.getBoundsZoomLevel(bounds);
		var magn =  this.magnifyFactor;
		var zoom =  this.um.getZoom();
		var z =  zoom + magn;
		var zl = 19;
		var ret = getBoundedValue(z, 0, zl);
		return ret; // NONAPI LOW
	}

	// Sets the center Lat/Lng of the magnified map to where its supposed to be
	// after either a) the cursor has moved, or b) the underlying map has moved,
	// resulting in the cursor hovering over a new Lat/Lng.
	// Since this function can be invoked from a handful of sources (including
	// this.p_onDocMouseMove, this.refresh, and the underlying map's zoom event)
	// we go through all applicable state validation checks.
	GxMagnifierb.prototype.p_refreshMapLatLng = function(force) {

		// In addition to usual validation, make sure mouse coordinates are
		// available and mouse tracking is turned on.
		if (!this.p_okayToRefreshMap(force)) return;

		if (this.parked) {

			if (!this.mousePtUmc || !this.mouseTrackingEnabled) return;

			// Make sure mouse is in main map container but not in magnified map's
			// container (If the magnified map could overlap's the main one, we don't
			// want to be scrolling it around when the user puts their mouse in it to
			// click a marker).  Note if this.mouseIsInContainer is undefined, we
			// have been incorrectly called, so explicitely check for 'false'.
			if (this.mouseIsInUmc && (this.mouseIsInContainer == false)) {
				// Set map to Lat/Lng point on main map that is directly under cursor
				this.p_centerMapAtUmcCoord(this.mousePtUmc);
			}
		} else {

			// Set map to point under middle of magnifier window
			// Note that in non-parked mode the magnifier container is a child of
			// the map window, so only minimal coordinate conversion is neccessary.
			var pt = getElementCenter(this.container, this.borderWidth);

			// Testing has determined you need to add 0.5 to the y coordinate in order
			// to prevent a 1px "jiggling" of the magnified map as you move it up and
			// down over the main map.  I think it's a rounding loss that happened
			// somewhere along the way.  For safety, I add it to x, too (although it
			// doesn't seem to be neccessary).  To see the effect, put these back to
			// 0 and set this.magnifyFactor to 0.
			pt.y += 0.6;
			pt.x += 0.6;

			this.p_centerMapAtUmcCoord(pt);

		}
	}

	GxMagnifierb.prototype.p_centerMapAtUmcCoord = function(pt) {
		//this.map.centerAtLatLng(this.um.containerCoordToLatLng(pt));  // NONAPI MED
		var center = this.um.fromContainerPixelToLatLng(pt);
		var zl     = this.map.getZoom();
		if (this.mapSyncEnabled){
			var mt = this.um.getCurrentMapType()
			this.map.setCenter(center, zl, mt);  // NONAPI MED
		}else{
			this.map.setCenter(center, zl);  // NONAPI MED
		}
	}

	// Centers the magnified map window after the mouse has moved, and updates
	// the map.  Also invokes autoPanning if required.
	// Requirements:
	// - not in parked mode, mouse coordinates set
	GxMagnifierb.prototype.p_refreshWindowCenter = function() {
		if (!this.mousePtUmc) return;

		// Get underlying map container bounds.  If autoPan is enabled, then
		// restrict the mouse so that the container stays in the main map
		// window's bounds.  If it's disabled, allow the mouse to travel out
		// of the main map window far enough to completely hide the magnified
		// map, then stop updating.
		var b = new GBounds(0, 0, this.umc.offsetWidth, this.umc.offsetHeight);
		b = expandBounds(b,
			(this.container.offsetWidth  / 2) * (this.autoPanEnabled ? -1 : 1),
			(this.container.offsetHeight / 2) * (this.autoPanEnabled ? -1 : 1));
		b = offsetBounds(b, this.borderWidth); // fix for borderWidth "bug"

		var newCenter = getBoundedPt(this.mousePtUmc, b);

		centerElementOnP(this.container, newCenter, this.borderWidth);

		// If autoPan is enabled and the mouse is in the autoPan region
		// The autopan region is an imaginary border that extends 1/2 of
		// the container width/height in from the main map's edges.
		// i.e. the mouse is inside the main map container, but outside
		// the mouse bounding region that keeps the full magnifier shown.
		if (this.autoPanEnabled && this.mouseIsInUmc && !isPtInBounds(this.mousePtUmc, b)) {
			// Pass off to the autopan function.  It will pan the map, which will
			// generate a "move" event, which in turn will invoke p_refreshMapLatLng
			this.p_doAutoPan();
		} else {
			this.p_stopAutoPan();
			this.p_refreshMapLatLng();
		}

	}

	/*************************************************************************************************
	* GxMagnifier autopanning
	*************************************************************************************************/
	function _____AUTOPAN() {} // [DELETELINE]

	// NOTE: The AutoPan functionality was written in a prior version of this component (when the
	// magnifier wasn't a child of the main map's container).  However, because it is nicely
	// encapsulated, it was not needed to rewrite the autoPan code for the overhaul that became
	// GxMagnifier.1.js.  Of course, it could probably be rewritten in a more optimized manner
	// that makes better use of information already calculated by the rest of the event chain.
	// Also, I haven't done a lot of testing to make sure it integrates perfectly into the rest
	// of the component.

	// Checks if the mouse is in the autoPanEnabled region.  If it is, then pans the map.
	// The autoPan logic is written (in terms of naming styles) to handle horizontal
	// panning, and then reused for handling vertical pans.
	var panningEW, panningNS, factor;  // store whether or not we're autopanning
	GxMagnifierb.prototype.p_doAutoPan = function() {
		if (!this.p_okayToRefreshMap()) return;
		// Check for horizontal autopan
		panningEW = this.p_checkPan(this.mousePtUmc.x, 0, this.umc.offsetWidth,
			this.container.offsetWidth, panningEW, 39, 37);
		// Reuse same function to check for vertical pan
		panningNS = this.p_checkPan(this.mousePtUmc.y, 0, this.umc.offsetHeight,
			this.container.offsetHeight, panningNS, 40, 38);
    // change factor to modify pan speed
    //if( factor > -100 ){	factor = factor -20;	}
    factor = -100;
		this.um.panBy(new GSize(factor*panningEW,factor*panningNS));				
	}

	GxMagnifierb.prototype.p_stopAutoPan = function() {
		panningEW = 0;
		panningNS = 0;
		factor = -100;
	}

	// This is the "control" portion of the autoPanEnabled logic.  It decides what to do
	// when the mouse is in an autoPanEnabled region.  Given that p_getAutoPanRatio() returns
	// a fraction, this function could theoretically be extended to accelerate
	// panning as the mouse travels further away from the center of the map.
	GxMagnifierb.prototype.p_checkPan = function(x, umcLeft, umcWidth, mapWidth, panning, rightKey, leftKey) {
		var ratio = this.p_getAutoPanRatio(x, umcLeft, umcWidth, mapWidth);
		return ratio;
	}

	// This is the "evaluate" portion of the autoPanEnabled logic.  It determines if the mouse
	// is in an autoPanEnabled region, and returns a fraction indicating how far into that
	// region the mouse has gone.
	// Returns a positive value if mouse is in right/bottom region, a negative value if its in
	// left/top region, and otherwise 0.
	// The specific value returned is between 0 and 1, proportional to how far into the AutoPan
	// region the mouse is (i.e. larger the farther away the mouse is from the map center).
	GxMagnifierb.prototype.p_getAutoPanRatio = function(x, containerLeft, containerWidth, mapWidth) {
		// Check the right-side autopan region
		var n = this.p_getOverlapRatio(x,
			(containerLeft + containerWidth - mapWidth / 2),  // left boundary of right-side autopan region
			(containerLeft + containerWidth));                // right boundary of same
		if (n != 0) return n;
		// Check the left-side autopan region, but reverse (1-n) and negate
		// (-n) returned fraction to make the "slider control" go the other way.
		n = this.p_getOverlapRatio(x,
			(containerLeft),                                  // left boundary of the left-side autopan region
			(containerLeft + mapWidth / 2));                  // right boundary of same
		if (n != 0) return -(1-n);

		// Otherwise simply return 0
		return 0;
	}

	// Returns how far into an imaginary box a co-ordinate is.
	// If x is outside of [left, right], 0 is returned, otherwise
	// a value between 0 and 1 is returned, proportional to much
	// bigger x is than left.
	// (Imagine a horizontal slider control)
	GxMagnifierb.prototype.p_getOverlapRatio = function(x, left, right) {
		if ((x > left) && (x < right)) {
			return (x - left) / (right - left);
		} else {
		 return 0;
		}
	}

	/*************************************************************************************************
	* GxMagnifier configuration
	*************************************************************************************************/
	function _____CONFIGURATION() {} // [DELETELINE]

	var DEFAULT_MAGNIFY_FACTOR = 2;

	// EXPOSE
	GxMagnifierb.prototype.setMagnification = function(levels) {
		this.magnifyFactor = (levels != undefined && levels != null) ? (levels) : DEFAULT_MAGNIFY_FACTOR;
		// Set the new zoom level
		this.p_refreshMapZoom(true);
	}

	GxMagnifierb.prototype.enableMapSync = function() {
		this.mapSyncEnabled = true;
	}

	GxMagnifierb.prototype.disableMapSync = function() {
		this.mapSyncEnabled = false;
	}

	GxMagnifierb.prototype.enableAutoMagnify = function() {
		this.autoMagnifyEnabled = true;
	}

	GxMagnifierb.prototype.disableAutoMagnify = function() {
		this.autoMagnifyEnabled = false;
	}

	GxMagnifierb.prototype.enableMouseTracking = function() {
		this.mouseTrackingEnabled = true;
	}

	GxMagnifierb.prototype.disableMouseTracking = function() {
		this.mouseTrackingEnabled = false;
	}

	GxMagnifierb.prototype.enableAutoPan = function() {
		this.autoPanEnabled = true;
	}

	GxMagnifierb.prototype.disableAutoPan = function() {
		this.p_stopAutoPan();
		this.autoPanEnabled = false;
	}

	GxMagnifierb.prototype.enablePanBeforeZoomIn = function() {
		this.panBeforeZoomInEnabled = true;
	}

	GxMagnifierb.prototype.disablePanBeforeZoomIn = function() {
		this.panBeforeZoomInEnabled = false;
	}

	GxMagnifierb.prototype.enablePrefetch = function() {
		this.prefetchEnabled = true;
	}

	GxMagnifierb.prototype.disablePrefetch = function() {
		this.prefetchEnabled = false;
	}

	GxMagnifierb.prototype.enableDefaultClickHandler = function() {
		this.defaultClickHandlerEnabled = true;
	}

	GxMagnifierb.prototype.disableDefaultClickHandler = function() {
		this.defaultClickHandlerEnabled = false;
	}

	GxMagnifierb.prototype.enableOverlaySync = function() {
		this.overlaySyncEnabled = true;
	}

	GxMagnifierb.prototype.disableOverlaySync = function() {
		this.overlaySyncEnabled = false;
	}

	GxMagnifierb.prototype.setBorderWidth = function(w) {
		this.borderWidth = w;
		this.container.style.borderWidth = w + 'px';
	}

	GxMagnifierb.prototype.setCursor = function(c) {
		setCursorC(this.container, c);
	}

	/*************************************************************************************************
	* Helper functions for bounding to regions
	*************************************************************************************************/
	function _____BOUNDING_HELPERS() {} // [DELETELINE]

	// Note: These functions are intended for use with pixel-type GPoints
	// and GBounds only.  They aren't written to work with Lat/Lng.

	// WISHLIST: Write helpers like isLatLngInBounds(), getBoundLatLng().
	// Be wary of international date line (see discussion at bottom of file)

	// WARNING: These functions may be called from rapid events like mousemove,
	// so they should be kept efficient.

	// Returns the given value, adjusting it if required so that it falls between
	// minVal and maxVal
	function getBoundedValue(val, minVal, maxVal) {
		if (val < minVal) return minVal;
		if (val > maxVal) return maxVal;
		return val;
	}

	function isValueInBounds(val, minVal, maxVal) {
		return ((val >= minVal) && (val <= maxVal));
	}

	function isPtInBounds(p, bound) {
		return (isValueInBounds(p.x, bound.minX, bound.maxX) &&
			isValueInBounds(p.y, bound.minY, bound.maxY));
	}

	/* unused
	function isPtInGSize(p, gs) {
		return (isValueInBounds(p.x, 0, gs.width) &&
			isValueInBounds(p.y, 0, gs.height));
	}
	*/

	// Determines whether the given point is in bounds of the given element.
	// Point must be specified in terms of the ELEMENT'S coordinate system,
	// not its offsetParent's (i.e. if pt is (0,0) then it falls on the
	// top-left corner of the element).
	// Primarily for use with a point returned from pageCoordToElement.
	function isPtContained(pt, el) {
		return (isValueInBounds(pt.x, 0, el.offsetWidth) &&
						isValueInBounds(pt.y, 0, el.offsetHeight));
	}

	// Adjusts the point's x and y as required to ensure it falls within
	// the given GBound.
	function getBoundedPt(pt, bounds) {
		var p = new GPoint();
		p.x = getBoundedValue(pt.x, bounds.minX, bounds.maxX);
		p.y = getBoundedValue(pt.y, bounds.minY, bounds.maxY);
		return p;
	}

	// Returns a new GBounds whose limits are grown/shrunk by the
	// given amounts.  If amountVert is not specified, then the
	// bounds is shrinked evenly on all sides by amountHorz.
	// If justShift is true then the bounds are shifted right
	// and down by the given amount instead of expanded (used by
	// offsetBounds()).
	function expandBounds(bounds, amountHorz, amountVert, justShift) {
		var b = new GBounds();
		if (!amountVert) amountVert = amountHorz
		justShift = (justShift) ? -1 : 1;
		b.minX = bounds.minX - amountHorz * justShift;
		b.maxX = bounds.maxX + amountHorz;
		b.minY = bounds.minY - amountVert * justShift;
		b.maxY = bounds.maxY + amountVert;
		return b;
	}

	// Returns a new GBounds whose limits are shifted by the
	// given amounts.  If amountVert is not specified, then
	// amountHorz is used for both the right and down shift.
	function offsetBounds(bounds, amountHorz, amountVert) {
		return expandBounds(bounds, amountHorz, amountVert, true);
	}

	/* unused
	// Gets the outer boundaries for an html element (like a div) and returns in
	// a new GBound object.  The result is in a co-ordinate system who's origin
	// is the top-left of the element's offsetParent.
	function getElementBounds(container) {
		var b = new GBounds();
		b.minX = container.offsetLeft;
		b.maxX = container.offsetLeft + container.offsetWidth;
		b.minY = container.offsetTop;
		b.maxY = container.offsetTop + container.offsetHeight;
		return b;
	}
	*/

	function getElementSize(container) {
		return new GSize(container.offsetWidth, container.offsetHeight);
	}

	// Tests whether a point in page coordinates (typically the cursor location)
	// is inside of a particular container
	function hitTest(pt, el) {
		// Convert point to element's coordinates
		return isPtContained(pageCoordToElement(pt, el), el);
	}

	/*************************************************************************************************
	* Other helper functions
	*************************************************************************************************/
	function _____OTHER_HELPERS() {} // [DELETELINE]

	// Add a line to the trace
	function trace(s, newline, clearfirst) {
		var d = document.getElementById("GxMagnifierTraceOutput");
		if (d) {
			if (newline == undefined || newline == null) newline = true;
			if (clearfirst) d.innerHTML = '';
			d.innerHTML += s + (newline ? '<br />' : '');
		}
	}

	// This one probably needs a good bit of improvement.
	function createImageC(imageSrc, container, ownerDocument) {
		var img = ownerDocument.createElement("img");
		if (ie) {
			img.style.filter='progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' +
				imageSrc + '", sizingMethod="")';
			img.src = "spacer.png"; // WISHLIST: Does Google have a file like this on its servers
		} else {                  //           we can use instead?
			img.src = imageSrc;
		}
		container.appendChild(img);
		return img;
	}

	// Adapted from API internals
	function setCursorC(a,b){
		try {
			a.style.cursor=b
		} catch (c) {
			if (b=="pointer") {
				setCursorC(a,"hand")
			}
		}
	}

	// Returns the center position of the element (in terms of its offsetParent)
	// BUG: In FireFox and IE under Windows in strict mode at least, the offsetWidth
	// function doesn't include the element's border width(s).  For a 2px border
	// this function will give a result 2px further left and 2px higher up than
	// we would like.  For now, this solved with a "borderAdjustment" hack.
	function getElementCenter(el, borderAdjustment) {
		var p = new GPoint();
		if (!borderAdjustment) borderAdjustment = 0;
		p.x = el.offsetLeft + el.offsetWidth / 2.0 + borderAdjustment;
		p.y = el.offsetTop + el.offsetHeight / 2.0 + borderAdjustment;
		return p;
	}

	// Centers the given element on the given point (in terms of its offsetParent).
	// See "BUG" note in getElementCenter().
	function centerElementOnP(el, pt, borderAdjustment) {
		if (!borderAdjustment) borderAdjustment = 0;
		el.style.left = pt.x - el.offsetWidth / 2.0 - borderAdjustment + 'px';
		el.style.top = pt.y - el.offsetHeight / 2.0 - borderAdjustment + 'px';
	}

	/*
	function getBorderWidth(el) {     // Really should be checking a bunch of styles
		var s = el.style.borderWidth;   // including borderLeft, borderTop, borderWidth
		if (!s && s == '') return 0;    // border, etc.  Too complex so I'm just leaving
		s = s.replace('px', '');        // it for now, until a better Javascript guru
		return parseInt(s);             // comes along with a better fix.
	}
	*/

	// Convert a coordinate based on the page body to one relative to to the container,
	// by walking up all offsetParent's until we hit the document.
	// See "BUG" note in getElementCenter().
	function pageCoordToElement(pt, el) {
		var p = new GPoint(pt.x, pt.y);
		for (var o = el; (o) && (o.offsetParent); o = o.offsetParent) {
			p.x -= o.offsetLeft;
			p.y -= o.offsetTop;
		}
		return p;
	}

	// Detect mouse coordinates relative to the document body
	// Based on http://www.devarticles.com/c/a/JavaScript/Handling-events-with-the-DOM-Part-III/5/
	function getMouseCoordinates(e) {
		var p = new GPoint();
		if(!e) var e = window.event;
		if(e.pageX || e.pageY){
			p.x = e.pageX;
			p.y = e.pageY;
		} else if(e.clientX || e.clientY) {
			p.x = e.clientX + document.documentElement.scrollLeft;
			p.y = e.clientY + document.documentElement.scrollTop;
		}
		return p;
	}

	// Perform a delayed zoom
	function GxMagnifierDelayedZoomb(mapContainer, level) {
		if (GxMagnifierDelayedZoomMap) {
			//GxMagnifierDelayedZoomMap.zoomTo(level);
			GxMagnifierDelayedZoomMap.setZoom(level);
			GxMagnifierDelayedZoomMap = undefined;
		}
	}

	/*************************************************************************************************
	* GxMagnifierControl class
	* This wraps the GxMagnifier class so that it can be used like a normal Google control.
	* Note that since the control interface is not yet officially specified, the stuff in here
	* could easily break in future versions.  I've just kind of emulated how the normal controls
	* *appear* to work.  Consider using the GxMagnifier class directly instead.
	*************************************************************************************************/
	function _____GX_MAGNIFIER_CONTROL() {} // [DELETELINE]

	function GxMagnifierControlb(createNewMap) {
		this.createNewMapOnInit = createNewMap;
		this.defaultPosition = new GxControlPositionHack(0, 8, 8);
	}

	// This is called by the API to create the control
	GxMagnifierControlb.prototype.initialize = function(map) {

		// Create new GxMagnifier
		if (!this.GxMagnifier) this.GxMagnifier = new GxMagnifier(map, this.createNewMapOnInit);

		// Create control buttons
		this.magnifyImage = 'magnify.gif';  // By default, try for the png file (WISHLIST: Any way to
		this.createControlButtons();        // check if the png file exists first?)

		// Not sure, but the API might require us to have a .div property
		this.div = this.buttons.container;  // required for API?

		// This isn't doing anything
		// GEvent.addListener(this.div, "contextmenu",
		//  function() {alert('GxMagnifier powered by Google Mappers.com')});

		// We have to return the control's container to the API
		return this.div;
	}

	GxMagnifierControlb.prototype.printable = function() {
		return 1;
	}
	GxMagnifierControlb.prototype.selectable = function() {
		return 1;
	}


	// Just here to make life easier for programmers
	GxMagnifierControlb.prototype.map = function() {
		return this.GxMagnifier.map;
	}

	// If image is undefined, uses simple text "Z"
	GxMagnifierControlb.prototype.setMagnifyImage = function(image) {
		this.magnifyImage = image;
	}

	GxMagnifierControlb.prototype.show = function() {
		this.buttons.container.style.display = '';
	}

	GxMagnifierControlb.prototype.hide = function() {
		this.GxMagnifier.hide();
		this.buttons.container.style.display = 'none';
	}

	GxMagnifierControlb.prototype.createControlButtons = function() {

		// Create new GxButtons using underlying map's ownerDocument
		var b = new GxButtons();
		this.buttons = b; // store for later use
		// b.generateContainer(this.GxMagnifier.um.ownerDocument);
		b.generateContainer(this.GxMagnifier.um.b.ownerDocument);

		// Create magnify button
		this.magnifyButton = b.addImageButton((this.magnifyImage) ? this.magnifyImage : 'magnify.gif',
			"Magnify region");

		// Bind to magnify button click event
		GEvent.bindDom(this.magnifyButton, "click", this, this.onMagnifyClick);

		// Hide the magnify button once we reach the lowest zoom level
		GEvent.bind(this.GxMagnifier.um, "zoomend", this,
			function() {
				//if (this.GxMagnifier.um.getZoomLevel() == MIN_ZOOM_LEVEL) {
				// @todo andreh - !!! verify the min zoom level for the new api
				var MIN_ZOOM_LEVEL = 19;
				var z = this.GxMagnifier.um.getZoom();
				if (z == MIN_ZOOM_LEVEL) {
					this.magnifyButton.style.display = 'none';
				} else {
					this.magnifyButton.style.display = '';
				}
			});

		// Append the buttons to the underlying map container
		b.appendToDom(this.GxMagnifier.umc);

	}

	// Required by API
	GxMagnifierControlb.prototype.getDefaultPosition = function() {
	// This function is required for the control interface
		return this.defaultPosition;
	}

	// Move the control buttons (only works if set before initialized)
	GxMagnifierControlb.prototype.setDefaultPosition = function(p) {
		this.defaultPosition = p;
	}

	// Probably required by the API
	GxMagnifierControlb.prototype.remove=function(){
		this.map.container.removeChild(this.div);
		this.div=null;
		this.GxMagnifier.hide();
	};

	// Handle the magnify button's click event
	// Note the user can override this function, so keep it exposed.
	GxMagnifierControlb.prototype.onMagnifyClick = function() {
		if (this.GxMagnifier.isVisible()) this.GxMagnifier.hide();
		else this.GxMagnifier.show();
	}

	/*************************************************************************************************
	* GxButtons class
	* For generating a div with buttons in it
	*************************************************************************************************/
	function _____GX_BUTTONS_CLASS() {} // [DELETELINE]

	function GxButtonsb() {}

	// Generate a container for the buttons, but don't append it to main document yet
	GxButtonsb.prototype.generateContainer = function(ownerDocument) {
		this.ownerDocument = (ownerDocument) ? ownerDocument : document;
		this.container = this.ownerDocument.createElement("div");
		// It appears the API internals move our div into the map container and set the noprint
		// class for us
		// ka(b.div,"noprint");
		return this.container;
	}

	// Append button container to document and return it
	// Generates a container if not done already.
	GxButtonsb.prototype.appendToDom = function(container) {
		if (!this.container) this.generateContainer();
		if (container) container.appendChild(this.container);
		else this.ownerDocument.appendChild(this.container);
		return this.div;
	}

	// Add an image button
	GxButtonsb.prototype.addImageButton = function(imageSrc, tooltipText) {
		if (!this.container) this.generateContainer();

		// Create image and set properties
		var img = createImageC(imageSrc, this.container, this.ownerDocument);
		img.setAttribute('tooltip', tooltipText);  // WISHLIST: make this work in non-MSIE browsers
		setCursorC(img, 'pointer');
		return img;
	}

	// Add a text button
	GxButtonsb.prototype.addTextButton = function(text, tooltipText) {
		if (!this.container) this.generateContainer();

		// Create div for the text and set properties
		var b = this.ownerDocument.createElement("div");
		b.setAttribute('tooltip', tooltipText);
		setCursorC(b, 'pointer');
		b.innerHTML = text;

		// Set up defaults
		b.style.width='16px'; b.style.height='16px';
		b.style.textAlign = "center";
		b.style.fontFamily = "Arial, Helvetica, sans serif";
		b.style.fontWeight = "bold";
		b.style.backgroundColor = '#FFFFFF';
		b.style.border = "1px solid black";
		b.style.textShadow = "Gray";
		b.style.verticalAlign = "top"; // not doing what I want

		this.container.appendChild(b);
		return b;
	}

	/*************************************************************************************************
	* GxControlPositionHack (until Google officializes their control interface)
	*************************************************************************************************/
	function _____G_CONTROL_POSITION_HACK() {} // [DELETELINE]

	function GxControlPositionHackb(a,b,c){
		this.anchor=a;
		this.offsetWidth=b||0;
		this.offsetHeight=c||0;
	}

	// These appear to be called by the API
	GxControlPositionHackb.prototype.apply=function(a){
		a.style.position="absolute";
		a.style[this.getWidthMeasure()]=this.offsetWidth+'px';
		a.style[this.getHeightMeasure()]=this.offsetHeight+'px';
	}

	GxControlPositionHackb.prototype.getWidthMeasure=function(){
		switch(this.anchor){
			case 1:
			case 3:
				return"right";
			default:return"left";
		}
	}

	GxControlPositionHackb.prototype.getHeightMeasure=function(){
		switch(this.anchor){
			case 2:case 3:return"bottom";default:return"top";
		}
	}

	/*************************************************************************************************
	* Scratch area
	*************************************************************************************************/
	function _____SCRATCH_AREA() {} //[DELETELINE]

	// You can test methods out here

	/*************************************************************************************************
	* Expose the Namespace
	*************************************************************************************************/
	// Make public interface (expose objects)
	function makeInterface(a) {
		var b = a || window;
		b.GxMagnifier = GxMagnifierb;
		b.GxMagnifierDelayedZoom = GxMagnifierDelayedZoomb;
		b.GxMagnifierDelayedZoomMap = undefined; // used for passing map to setTimeout
		b.GxMagnifierControl = GxMagnifierControlb;
		b.GxButtons = GxButtonsb;
		b.GxControlPositionHack = GxControlPositionHackb;
		b.gxTrace = trace;
	}

	makeInterface();

}
GxMagnifierNamespace();


	/*************************************************************************************************
	* Additional discussion below
	*************************************************************************************************/

/*  International date line crossing is a "drag":

	Lets say a bound is specified by a user dragging a box.  A lat range
	like [10, 20] could mean the user dragged east from 10 to 20, or they
	could have dragged west starting from 10, going across the -180/180
	boundary, and finally back to 10.  Even worst, if we get something
	like [20, 10], they could have crossed two boundaries, dragging east
	from 20 --> 180/-180 --> 0 --> 10.
	Clearly a standard for storing regions is required.

	The API defines that a GBound's min values correspond to top left (i.e.
	north-west-most).  This means that if a user drags westward, the bound
	should first be normalized by swapping the start and end values of the
	drag.  We then have bounds that are always defined in west to east fashion.

	If you're not a negative kind of guy/gal, and it helps you visualize
	things better, you could normalize the bounds to [0, 360] before working
	with them, and then shift them back once you're done.

	function getBoundedLatLng(val, minVal, maxVal) {}

*/

	/* Unused non-API copy solution
	// Return a copy of the given map by using undocumented API function.  Doesn't worry about
	// copying center lat/lng or zoom.  Can be removed.
	function copyMapAPI(map) {
		// - advantage: likely to be kept up to date if new attributes are added to maps
		// - disadvantage: will break if the big argument list is changed
		// If I recall correctly, the last parameter indicates deep copy?
		// (whatever it is, it is piped to the last parameter to the new GMap() constructor)
		// return map.copy(this.container, null, null, null, null, null, true); // NONAPI HIGH
		this.map = this.um.copy(this.container, null, null, null, null, null, true);  // NONAPI HIGH
	}
	*/

	/* Alternate mouse detection
		 Adapted from: http://www.howtocreate.co.uk/tutorials/index.php?tut=0&part=17
	function getMouseCoordinates2(e) {
		if( !e ) {
			if( window.event ) {
				//DOM
				e = window.event;
			} else {
				//TOTAL FAILURE, WE HAVE NO WAY OF REFERENCING THE EVENT
				return;
			}
		}
		var p = new GPoint();
		if( typeof( e.pageX ) == 'number' ) {
			//NS 4, NS 6+, Mozilla 0.9+
			p.x = e.pageX;
			p.y = e.pageY;
		} else {
			if( typeof( e.clientX ) == 'number' ) {
				//IE, Opera, NS 6+, Mozilla 0.9+
				//except that NS 6+ and Mozilla 0.9+ did pageX ...
				p.x = e.clientX;
				p.y = e.clientY;
				if( !( ( window.navigator.userAgent.indexOf( 'Opera' ) + 1 ) ||
					( window.ScriptEngine && ScriptEngine().indexOf( 'InScript' ) + 1 ) ||
					window.navigator.vendor == 'KDE' ) ) {
					if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
						//IE 4, 5 & 6 (in non-standards compliant mode)
						p.x += document.body.scrollLeft;
						p.y += document.body.scrollTop;
					} else if( document.documentElement &&
						( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
						//IE 6 (in standards compliant mode)
						p.x += document.documentElement.scrollLeft;
						p.y += document.documentElement.scrollTop;
					}
				}
			} else {
				//TOTAL FAILURE, WE HAVE NO WAY OF OBTAINING THE
				//MOUSE COORDINATES
				return;
			}
		}
		return p;
	}
	*/

	/*************************************************************************************************
	* Old Mouse capturing functions - depricated
	* (based on http://www.hypergurl.com/attack.html)
	*************************************************************************************************/
	/*
	var mouseMoveCallbackFn, mouseMoveCallbackObj;
	function captureMouseMove(callback) {

		if (n4||n6){
			window.captureEvents(Event.MOUSEMOVE);
			if (n4) window.onMouseMove=mouseMoveNN;
			else document.onmousemove=mouseMoveNN;
			mouseMoveCallback = callback;
//      mouseMoveCallbackObj =
		}
		if (ie||o6){
			document.onmousemove=mouseMoveIE;
			mouseMoveCallback = callback;
		}
	}

	// Netscape mousemove handler
	function mouseMoveNN(e) {
		var y = e.pageY-window.pageYOffset;
		var x = e.pageX;
		if (this.handler) this.handler(x, y)
		mouseMoveCallback(x, y);
	}

	// IE mousemove handler
	function mouseMoveIE() {
		var y = (this.ie)?event.clientY:event.clientY-window.pageYOffset;
		var x = event.clientX;
		mouseMoveCallback(x, y);
	}*/


