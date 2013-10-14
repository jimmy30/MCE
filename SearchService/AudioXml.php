<?php 
require_once 'AudiosearchService.php';
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
$strSearchType="audio";

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
	$objAudioService=new AudioSearchService();
	$objAudioService->setSearch($strYahoo,$strMsn,$strGoogle,$strFlickr);
	$objAudioService->setType($strSearchType);
	$objAudioService->setQuery($strQuery);
	$strFormatXml=$objAudioService->getXml($intStartIndex,$intNoOfResults);
}
catch(Exception $e)
{
	LogEntry($e->getMessage() ."\n". $e->getTraceAsString(),FILE|DEBUG);	
}


$Handle = fopen('Audio.xml', 'w');
fwrite($Handle,$strFormatXml);
fclose($Handle);


echo($strFormatXml);


/*
<YahooSearch>
	<Query>jackson</Query>
	<SearchType>audio</SearchType>
	<TotalResult>7</TotalResult>
	<AvailableResult></AvailableResult>
	<FirstIndex>1</FirstIndex>
	<EndIndex>11</EndIndex>
		   
	<Result>
	  	<Title>Monte interviews Ron Jackson of Internet Edge Inc.</Title>
		<Summary>Monte welcomes Ron Jackson to the show. Ron is currently the President of Internet Edge, Inc., a web publishing company he founded in 2000. Ron began as a radio/TV broadcaster in the late 60's and spent the next 20 years in that profession (most of it as a TV sportscaster in Floridas beautiful Tampa Bay area). In the late 80s he moved into the music business by opening the first in a chain of record stores that operated until 2000. After opening a website for the music business in 1997, he became fascinated with the boundless potential of the internet and by 2000 had decided opportunities on the web were so exciting that he wanted to spend all his time pursuing them. WebmasterRadio.FM podcast of all archived shows</Summary>
		<Url>http%3A%2F%2Fwww.webmasterradio.fm%2Fepisodes%2Faudio%2F2005%2FDM122805.mp3</Url>
		<ClickUrl>http%3A%2F%2Fwww.webmasterradio.fm%2Fepisodes%2Faudio%2F2005%2FDM122805.mp3</ClickUrl>
		<RefererUrl>http%3A%2F%2Ffeeds.feedburner.com%2Fwmrpodcast%3Fm%3D296</RefererUrl>
		<FileSize>60364928</FileSize>
		<FileFormat>mp3</FileFormat>
		<Duration>3772</Duration>
		<Channels>2</Channels>
		<Streaming>false</Streaming>
		<Copyright>WebmasterRadio.FM</Copyright>
	</Result>

	<Result>
		<Title>Bill Jackson (Cree) Part 1</Title>
		<Summary>Bill is a Cree from northern Alberta. He was born and raised in the Whitefish Lake Cree Nation. Bill talks candidly about his faith in Jesus and then goes on to tell the story of how he came to an awareness that he had a spiritual need. The Storyteller is a 15-minute weekly radio program and internet broadcast featuring true stories from First Nations people across North America who are following Jesus Christ without reservation. Don't be fooled, this is not some religious, feel good program. This is real life. It's raw, direct and personal. If you're tired of trying to figure out who we really are, or wonder if there really is hope for something better, you may want to listen to some folks who understand. The Storyteller is heard in 150 communities in Canada and the US.</Summary>
		<Url>http%3A%2F%2Fmedia.gospelcom.net%2Fwr%2Flow%2F081-BillJackson-1.mp3</Url>
		<ClickUrl>http%3A%2F%2Fmedia.gospelcom.net%2Fwr%2Flow%2F081-BillJackson-1.mp3</ClickUrl>
		<RefererUrl>http%3A%2F%2Fwww.withoutreservation.com</RefererUrl>
		<FileSize>3492362</FileSize>
		<FileFormat>mp3</FileFormat>
		<Duration>873</Duration>
		<SampleSize>16</SampleSize>
		<Channels>2</Channels>
		<Streaming>false</Streaming>
		<Copyright>2006 Without Reservation</Copyright>
	</Result>
		
	<Result>
		<Title>AOL's Sports Bloggers Live - Reggie Jackson, MLB, NFL Week 2 Recap...</Title>
		<Summary>Reggie Jackson discusses the Yanks, Red Sox, Bonds, 'Naked Gun' while MLB Insider Will Carroll breaks down the playoff push. Sports Illustrated's Jeffri Chadiha and Pigskin Bloggers on the NFL, The Sporting News' NASCAR writer Matt Crossman and bloggers Scottish and the Dude on The Chase. The World's First Interactive, Sports Talk Bloggers Show.  One Small Step For Blogs. One Giant Leap for Blog Kind! </Summary>
		<Url>http%3A%2F%2Fsportsbloggerslive.podcast.aol.com%2Fsbl_podcast091905.mp3</Url>
		<ClickUrl>http%3A%2F%2Fsportsbloggerslive.podcast.aol.com%2Fsbl_podcast091905.mp3</ClickUrl>
		<RefererUrl>http%3A%2F%2Fwww.sportsbloggerslive.com%2F</RefererUrl>
		<FileSize>53132127</FileSize>
		<FileFormat>mp3</FileFormat>
		<Duration>3794</Duration>
		<Channels>1</Channels>
		<Streaming>false</Streaming>
		<Copyright>AOL Sports</Copyright>
	</Result>
	
	<Result>
		<Title>Monte chats with Heidi Richards from the Women's Ecommerce Assoc...</Title>
		<Summary>Monte chats with Heidi Richards from the Women's Ecommerce Assoc.   Ron Jackson from DNJournal. The Womens ECommerce Association International is a not-for-profit, professional organization for individuals with an interest in doing business on the WEB. WECAI.org is dedicated to the advancement of women in business, industry, education and science. Domain Name Journal is an Internet Edge, Inc. company. Internet Edge, Inc. is a Florida corporation involved in web publishing and domain monetization through several subsidiary companies, including IdealRegistry.com, ThinkDomains.com, and NewNames.biz/info/us. This is all about learning how to be the master of your domain....legal rights, domain name monetization, ask questions live from the pro\'s....all right here on DomainMasters!</Summary>
		<Url>http%3A%2F%2Fwww.webmasterradio.fm%2Fepisodes%2Faudio%2F2005%2FDM092805.mp3</Url>
		<ClickUrl>http%3A%2F%2Fwww.webmasterradio.fm%2Fepisodes%2Faudio%2F2005%2FDM092805.mp3</ClickUrl>
		<RefererUrl>http%3A%2F%2Ffeeds.feedburner.com%2Fdomainmasters%3Fm%3D64</RefererUrl>
		<FileSize>55161793</FileSize>
		<FileFormat>mp3</FileFormat>
		<Duration>3447</Duration>
		<Channels>1</Channels>
		<Streaming>false</Streaming>
		<Copyright>WebmasterRadio.FM</Copyright>
	</Result>
	
	
	<Result>
		<Title>ANDREW JACKSON: HIS LIFE AND TIMES</Title>
		<Summary>Guest: H. W. Brands, Professor of History at the University of Texas at Austin An intelligent interview program on current affairs hosted by David Inge</Summary>
		<Url>http%3A%2F%2Fwww.will.uiuc.edu%2Fwillmp3%2Ffocus051012b.mp3</Url>
		<ClickUrl>http%3A%2F%2Fwww.will.uiuc.edu%2Fwillmp3%2Ffocus051012b.mp3</ClickUrl>
		<RefererUrl>http%3A%2F%2Fwill.uiuc.edu%2Fam%2Ffocus</RefererUrl>
		<FileSize>25124826</FileSize>
		<FileFormat>mp3</FileFormat>
		<Duration>3140</Duration>
		<Channels>1</Channels>
		<Streaming>false</Streaming>
		<Copyright>Copyright 2005</Copyright>
	</Result>
		
	<Result>
		<Title>Andy Grace podcast - Michael Jackson free at last</Title>
		<Summary>Jacko beats 'The Heat' and Australian State of Origin football fun. Australian podcast</Summary>
		<Url>http%3A%2F%2Fandygrace.com%2Fpodcast%2F2005%2F06%2F15junepodcast.mp3</Url>
		<ClickUrl>http%3A%2F%2Fandygrace.com%2Fpodcast%2F2005%2F06%2F15junepodcast.mp3</ClickUrl>
		<RefererUrl>http%3A%2F%2Fwww.andygrace.com%2Fpodcast%2F2005%2F06%2F15junepodcast.mp3</RefererUrl>
		<FileSize>3151464</FileSize>
		<FileFormat>mp3</FileFormat>
		<Duration>525</Duration>
		<Channels>1</Channels>
		<Streaming>false</Streaming>
	</Result>

	<Result>
		<Title>The Brothers At Play Podcast #6</Title>
		<Summary>Mike Jackson got off, Batman Beyond (Donte got in trouble for going), our home networking projects, old BAP tv shows coming online soon The Brothers At Play Podcast is our bi-monthly audio version of our web magazine.</Summary>
		<Url>http%3A%2F%2Fwww.brothersatplay.com%2Fradio%2FBAP-2005-06-20.mp3</Url>
		<ClickUrl>http%3A%2F%2Fwww.brothersatplay.com%2Fradio%2FBAP-2005-06-20.mp3</ClickUrl>
		<RefererUrl>http%3A%2F%2F2Guys2Cities.Blogspot.com</RefererUrl>
		<FileSize>29920216</FileSize>
		<FileFormat>mp3</FileFormat>
		<Duration>3736</Duration>
		<Channels>1</Channels>
		<Streaming>false</Streaming>
		<Copyright>Copyright - 2005 Brothers At Play, LLP</Copyright>
	</Result>
	
	
	</YahooSearch>
	
*/


?>




