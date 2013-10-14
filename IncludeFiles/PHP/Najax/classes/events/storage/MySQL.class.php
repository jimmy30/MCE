<?php
/**
 * NACLES MySQL Provider file.
 *
 * <p>This file defines the {@link NAJAX_Events_Storage_MySQL} Class.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 *
 * require_once('najax.php');
 *
 * require_once(NAJAX_BASE . '/classes/events/storage/MySQL.class.php');
 *
 * $storage = new NAJAX_Events_Storage_MySQL('server=?;user=?;password=?;database=?;[port=?]');
 *
 * $storage->postEvent('event', 'class');
 *
 * ?>
 * </code>
 *
 * @author	Stanimir Angeloff
 *
 * @package	NAJAX
 *
 * @subpackage	NACLES
 *
 * @version	0.4.0.0
 *
 */

/**
 * Defines the table name in the MySQL database that is used to save the
 * events information (default value: najax_events).
 *
 * @ignore
 *
 */
define('NAJAX_EVENTS_TABLE_NAME', 'najax_events');

/**
 * NAJAX Events Storage MySQL Class.
 *
 * <p>This class is a {@link NAJAX_Events_Storage} successor.</p>
 * <p>The class allows you to save events information in
 * MySQL database.</p>
 * <p>Example:</p>
 * <code>
 * <?php
 *
 * require_once('najax.php');
 *
 * require_once(NAJAX_BASE . '/classes/events/storage/MySQL.class.php');
 *
 * $storage = new NAJAX_Events_Storage_MySQL('server=?;user=?;password=?;database=?;[port=?]');
 *
 * $storage->postEvent('event', 'class');
 *
 * ?>
 * </code>
 *
 * @author		Stanimir Angeloff
 *
 * @package		NAJAX
 *
 * @subpackage	NACLES
 *
 * @version		0.4.0.0
 *
 */
class NAJAX_Events_Storage_MySQL extends NAJAX_Events_Storage
{
	/**
	 * Holds the MySQL server used in the connection string.
	 *
	 * @access	private
	 *
	 * @var		string
	 *
	 */
	var $sqlServer;

	/**
	 * Holds the MySQL user used in the connection string.
	 *
	 * @access	private
	 *
	 * @var		string
	 *
	 */
	var $sqlUser;

	/**
	 * Holds the MySQL password used in the connection string.
	 *
	 * @access	private
	 *
	 * @var		string
	 *
	 */
	var $sqlPassword;

	/**
	 * Holds the MySQL database used in the connection string.
	 *
	 * @access	private
	 *
	 * @var		string
	 *
	 */
	var $sqlDatabase;

	/**
	 * Holds the MySQL port used in the connection string.
	 *
	 * @access	private
	 *
	 * @var		string
	 *
	 */
	var $sqlPort = 3306;

	/**
	 * Indicates whether to open a new connection to the MySQL server
	 * if an old one already exists.
	 *
	 * @access	private
	 *
	 * @var		bool
	 *
	 */
	var $sqlOpenNew;

	/**
	 * Creates a new instance of the {@link NAJAX_Events_Storage_MySQL} class.
	 *
	 * @access	public
	 *
	 * @param	string	$dsn	The data source name and parameters to use
	 *							when connecting to MySQL.
	 *
 	 */
	function NAJAX_Events_Storage_MySQL($dsn)
	{
		$pairs = explode(';', $dsn);

		foreach ($pairs as $pair) {

			list($key, $value) = explode('=', $pair, 2);

			switch (strtolower($key)) {

				case 'server': {

					$this->sqlServer = $value;

					break;
				}

				case 'user': {

					$this->sqlUser = $value;

					break;
				}

				case 'password': {

					$this->sqlPassword = $value;

					break;
				}

				case 'database': {

					$this->sqlDatabase = $value;

					break;
				}

				case 'opennew': {

					$this->sqlOpenNew = $value;

					break;
				}

				case 'port': {

					$this->sqlPort = $value;

					break;
				}
			}
		}
	}

	/**
	 * Retrieves a new instance of the {@link NAJAX_Events_Storage_MySQL} class.
	 *
	 * <p>This method overrides {@link NAJAX_Events_Storage::getStorage}.</p>
	 *
	 * @access	public
	 *
	 * @param	string	$dsn	The data source name and parameters to use
	 *							when connecting to MySQL.
	 *
	 * @return	object	A singleton instance to the
	 *					{@link NAJAX_Events_Storage_MySQL} class.
	 *
	 * @static
	 *
 	 */
	function getStorage($dsn)
	{
		static $instance;

		if ( ! isset($instance)) {

			$instance = new NAJAX_Events_Storage_MySQL($dsn);
		}

		return $instance;
	}

	/**
	 * Creates a MySQL connection link.
	 *
	 * @access	private
	 *
	 * @return	resource
	 *
	 */
	function getConnection()
	{
		if ($this->sqlPort != 3306) {

			$server = "{$this->sqlServer}:{$this->sqlPort}";

		} else {

			$server = $this->sqlServer;
		}

		$connection = mysql_connect($server, $this->sqlUser, $this->sqlPassword, $this->sqlOpenNew);

		mysql_select_db($this->sqlDatabase, $connection);

		return $connection;
	}

