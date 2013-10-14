<?php 
require_once ('VideosearchService.php');
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
$strGrouper="";

$strQuery=$_GET["Query"];
$intStartIndex=$_GET["StartIndex"];
$intNoOfResults=$_GET["NoOfResults"];
$strSearchEngines=$_GET["SearchEngines"];
$strSearchType="video";

/*
$strQuery="india";
$intStartIndex="1";
$intNoOfResults="10";
$strSearchEngines="GOOGLE";
$strSearchType="video";*/


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
	$strFlickr="";	
}
else 
{
	$strFlickr="";	
}

if(isSearchEngineExists($strSearchEngines,"GROUPER")==true)
{
	$strGrouper="grouper";	
}
else 
{
	$strGrouper="";	
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
	$objVideoService=new VideoSearchService();
	$objVideoService->setSearch($strYahoo,$strMsn,$strGoogle,$strGrouper,$strFlickr);
	$objVideoService->setType($strSearchType);
	$objVideoService->setQuery($strQuery);
	$strFormatXml=$objVideoService->getXml($intStartIndex,$intNoOfResults);
	
	$Handle = fopen('Video.xml', 'w');
	fwrite($Handle,$strFormatXml);
	fclose($Handle);
	
	echo($strFormatXml);

}
catch(Exception $e)	
{
	LogEntry($e->getMessage() ."\n". $e->getTraceAsString(),FILE|DEBUG);	
}

/*
$strXml='<?xml version="1.0" encoding="iso-8859-1"?>';

$strXml=$strXml."<YahooSearch>";
//	<Query>"http://api.search.yahoo.com/VideoSearchService/V1/videoSearch?query=Pakistan&appid=abc-def-ijk"</Query>
$strXml=$strXml."<SearchType>video</SearchType>";
$strXml=$strXml."<TotalResult>4</TotalResult>";
$strXml=$strXml."<AvailableResult>191</AvailableResult>";
$strXml=$strXml."<FirstIndex>1</FirstIndex>";
$strXml=$strXml."<EndIndex>3</EndIndex>";

$strXml=$strXml."<SearchResults>";	

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>cricket by juventus pakistan cricket by juventus pakistan</Title>";
$strXml=$strXml."<Summary>Friday, April 14, 2006 Views: 6 Shared by : juventus_pakistan </Summary>";
$strXml=$strXml."<Url>http://www.un.org/webcast/sc030214pak.ram</Url>";
$strXml=$strXml."<ClickUrl>http://media01.grouper.com/2/0i/r6/kk7i_-j_preview.asf</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://grouper.com/GlobalMedia/MediaDetails.aspx?id=682805</RefererUrl>";
$strXml=$strXml."<FileSize>272588</FileSize>";
$strXml=$strXml."<FileFormat>msmedia</FileFormat>";
$strXml=$strXml."<Height>320</Height>";
$strXml=$strXml."<Width>240</Width>";
$strXml=$strXml."<Duration>8</Duration>";
$strXml=$strXml."<Streaming>false</Streaming>";
$strXml=$strXml."<Channels>2</Channels>";
$strXml=$strXml."<Thumbnail> img src=http://mud.mm-da.yimg.com/image/1648393117 height=75 width=75 </Thumbnail>";
$strXml=$strXml."<ThumbnailUrl>http://mud.mm-da.yimg.com/image/1648393117</ThumbnailUrl>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Presented by Juventus pakistan Presented by Juventus pakistan...</Title>";
$strXml=$strXml."<Summary>Friday, April 14, 2006 Views: 7 Shared by : juventus_pakistan </Summary>";
$strXml=$strXml."<Url>http://media01.grouper.com/2/si/n6/kk7i_-b_preview.asf</Url>";
$strXml=$strXml."<ClickUrl>http://media01.grouper.com/2/si/n6/kk7i_-b_preview.asf</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://grouper.com/GlobalMedia/MediaDetails.aspx?id=682744</RefererUrl>";
$strXml=$strXml."<FileSize>272588</FileSize><FileFormat>msmedia</FileFormat>";
$strXml=$strXml."<Height>320</Height>";
$strXml=$strXml."<Width>240</Width>";
$strXml=$strXml."<Duration>8</Duration>";
$strXml=$strXml."<Streaming>false</Streaming>";
$strXml=$strXml."<Channels>2</Channels>";
$strXml=$strXml."<Thumbnail>img src=http://mud.mm-da.yimg.com/image/1648848507 height=75 width=75 </Thumbnail>";
$strXml=$strXml."<ThumbnailUrl>http://mud.mm-da.yimg.com/image/1648848507</ThumbnailUrl>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Presented Juventus pakistan Presented Juventus pakistan</Title>";
$strXml=$strXml."<Summary>Friday, April 14, 2006 Views: 1 Shared by : juventus_pakistan </Summary>";
$strXml=$strXml."<Url>http://media01.grouper.com/2/hi/r6/kk7i_-e_preview.asf</Url>";
$strXml=$strXml."<ClickUrl>http://media01.grouper.com/2/hi/r6/kk7i_-e_preview.asf</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://grouper.com/GlobalMedia/MediaDetails.aspx?id=682758</RefererUrl>";
$strXml=$strXml."<FileSize>258142</FileSize><FileFormat>msmedia</FileFormat>";
$strXml=$strXml."<Height>320</Height>";
$strXml=$strXml."<Width>240</Width>";
$strXml=$strXml."<Duration>7</Duration>";
$strXml=$strXml."<Streaming>false</Streaming>";
$strXml=$strXml."<Channels>2</Channels>";
$strXml=$strXml."<Thumbnail>img src=http://mud.mm-da.yimg.com/image/1648404493 height=75 width=75</Thumbnail>";
$strXml=$strXml."<ThumbnailUrl>http://mud.mm-da.yimg.com/image/1648404493</ThumbnailUrl>";
$strXml=$strXml."</Result>";

$strXml=$strXml."<Result>";
$strXml=$strXml."<Title>Presented Juventus pakistan Presented Juventus pakistan</Title>";
$strXml=$strXml."<Summary>Friday, April 14, 2006 Views: 4 Shared by : juventus_pakistan </Summary>";
$strXml=$strXml."<Url>http://media01.grouper.com/2/qi/r6/kk7i_-f_preview.asf</Url>";
$strXml=$strXml."<ClickUrl>http://media01.grouper.com/2/qi/r6/kk7i_-f_preview.asf</ClickUrl>";
$strXml=$strXml."<RefererUrl>http://grouper.com/GlobalMedia/MediaDetails.aspx?id=682760</RefererUrl>";
$strXml=$strXml."<FileSize>206152</FileSize>";
$strXml=$strXml."<FileFormat>msmedia</FileFormat>";
$strXml=$strXml."<Height>320</Height>";
$strXml=$strXml."<Width>240</Width>";
$strXml=$strXml."<Duration>6</Duration>";
$strXml=$strXml."<Streaming>false</Streaming>";
$strXml=$strXml."<Channels>2</Channels>";
$strXml=$strXml."<Thumbnail>img src=http://mud.mm-da.yimg.com/image/1648390275 height=75 width=75</Thumbnail>";
$strXml=$strXml."<ThumbnailUrl>http://mud.mm-da.yimg.com/image/1648390275</ThumbnailUrl>";
$strXml=$strXml."</Result>";

$strXml=$strXml."</SearchResults>";	

$strXml=$strXml."</YahooSearch>";

echo($strXml);


//$Handle=fopen("my.xml","w");
//fwrite($Handle,$strXml);

*/
?>

 