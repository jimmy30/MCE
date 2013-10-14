<?php
/**
 * NAJAX Client Namespace file.
 *
 * <p>This file defines the {@link NAJAX_Client} Class.</p>
 * <p>Example:</p>
 * <code>
 * <script type="text/javascript">
 * <?php
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
 * require_once('najax.php');
 *
 * print NAJAX_Client::register('Calculator', 'server.php');
 *
 * ?>
 * </script>
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
 * NAJAX Client Class.
 *
 * <p>This class is used to register a PHP variable/class
 * in JavaScript.</p>
 * <p>This class is also used to assign meta data
 * to the classes. See
 * {@link NAJAX_Client::publicMethods},
 * {@link NAJAX_Client::privateMethods},
 * {@link NAJAX_Client::publicVariables},
 * {@link NAJAX_Client::privateVariables} and
 * {@link NAJAX_Client::mapMethods} for more information.</p>
 * <p>Example:</p>
 * <code>
 * <?php
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
 * define('NAJAX_AUTOHANDLE', true);
 *
 * require_once('najax.php');
 *
 * ?>
 * <?= NAJAX_Utilities::header() ?>
 * <script type="text/javascript">
 *
 * var calc = <?= NAJAX_Client::register(new Calculator()) ?>;
 *
 * calc.add(10);
 * calc.add(20);
 *
 * alert(calc.result);
 *
 * </script>
 * </code>
 *
 * @author		Stanimir Angeloff
 *
 * @package		NAJAX
 *
 * @version		0.4.0.0
 *
 */
class NAJAX_Client extends NAJAX_Observable
{
	/**
	 * Registers a PHP variable/class in JavaScript.
	 *
	 * <p>Example:</p>
	 * <code>
	 * <script type="text/javascript">
	 * <?php require_once('najax.php'); ?>
	 *
	 * var arr = <?= NAJAX_Client::register(array(1, 2, "string", array("Nested"))) ?>;
	 *
	 * alert(arr);
	 *
	 * </script>
	 * </code>
	 *
	 * @access	public
	 *
	 * @param	mixed	$var	Variable/Class name to register.
	 *
	 * @param	mixed	$params	When registering a variable/class you can
	 *							provide extended parameters, like class name
	 *							and callback URL.
	 *
	 * @return	string	JavaString code that represents the variable/class.
	 *
	 * @static
	 *
	 */
	function register($var, $params = null)
	{
		$type = NAJAX_Utilities::getType($var);

		if ($type == 'object') {

			$paramsType = NAJAX_Utilities::getType($params);

			if ($paramsType != 'string') {

				$callbackUrl = $_SERVER['PHP_SELF'];

				if ($paramsType == 'a_array') {

					if ( ! empty($params['class'])) {

						$className = $params['class'];
					}

					if ( ! empty($params['url'])) {

						$callbackUrl = $params['url'];
					}
				}

			} else {

				$callbackUrl = $params;
			}

			if (method_exists($var, NAJAX_CLIENT_METADATA_METHOD_NAME)) {

				call_user_func_array(array(&$var, NAJAX_CLIENT_METADATA_METHOD_NAME), null);
			}

			$objectCode = array();

			if (empty($className)) {

				$className = NAJAX_Utilities::caseConvert(get_class($var));
			}

			$meta = get_object_vars($var);

			$objectMeta = null;

			if (isset($meta['najaxMeta'])) {

				if (NAJAX_Utilities::getType($meta['najaxMeta']) == 'object') {

					if (strcasecmp(get_class($meta['najaxMeta']), 'NAJAX_Meta') == 0) {

						$objectMeta = $meta['najaxMeta'];

						unset($meta['najaxMeta']);

						unset($var->najaxMeta);
					}
				}
			}

			if (sizeof($meta) > 0) {

				foreach ($meta as $key => $value) {

					if ( ! empty($objectMeta)) {

						if ( ! $objectMeta->isPublicVariable($key)) {

							unset($meta[$key]);

							unset($var->$key);

							continue;
						}
					}

					$valueType = NAJAX_Utilities::getType($value);

					if (
					($valueType == 'object') ||
					($valueType == 's_array') ||
					($valueType == 'a_array')) {

						$var->$key = NAJAX_SERIALIZER_SKIP_STRING . NAJAX_Client::register($var->$key, $callbackUrl);
					}

					$meta[$key] = $valueType;
				}

				$var->__meta = $meta;

				$var->__size = sizeof($meta);

			} else {

				$var->__meta = null;

				$var->__size = 0;
			}

			$var->__class = $className;

			$var->__url = $callbackUrl;

			$var->__uid = md5(uniqid(rand(), true));

			$var->__output = null;

			$var->__timeout = null;

			$serialized = NAJAX_Serializer::serialize($var);

			$objectCode[] = substr($serialized, 1, strlen($serialized) - 2);

			$objectCode[] = '"__clone":function(obj){najax.clone(this, obj)}';

			$objectCode[] = '"__serialize":function(){return najax.serialize(this)}';

			$objectCode[] = '"catchEvent":function(){return najax.catchEvent(this, arguments)}';

			$objectCode[] = '"ignoreEvent":function(){return najax.ignoreEvent(this, arguments)}';

			$objectCode[] = '"postEvent":function(){return najax.postEvent(this, arguments)}';

			$objectCode[] = '"fetchOutput":function(){return this.__output}';

			$objectCode[] = '"setTimeout":function(miliseconds){this.__timeout = miliseconds}';

			$objectCode[] = '"getTimeout":function(){return this.__timeout}';

			$objectCode[] = '"clearTimeout":function(){this.__timeout = null}';

			$classMethods = get_class_methods($var);

			for ($iterator = sizeof($classMethods) - 1; $iterator >= 0; $iterator --) {

				if (strcasecmp($className, $classMethods[$iterator]) == 0) {

					unset($classMethods[$iterator]);

					continue;
				}

				if (strcasecmp($classMethods[$iterator], NAJAX_CLIENT_METADATA_METHOD_NAME) == 0) {

					unset($classMethods[$iterator]);

					continue;
				}

				if ( ! empty($objectMeta)) {

					if ( ! $objectMeta->isPublicMethod($classMethods[$iterator])) {

						unset($classMethods[$iterator]);

						continue;
					}
				}
			}

			if (sizeof($classMethods) > 0) {

				$index = 0;

				$length = sizeof($classMethods);

				$returnValue = '';

				foreach ($classMethods as $method) {

					$methodName = NAJAX_Utilities::caseConvert($method);

					if ( ! empty($objectMeta)) {

						$mapMethodName = $objectMeta->findMethodName($methodName);

						if (strcmp($mapMethodName, $methodName) != 0) {

							$methodName = $mapMethodName;
						}
					}

					$serialized = NAJAX_Serializer::serialize($methodName);

					$returnValue .= $serialized;

					$returnValue .= ':';

					$returnValue .= 'function(){return najax.call(this,' . $serialized .',arguments)}';

					if ($index < $length - 1) {

						$returnValue .= ',';
					}

					$index ++;
				}

				$objectCode[] = $returnValue;
			}

			$returnValue = '{' . join(',', $objectCode) . '}';

			return $returnValue;

		} else if (($type == 's_array') || ($type == 'a_array')) {

			foreach ($var as $key => $value) {

				$valueType = NAJAX_Utilities::getType($value);

				if (
				($valueType == 'object') ||
				($valueType == 's_array') ||
				($valueType == 'a_array')) {

					$var[$key] = NAJAX_SERIALIZER_SKIP_STRING . NAJAX_Client::register($var[$key], $params);
				}
			}

		} else if ($type == 'string') {

			$paramsType = NAJAX_Utilities::getType($params);

			if ($paramsType == 'string') {

				if (class_exists($var)) {

					$classObject = new $var;

					$classCode = NAJAX_Client::register($classObject, array('class' => $var, 'url' => $params));

					$classCode = $var . '=function(){return ' . $classCode . '}';

					return $classCode;
				}
			}
		}

		return NAJAX_Serializer::serialize($var);
	}

