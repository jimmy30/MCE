<?

class RSS
{
	//// Declaring DB connection and objects and privateiables
	var $strDbHost;
	var $strDbUser;
	var $strDbPassword;
	var $strDbName;	

	public function RSS()
	{
		$objProperties=new Properties();
		$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
			
		$this->strDbHost = $objProperties->getProperty('db_host');
		$this->strDbUser=$objProperties->getProperty('db_username');
		$this->strDbPassword = $objProperties->getProperty('db_password');
		$this->strDbName=$objProperties->getProperty('db_dbname');
		$dbc = new mysqli($this->strDbHost, $this->strDbUser, $this->strDbPassword, $this->strDbName) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
	}
	function unhtmlentities($string) {
		// replace numeric entities
		$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
		$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
		// replace literal entities
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
	return strtr($string, $trans_tbl);
	}
	public function GetPlaceCastFeed($param,$value)
	{
		return $this->getWayPoints($param,$value);
	}
	public function GetConsumerFeed($username,$password)
	{
		return $this->getConsumer($username,$password);
	}
	
	private function open()
	{
		DEFINE ('LINK', mysql_connect ($this->strDbHost, $this->strDbUser, $this->strDbPassword));
	}
	private function close()
	{
		mysql_close(LINK);
	}
	
	private function getWayPoints($param,$value)
	{
		$this->open();
		$endquery="";
		if(trim($param)!="" && trim($value)!="")	$endquery= " and $param='".$value."'";
		$query = "Select PlaceCastId,Long1,Lat1,Long2,Lat2,Long3,Lat3,Long4,Lat4,Name,Description,CountryName as Country,StateName as State,ZipCode,City from placecast ,country,state
				   where state.StateId=placecast.StateId 
					and country.CountryId=placecast.CountryId and placecast.IsActive=1 ".$endquery;
					
		$result = mysql_db_query ($this->strDbName, $query, LINK);
		$details = '<?xml version="1.0" encoding="ISO-8859-1" ?><PlaceCasts>';
		$pc='';
		while($row = mysql_fetch_array($result))
		{
			
			$id=$row[PlaceCastId];
			$directory='Contents/PlaceCasts/';
			$placecast=$directory.$id.'/';
			$tour=$placecast.$id.'.zip';
			
			$pc = $pc.'<PlaceCast ID="'.$row[PlaceCastId].'"><Direction Long1="'.$row[Long1].'" Lat1="'.$row[Lat1].'" Long2="'.$row[Long2].'" Lat2="'.$row[Lat2].'" Long3="'.$row[Long3].'" Lat3="'.$row[Lat3].'" Long4="'.$row[Long4].'" Lat4="'.$row[Lat4].'"/><Name>'. $row[Name] .'</Name><Description>'. htmlentities($row[Description]) .'</Description><Country>'. $row[Country] .'</Country><State>'. $row[State] .'</State><City>'. $row[City] .'</City><Zip>'. $row[ZipCode] .'</Zip><DateModified>'. date(DATE_RFC822).'</DateModified><Tour>'.$tour.'</Tour><Status>0</Status><Downloaded>0</Downloaded><WayPoints>';

  				   $query = "Select waypoint.WaypointId,waypoint.Name,waypoint.Description,waypoint.Address,waypoint.Long1,waypoint.Lat1,waypoint.Radius from waypoint,placecast
							 where waypoint.PlaceCastId=placecast.PlaceCastID and waypoint.PlaceCastId=$id and  waypoint.IsActive=1";
							 $inner='';
								$resultDetail = mysql_db_query ($this->strDbName, $query, LINK);
						while($rowDetail = mysql_fetch_array($resultDetail)){
  								$waypoint=$placecast.'Waypoints/'.$rowDetail[WaypointId].'/'.$rowDetail[WaypointId].'.html';

								$inner=$inner.'<WayPoint ID="'. $rowDetail[WaypointId] .'"><Name>'. $rowDetail[Name] .'</Name><Description>'. htmlentities($rowDetail[Description]) .'</Description><Address>'. $rowDetail[Address] .'</Address><link>'. $waypoint .'</link><Long1>'. $rowDetail[Long1] .'</Long1><Lat1>'. $rowDetail[Lat1] .'</Lat1><Radius>'. $rowDetail[Radius] .'</Radius></WayPoint>';

							}
							$pc=$pc.$inner.'</WayPoints></PlaceCast>';
				}
							$details=$details.$pc.'</PlaceCasts>';
							$this->close();
		return $details;
	}
	private function getConsumer($username,$password)
	{
		$this->open();
		
		$query = "select ConsumerId,FirstName,LastName,Email,City,consumer.IsActive,CountryName 
					from consumer,Country 
					where 
					Country.CountryId=Consumer.CountryId and (Email='$username' and Password='$password')";
					
		$result = mysql_db_query ($this->strDbName, $query, LINK);
		$details = '<?xml version="1.0" encoding="ISO-8859-1" ?><Consumers>';

		if($row = mysql_fetch_array($result)){
					$c = '<ConsumerId>'.$row[ConsumerId].' </ConsumerId><FirstName>'.$row[FirstName].'</FirstName><LastName>'.$row[LastName].'</LastName><Email>'.$row[Email].'</Email><City>'.$row[City].'</City><IsActive>'.$row[IsActive].'</IsActive><Country>'.$row[CountryName].'</Country>';

				}
				else{
						$c='<Result>Nothing Found</Result>';
				}
				$details=$details.$c.'</Consumers>';
				$this->close();
		return $details;
	}

}

?>