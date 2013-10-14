<?php 
class StateBO
{
	var $intStateId;
	var $intCountryId;	
	var $strStateName;		
	var $dateStateCreateDate;
	var $intStateIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getStateId()
 	{
 		return $this->intStateId;
 	}
 	function setStateId($pStateId)
 	{
 		$this->intStateId=$pStateId;
 	}
 	
 	function getCountryId()
 	{
 		return $this->intCountryId;
 	}
 	function setCountryId($pCountryId)
 	{
 		$this->intCountryId=$pCountryId;
 	}

 	function getStateName()
 	{
 		return $this->strStateName;
 	}
 	function setStateName($pStateName)
 	{
 		$this->strStateName=$pStateName;
 	}
 	
 	function getStateCreateDate()
 	{
 		return $this->dateStateCreateDate;
 	}
 	function setStateCreateDate($pStateCreateDate)
 	{
 		$this->dateStateCreateDate=$pStateCreateDate;
 	}

 	function getStateIsActive()
 	{
 		return $this->intStateIsActive;
 	}
 	function setStateIsActive($pStateIsActive)
 	{
 		$this->intStateIsActive=$pStateIsActive;
 	}

}


?>