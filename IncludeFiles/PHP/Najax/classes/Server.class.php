<?php
/**
 * NAJAX Server Namespace file.
 *
 * <p>This file defines the {@link NAJAX_Server} Class.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 *
 * require_once('najax.php');
 *
 * class Calculator
 * {
 * 	var $result;
 *
 * 	function Calculator()
 * 	{
 * 		$this->result = 0;
 * 	}
 *
 * 	function Add($arg)
 * 	{
 * 		$this->result += $arg;
 * 	}
 * }
 *
 * NAJAX_Server::runServer();
 *
 * ?>
 * </code>
 *
 * @author	Stanimir Angeloff
 *
 * @package	NAJAX
 *
 * @version	0.4.0.0
 *
 */

/**
 * NAJAX Server Class.
 *
 * <p>This class is used to handle client callbacks.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 *
 * require_once('najax.php');
 *
 * class Calculator
 * {
 * 	var $result;
 *
 * 	function Calculator()
 * 	{
 * 		$this->result = 0;
 * 	}
 *
 * 	function Add($arg)
 * 	{
 * 		$this->result += $arg;
 * 	}
 * }
 *
 * NAJAX_Server::runServer();
 *
 * ?>
 * </code>
 *
 * @author		Stanimir Angeloff
 *
 * @package		NAJAX
 *
 * @version		0.4.0.0
 *
 */
class NAJAX_Server extends NAJAX_Observable
{
	/**
	 * Checks if the request is a client callback
	 * to the server and handles it.
	 *
	 * @access	public
	 *
	 * @return	bool	true if the request is a valid client callback,
	 *					false otherwise.
	 *
	 * @static
	 *
	 */
	function runServer()
	{
		if ( ! NAJAX_Server::notifyObservers('runServerEnter')) {

			return false;
		}

		if (NAJAX_Server::initializeCallback()) {

			NAJAX_Server::dispatch();

			/**
			 * Defines whether the request is a client callback.
			 */
			define('NAJAX_CALLBACK', true);
		}

		if ( ! defined('NAJAX_CALLBACK')) {

			/**
			 * Defines whether the request is a client callback.
			 */
			define('NAJAX_CALLBACK', false);
		}

		if (NAJAX_Server::notifyObservers('runServerLeave', array('isCallback' => NAJAX_CALLBACK))) {

			return NAJAX_CALLBACK;

		} else {

			return false;
		}
	}

