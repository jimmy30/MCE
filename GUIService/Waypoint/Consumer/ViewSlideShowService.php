<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add Slide Show.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Slide Show Table
//require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/SlideShowDAO.php");

class ViewSlideShowService
{
	var $rssUrl;
	var $siteUrl;
	function __construct()
	{
	$objProperties=new Properties();
	$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
	$this->stieUrl=$objProperties->getProperty('site_url');
	$this->rssUrl=$objProperties->getProperty('placecast_rss_url');

	}

	/// LIST WAYPOINT BY PRODUCER ID
	function getSlideShowXML($PlaceCastId)
	{
/*		$filePath=$_SERVER['DOCUMENT_ROOT']."/Contents/PlaceCasts/".$PlaceCastId."/placecast.xml";

		$strXML=null;
		if(file_exists($filePath))
		{
			$handle=fopen($filePath,'r');
			$strXML=fread($handle,filesize($filePath));
			fclose($handle);
		}
	*/	
		$strXML=null;
		$filePath=str_replace("[SITE_URL]",$this->stieUrl,$this->rssUrl);
		$filePath=$filePath."?param=placecastid&value=$PlaceCastId";	
		$xmlDoc = new DOMDocument();
		if($xmlDoc->load($filePath))
		$strXML=$xmlDoc->saveXML();
		return $strXML;
	}	 
	
	function getHtmlContent($Location)
	{
		$filePath=$_SERVER['DOCUMENT_ROOT']."/".$Location;
		
		$strXML=null;
		if(file_exists($filePath))
		{
			$handle=fopen($filePath,'r');
			$strXML=fread($handle,filesize($filePath));
			fclose($handle);
		}
		return $strXML;
	
	}

	/// Mapping functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('getSlideShowXML','getHtmlContent'));

		NAJAX_Client::publicMethods($this, array('getSlideShowXML','getHtmlContent'));
	}

	
}

?>
