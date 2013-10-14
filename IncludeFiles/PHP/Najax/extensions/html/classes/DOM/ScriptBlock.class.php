<?php
/**
 * NAJAX HTML DOM Script Block file.
 *
 * <p>This file defines the {@link NAJAX_HTML_DOM_ScriptBlock} Class.</p>
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
 * NAJAX HTML DOM Script Block Class.
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
class NAJAX_HTML_DOM_ScriptBlock
{
	/**
	 * Holds script block source code.
	 *
	 * @access	public
	 *
	 * @var		string
	 *
	 */
	var $script;

	/**
	 * Creates a new instance of the {@link NAJAX_HTML_DOM_ScriptBlock} class.
	 *
	 * @param	string	$script	String that holds the JavaScript code.
	 *
	 * @access	public
	 *
	 */
	function NAJAX_HTML_DOM_ScriptBlock($script = null)
	{
		$this->script = $script;
	}

	/**
	 * Returns the JavaScript code that the block contains.
	 *
	 * <p>You should not call this method directly.</p>
	 *
	 * @access	public
	 *
	 * @return	string	JavaScript source code for the script block.
	 *
	 * @static
	 *
	 */
	function process()
	{
		return $this->script;
	}
}
?>