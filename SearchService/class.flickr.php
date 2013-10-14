<?php

// A Curl Class for making requests written by Dick Munroe
require_once 'class.curl.php';
// A MySQL access class that I addapted from the PHP Anthology's version
//require_once 'class.mysql.php';
// A PHP MySQL Table Wrapper that I wrote and love (http://addictedtonew.com/archives/82/php-and-mysql-table-wrapper/)
//require_once 'class.table.php';

/**
* Flickr API Class:
* Gives you easy access your photos stored on flickr.
* 
* @author John Nunemaker <nunemaker@gmail.com>
* @link http://addictedtonew.com/examples/flickr/
* @access public
* @version 1.1
*/
class flickr {
	/**
    * Flickr API Key
    * @var string
	* @access private 
    */
	var $api_key = '';
	
	/**
    * Flickr Web Services Url
    * @var string
	* @access private 
    */
	var $_flickr_url = 'http://www.flickr.com';
	
	/**
    * Flickr Web Services Url
    * @var string
	* @access private 
    */
	var $_flickr_api_url = 'http://www.flickr.com/services/rest/';
	
	/**
	* Flickr photo url
	* @var string
	* @access private
	*/
	var $_flickr_photo_url = 'http://static.flickr.com/{server_id}/{photo_id}_{secret}_{size}.jpg';
	
	/**
    * Gets set if there is an error; stores the code
    * @var string
	* @access private 
    */
	var $_error_code = '';
	
	/**
    * Gets set if there is an error; stores the message
    * @var string
	* @access private 
    */
	var $_error_msg = '';
	
	/**
	* Turns debugging on or off
	* @var bool
	* @access private
	*/
	var $_debug = false;
	
	/**
	* Turns request/response caching on or off
	* @var bool
	* @access private
	*/
	var $_cache_enabled = false;
	
	/**
	* Sets which type of caching is being used
	* @var string
	* @access private
	*/
	var $_cache_type = 'db';
	
	/**
	* The name of the cache table
	* @var string
	* @access private
	*/
	var $_cache_table = 'addicted_flickr_cache';
	
	/*
	* Object wrapper for cache table
	* @var object
	* @access private
	*/
	var $_cache = NULL;
	
	/*
	* Number of seconds to cache the Flickr request
	* @var int
	* @access private
	*/
	var $_cache_expire = 600;
	
	/*
	* Directory to store cached requests in if using fs cache_type
	* @var string
	* @access private
	*/
	var $_cache_dir = '_flickr_cache/';
	
	/**
	* This stores the MySQL object which is used to cache requests
	* @var MySQL Object
	* @access private
	*/
	var $_db = NULL;
	
	/**
	* flick constructor
	*
	* @param string $api_key An API Key is required to make flickr requests
	*
	* @return void
	* @access public
	*/
	var $strXmlString;
	var $strQuery;
	var $intReturnResult;
	function flickr($api_key) {
		$this->_api_key = $api_key;
	}
	
	/**
	* internal function that I use to make all the requests to flickr
	*
	* @param string $method The Flickr Method that is being requested
	* @param array $params An array of the various required and optional fields needed to make the mthod request
	*
	* @return array The xml turned into an array
	* @access public
	*/
	function makeRequest($method, $params) {
		$this->_clearErrors();
		
		$useCURL 			= in_array('curl', get_loaded_extensions());
		$params['method'] 	= $method;
		$params['api_key'] 	= $this->_api_key;
		
		$args = array();
		foreach($params as $k => $v){
			array_push($args, urlencode($k).'='.urlencode($v));
		}
		
		$query_str 		= implode('&', $args);
		$request 		= $this->_flickr_api_url . '?' . $query_str; // full url to request
		$hit_flickr 	= true; // whether or not to make a request to flickr
		$request_hash 	= md5($request);
		
		if ($this->_cache_enabled) {
			if ($this->_cache_type == 'db') {
				$now = time();
				$rows = $this->_cache->findMany("WHERE request = '" . $request_hash . "' AND date_expire > $now");
				
				// if any rows found, then use cached response
				if (count($rows) > 0) {
					$xml = $rows[0]->response;
					$hit_flickr = ($xml == '') ? true : false;
				}
			} else {
				$now = time();
				$file = $this->_cache_dir . md5($request) . '.cache';
				if (file_exists($file)) {
					$xml = file_get_contents($file);
					$hit_flickr = ($xml == '') ? true : false;
				}
			}
		}
		
		// only hit flickr if cached request not found above
		if ($hit_flickr) {
			// whether or not to use curl for request
			if ($useCURL) {
				$c = &new curl($request);
				$c->setopt(CURLOPT_FOLLOWLOCATION, true);
				$xml = $c->exec();
				$error = $c->hasError();
				if ($error) {
					$this->_error_msg = $error;
					return false;
				}
				$c->close();
			} else {
				// curl not available so use fsockopen
				$url_parsed = parse_url($request);
				$host 		= $url_parsed["host"];
				$port 		= ($url_parsed['port'] == 0) ? 80 : $url_parsed['port'];
				$path 		= $url_parsed["path"] . (($url_parsed['query'] != '') ? $path .= "?{$url_parsed[query]}" : '');
				$headers	= "GET $path HTTP/1.0\r\n";
				$headers	.= "Host: $host\r\n\r\n";
				$fp 		= fsockopen($host, $port, $errno, $errstr, 30);
				if (!$fp) {
					$this->_error_msg 	= $errstr;
					$this->_error_code 	= $errno;
					return false;
				} else {
					fwrite($fp, $headers);
					while (!feof($fp)) {
						$xml .= fgets($fp, 1024);
					}
					fclose($fp);
					
					/* 	
						this seems stupid, but it removes the 
						headers from the response; if you know 
						a better way let me know
					*/
					$xml_start = strpos($xml, '<?xml');
					$xml = substr($xml, $xml_start, strlen($xml));
				}
			}
			
			if ($this->_cache_enabled) {
				// store the cached request
				if ($this->_cache_type == 'db') {
					$this->_cache->request = $request_hash;
					$this->_cache->response = $xml;
					$this->_cache->date_expire = strtotime("+ $this->_cache_expire seconds", time());
					$this->_cache->save();
				} else {
					$file = $this->_cache_dir . $request_hash . '.cache';
					$fp = fopen($file, "w");
					$result = fwrite($fp, $xml);
					fclose($fp);
				}
			}
		}
				
		if ($this->_debug) {
			echo '<h2>XML Response</h2>';
			echo '<pre class="xml">';
			echo htmlspecialchars($xml);
			echo '</pre>';
		}
		
		$xml_parser = xml_parser_create();
		xml_parse_into_struct($xml_parser, $xml, $data);
		xml_parser_free($xml_parser);
		
		return $data;
	}
	
