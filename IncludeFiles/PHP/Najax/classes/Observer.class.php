<?php
/**
 * NAJAX Observer file.
 *
 * <p>This file defines the {@link NAJAX_Observer} Class.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 *
 * require_once('najax.php');
 *
 * class CallbackObserver extends NAJAX_Observer
 * {
 * 	function updateObserver($event, $arg)
 * 	{
 * 		print $event . ' called.';
 * 	}
 * }
 *
 * NAJAX_Server::addObserver(new CallbackObserver());
 *
 * ...
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
 * NAJAX Observer Class.
 *
 * <p>To observe NAJAX events you must define your own
 * classes that extend the {@link NAJAX_Observer} class.</p>
 * <p>See {@link NAJAX_Observer::updateObserver} for
 * more information.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 *
 * require_once('najax.php');
 *
 * class CallbackObserver extends NAJAX_Observer
 * {
 * 	function updateObserver($event, $arg)
 * 	{
 * 		print $event . ' called.';
 * 	}
 * }
 *
 * NAJAX_Server::addObserver(new CallbackObserver());
 *
 * ...
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
class NAJAX_Observer
{
	/**
	 * This method is called when {@link NAJAX_Observable::notifyObservers}
	 * is called.
	 *
	 * <p>You should override this method to accept two parameters - the
	 * event name and the event argument.</p>
	 * <p>If {@link NAJAX_Observable::notifyObservers} is called without
	 * parameters the event name is 'default'.</p>
	 * <p>You should also always return a boolean value that indicates
	 * the result of the event.</p>
	 *
	 * @access	public
	 *
	 * @return	bool	Always true.
	 *
	 */
	function updateObserver()
	{
		return true;
	}
}

?>