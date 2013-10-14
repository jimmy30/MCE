<?php 
class CountryBO
{
	var $intCountryId;
	var $strCountryName;		
	var $dateCountryCreateDate;
	var $intCountryIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	
 	function getCountryId()
 	{
 		return $this->intCountryId;
 	}
 	function setCountryId($pCountryId)
 	{
 		$this->intCountryId=$pCountryId;
 	}

 	function getCountryName()
 	{
 		return $this->strCountryName;
 	}
 	function setCountryName($pCountryName)
 	{
 		$this->strCountryName=$pCountryName;
 	}
 	
 	function getCountryCreateDate()
 	{
 		return $this->dateCountryCreateDate;
 	}
 	function setCountryCreateDate($pCountryCreateDate)
 	{
 		$this->dateCountryCreateDate=$pCountryCreateDate;
 	}

 	function getCountryIsActive()
 	{
 		return $this->intCountryIsActive;
 	}
 	function setCountryIsActive($pCountryIsActive)
 	{
 		$this->intCountryIsActive=$pCountryIsActive;
 	}

}


?>