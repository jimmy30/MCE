<?php 
class PlaceCastBO
{
	var $intPaceCastId;
	var $intProducerId;
	var $intPlaceCastCountryId;
	var $intPlaceCastStateId;
	var $strPlaceCastName;	
	var $strPlaceCastAddress;			
	var $strPlaceCastCity;		
	var $strPlaceCastZipCode;		
	var $decPlaceCastLat1;			
	var $decPlaceCastLong1;			
	var $decPlaceCastLat2;			
	var $decPlaceCastLong2;			
	var $decPlaceCastLat3;			
	var $decPlaceCastLong3;			
	var $decPlaceCastLat4;			
	var $decPlaceCastLong4;			
	var $datePlaceCastDescription;
	var $datePlaceCastCreateDate;
	var $intPlaceCastIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getPlaceCastId()
 	{
 		return $this->intPlaceCastId;
 	}
 	function setPlaceCastId($pPlaceCastId)
 	{
 		$this->intPlaceCastId=$pPlaceCastId;
 	}

 	function getProducerId()
 	{
 		return $this->intProducerId;
 	}
 	function setProducerId($pProducerId)
 	{
 		$this->intProducerId=$pProducerId;
 	}
 	
 	function getPlaceCastCountryId()
 	{
 		return $this->intPlaceCastCountryId;
 	}
 	function setPlaceCastCountryId($pPlaceCastCountryId)
 	{
 		$this->intPlaceCastCountryId=$pPlaceCastCountryId;
 	}

 	function getPlaceCastStateId()
 	{
 		return $this->intPlaceCastStateId;
 	}
 	function setPlaceCastStateId($pPlaceCastStateId)
 	{
 		$this->intPlaceCastStateId=$pPlaceCastStateId;
 	}
 	
 	function getPlaceCastName()
 	{
 		return $this->strPlaceCastName;
 	}
 	function setPlaceCastName($pPlaceCastName)
 	{
 		$this->strPlaceCastName=$pPlaceCastName;
 	}

 	function getPlaceCastAddress()
 	{
 		return $this->strPlaceCastAddress;
 	}
 	function setPlaceCastAddress($pPlaceCastAddress)
 	{
 		$this->strPlaceCastAddress=$pPlaceCastAddress;
 	}

 	function getPlaceCastCity()
 	{
 		return $this->strPlaceCastCity;
 	}
 	function setPlaceCastCity($pPlaceCastCity)
 	{
 		$this->strPlaceCastCity=$pPlaceCastCity;
 	}

 	function getPlaceCastZipCode()
 	{
 		return $this->strPlaceCastZipCode;
 	}
 	function setPlaceCastZipCode($pPlaceCastZipCode)
 	{
 		$this->strPlaceCastZipCode=$pPlaceCastZipCode;
 	}

 	function getPlaceCastLat1()
 	{
 		return $this->decPlaceCastLat1;
 	}
 	function setPlaceCastLat1($pPlaceCastLat1)
 	{
 		$this->decPlaceCastLat1=$pPlaceCastLat1;
 	}

 	function getPlaceCastLong1()
 	{
 		return $this->decPlaceCastLong1;
 	}
 	function setPlaceCastLong1($pPlaceCastLong1)
 	{
 		$this->decPlaceCastLong1=$pPlaceCastLong1;
 	}

 	function getPlaceCastLat2()
 	{
 		return $this->decPlaceCastLat2;
 	}
 	function setPlaceCastLat2($pPlaceCastLat2)
 	{
 		$this->decPlaceCastLat2=$pPlaceCastLat2;
 	}

 	function getPlaceCastLong2()
 	{
 		return $this->decPlaceCastLong2;
 	}
 	function setPlaceCastLong2($pPlaceCastLong2)
 	{
 		$this->decPlaceCastLong2=$pPlaceCastLong2;
 	}

 	function getPlaceCastLat3()
 	{
 		return $this->decPlaceCastLat3;
 	}
 	function setPlaceCastLat3($pPlaceCastLat3)
 	{
 		$this->decPlaceCastLat3=$pPlaceCastLat3;
 	}

 	function getPlaceCastLong3()
 	{
 		return $this->decPlaceCastLong3;
 	}
 	function setPlaceCastLong3($pPlaceCastLong3)
 	{
 		$this->decPlaceCastLong3=$pPlaceCastLong3;
 	}

 	function getPlaceCastLat4()
 	{
 		return $this->decPlaceCastLat4;
 	}
 	function setPlaceCastLat4($pPlaceCastLat4)
 	{
 		$this->decPlaceCastLat4=$pPlaceCastLat4;
 	}

 	function getPlaceCastLong4()
 	{
 		return $this->decPlaceCastLong4;
 	}
 	function setPlaceCastLong4($pPlaceCastLong4)
 	{
 		$this->decPlaceCastLong4=$pPlaceCastLong4;
 	}

 	function getPlaceCastDescription()
 	{
 		return $this->strPlaceCastDescription;
 	}
 	function setPlaceCastDescription($pPlaceCastDescription)
 	{
 		$this->strPlaceCastDescription=$pPlaceCastDescription;
 	}

 	function getPlaceCastCreateDate()
 	{
 		return $this->datePlaceCastCreateDate;
 	}
 	function setPlaceCastCreateDate($pPlaceCastCreateDate)
 	{
 		$this->datePlaceCastCreateDate=$pPlaceCastCreateDate;
 	}

 	function getPlaceCastIsActive()
 	{
 		return $this->intPlaceCastIsActive;
 	}
 	function setPlaceCastIsActive($pPlaceCastIsActive)
 	{
 		$this->intPlaceCastIsActive=$pPlaceCastIsActive;
 	}

}


?>