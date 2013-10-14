<?php 
class PlaceCastDownloadBO
{
	var $intPlaceCastDownloadId;
	var $intPaceCastId;
	var $intConsumerId;
	var $datePlaceCastDownloadCreateDate;
	var $intPlaceCastDownloadIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getPlaceCastDownloadId()
 	{
 		return $this->intPlaceCastDownloadId;
 	}
 	function setPlaceCastDownloadId($pPlaceCastDownloadId)
 	{
 		$this->intPlaceCastDownloadId=$pPlaceCastDownloadId;
 	}

 	function getConsumerId()
 	{
 		return $this->intConsumerId;
 	}
 	function setConsumerId($pConsumerId)
 	{
 		$this->intConsumerId=$pConsumerId;
 	}
 	
 	function getPlaceCastId()
 	{
 		return $this->intPlaceCastId;
 	}
 	function setPlaceCastId($pPlaceCastId)
 	{
 		$this->intPlaceCastId=$pPlaceCastId;
 	}

 	function getPlaceCastDownloadCreateDate()
 	{
 		return $this->datePlaceCastDownloadCreateDate;
 	}
 	function setPlaceCastDownloadCreateDate($pPlaceCastDownloadCreateDate)
 	{
 		$this->datePlaceCastDownloadCreateDate=$pPlaceCastDownloadCreateDate;
 	}

 	function getPlaceCastDownloadIsActive()
 	{
 		return $this->intPlaceCastDownloadIsActive;
 	}
 	function setPlaceCastDownloadIsActive($pPlaceCastDownloadIsActive)
 	{
 		$this->intPlaceCastDownloadIsActive=$pPlaceCastDownloadIsActive;
 	}

}


?>