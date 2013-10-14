<?php
/**
 * NAJAX Events Storage Namespace file.
 *
 * <p>This file defines the {@link NAJAX_Events_Storage} Class.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 *
 * require_once('najax.php');
 *
 * $storage = NAJAX_Events_Storage::getStorage();
 *
 * $storage->postEvent('event', 'class');
 *
 * ?>
 * </code>
 *
 * @author	Stanimir Angeloff
 *
 * @package	NAJAX
 *
 * @subpackage	NACLES
 *
 * @version	0.4.0.0
 *
 */

/**
 * NAJAX Events Storage Class.
 *
 * <p>This class is used as base class for all NACLES storage providers.</p>
 * <p>The class also defines the {@link getStorage} method which
 * is used to retrieve an instane to the configurated storage.</p>
 * <p>Example NACLES provider: {@link NAJAX_Events_Storage_MySQL}.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 *
 * define('NAJAX_EVENTS_STORAGE_DSN', 'MySQL://server=?;user=?;password=?;database=?');
 *
 * require_once('najax.php');
 *
 * // The line below will return a NAJAX_Events_Storage_MySQL
 * // class instance.
 * $storage = NAJAX_Events_Storage::getStorage();
 *
 * $storage->postEvent('event', 'class');
 *
 * ?>
 * </code>
 *
 * @author		Stanimir Angeloff
 *
 * @package		NAJAX
 *
 * @subpackage	NACLES
 *
 * @version		0.4.0.0
 *
 */
class NAJAX_Events_Storage
{
	/**
 	 * Retrieves an instane to the configurated NACLES storage provider.
	 *
	 * <p>Example:</p>
	 * <code>
	 * <?php
	 *
	 * require_once('najax.php');
	 *
	 * $storage = NAJAX_Events_Storage::getStorage();
	 *
	 * $storage->postEvent('event', 'class');
	 *
	 * ?>
	 * </code>
	 *
	 * @access	public
	 *
	 * @return	object	Singleton {@link NAJAX_Events_Storage} inherited class based
	 *					on the configuration (see {@link NAJAX_EVENTS_STORAGE_DSN}).
	 *
	 * @static
	 *
	 */
	function getStorage()
	{
		static $instance;

		if ( ! isset($instance)) {

			$className = null;

			$classParameters = null;

			$separator = '://';

			$position = strpos(NAJAX_EVENTS_STORAGE_DSN, $separator);

			if ($position === false) {

				$className = NAJAX_EVENTS_STORAGE_DSN;

			} else {

				$className = substr(NAJAX_EVENTS_STORAGE_DSN, 0, $position);

				$classParameters = substr(NAJAX_EVENTS_STORAGE_DSN, $position + strlen($separator));
			}

			if (empty($className)) {

				return null;
			}

			$fileName = NAJAX_BASE . '/classes/events/storage/' . $className . '.class.php';

			require_once($fileName);

			$realClassName = 'NAJAX_Events_Storage_' . $className;

			if ( ! class_exists($realClassName)) {

				return null;
			}

			$instance = new $realClassName($classParameters);
		}

		return $instance;
	}

	/**
	 * Abstract base class method.
	 *
	 * <p>Successor classes should override this method.</p>
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function postEvent()
	{
		return true;
	}

	/**
	 * Abstract base class method.
	 *
	 * <p>Successor classes should override this method.</p>
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function postMultipleEvents()
	{
		return true;
	}

	/**
	 * Abstract base class method.
	 *
	 * <p>Successor classes should override this method.</p>
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function cleanEvents()
	{
		return true;
	}

	/**
	 * Abstract base class method.
	 *
	 * <p>Successor classes should override this method.</p>
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function filterEvents()
	{
		return true;
	}

	/**
	 * Abstract base class method.
	 *
	 * <p>Successor classes should override this method.</p>
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function filterMultipleEvents()
	{
		return true;
	}
}
?>