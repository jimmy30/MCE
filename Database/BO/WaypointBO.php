<?php 
class WaypointBO
{
	var $intWaypointId;
	var $intPaceCastId;
	var $strWaypointName;	
	var $strWaypointAddress;
	var $strWaypointCity;			
	var $decWaypointLat1;			
	var $decWaypointLong1;			
	var $dateWaypointDescription;
	var $dateWaypointCreateDate;
	var $intWaypointIsActive;		
	var $intWaypointRadius;	
							
 	function __construct()
 	{
		 		
 	}
	
 	function getWaypointId()
 	{
 		return $this->intWaypointId;
 	}
 	function setWaypointId($pWaypointId)
 	{
 		$this->intWaypointId=$pWaypointId;
 	}

 	function getPlaceCastId()
 	{
 		return $this->intPlaceCastId;
 	}
 	function setPlaceCastId($pPlaceCastId)
 	{
 		$this->intPlaceCastId=$pPlaceCastId;
 	}
 	
 	function getWaypointName()
 	{
 		return $this->strWaypointName;
 	}
 	function setWaypointName($pWaypointName)
 	{
 		$this->strWaypointName=$pWaypointName;
 	}

 	function getWaypointAddress()
 	{
 		return $this->strWaypointAddress;
 	}
 	function setWaypointAddress($pWaypointAddress)
 	{
 		$this->strWaypointAddress=$pWaypointAddress;
 	}

 	function getWaypointCity()
 	{
 		return $this->strWaypointCity;
 	}
 	function setWaypointCity($pWaypointCity)
 	{
 		$this->strWaypointCity=$pWaypointCity;
 	}

 	function getWaypointLat1()
 	{
 		return $this->decWaypointLat1;
 	}
 	function setWaypointLat1($pWaypointLat1)
 	{
 		$this->decWaypointLat1=$pWaypointLat1;
 	}

 	function getWaypointLong1()
 	{
 		return $this->decWaypointLong1;
 	}
 	function setWaypointLong1($pWaypointLong1)
 	{
 		$this->decWaypointLong1=$pWaypointLong1;
 	}

 	function getWaypointDescription()
 	{
 		return $this->strWaypointDescription;
 	}
 	function setWaypointDescription($pWaypointDescription)
 	{
 		$this->strWaypointDescription=$pWaypointDescription;
 	}

 	function getWaypointCreateDate()
 	{
 		return $this->dateWaypointCreateDate;
 	}
 	function setWaypointCreateDate($pWaypointCreateDate)
 	{
 		$this->dateWaypointCreateDate=$pWaypointCreateDate;
 	}

 	function getWaypointIsActive()
 	{
 		return $this->intWaypointIsActive;
 	}
 	function setWaypointIsActive($pWaypointIsActive)
 	{
 		$this->intWaypointIsActive=$pWaypointIsActive;
 	}

 	function getWaypointRadius()
 	{
 		return $this->intWaypointRadius;
 	}
 	function setWaypointRadius($pWaypointRadius)
 	{
 		$this->intWaypointRadius=$pWaypointRadius;
 	}

}


?>