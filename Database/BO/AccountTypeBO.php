<?php 
class AccountTypeBO
{
	var $intAccountTypeId;
	var $strAccountTypeName;		
	var $dateAccountTypeCreateDate;
	var $intAccountTypeIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getAccountTypeId()
 	{
 		return $this->intAccountTypeId;
 	}
 	function setAccountTypeId($pAccountTypeId)
 	{
 		$this->intAccountTypeId=$pAccountTypeId;
 	}
 	
 	function getAccountTypeName()
 	{
 		return $this->strAccountTypeName;
 	}
 	function setAccountTypeName($pAccountTypeName)
 	{
 		$this->strAccountTypeName=$pAccountTypeName;
 	}
 	
 	function getAccountTypeCreateDate()
 	{
 		return $this->dateAccountTypeCreateDate;
 	}
 	function setAccountTypeCreateDate($pAccountTypeCreateDate)
 	{
 		$this->dateAccountTypeCreateDate=$pAccountTypeCreateDate;
 	}

 	function getAccountTypeIsActive()
 	{
 		return $this->intAccountTypeIsActive;
 	}
 	function setAccountTypeIsActive($pAccountTypeIsActive)
 	{
 		$this->intAccountTypeIsActive=$pAccountTypeIsActive;
 	}

}


?>