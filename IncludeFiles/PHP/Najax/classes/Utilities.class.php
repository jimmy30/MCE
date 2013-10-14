<?php
/**
 * NAJAX Utilities Namespace file.
 *
 * <p>This file defines the {@link NAJAX_Utilities} Class.</p>
 *
 * @author	Stanimir Angeloff
 *
 * @package	NAJAX
 *
 * @version	0.4.0.0
 *
 */

/**
 * NAJAX Utilities Class.
 *
 * <p>This class defines extended functions that
 * the NAJAX package uses and overrides some
 * deprecated functions, like gettype(...).</p>
 *
 * @author		Stanimir Angeloff
 *
 * @package		NAJAX
 *
 * @version		0.4.0.0
 *
 */
class NAJAX_Utilities extends NAJAX_Observable
{
	/**
	 * Checks if an array is an associative array.
	 *
	 * @access	public
	 *
	 * @param	mixed	$var	The array to check.
	 *
	 * @return	bool	true if {@link $var} is an associative array, false
	 *					if {@link $var} is a sequential array.
	 *
	 * @static
	 *
	 */
	function isAssocArray($var)
	{
		// This code is based on mike-php's
		// comment in is_array function documentation.
		//
		// http://bg.php.net/is_array
		//
		// Thank you.
		//

		if ( ! is_array($var)) {

			return false;
		}

		$arrayKeys = array_keys($var);

		$sequentialKeys = range(0, sizeof($var));

		if (function_exists('array_diff_assoc')) {

			if (array_diff_assoc($arrayKeys, $sequentialKeys)) {

				return true;
			}

		} else {

			if (
			(array_diff($arrayKeys, $sequentialKeys)) &&
			(array_diff($sequentialKeys, $arrayKeys))) {

				return true;
			}
		}

		return false;
	}

	/**
	 * Gets the type of a variable.
	 *
	 * @access	public
	 *
	 * @param	mixed	$var	The source variable.
	 *
	 * @return	string	Possibles values for the returned string are:
	 *					- "bool"
	 *					- "int"
	 *					- "float"
	 *					- "string"
	 *					- "s_array"
	 *					- "a_array"
	 *					- "object"
	 *					- "null"
	 *					- "unknown"
	 *
	 * @static
	 *
	 */
	function getType($var)
	{
		if (is_bool($var)) {

			return 'bool';

		} else if (is_int($var)) {

			return 'int';

		} else if (is_float($var)) {

			return 'float';

		} else if (is_string($var)) {

			return 'string';

		} else if (is_array($var)) {

			if (NAJAX_Utilities::isAssocArray($var)) {

				return 'a_array';

			} else {

				return 's_array';
			}

		} else if (is_object($var)) {

			return 'object';

		} else if (is_null($var)) {

			return 'null';
		}

		return 'unknown';
	}

	/**
	 * Return current UNIX timestamp with microseconds.
	 *
	 * @access	public
	 *
	 * @return	float	Returns the float 'sec,msec' where 'sec' is the
	 *					current time measured in the number of seconds since
	 *					the Unix Epoch (0:00:00 January 1, 1970 GMT), and
	 *					'msec' is the microseconds part.
	 *
	 * @static
	 *
	 */
	function getMicroTime()
	{
		list($microTime, $time) = explode(" ", microtime());

		return ((float) $microTime + (float) $time);
	}