	/**
	 * Checks if the request is a client callback to the
	 * server and initializes callback parameters.
	 *
	 * @access	public
	 *
	 * @return	bool	true if the request is a valid client callback,
	 *					false otherwise.
	 *
	 * @static
	 *
	 */
	function initializeCallback()
	{
		if ( ! NAJAX_Server::notifyObservers('initializeCallbackEnter')) {

			return false;
		}

		if (isset($_GET['najaxCall'])) {

			if (strcasecmp($_GET['najaxCall'], 'true') == 0) {

				if ( ! isset($GLOBALS['HTTP_RAW_POST_DATA'])) {

					return false;
				}

				$requestBody = @unserialize($GLOBALS['HTTP_RAW_POST_DATA']);

				if ($requestBody == null) {

					return false;
				}

				if (
				isset($requestBody['eventPost']) &&
				isset($requestBody['className']) &&
				isset($requestBody['sender']) &&
				isset($requestBody['event']) &&
				array_key_exists('data', $requestBody) &&
				array_key_exists('filter', $requestBody)) {

					if (
					(NAJAX_Utilities::getType($requestBody['eventPost']) != 'bool') ||
					(NAJAX_Utilities::getType($requestBody['className']) != 'string') ||
					(NAJAX_Utilities::getType($requestBody['sender']) != 'string') ||
					(NAJAX_Utilities::getType($requestBody['event']) != 'string')) {

						return false;
					}

					if ( ! empty($requestBody['className'])) {

						NAJAX_Server::loadClass($requestBody['className']);

					} else {

						return false;
					}

					if ( ! NAJAX_Server::isClassAllowed($requestBody['className'])) {

						return false;
					}

					$requestBody['sender'] = @unserialize($requestBody['sender']);

					if ($requestBody['sender'] === null) {

						return false;
					}

					if (strcasecmp(get_class($requestBody['sender']), $requestBody['className']) != 0) {

						return false;
					}

					if ( ! NAJAX_Server::notifyObservers('initializeCallbackSuccess', array('request' => &$requestBody))) {

						return false;
					}

					$GLOBALS['_NAJAX_SERVER_REQUEST_BODY'] =& $requestBody;

					if (NAJAX_Server::notifyObservers('initializeCallbackLeave', array('request' => &$requestBody))) {

						return true;
					}

				} else if (
				isset($requestBody['eventsCallback']) &&
				isset($requestBody['time']) &&
				isset($requestBody['data'])) {

					if (
					(NAJAX_Utilities::getType($requestBody['eventsCallback']) != 'bool') ||
					(NAJAX_Utilities::getType($requestBody['time']) != 'float') ||
					(NAJAX_Utilities::getType($requestBody['data']) != 's_array')) {

						return false;
					}

					foreach ($requestBody['data'] as $eventData) {

						if ( ! empty($eventData['className'])) {

							NAJAX_Server::loadClass($eventData['className']);

						} else {

							return false;
						}

						if ( ! NAJAX_Server::isClassAllowed($eventData['className'])) {

							return false;
						}
					}

					if ( ! NAJAX_Server::notifyObservers('initializeCallbackSuccess', array('request' => &$requestBody))) {

						return false;
					}

					$GLOBALS['_NAJAX_SERVER_REQUEST_BODY'] =& $requestBody;

					if (NAJAX_Server::notifyObservers('initializeCallbackLeave', array('request' => &$requestBody))) {

						return true;
					}

				} else {

					if (
					( ! isset($requestBody['source'])) ||
					( ! isset($requestBody['className'])) ||
					( ! isset($requestBody['method'])) ||
					( ! isset($requestBody['arguments']))) {

						return false;
					}

					if ( ! empty($requestBody['className'])) {

						NAJAX_Server::loadClass($requestBody['className']);
					}

					$requestBody['source'] = @unserialize($requestBody['source']);

					$requestBody['arguments'] = @unserialize($requestBody['arguments']);

					if (
					($requestBody['source'] === null) ||
					($requestBody['className'] === null) ||
					($requestBody['arguments'] === null)) {

						return false;
					}

					if (
					(NAJAX_Utilities::getType($requestBody['source']) != 'object') ||
					(NAJAX_Utilities::getType($requestBody['className']) != 'string') ||
					(NAJAX_Utilities::getType($requestBody['method']) != 'string') ||
					(NAJAX_Utilities::getType($requestBody['arguments']) != 's_array')) {

						return false;
					}

					if (strcasecmp($requestBody['className'], get_class($requestBody['source'])) != 0) {

						return false;
					}

					if ( ! NAJAX_Server::isClassAllowed($requestBody['className'])) {

						return false;
					}

					if (method_exists($requestBody['source'], NAJAX_CLIENT_METADATA_METHOD_NAME)) {

						call_user_func_array(array(&$requestBody['source'], NAJAX_CLIENT_METADATA_METHOD_NAME), null);

						if (isset($requestBody['source']->najaxMeta)) {

							if (NAJAX_Utilities::getType($requestBody['source']->najaxMeta) == 'object') {

								if (strcasecmp(get_class($requestBody['source']->najaxMeta), 'NAJAX_Meta') == 0) {

									if ( ! $requestBody['source']->najaxMeta->isPublicMethod($requestBody['method'])) {

										return false;
									}
								}
							}
						}
					}

					if ( ! NAJAX_Server::notifyObservers('initializeCallbackSuccess', array('request' => &$requestBody))) {

						return false;
					}

					$GLOBALS['_NAJAX_SERVER_REQUEST_BODY'] =& $requestBody;

					if (NAJAX_Server::notifyObservers('initializeCallbackLeave', array('request' => &$requestBody))) {

						return true;
					}
				}
			}
		}

		NAJAX_Server::notifyObservers('initializeCallbackLeave');

		return false;
	}

