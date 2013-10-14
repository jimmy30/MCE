<?php 
require_once('ImagesearchService.php');
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
$intNoOfResults=$_GET["NoOfResults"];
$strSearchEngines=$_GET["SearchEngines"];
$strSearchType="image";

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
	//$strMsn="";	
}
else 
{
	$strMsn="";	
	
}

if(isSearchEngineExists($strSearchEngines,"GOOGLE")==true)
{
	$strGoogle="google";	
	//$strGoogle="";	
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
	$objImageService=new ImageSearchService();
	$objImageService->setSearch($strYahoo,$strMsn,$strGoogle,$strFlickr);
	$objImageService->setType($strSearchType);
	$objImageService->setQuery($strQuery);
	$strFormatXml=$objImageService->getXml($intStartIndex,$intNoOfResults);

	$Handle = fopen('testall.xml', 'w');
	fwrite($Handle,$strFormatXml);
	fclose($Handle);

	echo($strFormatXml);
}
catch (Exception $e)
{
	
	LogEntry($e->getMessage() ."\n". $e->getTraceAsString(),FILE|DEBUG);	
}

/*
$strXml='<?xml version="1.0" encoding="iso-8859-1"?>';
$strXml=$strXml."<YahooSearch>";
	//<!--<Query>http://api.search.yahoo.com/ImageSearchService/V1/imageSearch?query=Pakistan&appid=abc-def-ijk</Query>-->
$strXml=$strXml."<SearchType>image</SearchType>";
$strXml=$strXml."<TotalResult>12</TotalResult>";
$strXml=$strXml."<AvailableResult>695750</AvailableResult>";
$strXml=$strXml."<FirstIndex>1</FirstIndex>";
$strXml=$strXml."<EndIndex>11</EndIndex>";

$strXml=$strXml."<SearchResults>";	
$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 047.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 047</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20047.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20047.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>58479</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>160_pakistan_flag.jpg</Title>";
$strXml=$strXml."<Summary></Summary>";
$strXml=$strXml."<Url>http://www.ctv.ca/archives/CTVNews/images/20040729/pakistan_iraq_040729/160_pakistan_flag.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://www.ctv.ca/archives/CTVNews/images/20040729/pakistan_iraq_040729/160_pakistan_flag.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl></RefererUrl>";
$strXml=$strXml."<FileSize>6187</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>120</Height>";
$strXml=$strXml."<Width>160</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>p4pakistan-child-injured.jpg</Title>";
$strXml=$strXml."<Summary></Summary>";
$strXml=$strXml."<Url>http://www.persecution.org/concern/2001/12/p4pakistan-child-injured.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://www.persecution.org/concern/2001/12/p4pakistan-child-injured.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.persecution.org/concern/2001/12/p4.html</RefererUrl>";
$strXml=$strXml."<FileSize>15365</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>167</Height>";
$strXml=$strXml."<Width>250</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";


$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";


$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";


$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Pakistan 038.jpg</Title>";
$strXml=$strXml."<Summary>Pakistan 038</Summary>";
$strXml=$strXml."<Url>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</Url>";
$strXml=$strXml."<ClickUrl>http://mch3w.ch.man.ac.uk/theory/staff/student/mbdtszt/pak_pics/Pakistan%20038.jpg</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://www.sitebelt.com/search/Pakistan.html</RefererUrl>";
$strXml=$strXml."<FileSize>49775</FileSize>";
$strXml=$strXml."<FileFormat>jpeg</FileFormat>";
$strXml=$strXml."<Height>480</Height>";
$strXml=$strXml."<Width>640</Width>";
$strXml=$strXml."<Thumbnail></Thumbnail>";
$strXml=$strXml."</Result>";


$strXml=$strXml."</SearchResults>";	

$strXml=$strXml."</YahooSearch>";

//$fp = fopen("my.xml","a");
//fwrite ($fp,$strXml);
//fclose($fp);
echo($strXml);
*/
?>

 