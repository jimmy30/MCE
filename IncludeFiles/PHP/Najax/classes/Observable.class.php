<?php
/**
 * NAJAX Observable Namespace file.
 *
 * <p>This file defines the {@link NAJAX_Observable} Class.</p>
 * <p>This class is used internally only.</p>
 *
 * @author	Stanimir Angeloff
 *
 * @package	NAJAX
 *
 * @version	0.4.0.0
 *
 */

/**
 * NAJAX Observable Class.
 *
 * <p>This class is used to extend classes with events.</p>
 * <p>You should never use this class directly. Rather,
 * use the classes that extend this class.</p>
 *
 * @access		private
 *
 * @author		Stanimir Angeloff
 *
 * @package		NAJAX
 *
 * @version		0.4.0.0
 *
 */
class NAJAX_Observable
{
	/**
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function addObserver(&$observer, $className = 'NAJAX_Observable')
	{
		if (NAJAX_Utilities::getType($observer) != 'object') {

			return false;
		}

		if ( ! is_subclass_of($observer, 'NAJAX_Observer')) {

			return false;
		}

		if ( ! isset($GLOBALS['_NAJAX_OBSERVERS'])) {

			$GLOBALS['_NAJAX_OBSERVERS'] = array();
		}

		$globalObservers =& $GLOBALS['_NAJAX_OBSERVERS'];

		$className = strtolower($className);

		if ( ! isset($globalObservers[$className])) {

			$globalObservers[$className] = array();
		}

		$globalObservers[$className][] =& $observer;

		return true;
	}

	/**
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function notifyObservers($event = 'default', $arg = null, $className = 'NAJAX_Observable')
	{
		if (empty($GLOBALS['_NAJAX_OBSERVERS'])) {

			return true;
		}

		$globalObservers =& $GLOBALS['_NAJAX_OBSERVERS'];

		$className = strtolower($className);

		if (empty($globalObservers[$className])) {

			return true;
		}

		$returnValue = true;

		foreach ($globalObservers[$className] as $index => $observer) {

			$eventValue = $observer->updateObserver($event, $arg);

			if (NAJAX_Utilities::getType($eventValue) == 'bool') {

				$returnValue &= $eventValue;
			}
		}

		return $returnValue;
	}
}

?>