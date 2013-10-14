<?php
/**
 * NAJAX all-in-one file.
 *
 * <p>This file includes all configuration files and
 * classes that the NAJAX package contains.</p>
 * <p>The file also includes all installed
 * extensions.</p>
 *
 * @author	Stanimir Angeloff
 *
 * @package	NAJAX
 *
 * @version	0.4.0.0
 *
 */

if ( ! defined('NAJAX_BASE')) {

	/**
	 * NAJAX base folder that contains all package files.
	 */
	define('NAJAX_BASE', dirname(__FILE__));
}

/**
 * Loads the NAJAX configuration file.
 */
require_once(NAJAX_BASE . '/config/najax.config.php');

/**
 * Loads the NAJAX extensions configuration file.
 */
require_once(NAJAX_BASE . '/config/extensions.config.php');

/**
 * Loads the file that defines the {@link NAJAX_Observer} Class.
 */
require_once(NAJAX_BASE . '/classes/Observer.class.php');

/**
 * Loads the class that is used to extend classes with events.
 */
require_once(NAJAX_BASE . '/classes/Observable.class.php');

/**
 * Loads the class that defines extended functions that
 * the NAJAX package uses and overrides some
 * deprecated functions, like gettype(...).
 */
require_once(NAJAX_BASE . '/classes/Utilities.class.php');

/**
 * Loads the class that is used to serialize a PHP variable
 * into a {@link http://www.json.org JSON} string.
 */
require_once(NAJAX_BASE . '/classes/Serializer.class.php');

/**
 * Loads the class that is used to register a PHP variable/class
 * in JavaScript.
 */
require_once(NAJAX_BASE . '/classes/Client.class.php');

/**
 * Loads the class that is used as base class for all
 * NACLES storage providers.
 */
require_once(NAJAX_BASE .'/classes/events/Storage.class.php');

/**
 * Loads the class that is used to handle client callbacks.
 */
require_once(NAJAX_BASE . '/classes/Server.class.php');

if ( ! empty($najaxExtensions)) {

	foreach ($najaxExtensions as $extension) {

		/**
		 * NAJAX extension base folder that contains all extension files.
		 */
		define('NAJAX_' . strtoupper($extension) . '_BASE', NAJAX_BASE . '/extensions/' . $extension);

		/**
		 * Loads the main extension file.
		 */
		require_once(NAJAX_BASE . '/extensions/' . $extension . '/' . $extension . '.ext.php');
	}
}

if (defined('NAJAX_AUTOHANDLE')) {

	if (NAJAX_AUTOHANDLE) {

		NAJAX_Server::runServer();

		if (defined('NAJAX_CALLBACK')) {

			if (NAJAX_CALLBACK) {

				exit;
			}
		}
	}
}
?>