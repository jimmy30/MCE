<?php 
class CellularProviderBO
{
	var $intCellularId;
	var $intCellularCode;		
	var $strCellularProvider;
	var $strEmail;			
	var $dteCreatedDate;
	var $intIsActive;
	
							
 	function __construct()
 	{
		 		
 	}
	
 	
 	function getCellularId()
 	{
 		return $this->intCellularId;
 	}
 	function setCellularId($pIntCellularId)
 	{
 		$this->intCellularId=$pIntCellularId;
 	}

 	function getCellularCode()
 	{
 		return $this->intCellularCode;
 	}
 	function setCellularCode($pIntCellularCode)
 	{
 		$this->intCellularCode=$pIntCellularCode;
 	}
 	
 	function getCellularProvider()
 	{
 		return $this->strCellularProvider;
 	}
 	function setCellularProvider($pStrCellularProvider)
 	{
 		$this->strCellularProvider=$pStrCellularProvider;
 	}

 	function getEmail()
 	{
 		return $this->strEmail;
 	}
 	function setEmail($pStrEmail)
 	{
 		$this->strEmail=$pStrEmail;
 	}
	function getCreatedDate()
	{
		return $this->dteCreatedDate;
	}
	function setCreatedDate($pDteCreatedDate)
	{
		$this->strCreatedDate=$pDteCreatedDate;
	}
	function getIsActive()
	{
		return $this->intIsActive;
	}
	function setIsActive($pIntIsActive)
	{
		$this->intIsActive=$pIntIsActive;
	}

}


?>