	/**
	 * Registers NAJAX client header files.
	 *
	 * @access	public
	 *
	 * @param	string	$base		Base NAJAX folder.
	 *
	 * @param	bool	$optimized	true to include optimized headers, false otherwise.
	 *
	 * @return	string	HTML code to include NAJAX client files.
	 *
	 * @static
	 *
	 */
	function header($base = '.', $optimized = true)
	{
		$returnValue = '<script type="text/javascript" src="' . $base . '/js/';

		$returnValue .= 'najax';

		if ($optimized) {

			$returnValue .= '_optimized';
		}

		$returnValue .= '.js">
		
		</script>';

		if (array_key_exists('_NAJAX_EXTENSION_HEADERS', $GLOBALS)) {

			foreach ($GLOBALS['_NAJAX_EXTENSION_HEADERS'] as $extension => $files) {

				$extensionBase = $base . '/extensions/' . $extension . '/';

				foreach ($files as $fileName) {

					$returnValue .= '<script type="text/javascript" src="' . $extensionBase . ($optimized ? $fileName[1] : $fileName[0]) . '"></script>';
				}
			}
		}

		return $returnValue;
	}

	/**
	 * Registers NACLES header data.
	 *
	 * <p>You should call this method after {@link NAJAX_Utilities::header}.</p>
	 * <p>NACLES header data includes server time and callback URL.</p>
	 *
	 * @access	public
	 *
	 * @param	string	$callbackUrl	NACLES callback URL.
	 *
	 * @return	string	HTML code to initialize NACLES.
	 *
	 * @static
	 *
	 */
	function eventsHeader($callbackUrl = null)
	{
		if ($callbackUrl == null) {

			$callbackUrl = $_SERVER['PHP_SELF'];
		}

		$returnValue = '<script type="text/javascript">';
		$returnValue .= 'najax.events.callbackUrl = ' . NAJAX_Client::register($callbackUrl) . ';';
		$returnValue .= 'najax.events.lastRefresh = ' . NAJAX_Client::register(NAJAX_Utilities::getMicroTime()) . ';';
		$returnValue .= '</script>';

		return $returnValue;
	}

	/**
	 * Registers NAJAX extension client header file.
	 *
	 * @access	public
	 *
	 * @param	string	$extension			The name of the NAJAX extension.
	 *
	 * @param	string	$fileName			The extension JavaScript file name.
	 *										This file must be located in the
	 *										extension base folder.
	 *
	 * @param	string	$optimizedFileName	The optimized extension JavaScript file name.
	 *										This file must be located in the
	 *										extension base folder.
	 *
	 *
	 * @return	bool	true on success, false otherwise.
	 *
	 * @static
	 *
	 */
	function extensionHeader($extension, $fileName, $optimizedFileName = null)
	{
		if ( ! array_key_exists('_NAJAX_EXTENSION_HEADERS', $GLOBALS)) {

			$GLOBALS['_NAJAX_EXTENSION_HEADERS'] = array();
		}

		$extension = strtolower($extension);

		if ( ! array_key_exists($extension, $GLOBALS['_NAJAX_EXTENSION_HEADERS'])) {

			$GLOBALS['_NAJAX_EXTENSION_HEADERS'][$extension] = array();
		}

		if (empty($optimizedFileName)) {

			$optimizedFileName = $fileName;
		}

		$GLOBALS['_NAJAX_EXTENSION_HEADERS'][$extension][] = array($fileName, $optimizedFileName);

		return true;
	}

	/**
	 * Returns the input string with all alphabetic characters
	 * converted to lower or upper case depending on the configuration.
	 *
	 * @param	string	$text	The text to convert to lower/upper case.
	 *
	 * @return	string	The converted text.
	 *
	 * @static
	 *
	 */
	function caseConvert($text)
	{
		return strtolower($text);
	}

	/**
	 * Adds a {@link NAJAX_Utilities} events observer.
	 *
	 * @access	public
	 *
	 * @param	mixed	$observer	The observer object to add (must extend {@link NAJAX_Observer}).
	 *
	 * @return	string	true on success, false otherwise.
	 *
	 * @static
	 *
	 */
	function addObserver(&$observer)
	{
		return parent::addObserver($observer, 'NAJAX_Utilities');
	}

	/**
	 *
	 * @access	private
	 *
	 * @return	bool
	 *
	 */
	function notifyObservers($event = 'default', $arg = null)
	{
		return parent::notifyObservers($event, $arg, 'NAJAX_Utilities');
	}
}
?>