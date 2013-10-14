<?php 
class WaypointDownloadBO
{
	var $intWaypointDownloadId;
	var $intPaceCastId;
	var $intConsumerId;
	var $dateWaypointDownloadCreateDate;
	var $intWaypointDownloadIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getWaypointDownloadId()
 	{
 		return $this->intWaypointDownloadId;
 	}
 	function setWaypointDownloadId($pWaypointDownloadId)
 	{
 		$this->intWaypointDownloadId=$pWaypointDownloadId;
 	}

 	function getConsumerId()
 	{
 		return $this->intConsumerId;
 	}
 	function setConsumerId($pConsumerId)
 	{
 		$this->intConsumerId=$pConsumerId;
 	}
 	
 	function getWaypointId()
 	{
 		return $this->intWaypointId;
 	}
 	function setWaypointId($pWaypointId)
 	{
 		$this->intWaypointId=$pWaypointId;
 	}

 	function getWaypointDownloadCreateDate()
 	{
 		return $this->dateWaypointDownloadCreateDate;
 	}
 	function setWaypointDownloadCreateDate($pWaypointDownloadCreateDate)
 	{
 		$this->dateWaypointDownloadCreateDate=$pWaypointDownloadCreateDate;
 	}

 	function getWaypointDownloadIsActive()
 	{
 		return $this->intWaypointDownloadIsActive;
 	}
 	function setWaypointDownloadIsActive($pWaypointDownloadIsActive)
 	{
 		$this->intWaypointDownloadIsActive=$pWaypointDownloadIsActive;
 	}

}


?>