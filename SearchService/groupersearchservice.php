<?php


class GrouperSearchService
{

var $strAppId;
var $strType;
var $strQuery;
var $arrService;
var $strXml;
var $strUrl;
var $intFirst;
var $intLast;
var $intTotalResult;
var $intTotalResultReturn;
var $strRes;
var $strNewUrl;
var $strFormatXml;
var $intVideoHeight=75;
var $intVideoWidth=75;

	function GrouperSearchService()
	{
		
	}

	
	function getQuery()
	{
		return  $this->strQuery;
	}

	function setQuery($value)
	{
		$this->strQuery=$value;
	}
	
	function getType()
	{
		return $this->strType;
	}	
	
	function setType($value)
	{
		$this->strType=$value;
	}

	
	
	function getTotalResultAvailable()
	{
		return $this->intTotalResult;
	}
	
	function setTotalResultAvailable()
	{
		$this->intTotalResult=$this->strRes[totalResultsAvailable];
	}
	
	function getFirstPosition()
	{
		return $this->intFirst;
	}
	
/*	function setFirstPosition()
	{
		$this->intFirst=$this->strRes['firstResultPosition'];
	}*/
	function setFirstPosition($pIntFirst)
	{
		$this->intFirst=$pIntFirst;
	}
	function getTotalResultReturn()
	{
		return $this->intTotalResultReturn;
	}

	function setTotalResultReturn($value)
	{
		$this->intTotalResultReturn=$value;
	}
	
	function getLastResult()
	{
		return $this->intLast;
	}
	function setLastResult()
	{
			$this->intLast = $this->intFirst + $this->strRes['totalResultsReturned']-1;
	}
	
	function buildQuery($pIntFirstIndex,$pIntNoOfResult)
	{
		
		$this->strUrl="http://www.grouper.com/rss.ashx?s=7&";
		$this->strUrl=$this->strUrl."q=".$this->strQuery."&max=".$pIntNoOfResult;
	    return $this->strUrl;
		
	}

	function getRawXml($pIntFirstIndex,$pIntNoOfResult)
	{
		
		$this->buildQuery($pIntFirstIndex,$pIntNoOfResult);
		try 
		{
			$this->strXml = simplexml_load_file($this->strUrl);
		}
		catch (Exception  $e)
		{
			 throw new GrouperSearchException("Enable to connect Grouper ");
		}

		if (!$this->strXml) 
		{
			throw new GrouperSearchException("Enable to connect grouper");
		}
		
		return $this->strXml;
		
	}

	function displayResult($pIntFirstIndex,$pIntNoOfResult)
	{
		$xml=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
		//var_dump($xml);
		//for($i=0; $i<10; $i++)	
 	//	{
 			
		$Handle = fopen('testall.xml', 'w');
			echo("<br>-----Title--------");
			$temp=$xml->channel->item;
			$temp=$temp->children('http://search.yahoo.com/mrss/');
			echo($temp->player);
			//var_dump($temp);
		  	//foreach($temp->children('http://search.yahoo.com/mrss/')  as $item) 
		  	
  			//{
  			//	echo("<br>");
  			//	echo($temp->player);
  			//	foreach ($xml->children('http://search.yahoo.com/mrss/') as $key); 
  			//	{
  			//		echo($key->description);
  					//var_dump($key->title);
  			//	}
  				
				//$strTemp="<".$key.">".$value['channel']."</".$key.">";
				//echo("<br>");
				//echo($item->link);
				//$strTemp=$xml->channel->item->link;

  				fwrite($Handle,$item->enclosure['url']);
			
			
	
	       //}
	       	fclose($Handle);
		   
    	//}
	}
  	
	function getXml($pIntFirstIndex,$pIntNoOfResult)
	{
	
	}
	
	function getVideoXml($pIntFirstIndex,$pIntNoOfResult)
	{
			$xml=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);		
			$objXmlEncode=new xmlEncode();
		    $this->intTotalResult=0;
			foreach ($xml->channel->item as $items )					 
			{
				$this->strFormatXml=$this->strFormatXml."<Result>";
				$this->strFormatXml=$this->strFormatXml."<Title>".htmlspecialchars($objXmlEncode->xmlCdataEncode($items->title))."</Title>";
				$this->strFormatXml=$this->strFormatXml."<Summary>".htmlspecialchars($objXmlEncode->xmlCdataEncode($items->description))."</Summary>";
				$this->strFormatXml=$this->strFormatXml."<Url>".urlencode($items->link)."</Url>";
				$this->strFormatXml=$this->strFormatXml."<ClickUrl></ClickUrl>";
				$this->strFormatXml=$this->strFormatXml."<RefererUrl></RefererUrl>";
				$this->strFormatXml=$this->strFormatXml."<FileSize></FileSize>";
				$this->strFormatXml=$this->strFormatXml."<FileFormat></FileFormat>";
				$this->strFormatXml=$this->strFormatXml."<Height></Height>";
				$this->strFormatXml=$this->strFormatXml."<Width></Width>";
				$this->strFormatXml=$this->strFormatXml."<Duration></Duration>";
				$this->strFormatXml=$this->strFormatXml."<Streaming></Streaming>";
				$this->strFormatXml=$this->strFormatXml."<Channels></Channels>";
				$newXml=$items->children("http://search.yahoo.com/mrss");
				$att=$newXml->thumbnail->attributes();
				//echo($att);
				$this->strFormatXml=$this->strFormatXml."<Thumbnail>"."img src="."'".urlencode($att)."'"." height='75' width='75'"."</Thumbnail>";
				$this->strFormatXml=$this->strFormatXml."<ThumbnailUrl>".urlencode($att)."</ThumbnailUrl>";
				$this->strFormatXml=$this->strFormatXml."<SearchEngine>Grouper</SearchEngine>";
				$this->strFormatXml=$this->strFormatXml."</Result>";
				$this->intTotalResult++;
			}
			//foreach ( as $items )					 
			//{
			//	$xml->channel->item
			//}
			$temp=$xml->channel->item;
			
			$abc=$temp->thumbnail->children('http://search.yahoo.com/mrss');
			
			echo($abc['url']);
			$this->setTotalResultReturn($this->intTotalResult);
			return $this->strFormatXml;
	}
	
	function writeToFile($strFileName,$pIntFirstIndex,$pIntNoOfResult)
	{
		if (file_exists($strFileName)) 
		{ 
		    $Handle = fopen($strFileName, 'w');
			$strFormatXml=$this->getXml($pIntFirstIndex,$pIntNoOfResult);
			fwrite($Handle,$strFormatXml);
    	    fclose($Handle);
		}
		else
		{
		    $Handle = fopen($strFileName, 'w');
			$strFormatXml=$this->getXml($pIntFirstIndex,$pIntNoOfResult);
			fwrite($Handle,$strFormatXml);
    	    fclose($Handle);
		}
	}
	
	
	

	
}
?>