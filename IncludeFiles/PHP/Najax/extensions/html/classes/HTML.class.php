<?php
/**
 * NAJAX HTML Class file.
 *
 * <p>This file defines the {@link NAJAX_HTML} Class.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 * 
 * class Update
 * {
 * 	function ui()
 * 	{
 * 		sleep(1);
 * 
 * 		$content =& NAJAX_HTML::getElementById('content');
 * 
 * 		$content->innerHTML = 'Hello World! How are you?';
 * 	}
 * }
 * 
 * define('NAJAX_AUTOHANDLE', true);
 * 
 * require_once('najax.php');
 * 
 * ?>
 * <?= NAJAX_Utilities::header('.') ?>
 * 
 * <div id="content">Hello!</div>
 * 
 * <script type="text/javascript">
 * 
 * var obj = <?= NAJAX_Client::register(new Update()) ?>;
 * 
 * obj.ui(najax.asyncCall);
 * 
 * </script>
 * </code>
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
 * Defines the string that is replaced with the current value
 * of the field.
 *
 * <p>Example:</p>
 * <code>
 * <?php
 * 
 * class Update
 * {
 * 	function ui()
 * 	{
 * 		sleep(1);
 * 
 * 		$content =& NAJAX_HTML::getElementById('content');
 * 
 * 		$content->innerHTML = NAJAX_HTML_CURRENT_VALUE . ' How are you?';
 * 	}
 * }
 * 
 * define('NAJAX_AUTOHANDLE', true);
 * 
 * require_once('najax.php');
 * 
 * ?>
 * <?= NAJAX_Utilities::header('.') ?>
 * <div id="content">Hello!</div>
 * <script type="text/javascript">
 * 
 * var obj = <?= NAJAX_Client::register(new Update()) ?>;
 * 
 * obj.ui(najax.asyncCall);
 * 
 * </script>
 * </code>
 */
define('NAJAX_HTML_CURRENT_VALUE', '<![najaxHtml:currentValue[');

/**
 * @global	Contains all NAJAX_HTML DOM objects.
 */
$GLOBALS['_NAJAX_HTML_DATA'] = array();

