<?php
/**
 * NAJAX Configuration file.
 *
 * <p>This file contains most of the available NAJAX
 * configuration options.</p>
 * <p>You can modify this file, but you should be aware
 * that NAJAX is only tested with the default
 * configuration.</p>
 *
 * @author	Stanimir Angeloff
 *
 * @package	NAJAX
 *
 * @version	0.4.0.0
 *
 */

if ( ! defined('NAJAX_SERIALIZER_SKIP_STRING')) {

	/**
	 * Defines the prefix that is used to indicate the
	 * Serializer to skip string serialization.
	 *
	 * <p>Example:</p>
	 * <code>
	 * <?php
	 *
	 * require_once('najax.php');
	 *
	 * $arr = array(1, 2, NAJAX_SERIALIZER_SKIP_STRING . 'function skip() { alert("skip."); }');
	 *
	 * ?>
	 * <script type="text/javascript">
	 *
	 * var arr = <?= NAJAX_Serializer::serialize($arr) ?>;
	 *
	 * arr[2]();
	 *
	 * </script>
	 * </code>
	 */
	define('NAJAX_SERIALIZER_SKIP_STRING', '<![najaxSerializer:skipString[');
}

if ( ! defined('NAJAX_CLIENT_METADATA_METHOD_NAME')) {

	/**
	 * Defines the method name that is called when NAJAX
	 * needs more information about an object.
	 *
	 * <p>Every class that you will register with {@link NAJAX_Client}
	 * should implement this method to provide more information
	 * about its methods and variables.</p>
	 * <p>Example:</p>
	 * <code>
	 * <script type="text/javascript">
	 * <?php
	 *
	 * class MetaExample
	 * {
	 * 	var $privateVar;
	 * 	var $publicVar;
	 *
	 * 	function PrivateMethod() {}
	 * 	function PublicMethod() {}
	 *
	 * 	function najaxGetMeta()
	 * 	{
	 * 		NAJAX_Client::privateMethods($this, array('PrivateMethod'));
	 *
	 * 		NAJAX_Client::privateVariables($this, array('privateVar'));
	 *
	 * 		NAJAX_Client::mapMethods($this, array('PublicMethod'));
	 * 	}
	 * }
	 *
	 * require_once('najax.php');
	 *
	 * print NAJAX_Client::register('MetaExample', 'server.php');
	 *
	 * ?>
	 * </script>
	 * </code>
	 *
	 */
	define('NAJAX_CLIENT_METADATA_METHOD_NAME', 'najaxGetMeta');
}

if ( ! defined('NAJAX_EVENTS_STORAGE_DSN')) {

	/**
	 * Defines the data source name and parameters to use
	 * when event's information is saved.
	 *
	 * <p>DSN Examples:</p>
	 * <code>
	 * File://c:/events.txt
	 * MySQL://server=?;user=?;password=?;database=?;[port=?]
	 * </code>
	 *
	 */
	define('NAJAX_EVENTS_STORAGE_DSN', 'MySQL://server=?;user=?;password=?;database=?');
}

if ( ! defined('NAJAX_EVENTS_LIFETIME')) {

	/**
	 * Defines the default lifetime for an event.
	 *
	 * <p>The default value is 2 minutes. Please note, that
	 * the lifetime should be between 30 seconds and 5 minutes
	 * for performance reasons.</p>
	 */
	define('NAJAX_EVENTS_LIFETIME', 60 * 2);
}

?>