	/**
	 * Closes a MySQL connection link.
	 *
	 * @access	private
	 *
	 * @return	void
	 *
	 */
	function closeConnection($connection)
	{
		mysql_close($connection);
	}

	/**
	 * Escapes special characters in the {@link $unescapedString},
	 * taking into account the current charset of the connection.
	 *
	 * @access	private
	 *
	 * @return	string
	 *
	 */
	function escapeString($unescapedString, $connection)
	{
		if (function_exists('mysql_real_escape_string')) {

			return mysql_real_escape_string($unescapedString, $connection);
		}

		return mysql_escape_string($unescapedString);
	}

	/**
 	 * Posts a single event to the database.
	 *
	 * <p>The {@link $event} and {@link $class} arguments are required
	 * for each event. The {@link $sender}, {@link $data}, {@link $filter},
	 * {@link $time} and {@link $lifetime} arguments are optional.</p>
	 * <p>In case you have supplied both {@link $class} and {@link $sender},
	 * then the {@link $sender}'s class must match the one you've supplied.</p>
	 * <p>This method calls {@link postMultipleEvents} with the appropriate
	 * arguments.</p>
	 *
	 * @access	public
	 *
	 * @param	string	$event		The event name (case-sensitive).
	 *
	 * @param	string	$class		The class that is the source of the event.
	 *
	 * @param	object	$sender		The sender object of the event.
	 *
	 * @param	mixed	$data		The data associated with the event.
	 *
	 * @param	string	$filter		The event filter data (case-insensitive).
	 *								Using this argument you can post events with
	 *								the same name but with different filter data.
	 *								The client will respond to them individually.
	 *
	 * @param	int		$time		The event start time (seconds since the Unix
	 *								Epoch (January 1 1970 00:00:00 GMT).
	 *
	 * @param	int		$lifetime	The event lifetime (in seconds).
	 *
	 * @return	bool	true on success, false otherwise.
	 *
	 */
	function postEvent($event, $class, $sender = null, $data = null, $filter = null, $time = null, $lifetime = null)
	{
		return $this->postMultipleEvents(array(array(
		'event'		=>	$event,
		'className'	=>	$class,
		'sender'	=>	$sender,
		'data'		=>	$data,
		'filter'	=>	$filter,
		'time'		=>	$time,
		'lifetime'	=>	$lifetime
		)));
	}

	/**
 	 * Posts multiple events to the database.
	 *
	 * <p>Valid keys for each event are:</p>
	 * - event		- the event name (case-sensitive);
	 * - className	- the class that is the source of the event;
	 * - sender		- the sender object of the event;
	 * - data		- the data associated with the event;
	 * - filter		- the event filter data (case-insensitive);
	 *				  using this key you can post events with
	 *				  the same name but with different filter data;
	 *				  the client will respond to them individually;
	 * - time		- the event start time (seconds since the Unix
	 *				  Epoch (January 1 1970 00:00:00 GMT);
	 * - lifetime	- the event lifetime (in seconds);
	 *
	 * @access	public
	 *
	 * @param	array	$eventsData		Array containing associative arrays
	 *									with information for each event.
	 *
	 * @return	bool	true on success, false otherwise.
	 *
	 */
	function postMultipleEvents($eventsData)
	{
		$connection = $this->getConnection();

		foreach ($eventsData as $event) {

			if (( ! isset($event['time'])) || ($event['time'] === null)) {

				$event['time'] = NAJAX_Utilities::getMicroTime();
			}

			if (( ! isset($event['lifetime'])) || ($event['lifetime'] === null)) {

				$event['lifetime'] = NAJAX_EVENTS_LIFETIME;
			}

			if ((isset($event['sender'])) && ($event['sender'] !== null)) {

				if (NAJAX_Utilities::getType($event['sender']) != 'object') {

					continue;
				}

				if (strcasecmp($event['className'], get_class($event['sender'])) != 0) {

					continue;
				}
			}

			$sqlQuery = '
				INSERT INTO
					`' . NAJAX_EVENTS_TABLE_NAME . '`
				(
					`event`,
					`className`,
					`filter`,
					`sender`,
					`data`,
					`time`,
					`endTime`
				)
				VALUES
				(
					\'' . $this->escapeString($event['event'], $connection) . '\',
					\'' . $this->escapeString($event['className'], $connection) . '\',
			';

			if (isset($event['filter'])) {

				$sqlQuery .= '\'' . $this->escapeString($event['filter'], $connection) . '\',';

			} else {

				$sqlQuery .= 'NULL,';
			}

			if (isset($event['sender'])) {

				$sqlQuery .= '\'' . $this->escapeString(serialize($event['sender']), $connection) . '\',';

			} else {

				$sqlQuery .= 'NULL,';
			}

			if (isset($event['data'])) {

				$sqlQuery .= '\'' . $this->escapeString(serialize($event['data']), $connection) . '\',';

			} else {

				$sqlQuery .= 'NULL,';
			}

			$sqlQuery .= '
					' . $this->escapeString($event['time'], $connection) . ',
					' . $this->escapeString($event['time'] + $event['lifetime'], $connection) . '
				)';

			mysql_query($sqlQuery, $connection);
		}

		$this->closeConnection($connection);

		return true;
	}

