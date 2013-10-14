<?php
/**
 * NAJAX HTML DOM Elements By Tag Name file.
 *
 * <p>This file defines the {@link NAJAX_HTML_DOM_ElementsByTagName} Class.</p>
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
 * Loads the file that defines the base class for {@link NAJAX_HTML_DOM_ElementsByTagName}.
 */
require_once(NAJAX_HTML_BASE . '/classes/DOM/BaseElement.class.php');

/**
 * NAJAX HTML DOM Elements By Tag Name Class.
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
class NAJAX_HTML_DOM_ElementsByTagName extends NAJAX_HTML_DOM_BaseElement
{
	/**
	 * Creates a new instance of the {@link NAJAX_HTML_DOM_ElementsByTagName} class.
	 *
	 * @param	string	$tagName	String that holds the tag name of the elements.
	 *
	 * @access	public
	 *
	 */
	function NAJAX_HTML_DOM_ElementsByTagName($tagName)
	{
		parent::NAJAX_HTML_DOM_BaseElement();

		$this->tagName = $tagName;

		$this->skipKeys[] = 'tagName';
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
		return '__' . ereg_replace('[^a-zA-Z0-9]', '_', $this->tagName);
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

		$returnValue = $element . 's=document.getElementsByTagName("' . $this->tagName . '");';

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