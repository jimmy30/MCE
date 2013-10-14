<?php

require_once('TextsearchService.php');

require_once("../Utilities/ErrorHandler.inc");
require_once('../Utilities/Utilities.php');
require_once("../Exceptions/SearchServices/YahooSearchException.php");
require_once("../Exceptions/SearchServices/GoogleSearchException.php");
require_once("../Exceptions/SearchServices/MsnSearchException.php");
require_once("../Exceptions/SearchServices/FlickrSearchException.php");
require_once("../Utilities/XmlEncode.php");



$strYahoo="";
$strMsn="";
$strGoogle="";
$strFlickr="";


$strQuery=$_GET["Query"];
$intStartIndex=$_GET["StartIndex"];
$intNoOfResults=$_GET["NoOfResults"];
$strSearchEngines=$_GET["SearchEngines"];
$strSearchType="web";
/*
$strQuery='pakistan';
$intStartIndex=1;
$intNoOfResults=10;
$strSearchEngines='GOOGLE';
$strSearchType="web";
*/
if(isSearchEngineExists($strSearchEngines,"YAHOO")==true)
{
	$strYahoo="yahoo";	
}
else 
{
	$strYahoo="";	
	
}
if(isSearchEngineExists($strSearchEngines,"MSN")==true)
{
	$strMsn="msn";	
}
else 
{
	$strMsn="";	
	
}

if(isSearchEngineExists($strSearchEngines,"GOOGLE")==true)
{
	$strGoogle="google";	

}
else 
{
	$strGoogle="";	
}

if(isSearchEngineExists($strSearchEngines,"FLICKR")==true)
{
	$strFlickr="flickr";	
}
else 
{
	$strFlickr="";	
}


try 
{
	//return $strGoogle;
	$objTextService=new TextSearchService();
	$objTextService->setSearch($strYahoo,$strMsn,$strGoogle,$strFlickr);
	$objTextService->setType($strSearchType);
	$objTextService->setQuery($strQuery);
	$strFormatXml=$objTextService->getXml($intStartIndex,$intNoOfResults);
	
	$Handle = fopen('text.xml', 'w');
	fwrite($Handle,$strFormatXml);
	fclose($Handle);
	

	echo($strFormatXml);

}
catch(Exception $e )
{
	LogEntry($e->getMessage() ."\n". $e->getTraceAsString(),FILE|DEBUG);	
}
?>