	/***************************************************************************************************************
											******* GROUP FUNCTIONS ********
	****************************************************************************************************************/
	
	/**
	* Gets the information for a group
	*
	* @param string $group_id The id of the group who's info you want to retreive
	*
	* @return array $ret_array Array full of users information
	* @access private
	*/
	function getGroupInfo($group_id) {
		$ret_array = array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.groups.getInfo', array('group_id'=>$group_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// build return array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'NAME':
					$ret_array['name'] = $a['value'];
					break;
				case 'DESCRIPTION':
					$ret_array['description'] = $a['value'];
					break;
				case 'MEMBERS':
					$ret_array['members'] = $a['value'];
					break;
				case 'ONLINE':
					$ret_array['online'] = $a['value'];
					break;
				case 'PRIVACY':
					$ret_array['privacy'] = $a['value'];
					break;
				case 'CHATID':
					$ret_array['chatid'] = $a['value'];
					break;
				case 'CHATCOUNT':
					$ret_array['chatcount'] = $a['value'];
					break;
			}
		}
		$ret_array['group_url'] = "{$this->_flickr_url}/groups/{$group_id}/";
		$ret_array['pool_url'] 	= "{$this->_flickr_url}/groups/{$group_id}/pool/";
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Returns the photos for a particular group. Returns 25 per page default.
	*
	* @param string $group_id The id of the group whose photos you want to retrieve
	* @param integer $page (Optional: The page number of results to return. Defaults to 1.)
	* @param integer $per_page (Optional: The default amount of photos returned per page. Defaults to 10.)
	* @param string $tags (Optional: A tag to filter the pool with. At the moment only one tag at a time is supported.)
	* @param string $extras (Optional: Extra information to grab for each pic. Defaults to everything.)
	*
	* @return array $photos The array of arrays storing all the photos and their information for the current page
	* @access public
	*/
	function getGroupPhotos($group_id, $page=1, $per_page=10, $tags='', $extras='license, date_upload, date_taken, owner_name, icon_server') {
		$ret_array 	= array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.groups.pools.getPhotos', 
									array(	'group_id'	=> $group_id, 
											'tags'		=> $tags,
											'extras' 	=> $extras,
											'per_page' 	=> $per_page,
											'page' 		=> $page											
										)
								);
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// loop through the response xml array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'PHOTOS':
					if ($a['type'] != 'cdata') {
						if (is_array($a['attributes'])) {
							$page 					= $a['attributes']['PAGE'];
							$pages 					= $a['attributes']['PAGES'];
							$ret_array['page'] 		= $page;
							$ret_array['prev_page'] = ($page > 1) ? $page - 1 : NULL;
							$ret_array['next_page'] = ($page < $pages) ? $page + 1 : NULL;
							$ret_array['pages'] 	= $pages;
							$ret_array['total'] 	= $a['attributes']['TOTAL'];
						}
					}
					break;
				case 'PHOTO':
					if (is_array($a['attributes']) && count($a['attributes']) > 0) {
						foreach ($a['attributes'] as $key => $val) {
							if ($key == 'DATETAKEN') {
								$val = strtotime($val);
							}
							$ret_array['photos'][$a['attributes']['ID']][strtolower($key)] = $val;
						}
						$server 	= $a['attributes']['SERVER'];
						$photo_id 	= $a['attributes']['ID'];
						$secret 	= $a['attributes']['SECRET'];
						
						$ret_array['photos'][$a['attributes']['ID']]['url'] = $this->_replaceURL($server, $photo_id, $secret);
						$ret_array['photos'][$a['attributes']['ID']]['s_url'] = $this->_replaceURL($server, $photo_id, $secret, 's');
						$ret_array['photos'][$a['attributes']['ID']]['t_url'] = $this->_replaceURL($server, $photo_id, $secret, 't');
						$ret_array['photos'][$a['attributes']['ID']]['m_url'] = $this->_replaceURL($server, $photo_id, $secret, 'm');
						$ret_array['photos'][$a['attributes']['ID']]['b_url'] = $this->_replaceURL($server, $photo_id, $secret, 'b');
						$ret_array['photos'][$a['attributes']['ID']]['o_url'] = $this->_replaceURL($server, $photo_id, $secret, 'o');
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/***************************************************************************************************************
											******* USER FUNCTIONS ********
	****************************************************************************************************************/
	
	/**
	* Gets the information about a person
	*
	* @param string $user_id The id of the user who's info you want to retreive
	*
	* @return array $ret_array Array full of user's information
	* @access private
	*/
	function getUserInfo($user_id) {
		$ret_array = array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.people.getInfo', array('user_id'=>$user_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// build return array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'PERSON':
					if (is_array($a['attributes'])) {
						$ret_array['id'] 			= $a['attributes']['ID'];
						$ret_array['nsid'] 			= $a['attributes']['NSID'];
						$ret_array['isadmin'] 		= $a['attributes']['ISADMIN'];
						$ret_array['ispro'] 		= $a['attributes']['ISPRO'];
						$ret_array['iconserver'] 	= $a['attributes']['ICONSERVER'];
					}
					break;
				case 'USERNAME':
					$ret_array['username'] = $a['value'];
					break;
				case 'REALNAME':
					$ret_array['realname'] = $a['value'];
					break;
				case 'MBOX_SHA1SUM':
					$ret_array['mbox_sha1sum'] = $a['value'];
					break;
				case 'LOCATION':
					$ret_array['location'] = $a['value'];
					break;
				case 'FIRSTDATETAKEN':
					$ret_array['firstdatetaken'] = strtotime($a['value']);
					break;
				case 'FIRSTDATE':
					$ret_array['firstdate'] = $a['value'];
					break;
				case 'COUNT':
					$ret_array['count'] = $a['value'];
					break;
			}
		}
		$ret_array['profile_url'] = "{$this->_flickr_url}/people/{$user_id}/";
		$ret_array['photos_url'] = "{$this->_flickr_url}/photos/{$user_id}/";
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Gets the users public groups
	*
	* @param string $user_id The user id of whose public groups you would like to retrive
	*
	* @return $ret_array The array of groups
	* @access public
	*/
	function getUsersPublicGroups($user_id) {
		$ret_array = array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.people.getPublicGroups', array('user_id'=>$user_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'GROUP':
					if (is_array($a['attributes'])) {
						$group_id 								= $a['attributes']['NSID'];
						$ret_array[$group_id]['nsid'] 			= $a['attributes']['NSID'];
						$ret_array[$group_id]['name'] 			= $a['attributes']['NAME'];
						$ret_array[$group_id]['admin'] 			= $a['attributes']['ADMIN'];
						$ret_array[$group_id]['eighteenplus'] 	= $a['attributes']['EIGHTEENPLUS'];
					}
					break;
			}
		}
		if ($this->_debug) {
			echo "<h2>Function Return</h2>";
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Returns the photos for a particular user. Returns 25 per page default.
	*
	* @param string $user_id The id of the user whose photos you want to retrieve
	* @param integer $page (Optional: The page number of results to return. Defaults to 1.)
	* @param integer $per_page (Optional: The default amount of photos returned per page. Defaults to 10.)
	* @param string $extras (Optional: Extra information to grab for each pic. Defaults to everything.)
	*
	* @return array $photos The array of arrays storing all the photos and their information for the current page
	* @access public
	*/
	function getUsersPublicPhotos($user_id, $page=1, $per_page=10, $extras='license, date_upload, date_taken, owner_name, icon_server') {
		$ret_array 	= array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.people.getPublicPhotos', 
									array(	'user_id'	=> $user_id, 
											'extras' 	=> $extras,
											'per_page' 	=> $per_page,
											'page' 		=> $page											
										)
								);
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// loop through the response xml array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'PHOTOS':
					if ($a['type'] != 'cdata') {
						if (is_array($a['attributes'])) {
							$page 					= $a['attributes']['PAGE'];
							$pages 					= $a['attributes']['PAGES'];
							$ret_array['page'] 		= $page;
							$ret_array['prev_page'] = ($page > 1) ? $page - 1 : NULL;
							$ret_array['next_page'] = ($page < $pages) ? $page + 1 : NULL;
							$ret_array['pages'] 	= $pages;
							$ret_array['total'] 	= $a['attributes']['TOTAL'];
						}
					}
					break;
				case 'PHOTO':
					if (is_array($a['attributes']) && count($a['attributes']) > 0) {
						foreach ($a['attributes'] as $key => $val) {
							if ($key == 'DATETAKEN') {
								$val = strtotime($val);
							}
							$ret_array['photos'][$a['attributes']['ID']][strtolower($key)] = $val;
						}
						$server 	= $a['attributes']['SERVER'];
						$photo_id 	= $a['attributes']['ID'];
						$secret 	= $a['attributes']['SECRET'];
						
						$ret_array['photos'][$a['attributes']['ID']]['url'] = $this->_replaceURL($server, $photo_id, $secret);
						$ret_array['photos'][$a['attributes']['ID']]['s_url'] = $this->_replaceURL($server, $photo_id, $secret, 's');
						$ret_array['photos'][$a['attributes']['ID']]['t_url'] = $this->_replaceURL($server, $photo_id, $secret, 't');
						$ret_array['photos'][$a['attributes']['ID']]['m_url'] = $this->_replaceURL($server, $photo_id, $secret, 'm');
						$ret_array['photos'][$a['attributes']['ID']]['b_url'] = $this->_replaceURL($server, $photo_id, $secret, 'b');
						$ret_array['photos'][$a['attributes']['ID']]['o_url'] = $this->_replaceURL($server, $photo_id, $secret, 'o');
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Gets a list of photosets for a user
	*
	* @param string $user_id The id of the user whose photosets you want to list
	*
	* @return array $ret_array Array full of users photosets
	* @access private
	*/
	function getUsersPhotosets($user_id) {
		$set_count = 1;
		$ret_array = array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.photosets.getList', array('user_id'=>$user_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// build return array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'PHOTOSET':
					if (is_array($a['attributes'])) {
						$ret_array[$set_count]['id'] 			= $a['attributes']['ID'];
						$ret_array[$set_count]['primary'] 		= $a['attributes']['PRIMARY'];
						$ret_array[$set_count]['secret'] 		= $a['attributes']['SECRET'];
						$ret_array[$set_count]['server'] 		= $a['attributes']['SERVER'];
						$ret_array[$set_count]['photos'] 		= $a['attributes']['PHOTOS'];
						$ret_array[$set_count]['primary_url'] 	= $this->_replaceURL(
																						$a['attributes']['SERVER'], 
																						$a['attributes']['PRIMARY'],
																						$a['attributes']['SECRET'],
																						's'
																					);
						$ret_array[$set_count]['set_url'] 		= "{$this->_flickr_url}/photos/{$user_id}/sets/{$a['attributes']['ID']}/";
					}
					break;
				case 'TITLE':
					$ret_array[$set_count]['title'] = $a['value'];
					break;
				case 'DESCRIPTION':
					$ret_array[$set_count]['description'] = $a['value'];
					$set_count++;
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Get all tags for user
	*
	* @param string $user_id
	*
	* @return array $ret_array Array of user's tags
	* @access public
	*/
	function getUsersTags($user_id) {
		$ret_array = array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.tags.getListUser', array('user_id'=>$user_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// build return array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'TAG':
					$ret_array[] = $a['value'];
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Get popular tags for user
	*
	* @param string $user_id The user whose popular tags you want to retrieve
	* @param integer $count The number of popular tags to return
	*
	* @return array $ret_array Array of user's popular tags
	* @access public
	*/
	function getUsersPopularTags($user_id, $count = 20) {
		$tag_count = 1;
		$ret_array = array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.tags.getListUserPopular', array('user_id'=>$user_id, 'count'=>$count));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// build return array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'TAG':
					$ret_array[$tag_count]['title'] = $a['value'];
					if (is_array($a['attributes'])) {
						$ret_array[$tag_count]['count'] = $a['attributes']['COUNT'];
					}
					$tag_count++;
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/***************************************************************************************************************
											******* PHOTOS FUNCTIONS ********
	****************************************************************************************************************/
	
	/**
	* Gets info for a single photo
	*
	* @param integer $photo_id 	The id of the photo whose info to retrieve
	* @param integer $secret 	The secret key for the photo. If the correct secret is passed 
	*							then permissions checking is skipped. This enables the 'sharing' 
	*							of individual photos by passing around the id and secret.
	*
	* @return array $ret_array 	The array of photo information
	* @access public
	*/
	function getPhotoInfo($photo_id, $secret = '') {
		$tag_count 			= 1;
		$note_count 		= 1;
		$ret_array 			= array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.photos.getInfo', array('photo_id'=>$photo_id, 'secret'=>$secret));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'PHOTO':
					if (is_array($a['attributes'])) {
						$ret_array['id'] 			= $a['attributes']['ID'];
						$ret_array['secret'] 		= $a['attributes']['SECRET'];
						$ret_array['server'] 		= $a['attributes']['SERVER'];
						$ret_array['date_uploaded'] = $a['attributes']['DATEUPLOADED'];
						$ret_array['is_favorite'] 	= $a['attributes']['ISFAVORITE'];
						$ret_array['license'] 		= $a['attributes']['LICENSE'];
						$ret_array['rotation'] 		= $a['attributes']['ROTATION'];
						
						$id 	= $a['attributes']['ID'];
						$secret = $a['attributes']['SECRET'];
						$server = $a['attributes']['SERVER'];
						
						$ret_array['urls']['url'] 		= $this->_replaceURL($server, $id, $secret);
						$ret_array['urls']['s_url'] 		= $this->_replaceURL($server, $id, $secret, 's');
						$ret_array['urls']['t_url'] 		= $this->_replaceURL($server, $id, $secret, 't');
						$ret_array['urls']['m_url'] 		= $this->_replaceURL($server, $id, $secret, 'm');
						$ret_array['urls']['b_url'] 		= $this->_replaceURL($server, $id, $secret, 'b');
						$ret_array['urls']['o_url'] 		= $this->_replaceURL($server, $id, $secret, 'o');
						$url_count++;
					}
					break;
				case 'OWNER':
					if (is_array($a['attributes'])) {
						$ret_array['owner_nsid']		= $a['attributes']['NSID'];
						$ret_array['owner_username']	= $a['attributes']['USERNAME'];
						$ret_array['owner_realname']	= $a['attributes']['REALNAME'];
						$ret_array['owner_location']	= $a['attributes']['LOCATION'];
					}
					break;
				case 'TITLE':
					$ret_array['title'] = $a['value'];
					break;
				case 'DESCRIPTION':
					$ret_array['description'] = $a['value'];
					break;
				case 'VISIBILITY':
					if (is_array($a['attributes'])) {
						$ret_array['is_public']		= $a['attributes']['ISPUBLIC'];
						$ret_array['is_friend']		= $a['attributes']['ISFRIEND'];
						$ret_array['is_family']		= $a['attributes']['ISFAMILY'];
					}
					break;
				case 'DATES':
					if (is_array($a['attributes'])) {
						$ret_array['date_posted']		= $a['attributes']['POSTED'];
						$ret_array['date_taken']		= strtotime($a['attributes']['TAKEN']);
						$ret_array['date_last_update']	= $a['attributes']['LASTUPDATE'];
						$ret_array['taken_granularity'] = $a['attributes']['TAKENGRANULARITY'];
					}
					break;
				case 'EDITABILITY':
					if (is_array($a['attributes'])) {
						$ret_array['can_comment']	= $a['attributes']['CANCOMMENT'];
						$ret_array['can_addmeta']	= $a['attributes']['CANADDMETA'];
					}
					break;
				case 'COMMENTS':
					$ret_array['comments'] = $a['value'];
					break;
				case 'NOTE':
					if (is_array($a['attributes'])) {
						$ret_array['notes'][$note_count]['id']			= $a['attributes']['ID'];
						$ret_array['notes'][$note_count]['author']		= $a['attributes']['AUTHOR'];
						$ret_array['notes'][$note_count]['author_name']	= $a['attributes']['AUTHORNAME'];
						$ret_array['notes'][$note_count]['x']			= $a['attributes']['X'];
						$ret_array['notes'][$note_count]['y']			= $a['attributes']['Y'];
						$ret_array['notes'][$note_count]['w']			= $a['attributes']['W'];
						$ret_array['notes'][$note_count]['h']			= $a['attributes']['H'];
						$ret_array['notes'][$note_count]['note']		= $a['value'];
						$note_count++;
					}
					break;
				case 'TAG':
					if (is_array($a['attributes'])) {
						$ret_array['tags'][$tag_count]['id']			= $a['attributes']['ID'];
						$ret_array['tags'][$tag_count]['author']		= $a['attributes']['AUTHOR'];
						$ret_array['tags'][$tag_count]['raw']			= $a['attributes']['RAW'];
						$ret_array['tags'][$tag_count]['tag']			= $a['value'];
						$tag_count++;
					}
					break;
				case 'URL':
					if (is_array($a['attributes'])) {
						$ret_array['urls'][$a['attributes']['TYPE']] = $a['value'];
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Searches photos based on a ton of optional criteria
	*
	* @param string $user_id (optional)	The NSID of the user who's photo to search. 
	*									If this parameter isn't passed then everybody's public 
	*									photos will be searched.
	* @param string $tags (optional) 	A comma-delimited list of tags. Photos with one or more 
	*									of the tags listed will be returned.
	* @param integer $per_page (optional)Number of photos to return per page. If this argument is omitted, 
	*									it defaults to 100. The maximum allowed value is 500.
	* @param integer $page (optional) 	The page of results to return. If this argument is omitted, it 
	*									defaults to 1.
	* @param string $sort (optional) 	The order in which to sort returned photos. Deafults to date-posted-desc. 
	*									The possible values are: date-posted-asc, date-posted-desc, date-taken-asc 
	*									and date-taken-desc.
	* @param string $tag_mode (optional)Either 'any' for an OR combination of tags, or 'all' for 
	*									an AND combination. Defaults to 'any' if not specified.
	* @param string $text (optional) 	A free text search. Photos who's title, description or 
	*									tags contain the text will be returned.
	* @param string $min_upload_date (optional) Minimum upload date. Photos with an upload date 
	*									greater than or equal to this value will be returned. The 
	*									date should be in the form of a unix timestamp.
	* @param string $max_upload_date (optional) Maximum upload date. Photos with an upload date less 
	*									than or equal to this value will be returned. The date should 
	*									be in the form of a unix timestamp.
	* @param string $min_taken_date (optional) Minimum taken date. Photos with an taken date greater 
	*									than or equal to this value will be returned. The date should 
	*									be in the form of a unix timestamp.
	* @param string $max_taken_date (optional) Maximum taken date. Photos with an taken date less than 
	*									or equal to this value will be returned. The date should 
	*									be in the form of a unix timestamp.
	* @param integer $license (optional)The license id for photos (for possible values see the flickr documentation:
	*									http://flickr.com/services/api/flickr.photos.licenses.getInfo.html).
	* 
	* This was suggested by Peter Rukavina (http://ruk.ca/).
	* @return array $ret_array 	The array of photo information
	* @access public
	*/
	function photoSearch(	$user_id='', $tags='', $per_page=100, $page=1, $sort='date-posted-desc', $tag_mode='any', 
							$text='', $min_upload_date='', $max_upload_date='', $min_taken_date='', $max_taken_date='', 
							$license='') {
		$photo_count 		= 1;
		$ret_array 			= array();
		$ret_array['photos']= array();
		$found 				= array();
		$extras				= 'license, date_upload, date_taken, owner_name, icon_server';
		
		// min and max taken date need to be in mysql date time format
		$min_taken_date = ($min_taken_date != '') ? date('Y-m-d H:i:s', $min_taken_date) : $min_taken_date;
		$max_taken_date = ($max_taken_date != '') ? date('Y-m-d H:i:s', $max_taken_date) : $max_taken_date;
				
		// make request to flickr
		$data = $this->makeRequest('flickr.photos.search', array(	'user_id'			=> $user_id, 
																	'tags'				=> $tags,
																	'per_page'			=> $per_page,
																	'page'				=> $page,
																	'sort'				=> $sort,
																	'tag_mode'			=> $tag_mode,
																	'text'				=> $text,
																	'min_upload_date'	=> $min_upload_date,
																	'max_upload_date'	=> $max_upload_date,
																	'min_taken_date'	=> $min_taken_date,
																	'max_taken_date'	=> $max_taken_date,
																	'license' 			=> $license,
																	'extras' 			=> $extras
																));
		
		// check if error
		if ($this->_checkForError($data)) {
			throw new FlickrSearchException("Enable to connect Flickr");
			return false;
		}
		
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'PHOTOS':
					if (is_array($a['attributes'])) {
						$ret_array['page'] 		= $a['attributes']['PAGE'];
						$ret_array['pages'] 	= $a['attributes']['PAGES'];
						$ret_array['per_page'] 	= $a['attributes']['PERPAGE'];
						$ret_array['total'] 	= $a['attributes']['TOTAL'];
					}
					break;
				case 'PHOTO':
					if (is_array($a['attributes'])) {
						$ret_array['photos'][$photo_count]['id'] 					= $a['attributes']['ID'];
						$ret_array['photos'][$photo_count]['owner']					= $a['attributes']['OWNER'];
						$ret_array['photos'][$photo_count]['secret'] 				= $a['attributes']['SECRET'];
						$ret_array['photos'][$photo_count]['server'] 				= $a['attributes']['SERVER'];
						$ret_array['photos'][$photo_count]['title'] 				= $a['attributes']['TITLE'];
						$ret_array['photos'][$photo_count]['is_public'] 			= $a['attributes']['ISPUBLIC'];
						$ret_array['photos'][$photo_count]['is_friend'] 			= $a['attributes']['ISFRIEND'];
						$ret_array['photos'][$photo_count]['is_family'] 			= $a['attributes']['ISFAMILY'];
						$ret_array['photos'][$photo_count]['date_upload'] 			= $a['attributes']['DATEUPLOAD'];
						$ret_array['photos'][$photo_count]['date_taken'] 			= strtotime($a['attributes']['DATETAKEN']);
						$ret_array['photos'][$photo_count]['date_taken_granularity']= $a['attributes']['DATETAKENGRANULARITY'];
						$ret_array['photos'][$photo_count]['owner_name'] 			= $a['attributes']['OWNERNAME'];
						$ret_array['photos'][$photo_count]['icon_server'] 			= $a['attributes']['ICONSERVER'];
						
						$id 	= $a['attributes']['ID'];
						$secret = $a['attributes']['SECRET'];
						$server = $a['attributes']['SERVER'];
						$user_id = $a['attributes']['OWNER'];
						
						$ret_array['photos'][$photo_count]['photo_page'] 	= "{$this->_flickr_url}/photos/{$user_id}/{$id}/";
						$ret_array['photos'][$photo_count]['url'] 			= $this->_replaceURL($server, $id, $secret);
						$ret_array['photos'][$photo_count]['s_url'] 		= $this->_replaceURL($server, $id, $secret, 's');
						$ret_array['photos'][$photo_count]['t_url'] 		= $this->_replaceURL($server, $id, $secret, 't');
						$ret_array['photos'][$photo_count]['m_url'] 		= $this->_replaceURL($server, $id, $secret, 'm');
						$ret_array['photos'][$photo_count]['b_url'] 		= $this->_replaceURL($server, $id, $secret, 'b');
						$ret_array['photos'][$photo_count]['o_url'] 		= $this->_replaceURL($server, $id, $secret, 'o');
						$photo_count++;
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Gets all the contexts for a given photo
	*
	* @param integer $photo_id The id of the photo whose contexts you want to retrieve
	*
	* @return array $ret_array Array of all the contexts
	* @access public
	*/
	function getAllPhotoContexts($photo_id) {
		$set_count 			= 1;
		$pool_count 		= 1;
		$ret_array 			= array();
		$ret_array['sets'] 	= array();
		$ret_array['pools'] = array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.photos.getAllContexts', array('photo_id'=>$photo_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'SET':
					if (is_array($a['attributes'])) {
						$ret_array['sets'][$set_count]['id'] 		= $a['attributes']['ID'];
						$ret_array['sets'][$set_count]['title'] 	= $a['attributes']['TITLE'];
						$set_count++;
					}
					break;
				case 'POOL':
					if (is_array($a['attributes'])) {
						$ret_array['pools'][$pool_count]['id'] 		= $a['attributes']['ID'];
						$ret_array['pools'][$pool_count]['title'] 	= $a['attributes']['TITLE'];
						$pool_count++;
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Gets the context for a given photo
	*
	* @param integer $photo_id The id of the photo whose context you want to retrieve
	*
	* @return array $ret_array Array of context information
	* @access public
	*/
	function getPhotoContext($photo_id) {
		$ret_array 		= array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.photos.getContext', array('photo_id'=>$photo_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'COUNT':
					$ret_array['count'] = $a['value'];
					break;
				case 'PREVPHOTO':
					if (is_array($a['attributes'])) {
						$ret_array['prevphoto']['id'] 		= $a['attributes']['ID'];
						$ret_array['prevphoto']['secret'] 	= $a['attributes']['SECRET'];
						$ret_array['prevphoto']['title'] 	= $a['attributes']['TITLE'];
						$ret_array['prevphoto']['url'] 		= $this->_flickr_url . $a['attributes']['URL'];
						$ret_array['prevphoto']['thumb'] 	= $a['attributes']['THUMB'];
					}
					break;
				case 'NEXTPHOTO':
					if (is_array($a['attributes'])) {
						$ret_array['nextphoto']['id'] 		= $a['attributes']['ID'];
						$ret_array['nextphoto']['secret'] 	= $a['attributes']['SECRET'];
						$ret_array['nextphoto']['title'] 	= $a['attributes']['TITLE'];
						$ret_array['nextphoto']['url'] 		= $this->_flickr_url . $a['attributes']['URL'];
						$ret_array['nextphoto']['thumb'] 	= $a['attributes']['THUMB'];
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Gets the context for a photo within a given photoset
	*
	* @param integer $photoset_id The id of the photoset to obtain the context in
	* @param integer $photo_id The id of the photo whose context to retrieve
	*
	* @return array $ret_array An array containing next and previous photo information
	* @access public
	*/
	function getPhotoContextInSet($photoset_id, $photo_id) {
		$ret_array 		= array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.photosets.getContext', array('photo_id'=>$photo_id, 'photoset_id'=>$photoset_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'COUNT':
					$ret_array['count'] = $a['value'];
					break;
				case 'PREVPHOTO':
					if (is_array($a['attributes'])) {
						$ret_array['prevphoto']['id'] 		= $a['attributes']['ID'];
						$ret_array['prevphoto']['secret'] 	= $a['attributes']['SECRET'];
						$ret_array['prevphoto']['title'] 	= $a['attributes']['TITLE'];
						$ret_array['prevphoto']['url'] 		= $this->_flickr_url . $a['attributes']['URL'];
						$ret_array['prevphoto']['thumb'] 	= $a['attributes']['THUMB'];
					}
					break;
				case 'NEXTPHOTO':
					if (is_array($a['attributes'])) {
						$ret_array['nextphoto']['id'] 		= $a['attributes']['ID'];
						$ret_array['nextphoto']['secret'] 	= $a['attributes']['SECRET'];
						$ret_array['nextphoto']['title'] 	= $a['attributes']['TITLE'];
						$ret_array['nextphoto']['url'] 		= $this->_flickr_url . $a['attributes']['URL'];
						$ret_array['nextphoto']['thumb'] 	= $a['attributes']['THUMB'];
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Gets the context for a photo within a given photoset
	*
	* @param string $group_id The id of the group whose pool the photo is in
	* @param integer $photo_id The id of the photo whose context to retrieve in the group's pool
	*
	* @return array $ret_array An array containing next and previous photo information
	* @access public
	*/
	function getPhotoContextInPool($group_id, $photo_id) {
		$ret_array 		= array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.groups.pools.getContext', array('photo_id'=>$photo_id, 'group_id'=>$group_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'COUNT':
					$ret_array['count'] = $a['value'];
					break;
				case 'PREVPHOTO':
					if (is_array($a['attributes'])) {
						$ret_array['prevphoto']['id'] 		= $a['attributes']['ID'];
						$ret_array['prevphoto']['secret'] 	= $a['attributes']['SECRET'];
						$ret_array['prevphoto']['title'] 	= $a['attributes']['TITLE'];
						$ret_array['prevphoto']['url'] 		= $this->_flickr_url . $a['attributes']['URL'];
						$ret_array['prevphoto']['thumb'] 	= $a['attributes']['THUMB'];
					}
					break;
				case 'NEXTPHOTO':
					if (is_array($a['attributes'])) {
						$ret_array['nextphoto']['id'] 		= $a['attributes']['ID'];
						$ret_array['nextphoto']['secret'] 	= $a['attributes']['SECRET'];
						$ret_array['nextphoto']['title'] 	= $a['attributes']['TITLE'];
						$ret_array['nextphoto']['url'] 		= $this->_flickr_url . $a['attributes']['URL'];
						$ret_array['nextphoto']['thumb'] 	= $a['attributes']['THUMB'];
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Gets the tags for a given photo
	*
	* @param integer $photo_id The id of the photo whose tags you want to retrieve
	*
	* @return array $ret_array Array of tags
	* @access public
	*/
	function getPhotoTags($photo_id) {
		$tag_count 		= 1;
		$ret_array 		= array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.tags.getListPhoto', array('photo_id'=>$photo_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'TAG':
					if (is_array($a['attributes'])) {
						$ret_array[$tag_count]['id'] = $a['attributes']['ID'];
						$ret_array[$tag_count]['author'] = $a['attributes']['AUTHOR'];
						$ret_array[$tag_count]['authorname'] = $a['attributes']['AUTHORNAME'];
						$ret_array[$tag_count]['raw'] = $a['attributes']['RAW'];
						$tag_count++;
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/***************************************************************************************************************
											******* PHOTOSET FUNCTIONS ********
	****************************************************************************************************************/
	
	/**
	* Gets the information about a photoset
	*
	* @param integer $photoset_id The id of the photoset whose info you want to receive
	*
	* @return array $ret_array Array full of photoset's information
	* @access private
	*/
	function getPhotosetInfo($photoset_id) {
		$ret_array = array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.photosets.getInfo', array('photoset_id'=>$photoset_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// build return array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'PHOTOSET':
					if (is_array($a['attributes'])) {
						$ret_array['id'] 			= $a['attributes']['ID'];
						$ret_array['owner'] 		= $a['attributes']['OWNER'];
						$ret_array['primary'] 		= $a['attributes']['PRIMARY'];
						$ret_array['photos'] 		= $a['attributes']['PHOTOS'];
					}
					break;
				case 'TITLE':
					$ret_array['title'] = $a['value'];
					break;
				case 'DESCRIPTION':
					$ret_array['description'] = $a['value'];
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/**
	* Returns the photos for a photoset
	*
	* @param string $user_id The user_id of the photoset owner. This is needed to build photo urls.
	* @param integer $photoset_id The photoset_id whose photos you want to retrieve
	*
	* @return array $photos The array of arrays storing all the photos and their information
	* @access public
	*/
	function getPhotosetPhotos($user_id, $photoset_id) {
		$ret_array 	= array();
		
		// make request to flickr
		$data = $this->makeRequest('flickr.photosets.getPhotos', array('photoset_id' => $photoset_id));
		
		// check if error
		if ($this->_checkForError($data)) {
			return false;
		}
		
		// loop through the response xml array
		for ($i=0, $count=count($data); $i<$count; $i++) {
			$a = $data[$i];
			switch ($a['tag']) {
				case 'PHOTOSET':
					if (is_array($a['attributes'])) {
						$ret_array['id'] = $a['attributes']['ID'];
						$ret_array['primary'] = $a['attributes']['PRIMARY'];
					}
					break;
				case 'PHOTO':
					if (is_array($a['attributes'])) {
						$id 									= $a['attributes']['ID'];
						$secret 								= $a['attributes']['SECRET'];
						$server 								= $a['attributes']['SERVER'];
						$ret_array['photos'][$id]['secret'] 	= $secret;
						$ret_array['photos'][$id]['server'] 	= $server;
						$ret_array['photos'][$id]['title'] 		= $a['attributes']['TITLE'];
						$ret_array['photos'][$id]['isprimary'] 	= $a['attributes']['ISPRIMARY'];
						$ret_array['photos'][$id]['url'] 		= $this->_replaceURL($server, $id, $secret);
						$ret_array['photos'][$id]['s_url'] 		= $this->_replaceURL($server, $id, $secret, 's');
						$ret_array['photos'][$id]['t_url'] 		= $this->_replaceURL($server, $id, $secret, 't');
						$ret_array['photos'][$id]['m_url'] 		= $this->_replaceURL($server, $id, $secret, 'm');
						$ret_array['photos'][$id]['b_url'] 		= $this->_replaceURL($server, $id, $secret, 'b');
						$ret_array['photos'][$id]['o_url'] 		= $this->_replaceURL($server, $id, $secret, 'o');
						$ret_array['photos'][$id]['photo_page']	= "{$this->_flickr_url}/photos/{$user_id}/{$id}/in/set-{$photoset_id}/";
						
					}
					break;
			}
		}
		if ($this->_debug) {
			echo '<h2>Function Return</h2>';
			$this->_a($ret_array);
			echo '<hr />';
		}
		return $ret_array;
	}
	
	/***************************************************************************************************************
											******* CACHE FUNCTIONS ********
	****************************************************************************************************************/
	
	/**
	* Enables the caching of requests and responses in a MySQL database.
	*
	* @param string $host The host of your mysql database
	* @param string $db_user The username needed to access your mysql database
	* @param string $db_pass The password needed to access your mysql database
	* @param string $db_name The name of the database you want to store caching in
	*
	* @return void
	* @access public
	*/
	function enableDBCache($host, $db_user, $db_pass, $db_name, $expire_seconds = 600) {
		$this->_cache_enabled 	= true;
		$this->_cache_type 		= 'db';
		$this->_cache_expire 	= $expire_seconds;
		
		$this->_db =& new MySQL($host, $db_user, $db_pass, $db_name);
		$this->_db->query("
							CREATE TABLE IF NOT EXISTS $this->_cache_table (
								`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
								`request` VARCHAR( 255 ) NOT NULL ,
								`response` TEXT NOT NULL ,
								`date_expire` BIGINT UNSIGNED NOT NULL ,
								PRIMARY KEY ( `id` )
							) TYPE = MYISAM
						");
		if ($this->_db->isError()) {
			echo $this->_db->getErrorMsg();
		} else {
			$this->_db->query("DELETE FROM $this->_cache_table WHERE date_expire < " . time());
			if ($this->_db->isError()) {
				echo $this->_db->getErrorMsg();
			}
			$this->_db->query("OPTIMIZE TABLE $this->_cache_table");
			if ($this->_db->isError()) {
				echo $this->_db->getErrorMsg();
			}
			$this->_cache =& new table($this->_db, $this->_cache_table);
		}
	}
	
	/**
	* Enables the caching of requests and responses in the file system
	*
	* @param string $dir The folder to cache the requests in
	*
	* @return void
	* @access public
	*/
	function enableFSCache($dir, $expire_seconds = 600) {
		$this->_cache_enabled 	= true;
		$this->_cache_type 		= 'fs';
		$this->_cache_dir 		= $dir;
		$this->_cache_expire 	= $expire_seconds;
		
		$d = dir($this->_cache_dir);
		while ($file = $d->read()) {
			$file = $this->_cache_dir . $file;
			if (substr($file, -6) == '.cache' && ( (filemtime($file) + $this->_cache_expire) > time()) ) {
				unlink($file);
			}
		}		
	}
	
	/***************************************************************************************************************
											******* UTILITY FUNCTIONS ********
	****************************************************************************************************************/
	
	/**
	* Checks an array that used to be xml for an error, if so it sets the error code and message
	*
	* @param array $data The array to check for flickr response errors
	*
	* @return bool True if error false if not
	* @access private
	*/
	function _checkForError($data) {
		if ($data[0]['attributes']['STAT'] == 'fail') {
			$this->_error_code = $data[1]['attributes']['CODE'];
			$this->_error_msg = $data[1]['attributes']['MSG'];
			return true;
		}
		return false;
	}
	
	/**
	* Checks if there is an error, if so it returns it
	*
	* @return string The error code and message
	* @access public
	*/
	function isError() {
		if  ($this->_error_msg != '') {
			return true;
		}
		return false;
	}
	
	/**
	* Returns error code and message if any
	*
	* @return string The error code and message
	* @access public
	*/
	function getErrorMsg() {
		return '<p>Error: (' . $this->_error_code . ') ' . $this->_error_msg . '</p>';
	}
	
	/**
	* Clears the error variables
	*
	* @return void
	* @access private
	*/
	function _clearErrors() {
		$this->_error_code = '';
		$this->_error_msg = '';
	}
	
	/**
	* Given the parameters, this replaces the $_flickr_photo_url to make the link to the photo
	*
	* @return string $url The url to link to the image
	* @access private
	*/
	function _replaceURL($server_id, $photo_id, $secret, $size=NULL) {
		$ret_url = '';
		
		$ret_url = str_replace('{server_id}', $server_id, $this->_flickr_photo_url);
		$ret_url = str_replace('{photo_id}', $photo_id, $ret_url);
		$ret_url = str_replace('{secret}', $secret, $ret_url);
		$ret_url = ($size == NULL) ? str_replace('_{size}', '', $ret_url) : str_replace('{size}', $size, $ret_url);
		return $ret_url;
	}
	
	/**
	* Sets debug to true or false
	*
	* @param bool $debug True or false
	*
	* @return void
	* @access public
	*/
	function setDebug($debug) {
		$this->_debug = $debug;
	}
	
	/**
	* Just for debugging; prints an array nicely
	*
	* @param array $array The array to print out
	*
	* @return void
	* @access private
	*/
	function _a($array) {
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
	function setQuery($value)
	{
		$this->strQuery=$value;
	}
	function getQuery()
	{
		return $this->strQuery;
	}
	function getXml($pIntFirstIndex,$pIntNoOfResult)
	{
		
		$result = $this->photoSearch('', $this->strQuery, $pIntNoOfResult, 1);
		if ($this->isError()) 
		{
		    //echo $this->getErrorMsg();
		    throw new FlickrSearchException("Enable to Connect Flickr");
		}
		else
		{
		    $photos = $result['photos'];
			$pintEndIndex=$pIntNoOfResult+$pIntFirstIndex;
    		$this->strXmlString="<FlickrSearch><Query>$this->strQuery</Query>
						   <SearchType></SearchType>
				  	       <TotalResult>$pIntNoOfResult</TotalResult>
		   				   <AvailableResult></AvailableResult>
		   				   <FirstIndex>$pIntFirstIndex</FirstIndex>
		   				   <EndIndex>$pintEndIndex</EndIndex>";
	    	if (count($photos) > 0)
			{
		        foreach($photos as $photo)
				{
					$this->strXmlString=$this->strXmlString."<Result>";	
		        // echo '<div class="photo-ind">';
			      //  echo '<a href="' . $photo['photo_page'] . '" title="' . $photo['title'] . '"><img src="' . $photo['s_url'] . '" alt="' . $photo['title'] . '" /></a>';
					//echo ($photo['title']);
  					//echo ($photo['url']);
                   $this->strXmlString=$this->strXmlString."<Summary></Summary>";
                   $this->strXmlString=$this->strXmlString."<Title>".htmlentities($photo['title'])."</Title>";
                   $value=$photo['s_url'];
				   $this->strXmlString=$this->strXmlString."<Url>".urlencode($photo['url'])."</Url>";
                   $this->strXmlString=$this->strXmlString."<ClickUrl>".urlencode($photo['photo_page'])."</ClickUrl>";
                   $this->strXmlString=$this->strXmlString."<RefererUrl>".urlencode($photo['t_url'])."</RefererUrl>";
                   $this->strXmlString=$this->strXmlString."<FileSize></FileSize>"; 
                   $this->strXmlString=$this->strXmlString."<FileFormat></FileFormat>"; 
                   $this->strXmlString=$this->strXmlString."<Height></Height>"; 
                   $this->strXmlString=$this->strXmlString."<Width></Width>"; 
                   $this->strXmlString=$this->strXmlString."<Thumbnail>img src=".$value."</Thumbnail>";
                   $this->strXmlString=$this->strXmlString."</Result>";	
                   //echo '</div>';
		     	}
  		   }
  		   else 
  		   {
  		   	
  		   	 throw new FlickrSearchException("No result found");
  		   }
           $this->strXmlString=$this->strXmlString."</FlickrSearch>";
		   return $this->strXmlString;
		}
	}
	
	function getImageXml($pIntFirstIndex,$pIntNoOfResult)
	{
		 $this->intReturnResult=0;
		$result = $this->photoSearch('', $this->strQuery, $pIntNoOfResult, 1);
		if($result)
		{
			/*
			if ($this->isError()) 
			{
			   // echo $this->getErrorMsg();
			   throw new FlickrSearchException("Enable to Connect Flickr");
			}
			
			else
			{*/
				$photos = $result['photos'];
				$pintEndIndex=$pIntNoOfResult+$pIntFirstIndex;
				if (count($photos) > 0)
				{
				   
					foreach($photos as $photo)
					{
						$this->strXmlString=$this->strXmlString."<Result>";	
					// echo '<div class="photo-ind">';
					  //  echo '<a href="' . $photo['photo_page'] . '" title="' . $photo['title'] . '"><img src="' . $photo['s_url'] . '" alt="' . $photo['title'] . '" /></a>';
						//echo ($photo['title']);
						//echo ($photo['url']);
					   $this->strXmlString=$this->strXmlString."<Title>".htmlentities($photo['title'])."</Title>";
					   $this->strXmlString=$this->strXmlString."<Summary></Summary>";
					   $value=$photo['s_url'];
					   $this->strXmlString=$this->strXmlString."<Url>".urlencode($photo['url'])."</Url>";
					   $this->strXmlString=$this->strXmlString."<ClickUrl>".urlencode($photo['photo_page'])."</ClickUrl>";
					   $this->strXmlString=$this->strXmlString."<RefererUrl>".urlencode($photo['t_url'])."</RefererUrl>";
					   $this->strXmlString=$this->strXmlString."<FileSize></FileSize>"; 
					   $this->strXmlString=$this->strXmlString."<FileFormat></FileFormat>"; 
					   $this->strXmlString=$this->strXmlString."<Height></Height>"; 
					   $this->strXmlString=$this->strXmlString."<Width></Width>"; 
					   $this->strXmlString=$this->strXmlString."<Thumbnail>img src=".$value."</Thumbnail>";
					   $this->strXmlString=$this->strXmlString."<SearchEngine>Flickr</SearchEngine>";
					   $this->strXmlString=$this->strXmlString."</Result>";	
					   $this->intReturnResult=$this->intReturnResult+1;
					   //echo '</div>';
					}
			   }
			   else 
			   {
				 $this->intReturnResult=0;
				// throw new FlickrSearchException("No result found");
			   }
         	  return $this->strXmlString;
			//}
		}
	}

	function writeToFile($strFileName,$pIntFirstIndex,$pIntNoOfResult)
	{
		$strFormatXml=$this->getXml($pIntFirstIndex,$pIntNoOfResult);
		$Handle = fopen($strFileName, 'w');
		fwrite($Handle,$strFormatXml);
   	    fclose($Handle);
	}
}
?>