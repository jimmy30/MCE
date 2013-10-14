<?php

$appId=$_GET['appid'];
$strLocation=$_GET['location'];
$strCity=$_GET['city'];
$strState=$_GET['state'];
$strStreet=$_GET['street'];
$intZipCode=$_GET['zip'];
$objMapService=new clsMapService();
$objMapService->setApplicationId($appId);
$objMapService-> setLoacation($strLocation);
$objMapService->setCity($strCity);
$objMapService->setState($strState);
$objMapService->setStreet($strStreet);
$objMapService->setZipCode($intZipCode);
$strFormatXml=$objMapService->getFormatXml();
echo($strFormatXml);
//echo("helloooo");
class clsMapService
{
	var $strUr;
	var $strAppId;
	var $strLocation;
	var $intZipCode;
	var $strStreet;
	var $strCity;
	var $strState;
	var $strXml;
	var $strFormatString;
	var $strXmlResult;
	var $fltLong;
	var $fltLat;
	var $strResult;
	function getApplicationId()
	{
		return $this->strAppId;
	}
	function setApplicationId($value)
	{
		$this->strAppId=$value;
	}
	function getLocation()
	{
		return $this->strLocation;
	}
	function setLoacation($value)
	{
		$this->strLocation=$value;
	}
	function getZipCode()
	{
		return $this->intZipCode;
	}
	function setZipCode($value)
	{
		$this->intZipCode=$value;
	}
	function getStreet()
	{
		return $this->strStreet;
	}
	function setStreet($value)
	{
		$this->strStreet=$value;
	}
	function getCity()
	{
		return $this->strCity;
	}
	function setCity($value)
	{
		$this->strCity=$value;
	}
	function getState()
	{
		return $this->strState;
	}
	function setState($value)
	{
		$this->strState=$value;
	}
	
	function getUrl($pStrStreet=NULL,$pStrCity=NULL,$pStrState=NULL,$pIntZipCode=NULL,$pStrLocation=NULL)
	{
		$this->strUrl="http://api.local.yahoo.com/MapsService/V1/geocode";
		
		if ($pStrStreet!="" && $pStrCity=="" && $pStrState=="" && $pIntZipCode=="" && $pStrLocation=="")
		{
			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet;

			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity!="" && $pStrState=="" && $pIntZipCode=="" && $pStrLocation=="")
		{
			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."city=".$pStrCity;

			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity=="" && $pStrState!="" && $pIntZipCode=="" && $pStrLocation=="")
		{
			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."state=".$pStrState;

			return $this->strUrl;
		}

		else if ($pStrStreet=="" && $pStrCity=="" && $pStrState=="" && $pIntZipCode!="" && $pstrLocation=="")
		{
			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."zip=".$pIntZipCode;
			
			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity=="" && $pStrState=="" && $pIntZipCode=="" && $pStrLocation!="")
		{
			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."zip=".$pStrLocation;

			return $this->strUrl;
		}
		
		else if ($pStrStreet!="" && $pStrCity!="" && $pStrState=="" && $pIntZipCode=="" && $pStrLocation=="")
		{
			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."city=".$pStrCity;

			return $this->strUrl;
		}
		
		else if ($pStrStreet!="" && $pStrCity=="" && $pStrState!="" && $pIntZipCode=="" && $pStrLocation=="")
		{
			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."state=".$pStrState;

			return $this->strUrl;
		}
		
		else if ($pStrStreet!="" && $pStrCity=="" && $pStrState=="" && $pIntZipCode!="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."zip=".$pIntZipCode;

			return $this->strUrl;
		}
		else if ($pStrStreet!="" && $pStrCity=="" && $pStrState=="" && $pIntZipCode=="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."location=".$pStrLocation;

			return $this->strUrl;
		}
		
		else if ($pStrStreet!="" && $pStrCity!="" && $pStrState!="" && $pIntZipCode=="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."city=".$pStrCity."&"."state=".$pStrState;

			return $this->strUrl;
		}
		else if ($pStrStreet!="" && $pStrCity=="" && $pStrState!="" && $pIntZipCode!="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."state=".$pStrState."&"."zip=".$pIntZipCode;

			return $this->strUrl;
		}

		else if ($pStrStreet!="" && $pStrCity!="" && $pStrState=="" && $pIntZipCode!="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."cit=".$pStrCity."&"."zip=".$pIntZipCode;

			return $this->strUrl;
		}
		
		else if ($pStrStreet!="" && $pStrCity!="" && $pStrState=="" && $pIntZipCode=="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."cit=".$pStrCity."&"."location=".$pStrLocation;

			return $this->strUrl;
		}
		else if ($pStrStreet!="" && $pStrCity=="" && $pStrState!="" && $pIntZipCode=="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."state=".$pStrState."&"."location=".$pStrLocation;

			return $this->strUrl;
		}
		else if ($pStrStreet!="" && $pStrCity=="" && $pStrState=="" && $pIntZipCode!="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."street=".$pStrStreet."&"."zip=".$pIntZipCode."&"."location=".$pStrLocation;

			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity!="" && $pStrState!="" && $pIntZipCode=="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."city=".$pStrCity."&"."state=".$pStrState;

			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity!="" && $pStrState=="" && $pIntZipCode!="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."city=".$pStrCity."&"."zip=".$pIntZipCode;

			return $this->strUrl;
		}
		
		else if ($pStrStreet=="" && $pStrCity!="" && $pStrState=="" && $pIntZipCode=="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."city=".$pStrCity."&"."location=".$pStrLocation;

			return $this->strUrl;
		}

		else if ($pStrStreet=="" && $pStrCity!="" && $pStrState!="" && $pIntZipCode!="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."city=".$pStrCity."&"."state=".$pStrState."&"."zip=".$pIntZipCode;

			return $this->strUrl;
		}

		else if ($pStrStreet=="" && $pStrCity!="" && $pStrState!="" && $pIntZipCode=="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."city=".$pStrCity."&"."state=".$pStrState."&"."location=".$pStrLocation;

			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity!="" && $pStrState=="" && $pIntZipCode!="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."city=".$pStrCity."&"."zip=".$pIntZipCode."&"."location=".$pStrLocation;

			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity=="" && $pStrState!="" && $pIntZipCode!="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."state=".$pStrState."&"."zip=".$pIntZipCode;

			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity=="" && $pStrState!="" && $pIntZipCode=="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."state=".$pStrState."&"."location=".$pStrLocation;

			return $this->strUrl;
		}
		else if ($pStrStreet=="" && $pStrCity=="" && $pStrState!="" && $pIntZipCode!="" && $pStrLocation!="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."state="."&".$pStrState."zip=".pIntZipCode."&"."location=".$pStrLocation;

			return $this->strUrl;
		}
		else if ($pStrStreet!="" && $pStrCity!="" && $pStrState!="" && $pIntZipCode!="" && $pStrLocation=="")
		{

			$this->strUrl=$this->strUrl."?appid=".$this->getApplicationId()."&"."state="."&".$pStrState."zip=".pIntZipCode."&"."location=".$pStrLocation;

			return $this->strUrl;
		}

		
	}
	
