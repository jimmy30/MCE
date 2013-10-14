<?php
class AdsGroupBO
{
	var $intAdsGroupId;
	var $intAdsId;
	var $intGroupId;
	
	function getAdsId()
	{
		return $this->intAdsId;
	}
	function setAdsId($value)
	{
		$this->intAdsId=$value;	
	}
	function getGroupId()
	{
		return $this->intGroupId;
	}
	function setGroupId($value)
	{
		$this->intGroupId=$value;
	}
}
?>