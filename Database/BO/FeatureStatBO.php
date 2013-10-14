<?php 
class FeatureStatBO
{
	var $intStatId;
	var $intUserType;		
	var $strPageTile;
	var $strPageUrl;
	var $intHits;
	var $dateFeatureStatCreateDate;
	var $intFeatureStatIsActive;			
							
 	function __construct()
 	{
		 		
 	}
	
 	function getStatId()
 	{
 		return $this->intStatId;
 	}
 	function setStatId($pStatId)
 	{
 		$this->intStatId=$pStatId;
 	}
 	
 	function getUserType()
 	{
 		return $this->intUserType;
 	}
 	function setUserType($pUserType)
 	{
 		$this->intUserType=$pUserType;
 	}

 	function getPageTile()
 	{
 		return $this->strPageTile;
 	}
 	function setPageTile($pPageTile)
 	{
 		$this->strPageTile=$pPageTile;
 	}

 	function getPageUrl()
 	{
 		return $this->strPageUrl;
 	}
 	function setPageUrl($pPageUrl)
 	{
 		$this->strPageUrl=$pPageUrl;
 	}

 	function getHits()
 	{
 		return $this->intHits;
 	}
 	function setHits($pHits)
 	{
 		$this->intHits=$pHits;
 	}
 	
 	function getFeatureStatCreateDate()
 	{
 		return $this->dateFeatureStatCreateDate;
 	}
 	function setFeatureStatCreateDate($pFeatureStatCreateDate)
 	{
 		$this->dateFeatureStatCreateDate=$pFeatureStatCreateDate;
 	}

 	function getFeatureStatIsActive()
 	{
 		return $this->intFeatureStatIsActive;
 	}
 	function setFeatureStatIsActive($pFeatureStatIsActive)
 	{
 		$this->intFeatureStatIsActive=$pFeatureStatIsActive;
 	}

}


?>