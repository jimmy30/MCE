<?php 
class SmsAlertBO
{
	var $intSmsAlertId;
	var $intConsumerId;
	var $intCountryId;
	var $intAdd;
	var $intModify;
	var $dateCreateDate;
	var $intIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getSmsAlertId()
 	{
 		return $this->intSmsAlertId;
 	}
 	function setSmsAlertId($pSmsAlertId)
 	{
 		$this->intSmsAlertId=$pSmsAlertId;
 	}

 	function getConsumerId()
 	{
 		return $this->intConsumerId;
 	}
 	function setConsumerId($pConsumerId)
 	{
 		$this->intConsumerId=$pConsumerId;
 	}
 	
 	function getCountryId()
 	{
 		return $this->intCountryId;
 	}
 	function setCountryId($pCountryId)
 	{
 		$this->intCountryId=$pCountryId;
 	}

 	function getAdd()
 	{
 		return $this->intAdd;
 	}
 	function setAdd($pAdd)
 	{
 		$this->intAdd=$pAdd;
 	}

 	function getModify()
 	{
 		return $this->intModify;
 	}
 	function setModify($pModify)
 	{
 		$this->intModify=$pModify;
 	}

 	function getCreateDate()
 	{
 		return $this->dateCreateDate;
 	}
 	function setCreateDate($pCreateDate)
 	{
 		$this->dateCreateDate=$pCreateDate;
 	}

 	function getIsActive()
 	{
 		return $this->intIsActive;
 	}
 	function setIsActive($pIsActive)
 	{
 		$this->intIsActive=$pIsActive;
 	}

}


?>