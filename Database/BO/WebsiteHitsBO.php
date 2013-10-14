<?php 
class WebsiteHitsBO
{
	var $intHitsId;
	var $strSessionId;		
	var $strCleintIP;
	var $dateWebsiteHitsCreateDate;
	var $intWebsiteHitsIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getHitsId()
 	{
 		return $this->intHitsId;
 	}
 	function setHitsId($pHitsId)
 	{
 		$this->intHitsId=$pHitsId;
 	}
 	
 	function getSessionId()
 	{
 		return $this->strSessionId;
 	}
 	function setSessionId($pSessionId)
 	{
 		$this->strSessionId=$pSessionId;
 	}

 	function getCleintIP()
 	{
 		return $this->strCleintIP;
 	}
 	function setCleintIP($pCleintIP)
 	{
 		$this->strCleintIP=$pCleintIP;
 	}

 	
 	function getWebsiteHitsCreateDate()
 	{
 		return $this->dateWebsiteHitsCreateDate;
 	}
 	function setWebsiteHitsCreateDate($pWebsiteHitsCreateDate)
 	{
 		$this->dateWebsiteHitsCreateDate=$pWebsiteHitsCreateDate;
 	}

 	function getWebsiteHitsIsActive()
 	{
 		return $this->intWebsiteHitsIsActive;
 	}
 	function setWebsiteHitsIsActive($pWebsiteHitsIsActive)
 	{
 		$this->intWebsiteHitsIsActive=$pWebsiteHitsIsActive;
 	}

}


?>