	function getXml()
	{
	
		$this->strUrl=$this->getUrl($this->getStreet(),$this->getCity(),$this->getState(),$this->getZipCode(),$this->getLocation());

			//$this->strUrl="http://api.local.yahoo.com/MapsService/V1/geocode?appid=yahoomapapi1234&city=austin"; 
			if($this->strUrl)
			{
	    		$this->strXml = simplexml_load_file($this->strUrl); 			
				return $this->strXml;
			}
		
	}
	function getFormatXml()
	{
		$this->strXmlResult=$this->getResult();
		$this->strFormatXml="<Result>";
		$this->strFormatXml=$this->strFormatXml."<Longitude>".$this->strXmlResult['Longitude']."</Longitude>";
		$this->strFormatXml=$this->strFormatXml."<Latitude>".$this->strXmlResult['Latitude']."</Latitude>";
		$this->strFormatXml=$this->strFormatXml."<Country>".$this->strXmlResult['Country']."</Country>";
		$this->strFormatXml=$this->strFormatXml."<Address>".$this->strXmlResult['Address']."</Address>";
		$this->strFormatXml=$this->strFormatXml."<City>".$this->strXmlResult['City']."</City>";
		$this->strFormatXml=$this->strFormatXml."<ZipCode>".$this->strXmlResult['Zip']."</ZipCode>";
		$this->strFormatXml=$this->strFormatXml."<State>".$this->strXmlResult['State']."</State>";
		$this->strFormatXml=$this->strFormatXml."</Result>";
		return $this->strFormatXml;
	}
	function getResult()
	{
		$this->strXml=$this->getXml();	
		if(!is_object($this->strXml))
		{ 
			return false;
		}
	    $this->strResult['precision'] = (string)$this->strXml->Result['precision'];
		foreach($this->strXml->Result->children() as $key=>$val)
		{
		    if(strlen($val)) $this->strResult[(string)$key] =  (string)$val;
  		} 
	   return $this->strResult;
	}
	
}
?>