	/**
	 * Dispatches a client callback to the server.
	 *
	 * @access	public
	 *
	 * @return	string	Outputs JavaString code that contains the result
	 *					and the output of the callback.
	 *
	 * @static
	 *
	 */
	function dispatch()
	{
		if (empty($GLOBALS['_NAJAX_SERVER_REQUEST_BODY'])) {

			return false;
		}

		$requestBody =& $GLOBALS['_NAJAX_SERVER_REQUEST_BODY'];

		if ( ! NAJAX_Server::notifyObservers('dispatchEnter', array('request' => &$requestBody))) {

			return false;
		}

		if (isset($requestBody['eventPost'])) {

			$callbackResponse = array();

			$storage = NAJAX_Events_Storage::getStorage();

			$callbackResponse['status'] = $storage->postEvent($requestBody['event'], $requestBody['className'], $requestBody['sender'], $requestBody['data'], $requestBody['filter']);

			if (NAJAX_Server::notifyObservers('dispatchLeave', array('request' => &$requestBody, 'response' => &$callbackResponse))) {

				if ( ! empty($callbackResponse['status'])) {

					print NAJAX_Client::register($callbackResponse);
				}
			}

		} else if (isset($requestBody['eventsCallback'])) {

			$eventsQuery = array();

			foreach ($requestBody['data'] as $event) {

				$eventsQuery[] = array(
				'event'		=>	$event['event'],
				'className'	=>	$event['className'],
				'filter'	=>	$event['filter'],
				'time'		=>	$requestBody['time']
				);
			}

			$callbackResponse = array();

			$storage = NAJAX_Events_Storage::getStorage();

			$storage->cleanEvents();

			$callbackResponse['result'] = $storage->filterMultipleEvents($eventsQuery);

			if (NAJAX_Server::notifyObservers('dispatchLeave', array('request' => &$requestBody, 'response' => &$callbackResponse))) {

				if ( ! empty($callbackResponse['result'])) {

					print NAJAX_Client::register($callbackResponse);
				}
			}

		} else {

			$callbackResponse = array();

			$outputBuffering = @ob_start();

			set_error_handler(array('NAJAX_Server', 'handleError'));

			$callbackResponse['returnValue'] = call_user_func_array(array(&$requestBody['source'], $requestBody['method']), $requestBody['arguments']);

			if (defined('NAJAX_SERVER_EXCEPTION')) {

				if (NAJAX_Server::notifyObservers('dispatchFailed', array('request' => &$requestBody, 'message' => NAJAX_SERVER_EXCEPTION))) {

					NAJAX_Server::throwException(NAJAX_SERVER_EXCEPTION);

					return false;
				}
			}

			$callbackResponse['returnObject'] =& $requestBody['source'];

			if ($outputBuffering) {

				$output = @ob_get_contents();

				if ( ! empty($output)) {

					$callbackResponse['output'] = $output;
				}

				@ob_end_clean();
			}

			restore_error_handler();

			if (NAJAX_Server::notifyObservers('dispatchLeave', array('request' => &$requestBody, 'response' => &$callbackResponse))) {

				print NAJAX_Client::register($callbackResponse);
			}
		}
	}