	/**
 	 * Deletes old events from the database.
	 *
	 * <p>This method is called before calling {@link filterEvents}
	 * or {@link filterMultipleEvents} to delete all expired events
	 * from the database.</p>
	 *
	 * @access	public
	 *
	 * @return	bool	true on success, false otherwise.
	 *
	 */
	function cleanEvents()
	{
		$connection = $this->getConnection();

		$time = NAJAX_Utilities::getMicroTime() - NAJAX_EVENTS_LIFETIME;

		$sqlQuery = '
			DELETE FROM
				`' . NAJAX_EVENTS_TABLE_NAME . '`
			WHERE
				`endTime` < ' . $this->escapeString($time, $connection) . '
		';

		mysql_query($sqlQuery, $connection);

		$this->closeConnection($connection);

		return true;
	}

	/**
 	 * Filters the events in the database using a single criteria.
	 *
	 * <p>The {@link $event} and {@link $class} arguments are required
	 * for each event. The {@link $filter} and {@link $time} arguments
	 * are optional.</p>
	 * <p>This method calls {@link filterMultipleEvents} with the appropriate
	 * arguments.</p>
	 *
	 * @access	public
	 *
	 * @param	string	$event		The event name (case-sensitive).
	 *
	 * @param	string	$class		The class that is the source of the event.
	 *
	 * @param	string	$filter		The event filter data (case-insensitive).
	 *								Using this argument you can filter events with
	 *								the same name but with different filter data.
	 *
	 * @param	int		$time		The event start time (seconds since the Unix
	 *								Epoch (January 1 1970 00:00:00 GMT).
	 *
	 * @return	array	Sequental array that contains all events that match the
	 *					supplied criterias, ordered by time (ascending).
	 *
	 */
	function filterEvents($event, $class, $filter = null, $time = null)
	{
		return $this->filterMultipleEvents(array(array(
		'event'		=>	$event,
		'className'	=>	$class,
		'filter'	=>	$filter,
		'time'		=>	$time
		)));
	}

	/**
 	 * Filters the events in the database using multiple criterias.
	 *
	 * <p>Valid keys for each event are:</p>
	 * - event		- the event name (case-sensitive);
	 * - className	- the class that is the source of the event;
	 * - filter		- the event filter data (case-insensitive);
	 * 				  using this argument you can filter events with
	 *				  the same name but with different filter data;
	 * - time		- the event start time (seconds since the Unix
	 *				  Epoch (January 1 1970 00:00:00 GMT).
	 *
	 * @access	public
	 *
	 * @param	array	$eventsData		Array containing associative arrays
	 *									with information for each event.
	 *
	 * @return	array	Sequental array that contains all events that match the
	 *					supplied criterias, ordered by time (ascending).
	 *
	 */
	function filterMultipleEvents($eventsData)
	{
		$connection = $this->getConnection();

		$sqlQuery = '
			SELECT
				`event`,
				`className`,
				`filter`,
				`sender`,
				`data`,
				`time`,
				`endTime`
			FROM
				`' . NAJAX_EVENTS_TABLE_NAME . '`
			WHERE
		';

		$index = 0;

		$length = sizeof($eventsData);

		foreach ($eventsData as $event) {

			if (( ! isset($event['time'])) || ($event['time'] === null)) {

				$event['time'] = NAJAX_Utilities::getMicroTime();
			}

			$sqlQuery .= '(
				`time` > ' . $this->escapeString($event['time'], $connection) . '
				AND
				`event` = \'' . $this->escapeString($event['event'], $connection) . '\'
				AND
				`className` = \'' . $this->escapeString($event['className'], $connection) . '\'
			';

			if (isset($event['filter'])) {

				$sqlQuery .= 'AND `filter` = \'' . $this->escapeString($event['filter'], $connection) . '\'';
			}

			if ($index < $length - 1) {

				$sqlQuery .= ') OR ';

			} else {

				$sqlQuery .= ')';
			}

			$index ++;
		}

		$sqlQuery .= '
			ORDER BY
				`time` ASC
		';

		$events = array();

		$sqlResult = mysql_query($sqlQuery, $connection);

		while (($row = mysql_fetch_assoc($sqlResult)) !== false) {

			$events[] = array(
			'event'		=>	$row['event'],
			'className'	=>	$row['className'],
			'filter'	=>	$row['filter'],
			'time'		=>	(float) $row['time'],
			'endTime'	=>	(float) $row['endTime'],
			'eventData'	=>	array(
			'sender'	=>	($row['sender'] === null ? null : unserialize($row['sender'])),
			'data'		=>	($row['data'] === null ? null : unserialize($row['data']))
			));
		}

		mysql_free_result($sqlResult);

		$this->closeConnection($connection);

		return $events;
	}
}
?>