	/**
	 * Assigns public methods to the class meta data.
	 *
	 * @param	object	$var		The object where the meta data is stored.
	 *
	 * @param	array	$methods	The class public methods.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function publicMethods(&$var, $methods)
	{
		if (NAJAX_Utilities::getType($var) != 'object') {

			return false;
		}

		if ( ! isset($var->najaxMeta)) {

			require_once(NAJAX_BASE . '/classes/Meta.class.php');

			$var->najaxMeta = new NAJAX_Meta();
		}

		$var->najaxMeta->setPublicMethods($methods);
	}

	/**
	 * Assigns private methods to the class meta data.
	 *
	 * @param	object	$var		The object where the meta data is stored.
	 *
	 * @param	array	$methods	The class private methods.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function privateMethods(&$var, $methods)
	{
		if (NAJAX_Utilities::getType($var) != 'object') {

			return false;
		}

		if ( ! isset($var->najaxMeta)) {

			require_once(NAJAX_BASE . '/classes/Meta.class.php');

			$var->najaxMeta = new NAJAX_Meta();
		}

		$var->najaxMeta->setPrivateMethods($methods);
	}

	/**
	 * Assigns public variables to the class meta data.
	 *
	 * @param	object	$var		The object where the meta data is stored.
	 *
	 * @param	array	$variables	The class public variables.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function publicVariables(&$var, $variables)
	{
		if (NAJAX_Utilities::getType($var) != 'object') {

			return false;
		}

		if ( ! isset($var->najaxMeta)) {

			require_once(NAJAX_BASE . '/classes/Meta.class.php');

			$var->najaxMeta = new NAJAX_Meta();
		}

		$var->najaxMeta->setPublicVariables($variables);
	}

	/**
	 * Assigns private variables to the class meta data.
	 *
	 * @param	object	$var		The object where the meta data is stored.
	 *
	 * @param	array	$variables	The class private variables.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function privateVariables(&$var, $variables)
	{
		if (NAJAX_Utilities::getType($var) != 'object') {

			return false;
		}

		if ( ! isset($var->najaxMeta)) {

			require_once(NAJAX_BASE . '/classes/Meta.class.php');

			$var->najaxMeta = new NAJAX_Meta();
		}

		$var->najaxMeta->setPrivateVariables($variables);
	}

	/**
	 * Assigns methods map to the class meta data.
	 *
	 * @param	object	$var		The object where the meta data is stored.
	 *
	 * @param	array	$methodsMap	The class methods map.
	 *
	 * @return	void
	 *
	 * @static
	 *
	 */
	function mapMethods(&$var, $methodsMap)
	{
		if (NAJAX_Utilities::getType($var) != 'object') {

			return false;
		}

		if ( ! isset($var->najaxMeta)) {

			require_once(NAJAX_BASE . '/classes/Meta.class.php');

			$var->najaxMeta = new NAJAX_Meta();
		}

		$var->najaxMeta->setMethodsMap($methodsMap);
	}

	/**
	 * Adds a {@link NAJAX_Client} events observer.
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
		return parent::addObserver($observer, 'NAJAX_Client');
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
		return parent::notifyObservers($event, $arg, 'NAJAX_Client');
	}
}
?>