	/**
	 * Handles all errors that occur during the callback.
	 *
	 * <p>Only E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR and E_USER_ERROR
	 * will halt the callback and throw an exception.</p>
	 *
	 * @access	private
	 *
	 * @param	int		$type		Error type (compile, core, user...).
	 *
	 * @param	string	$message	Error message.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function handleError($type, $message)
	{
		if (error_reporting()) {

			if ( ! NAJAX_Server::notifyObservers('handleErrorEnter', array('type' => &$type, 'message' => &$message))) {

				return false;
			}

			$breakLevel = E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR;

			if (($type & $breakLevel) > 0) {

				if ( ! defined('NAJAX_SERVER_EXCEPTION')) {

					/**
					 * Defines the error message that caused the callback to halt.
					 */
					define('NAJAX_SERVER_EXCEPTION', $message);
				}
			}
		}

		NAJAX_Server::notifyObservers('handleErrorLeave', array('type' => &$type, 'message' => &$message));
	}

	/**
	 * Throws a NAJAX callback exception.
	 *
	 * @access	private
	 *
	 * @param	string	$message	Exception message.
	 *
	 * @return	string	Outputs JavaString code that contains the
	 *					exception message.
	 *
	 * @static
	 *
	 */
	function throwException($message)
	{
		if ( ! NAJAX_Server::notifyObservers('throwExceptionEnter', array('message' => &$message))) {

			return false;
		}

		restore_error_handler();

		$callbackException = array();

		$callbackException['exception'] = $message;

		if (NAJAX_Server::notifyObservers('throwExceptionLeave', array('message' => &$message))) {

			print NAJAX_Client::register($callbackException);
		}
	}

	/**
	 * Adds a specified class to the classes map.
	 *
	 * <p>Example:</p>
	 * <code>
	 * <?php
	 *
	 * require_once('najax.php');
	 *
	 * NAJAX_Server::mapClass('Calculator', 'Calculator.class.php');
	 *
	 * NAJAX_Server::mapClass('EnglishDictionary', array('BaseDictionary.class.php', 'EnglishDictionary.class.php'));
	 *
	 * NAJAX_Server::runServer();
	 *
	 * ?>
	 * </code>
	 *
	 * @access	public
	 *
	 * @param	string	$className	The class name to add.
	 *
	 * @param	mixed	$files		The files that are required
	 *								to load the class.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function mapClass($className, $files)
	{
		if ( ! isset($GLOBALS['_NAJAX_SERVER_CLASSES_MAP'])) {

			$GLOBALS['_NAJAX_SERVER_CLASSES_MAP'] = array();
		}

		$GLOBALS['_NAJAX_SERVER_CLASSES_MAP'][strtolower($className)] = $files;
	}

	/**
	 * Loads a specified class from the classes map.
	 *
	 * @access	private
	 *
	 * @param	string	$className	The class name to load. Note that all files
	 *								that are included in the class map will be
	 *								loaded.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function loadClass($className)
	{
		$className = strtolower($className);

		if ( ! empty($GLOBALS['_NAJAX_SERVER_CLASSES_MAP'])) {

			if (isset($GLOBALS['_NAJAX_SERVER_CLASSES_MAP'][$className])) {

				$files = $GLOBALS['_NAJAX_SERVER_CLASSES_MAP'][$className];

				$filesType = NAJAX_Utilities::getType($files);

				if ($filesType == 'string') {

					require_once($files);

				} else if (
				($filesType == 's_array') ||
				($filesType == 'a_array')) {

					foreach ($files as $fileName) {

						require_once($fileName);
					}
				}
			}
		}
	}

	/**
	 * Adds specified classes to the allowed classes map.
	 *
	 * <p>Example:</p>
	 * <code>
	 * <?php
	 *
	 * class AllowedClass
	 * {
	 * 	function call() { return 'AllowedClass->call()'; }
	 * }
	 *
	 * class DeniedClass
	 * {
	 * 	function call() { return 'DeniedClass->call()'; }
	 * }
	 *
	 * require_once('najax.php');
	 *
	 * NAJAX_Server::allowClasses('AllowedClass');
	 *
	 * if (NAJAX_Server::runServer()) {
	 *
	 * 	exit;
	 * }
	 *
	 * ?>
	 * <?= NAJAX_Utilities::header() ?>
	 *
	 * <script type="text/javascript">
	 *
	 * var allowedClass = <?= NAJAX_Client::register(new AllowedClass()) ?>;
	 *
	 * var deniedClass = <?= NAJAX_Client::register(new DeniedClass()) ?>;
	 *
	 * alert(allowedClass.call());
	 *
	 * // This line will throw an exception.
	 * // DeniedClass is not in the allowed classes list.
	 * alert(deniedClass.call());
	 *
	 * </script>
	 * </code>
	 *
	 * @access	public
	 *
	 * @param	mixed	$classes	The classes that can be accessed within
	 *								a callback request.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function allowClasses($classes)
	{
		$classesType = NAJAX_Utilities::getType($classes);

		if ( ! isset($GLOBALS['_NAJAX_SERVER_ALLOWED_CLASSES'])) {

			$GLOBALS['_NAJAX_SERVER_ALLOWED_CLASSES'] = array();
		}

		$allowedClasses =& $GLOBALS['_NAJAX_SERVER_ALLOWED_CLASSES'];

		if ($classesType == 'string') {

			$allowedClasses[] = strtolower($classes);

		} else if (($classesType == 's_array') || ($classesType == 'a_array')) {

			foreach ($classes as $class) {

				$allowedClasses[] = strtolower($class);
			}
		}
	}

	/**
	 * Adds specified classes to the denied classes map.
	 *
	 * <p>Example:</p>
	 * <code>
	 * <?php
	 *
	 * class AllowedClass
	 * {
	 * 	function call() { return 'AllowedClass->call()'; }
	 * }
	 *
	 * class DeniedClass
	 * {
	 * 	function call() { return 'DeniedClass->call()'; }
	 * }
	 *
	 * require_once('najax.php');
	 *
	 * NAJAX_Server::denyClasses('DeniedClass');
	 *
	 * if (NAJAX_Server::runServer()) {
	 *
	 * 	exit;
	 * }
	 *
	 * ?>
	 * <?= NAJAX_Utilities::header() ?>
	 *
	 * <script type="text/javascript">
	 *
	 * var allowedClass = <?= NAJAX_Client::register(new AllowedClass()) ?>;
	 *
	 * var deniedClass = <?= NAJAX_Client::register(new DeniedClass()) ?>;
	 *
	 * alert(allowedClass.call());
	 *
	 * // This line will throw an exception.
	 * // DeniedClass is in the denied classes list.
	 * alert(deniedClass.call());
	 *
	 * </script>
	 * </code>
	 *
	 * @access	public
	 *
	 * @param	mixed	$classes	The classes that can NOT be accessed
	 *								within a callback request.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function denyClasses($classes)
	{
		$classesType = NAJAX_Utilities::getType($classes);

		if ( ! isset($GLOBALS['_NAJAX_SERVER_DENIED_CLASSES'])) {

			$GLOBALS['_NAJAX_SERVER_DENIED_CLASSES'] = array();
		}

		$deniedClasses =& $GLOBALS['_NAJAX_SERVER_DENIED_CLASSES'];

		if ($classesType == 'string') {

			$deniedClasses[] = strtolower($classes);

		} else if (($classesType == 's_array') || ($classesType == 'a_array')) {

			foreach ($classes as $class) {

				$deniedClasses[] = strtolower($class);
			}
		}
	}

	/**
	 * Checks if a class can be accessed within a callback request.
	 *
	 * @access	private
	 *
	 * @param	string	$class	The class name to check.
	 *
	 * @return	bool	true if the class can be accessed, false if
	 *					the class is denied and can NOT be accessed.
	 *
	 * @static
	 *
	 */
	function isClassAllowed($class)
	{
		$allowedClasses = null;

		$deniedClasses = null;

		if (isset($GLOBALS['_NAJAX_SERVER_ALLOWED_CLASSES'])) {

			$allowedClasses =& $GLOBALS['_NAJAX_SERVER_ALLOWED_CLASSES'];
		}

		if (isset($GLOBALS['_NAJAX_SERVER_DENIED_CLASSES'])) {

			$deniedClasses =& $GLOBALS['_NAJAX_SERVER_DENIED_CLASSES'];
		}

		if ( ! empty($deniedClasses)) {

			if (in_array(strtolower($class), $deniedClasses)) {

				return false;
			}
		}

		if ( ! empty($allowedClasses)) {

			if ( ! in_array(strtolower($class), $allowedClasses)) {

				return false;
			}
		}

		return true;
	}

	/**
	 * Adds a {@link NAJAX_Server} events observer.
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
		return parent::addObserver($observer, 'NAJAX_Server');
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
		return parent::notifyObservers($event, $arg, 'NAJAX_Server');
	}
}
?>