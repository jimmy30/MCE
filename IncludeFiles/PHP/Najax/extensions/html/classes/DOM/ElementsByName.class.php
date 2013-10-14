<?php
/**
 * NAJAX HTML DOM Elements By Name file.
 *
 * <p>This file defines the {@link NAJAX_HTML_DOM_ElementsByName} Class.</p>
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
 * Loads the file that defines the base class for {@link NAJAX_HTML_DOM_ElementsByName}.
 */
require_once(NAJAX_HTML_BASE . '/classes/DOM/BaseElement.class.php');

/**
 * NAJAX HTML DOM Elements By Name Class.
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
class NAJAX_HTML_DOM_ElementsByName extends NAJAX_HTML_DOM_BaseElement
{
	/**
	 * Creates a new instance of the {@link NAJAX_HTML_DOM_ElementsByName} class.
	 *
	 * @param	string	$name	String that holds the name of the elements.
	 *
	 * @access	public
	 *
	 */
	function NAJAX_HTML_DOM_ElementsByName($name)
	{
		parent::NAJAX_HTML_DOM_BaseElement();

		$this->name = $name;

		$this->skipKeys[] = 'name';
	}

	/**
	 * Returns the JavaScript name of the elements.
	 *
	 * @access	public
	 *
	 * @return	string	The JavaScript name of the elements.
	 *
	 */
	function getElement()
	{
		return '__' . ereg_replace('[^a-zA-Z0-9]', '_', $this->name);
	}

	/**
	 * Returns the JavaScript code of the DOM elements.
	 *
	 * <p>You should not call this method directly.</p>
	 *
	 * @access	public
	 *
	 * @return	string	JavaScript source code for the DOM elements.
	 *
	 * @static
	 *
	 */
	function process()
	{
		$element = $this->getElement();

		$returnValue = $element . 's=document.getElementsByName("' . $this->name . '");';

		$returnValue .= 'for(' . $element . 'sIterator=0;';
		$returnValue .= $element . 'sIterator<' . $element . 's.length;';
		$returnValue .= $element . 'sIterator++){';
		$returnValue .= $element . '=' . $element . 's[' . $element . 'sIterator];';

		$returnValue .= parent::process($element);

		$returnValue .= '}';

		return $returnValue;
	}
}
?>