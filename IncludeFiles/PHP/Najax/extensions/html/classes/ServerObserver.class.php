<?php
/**
 * NAJAX HTML Server Observer file.
 *
 * <p>This file defines the {@link NAJAX_HTML_ServerObserver} Class.</p>
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
 * NAJAX HTML Server Observer Class.
 *
 * <p>This class is used by the {@link NAJAX_HTML} extension
 * to process server events.</p>
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
class NAJAX_HTML_ServerObserver extends NAJAX_Observer
{
	/**
	 * This method is called when {@link NAJAX_Server::notifyObservers}
	 * is called.
	 *
	 * @access	private
	 *
	 * @return	bool	Always true.
	 *
	 */
	function updateObserver($event, $arguments)
	{
		if ($event == 'initializeCallbackSuccess') {

			if (array_key_exists('source', $arguments['request'])) {

				/**
				 * Loads the file that defines the {@link NAJAX_HTML} class.
				 */
				require_once(NAJAX_HTML_BASE . '/classes/HTML.class.php');
			}
		}

		if ($event == 'dispatchLeave') {

			if (array_key_exists('returnValue', $arguments['response'])) {

				$arguments['response']['html'] = NAJAX_HTML::process();
			}
		}

		return true;
	}
}
?>