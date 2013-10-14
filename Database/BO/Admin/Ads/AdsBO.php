<?php
class AdsBO
{
	var $intAdsId;
	var $strAdsName;
	var $strDescription;
	var $strImage;
	var $dteExpiryDate;
	var $dteCreatedDate;
	var $blnActive;
	var $intGroupId;
	var $intPageId;
	var $strGroupName;
	var $strPageName;
	var $strAdSize;
	var $strSniffet;

	function getAdsId()
	{
		return $this->intAdsId;
	}
	function setAdsId($value)
	{
		$this->intAdsId=$value;	
	}
	function getAdsName()
	{
		return $this->strAdsName;
	}
	function setAdsName($value)
	{
		$this->strAdsName=$value;
	}
	function getAdsDescription()
	{
		return $this->strDescription;
	}
	function setAdsDescription($value)
	{
		$this->strDescription=$value;
	}
	function getImagePath()
	{
		return $this->strImage;
	}
	function setImagePath($value)
	{
		$this->strImage=$value;
	}
	function getExpiryDate()
	{
		return $this->dteExpiryDate;
	}
	function setExpiryDate($value)
	{
		$this->dteExpiryDate=$value;
	}
	function getCreateDate()
	{
		return $this->dteCreatedDate;
	}
	function setCreatedDate($value)
	{
		$this->dteCreatedDate=$value;
	}
	function getActive()
	{
		return $this->blnActive;
	}
	function setActive($value)
	{
		$this->blnActive=$value;
	}
	function getGroupId()
	{
		return $this->intGroupId;
	}
	function setGroupId($value)
	{
		$this->intGroupId=$value;
	}
	function getGroupName()
	{
		return $this->strGroupName;
	}
	function setGroupName($value)
	{
		$this->strGroupName=$value;
	}
	function getPageId()
	{
		return $this->intPageId;
	}
	function setPageId($value)
	{
		$this->intPageId=$value;
	}
	function getPageName()
	{
		return $this->strPageName;
	}
	function setPageName($value)
	{
		$this->strPageName=$value;
	}
	function getAdSize()
	{
		return $this->strAdSize;
	}
	function setAdSize($value)
	{
		$this->strAdSize=$value;
	}
	function getSinffet()
	{
		return $this->strSniffet;
	}
	function setSniffet($value)
	{
		$this->strSniffet=$value;
	}
}

?>
