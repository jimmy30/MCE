<?php
/**
 * NAJAX Meta Namespace file.
 *
 * <p>This file defines the {@link NAJAX_Meta} Class.</p>
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
 * NAJAX Meta Class.
 *
 * <p>This class is used to extend classes with meta
 * data, such as private methods and/or variables.</p>
 * <p>You should never use this class directly.
 * Rather, use the {@link NAJAX_Utilities} class.</p>
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
class NAJAX_Meta extends NAJAX_Observable
{
	/**
	 *
	 * @access	private
	 *
	 * @var		array
	 *
	 */
	var $publicMethods;

	/**
	 *
	 * @access	private
	 *
	 * @var		array
	 *
	 */
	var $privateMethods;

	/**
	 *
	 * @access	private
	 *
	 * @var		array
	 *
	 */
	var $publicVariables;

	/**
	 *
	 * @access	private
	 *
	 * @var		array
	 *
	 */
	var $privateVariables;

	/**
	 *
	 * @access	private
	 *
	 * @var		array
	 *
	 */
	var $methodsMap;

	/**
	 *
	 * @access	public
	 *
	 * @return	void
	 *
	 */
	function setPublicMethods($methods)
	{
		$methodsType = NAJAX_Utilities::getType($methods);

		if ($methodsType == 'string') {

			$this->publicMethods = array(NAJAX_Utilities::caseConvert($methods));

		} else if (($methodsType == 's_array') || ($methodsType == 'a_array')) {

			$this->publicMethods = array_map(array('NAJAX_Utilities', 'caseConvert'), $methods);

		} else {

			$this->publicMethods = null;
		}
	}

	/**
	 *
	 * @access	public
	 *
	 * @return	void
	 *
	 */
	function setPrivateMethods($methods)
	{
		$methodsType = NAJAX_Utilities::getType($methods);

		if ($methodsType == 'string') {

			$this->privateMethods = array(NAJAX_Utilities::caseConvert($methods));

		} else if (($methodsType == 's_array') || ($methodsType == 'a_array')) {

			$this->privateMethods = array_map(array('NAJAX_Utilities', 'caseConvert'), $methods);

		} else {

			$this->privateMethods = null;
		}
	}

	/**
	 *
	 * @access	public
	 *
	 * @return	void
	 *
	 */
	function setPublicVariables($variables)
	{
		$variablesType = NAJAX_Utilities::getType($variables);

		if ($variablesType == 'string') {

			$this->publicVariables = array(NAJAX_Utilities::caseConvert($variables));

		} else if (($variablesType == 's_array') || ($variablesType == 'a_array')) {

			$this->publicVariables = array_map(array('NAJAX_Utilities', 'caseConvert'), $variables);

		} else {

			$this->publicVariables = null;
		}
	}

	/**
	 *
	 * @access	public
	 *
	 * @return	void
	 *
	 */
	function setPrivateVariables($variables)
	{
		$variablesType = NAJAX_Utilities::getType($variables);

		if ($variablesType == 'string') {

			$this->privateVariables = array(NAJAX_Utilities::caseConvert($variables));

		} else if (($variablesType == 's_array') || ($variablesType == 'a_array')) {

			$this->privateVariables = array_map(array('NAJAX_Utilities', 'caseConvert'), $variables);

		} else {

			$this->privateVariables = null;
		}
	}

	/**
	 *
	 * @access	public
	 *
	 * @return	void
	 *
	 */
	function setMethodsMap($methodsMap)
	{
		$methodsMapType = NAJAX_Utilities::getType($methodsMap);

		if ($methodsMapType == 'string') {

			$this->methodsMap = array(NAJAX_Utilities::caseConvert($methodsMap) => $methodsMap);

		} else if (($methodsMapType == 's_array') || ($methodsMapType == 'a_array')) {

			$map = array();

			foreach ($methodsMap as $method) {

				$map[NAJAX_Utilities::caseConvert($method)] = $method;
			}

			$this->methodsMap = $map;

		} else {

			$this->methodsMap = null;
		}
	}

	/**
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function isPublicMethod($methodName)
	{
		if ( ! empty($this->privateMethods)) {

			if (in_array(NAJAX_Utilities::caseConvert($methodName), $this->privateMethods)) {

				return false;
			}
		}

		if ( ! empty($this->publicMethods)) {

			if ( ! in_array(NAJAX_Utilities::caseConvert($methodName), $this->publicMethods)) {

				return false;
			}
		}

		return true;
	}

	/**
	 *
	 * @access	public
	 *
	 * @return	bool
	 *
	 */
	function isPublicVariable($variableName)
	{
		if ( ! empty($this->privateVariables)) {

			if (in_array(NAJAX_Utilities::caseConvert($variableName), $this->privateVariables)) {

				return false;
			}
		}

		if ( ! empty($this->publicVariables)) {

			if ( ! in_array(NAJAX_Utilities::caseConvert($variableName), $this->publicVariables)) {

				return false;
			}
		}

		return true;
	}

	/**
	 *
	 * @access	public
	 *
	 * @return	string
	 *
	 */
	function findMethodName($methodName)
	{
		if ( ! empty($this->methodsMap)) {

			$name = NAJAX_Utilities::caseConvert($methodName);

			if (isset($this->methodsMap[$name])) {

				return $this->methodsMap[$name];
			}
		}

		return $methodName;
	}

	/**
	 * Adds a {@link NAJAX_Meta} events observer.
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
		return parent::addObserver($observer, 'NAJAX_Meta');
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
		return parent::notifyObservers($event, $arg, 'NAJAX_Meta');
	}
}
?>