<?php
/**
 * NAJAX_HTML Extension File.
 *
 * <p>This file initialized the NAJAX_HTML extension
 * and installs all necessary server observers.</p>
 * <p>Note that this file is not included directly.
 * You should add the extension manually to the
 * extensions configuration file.</p>
 *
 * @author		Stanimir Angeloff
 *
 * @package		NAJAX
 *
 * @subpackage	NAJAX_HTML
 *
 * @version		0.4.0.0
 *
 */

/**
 * Load the class that defines the NAJAX_HTML Server observer.
 */
require_once(NAJAX_HTML_BASE . '/classes/ServerObserver.class.php');

NAJAX_Server::addObserver(new NAJAX_HTML_ServerObserver());

NAJAX_Utilities::extensionHeader('html', 'js/html.js', 'js/html_optimized.js');

?>