/**
 * NAJAX HTML Class.
 *
 * <p>This class is used to update the content and the
 * style of a page.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 * 
 * class Update
 * {
 * 	function ui()
 * 	{
 * 		sleep(1);
 * 
 * 		$content =& NAJAX_HTML::getElementById('content');
 * 
 * 		$content->innerHTML = 'Hello World! How are you?';
 * 	}
 * }
 * 
 * define('NAJAX_AUTOHANDLE', true);
 * 
 * require_once('najax.php');
 * 
 * ?>
 * <?= NAJAX_Utilities::header('.') ?>
 * 
 * <div id="content">Hello!</div>
 * 
 * <script type="text/javascript">
 * 
 * var obj = <?= NAJAX_Client::register(new Update()) ?>;
 * 
 * obj.ui(najax.asyncCall);
 * 
 * </script>
 * </code>
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
class NAJAX_HTML
{
	/**
	 * Returns the element whose ID is specified.
	 *
	 * <p>Note that you must use the '&' operator in order
	 * to get a reference to the element.</p>
	 * <p>Example:</p>
	 * <code>
	 * $content =& NAJAX_HTML::getElementById('content');
	 * </code>
	 *
	 * @access	public
	 *
	 * @param	string	$id	String representing the unique id of
	 *						the element being sought.
	 *
	 * @return	object	The DOM element with the specified ID.
	 *					Note that the server has no idea whether
	 *					the element exists on the client or not.
	 *
	 * @static
	 *
	 */
	function &getElementById($id)
	{
		/**
		 * Loads the class that defines the DOM element by ID class.
 		 */
		require_once(NAJAX_HTML_BASE . '/classes/DOM/ElementById.class.php');

		$element = new NAJAX_HTML_DOM_ElementById($id);

		$GLOBALS['_NAJAX_HTML_DATA'][] =& $element;

		return $element;
	}

	/**
	 * Returns an object representing a list of elements
	 * of a given name in the document.
	 *
	 * <p>Note that you must use the '&' operator in order
	 * to get a reference to the list.</p>
	 * <p>Example:</p>
	 * <code>
	 * $messages =& NAJAX_HTML::getElementsByName('message');
	 * </code>
	 *
	 * @access	public
	 *
	 * @param	string	$name	String representing the value of
	 *							the name attribute on the element.
	 *
	 * @return	object	The DOM elements list with the specified name.
	 *					Note that the server has no idea whether
	 *					any elements exists on the client or not.
	 *
	 * @static
	 *
	 */
	function &getElementsByName($name)
	{
		/**
		 * Loads the class that defines the DOM elements by name class.
 		 */
		require_once(NAJAX_HTML_BASE . '/classes/DOM/ElementsByName.class.php');

		$elements = new NAJAX_HTML_DOM_ElementsByName($name);

		$GLOBALS['_NAJAX_HTML_DATA'][] =& $elements;

		return $elements;
	}

	/**
	 * Returns an object representing a list of elements
	 * of a given tag name in the document.
	 *
	 * <p>Note that you must use the '&' operator in order
	 * to get a reference to the list.</p>
	 * <p>Example:</p>
	 * <code>
	 * $inputs =& NAJAX_HTML::getElementsByTagName('input');
	 * </code>
	 *
	 * @access	public
	 *
	 * @param	string	$tagName	String representing the name of
	 *								the tag on the element.
	 *
	 * @return	object	The DOM elements list with the specified tag name.
	 *					Note that the server has no idea whether
	 *					any elements exists on the client or not.
	 *
	 * @static
	 *
	 */
	function &getElementsByTagName($tagName)
	{
		/**
		 * Loads the class that defines the DOM elements by tag name class.
 		 */
		require_once(NAJAX_HTML_BASE . '/classes/DOM/ElementsByTagName.class.php');

		$elements = new NAJAX_HTML_DOM_ElementsByTagName($tagName);

		$GLOBALS['_NAJAX_HTML_DATA'][] =& $elements;

		return $elements;
	}

	/**
	 * Adds a given JavaScript code to the output.
	 *
	 * <p>Note that you must use the '&' operator in order
	 * to get a reference to the script block.</p>
	 * <p>You should add ';' at the end of the script.</p>
	 * <p>Example:</p>
	 * <code>
	 * NAJAX_HTML::addScriptBlock('alert("Hello World!");');
	 * </code>
	 *
	 * @access	public
	 *
	 * @param	string	$script	JavaScript source code.
	 *
	 * @return	object	The DOM element that represents the script block.
	 *
	 * @static
	 *
	 */
	function &addScriptBlock($script)
	{
		/**
		 * Loads the class that defines the DOM script block class.
 		 */
		require_once(NAJAX_HTML_BASE . '/classes/DOM/ScriptBlock.class.php');

		$scriptBlock = new NAJAX_HTML_DOM_ScriptBlock($script);

		$GLOBALS['_NAJAX_HTML_DATA'][] =& $scriptBlock;

		return $scriptBlock;
	}

	/**
	 * Returns the JavaScript code of all DOM elements.
	 *
	 * <p>You should not call this method directly.</p>
	 *
	 * @access	public
	 *
	 * @return	string	JavaScript source code for each DOM element
	 *					or null if no DOM elements were created.
	 *
	 * @static
	 *
	 */
	function process()
	{
		if ( ! empty($GLOBALS['_NAJAX_HTML_DATA'])) {

			$returnValue = '';

			foreach ($GLOBALS['_NAJAX_HTML_DATA'] as $domObject) {

				$returnValue .= $domObject->process();
			}

			return $returnValue;
		}

		return null;
	}
}
?>