<?php


class YahooSearchService
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

	function YahooSearchService()
	{
	$this->setServices();
	}

	function getApplicationId()
	{
		return $this->strAppId;
	}
	function setApplicationId($value)
	{

		$this->strAppId=$value;
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

	function setServices()
	{
				 $this->arrService = array('image'=>'http://api.search.yahoo.com/ImageSearchService/V1/imageSearch',
                 'local'=>'http://api.local.yahoo.com/LocalSearchService/V1/localSearch',
                 'news'=>'http://api.search.yahoo.com/NewsSearchService/V1/newsSearch',
                 'video'=>'http://api.search.yahoo.com/VideoSearchService/V1/videoSearch',
                 'web'=>'http://api.search.yahoo.com/WebSearchService/V1/webSearch',
				// 'audio'=>'http://api.search.yahoo.com/AudioSearchService/V1/artistSearch');
				 'audio'=>'http://api.search.yahoo.com/AudioSearchService/V1/podcastSearch');
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

	function setTotalResultReturn()
	{
		$this->intTotalResultReturn=$this->strRes['totalResultsReturned'];
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
		global $appid, $service;
		//$pIntNoOfResult=$pIntNoOfResult-$pIntFirstIndex;
		
		$q = '?query='.$this->strQuery."&start=".$pIntFirstIndex."&results=".$pIntNoOfResult;
		
	    $q .= "&appid=$this->strAppId";
	    $this->strUrl=$q;
		return $q;
	}

	function getRawXml($pIntFirstIndex,$pIntNoOfResult)
	{
		
		$this->setServices();
		$this->buildQuery($pIntFirstIndex,$pIntNoOfResult);
		$this->strNewUrl=$this->arrService[$this->strType].$this->strUrl;
		try 
		{
			$this->strXml = simplexml_load_file($this->arrService[$this->strType].$this->strUrl);
			//!$this->strXml="";
		}
		
		
		catch (Exception  $e)
		{
		
			 throw new YahooSearchException("Enable to connect Yahoo ");
		}
		
		
		if (!$this->strXml) 
		{
			throw new YahooSearchException("Enable to connect Yahoo");
		}
		
		foreach($this->strXml->attributes() as $name=>$attr)
			{
			 $this->strRes[$name]=$attr;
			}
		return $this->strXml;
		
		
	}

	function displayResult($pIntFirstIndex,$pIntNoOfResult)
	{
	$xml=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
		for($i=0; $i<$this->strRes['totalResultsReturned']; $i++)	
 		{

			echo("<table cellspacing=0 cellpading=0 border=0>");
		  	foreach($xml->Result[$i] as $key=>$value) 
  			{
			echo("<tr>");
				switch($key) 
				{
					
			      case 'Thumbnail':
			        echo "<td aligh=right></td><td><div align=justify width=600><img src=\"{$value->Url}\" height=\"{$value->Height}\" width=\"{$value->Width}\" /> </div></td>";
			        break;
			      case 'Cache':
			        echo "<td aligh=right><b>Cache:</b></td><td><div align=justify width=600> <a href=\"{$value->Url}\">{$value->Url}</a> [{$value->Size}]</div></td>";
			        break;
			      case 'PublishDate':
			      case 'ModificationDate':
			        echo "<td align=right><b>$key:</b></td><td width=600>".strftime('%X %x')."</td>";
			        break;
			      default:
			        if(stristr($key,'url')) 
					echo "<td align=left><b>url:</b></td><td><div align=justify width=600><a href=\"$value\">$value</a></div></td>";
					else 
					echo "<td aligh=right><b>$key:</b></td> <td><div align=justify width=600>$value</div></td>";
					break;
			    }
			   echo("</tr>");
	
	       }
		   echo("</table>");
    	}
	}
  	
	function getXml($pIntFirstIndex,$pIntNoOfResult)
	{
	$objXmlEncode=new xmlEncode();
		$this->intTotalResult=$pIntFirstIndex+$pIntNoOfResult;
			$xml=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
			

			
		   $this->strFormatXml=$this->strFormatXml."<YahooSearch>
		   <Query>$this->strQuery</Query>
		   <SearchType>$this->strType</SearchType>
		   <TotalResult>$pIntNoOfResult</TotalResult>
		   <AvailableResult></AvailableResult>
		   <FirstIndex>$pIntFirstIndex</FirstIndex>
		   <EndIndex>$this->intTotalResult</EndIndex>
		   <SearchResults>";
		for($i=0; $i<$this->strRes['totalResultsReturned']; $i++)	
 		{
			$this->strFormatXml=$this->strFormatXml."<Result>";
		  	foreach($xml->Result[$i] as $key=>$value) 
  			{
  				if( ($this->strType=="audio" && $key=="Copyright")  || ($this->strType=="audio" && $key=="SampleSize") ) 
				{
					//TODO-CORECT THIS 
				}
				else 
				{
					if ($key=="Thumbnail") 
					{
						$this->strFormatXml=$this->strFormatXml."<$key>img src='{$value->Url}' height='{$this->intVideoHeight}' width='{$this->intVideoHeight}'</$key>";
						if($this->strType=="video") 
						{
							$this->strFormatXml=$this->strFormatXml."<$key"."Url>{urlencode($value->Url)}</$key"."Url>";
						}
					}
					elseif ($key=="RefererUrl" || $key=="Url" || $key=="ClickUrl")
					{
						$this->strFormatXml=$this->strFormatXml."<$key>".urlencode($value)."</$key>";
					}	
					else
					{
						$this->strFormatXml=$this->strFormatXml."<$key>".$objXmlEncode->xmlCdataEncode($value)."</$key>";
						
					}
				}
	       }
		   $this->strFormatXml=$this->strFormatXml."</Result>";	  		
    	}
		
		$this->strFormatXml=$this->strFormatXml."</SearchResults>";		
		$this->strFormatXml=$this->strFormatXml."</YahooSearch>";
		return $this->strFormatXml;
	}
	
	function getImageXml($pIntFirstIndex,$pIntNoOfResult) 
	{
			$objXmlEncode=new xmlEncode();
			$this->intTotalResult=$pIntFirstIndex+$pIntNoOfResult;
			$xml=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
			//$this->strFormatXml=$this->strFormatXml."<SearchResults>";
		for($i=0; $i<$this->strRes['totalResultsReturned']; $i++)	
 		{
			$this->strFormatXml=$this->strFormatXml."<Result>";
		  	foreach($xml->Result[$i] as $key=>$value) 
  			{
  				
  				if( ($this->strType=="audio" && $key=="Copyright")  || ($this->strType=="audio" && $key=="SampleSize") ) 
				{
					//TODO-CORECT THIS 
				}
  				else 
  				{
					if ($key=="Thumbnail") 
					{
						$this->strFormatXml=$this->strFormatXml."<$key>img src='{$value->Url}' height='{$this->intVideoHeight}' width='{$this->intVideoHeight}'</$key>";
						if($this->strType=="video") 
						{
							$this->strFormatXml=$this->strFormatXml."<$key"."Url>".urlencode($value->Url)."</$key"."Url>";
						}
					}
					elseif ($key=="RefererUrl" || $key=="Url" || $key=="ClickUrl")
					{
						$this->strFormatXml=$this->strFormatXml."<$key>".urlencode($value)."</$key>";
					}	
					else
					{
						$this->strFormatXml=$this->strFormatXml."<$key>".$objXmlEncode->xmlCdataEncode($value)."</$key>";
						
					}
  				}
	       }
		  	$this->strFormatXml=$this->strFormatXml."<SearchEngine>Yahoo</SearchEngine>";
		   $this->strFormatXml=$this->strFormatXml."</Result>";	  		
    	}
		
		//$this->strFormatXml=$this->strFormatXml."</SearchResults>";		
		//$this->strFormatXml=$this->strFormatXml."<YahooSearch></YahooSearch>";
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
	
	
	function nextPrev($strRes, $intStart, $intLast)
	{
	  if($intStart > 1)
    	echo '<a href="'.$_SERVER['PHP_SELF'].
                   '?query='.rawurlencode($_REQUEST['query']).
                   '&type='.rawurlencode($_REQUEST['type']).
				   '&search='.rawurlencode($_REQUEST['search']).
                   '&start='.($intStart-10).'">Previous Page </a>&nbsp | &nbsp; ';
	  if($intLast < $this->strRes['totalResultsAvailable'])
	    echo '<a href="'.$_SERVER['PHP_SELF'].
                   '?query='.rawurlencode($_REQUEST['query']).
                   '&type='.rawurlencode($_REQUEST['type']).
				   '&search='.rawurlencode($_REQUEST['search']).
                   '&start='.($intLast+1).'">Next Page</a>';
	}

	function done()
	 {
		  echo '</body></html>';
		  exit;
	}

}
?>