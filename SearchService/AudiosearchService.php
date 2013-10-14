<?php
require_once('yahoosearchservice.php');
require_once('googlesearchservice.php'); 
require_once("msnsearchservice.php");

class AudioSearchService
{

var $strSearch;	
var $strType;
var $strQuery;
var $strYahoo;
var $strMsn;
var $strGoogle;
var $strXmlYahoo;
var $strXmlGoogle;
var $strXmlMsn;
var $strFlickr;
var $intGoogleTotalResult;
var $intGoogleResult;
var $intResult;
var $intResultReturn;
var $intTotalResult;
var $intMsnResult;
	function setSearch($pStrYahoo=NULL,$pStrMsn=NULL,$pStrGoogle=NULL,$pStrFlickr=NULL)
	{
		$this->strYahoo=$pStrYahoo;
		$this->strMsn=$pStrMsn;
		$this->strGoogle=$pStrGoogle;
		$this->strFlickr=$pStrFlickr;
		
	}
	function getSearch()
	{
		return $this->strSearch;
	}
	function setType($value)
	{
		$this->strType=$value;
	}
	function getType()
	{
		return $this->strType;
	}
	function setQuery($value)
	{
		$this->strQuery=$value;
	}
	function getQuery()
	{
		return $this->strQuery;
	}
	function getYahooXml($pIntFirstIndex,$pIntNoOfResult)
	{

		try
		{
			$objYahooSearch=new YahooSearchService();
			$objYahooSearch->setType($this->getType());
			$objYahooSearch->setQuery($this->getQuery());
			$objYahooSearch->setApplicationId('abc-def-ijk');
			$this->strXmlYahoo=$objYahooSearch->getImageXml($pIntFirstIndex,$pIntNoOfResult);
			$objYahooSearch->setLastResult();
			$this->intTotalResult=$objYahooSearch->getLastResult();
			return $this->strXmlYahoo;
		}
		catch (Exception $e)
		{
			
			throw  new YahooSearchException("Yahoo : No record found ");
		}
	}
	
	function getGoogleXml($pIntFirstIndex,$pIntNoOfResult)
	{
		
		try
		{
			$objGoogleSearch=new GoogleSearchService();
			$objGoogleSearch->setKey('eUG8Y9ZQFHLk7RmbvzxNKv17h3XCxGoI');
			$objGoogleSearch->setSoapClient();
			$objGoogleSearch->setType($this->getType());
			$strNewQuery=$this->getQuery();
			$strNewType=$this->getType();
			$strNewQuery=$strNewQuery.'+'.$strNewType;
			$objGoogleSearch->setQuery($strNewQuery);
			$objGoogleSearch->setStart();
			$this->strXmlGoogle=$objGoogleSearch->getVideoXml($pIntFirstIndex,$pIntNoOfResult);
			$this->intGoogleResult=$objGoogleSearch->intReturnResult;
			return $this->strXmlGoogle;
			
		}
		catch (Exception $e)
		{
			
			throw  new GoogleSearchException("Google : No record found ");
		}
	}
	function getMsnXml($pIntFirstIndex,$pIntNoOfResult)
	{
	
		try
		{
			$objMsnSearch=new MSNWebSearch();
			$objMsnSearch->setApiKey('DEB8C9D66FB593A66F36B6D41E98983B49F94E64');
			$objMsnSearch->setNewQuery($this->getQuery());
			$strNewQuery=$this->getQuery();
			$strNewType=$this->getType();
			$strNewQuery=$strNewQuery.'+'.$strNewType;
			$objMsnSearch->setQuery($strNewQuery);
			$objMsnSearch->setType($this->getType());
			$objMsnSearch->setSearch($strSearch);
			$objMsnSearch->setRecordsPerPage(10);
			$currentPage = 1;
			$objMsnSearch->setPage($currentPage);
			$this->strXmlMsn=$objMsnSearch->getAudioXml($pIntFirstIndex,$pIntNoOfResult);
			$this->intMsnResult=$objMsnSearch->intReturnResult;
			return $this->strXmlMsn;
			
		}
		catch (Exception $e)
		{
			
			throw  new MsnSearchException("Msn : No record found ");
		}
	}
	
	function getTotalResult($pIntFirstIndex,$pIntNoOfResult)
	{
		
		if ($pIntFirstIndex>800)
		{
					
					$pIntNoOfResult=$this->intTotalResult;
					
					if ($pIntNoOfResult>$pIntFirstIndex) 
					{
						$this->intResultReturn=$pIntNoOfResult-(--$pIntFirstIndex);
					
					}
					else 
					{
						
						$this->intResultReturn=$pIntFirstIndex-$pIntNoOfResult;
					}
		}
		elseif($pIntFirstIndex>$pIntNoOfResult) 
		{
					$this->intResultReturn=$this->intResult-$pIntFirstIndex;
		}
		else 
		{
			$this->intResultReturn=$this->intResult-($pIntFirstIndex);
		}
		return $this->intResultReturn;
	}
	
	function getXml($pIntFirstIndex,$pIntNoOfResult)
	{

		$strStartXml="<SearchResults>
					 <Query>$this->strQuery</Query>
					 <SearchType>$this->strType</SearchType>
					 <StartIndex>$pIntFirstIndex</StartIndex>";
		
		$this->intResult=$pIntNoOfResult+$pIntFirstIndex;			 
		// Yahoo			 
		if ($this->strYahoo=="yahoo" && $this->strMsn=="" && $this->strGoogle=="" && $this->strFlickr=="") 
		{
			$this->strXmlYahoo=$this->getYahooXml($pIntFirstIndex,$pIntNoOfResult);
			//$intYahooResult=$pIntNoOfResult;
			
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$intYahooResult=$this->intTotalResult+1;
			$strStartXml=$strStartXml."<TotalResult>$intYahooResult</TotalResult><SearchResults>";
			$strXml=$strStartXml.$this->strXmlYahoo;
		}
		// Google
		elseif ($this->strGoogle=="google" && $this->strYahoo=="" &&$this->strMsn=="" && $this->strFlickr=="") 
		{
			
			//$intTestIndex=$pIntNoOfResult-$pIntFirstIndex;
			
			//$this->strXmlGoogle=$this->getGoogleXml($pIntFirstIndex,$pIntNoOfResult);
			//$this->intGoogleResult=$this->getTotalResult($pIntFirstIndex,$pIntNoOfResult);
			$strStartXml=$strStartXml."<EndIndex>0</EndIndex>";			
			$strStartXml=$strStartXml."<TotalResult>0</TotalResult><SearchResults>";
			$strXml=$strStartXml.$this->strXmlGoogle;
			
		}
		// Msn
		elseif ($this->strMsn=="msn" && $this->strYahoo=="" && $this->strGoogle=="" && $this->strFlickr=="")
		{
			$this->strXmlMsn=$this->getMsnXml($pIntFirstIndex,$pIntNoOfResult);
			//$intMsnResult=$this->getTotalResult($pIntFirstIndex,$pIntNoOfResult);
			
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>$this->intMsnResult</TotalResult><SearchResults>";
			
			$strXml=$strStartXml.$this->strXmlMsn;
		}
		// Flickr
		elseif($this->strFlickr=="flickr" && $this->strYahoo=="" && $this->strGoogle=="" && $this->strMsn=="")
		{
			
			$strStartXml=$strStartXml."<EndIndex>0</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>0</TotalResult><SearchResults>";
			$strXml=$strStartXml;
			
		}
		// Yahoo, Google
		elseif ($this->strYahoo=="yahoo" && $this->strGoogle=="google" && $this->strMsn=="" && $this->strFlickr=="")
		{
				
			$this->strXmlYahoo=$this->getYahooXml($pIntFirstIndex,$pIntNoOfResult);
			//$intYahooResult=$pIntNoOfResult;
			$intYahooResult=$this->intTotalResult+1;
		//	$this->strXmlGoogle=$this->getGoogleXml($pIntFirstIndex,$pIntNoOfResult);
		//	$this->intGoogleResult=$this->getTotalResult($pIntFirstIndex,$pIntNoOfResult);
			
		//	$intTotalResultReturn=$intYahooResult+$this->intGoogleResult;
			
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>$intYahooResult</TotalResult><SearchResults>";
			
			$strXml=$strStartXml.$this->strXmlYahoo;
		}
		// Yahoo, Msn
		elseif ($this->strYahoo=="yahoo" && $this->strGoogle=="" && $this->strMsn=="msn" && $this->strFlickr=="")
		{
			$this->strXmlYahoo=$this->getYahooXml($pIntFirstIndex,$pIntNoOfResult);
			//$intYahooResult=$pIntNoOfResult;
			$intYahooResult=$this->intTotalResult+1;
			$this->strXmlMsn=$this->getMsnXml($pIntFirstIndex,$pIntNoOfResult);
			//$intMsnResult=$this->getTotalResult($pIntFirstIndex,$pIntNoOfResult);
			
			$intTotalResultReturn=$intYahooResult+$this->intMsnResult;
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>$intTotalResultReturn</TotalResult><SearchResults>";
			
			$strXml=$strStartXml.$this->strXmlYahoo.$this->strXmlMsn;

		}
		// Yahoo, Flickr
		elseif ($this->strYahoo=="yahoo" && $this->strGoogle=="" && $this->strMsn=="" && $this->strFlickr=="flickr")
		{
			$this->strXmlYahoo=$this->getYahooXml($pIntFirstIndex,$pIntNoOfResult);
			$intYahooResult=$this->intTotalResult+1;
			$intTotalResultReturn=$intYahooResult+0;
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>$intTotalResultReturn</TotalResult><SearchResults>";
			$strXml=$strStartXml.$this->strXmlYahoo;
		}
		// Msn, Flickr
		elseif ($this->strYahoo=="" && $this->strGoogle=="" && $this->strMsn=="msn" && $this->strFlickr=="flickr")
		{
		
			$strStartXml=$strStartXml."<EndIndex>0</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>0</TotalResult><SearchResults>";
			$strXml=$strStartXml;
		}
		// Yahoo, Msn, Flickr
		elseif ($this->strYahoo=="yahoo" && $this->strGoogle=="" && $this->strMsn=="msn" && $this->strFlickr=="flickr")
		{
		
			$this->strXmlYahoo=$this->getYahooXml($pIntFirstIndex,$pIntNoOfResult);
			$intYahooResult=$this->intTotalResult+1;
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>$intYahooResult</TotalResult><SearchResults>";
			$strXml=$strStartXml.$this->strXmlYahoo;
		}
		// Google, Flickr
		elseif ($this->strYahoo=="" && $this->strGoogle=="google" && $this->strMsn=="" && $this->strFlickr=="flickr")
		{
			$strStartXml=$strStartXml."<EndIndex>0</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>0</TotalResult><SearchResults>";
			$strXml=$strStartXml;
		}
		// Google, Msn
		elseif ($this->strYahoo=="" && $this->strGoogle=="google" && $this->strMsn=="msn" && $this->strFlickr=="")
		{
			/*$this->strXmlMsn=$this->getMsnXml($pIntFirstIndex,$pIntNoOfResult);
			$intMsnResult=$this->getTotalResult($pIntFirstIndex,$pIntNoOfResult);
			
			$this->strXmlGoogle=$this->getGoogleXml($pIntFirstIndex,$pIntNoOfResult);
			$this->intGoogleResult=$this->getTotalResult($pIntFirstIndex,$pIntNoOfResult);
			
			$intTotalResultResturn=$intMsnResult+$this->intGoogleResult;
			*/
			$strStartXml=$strStartXml."<EndIndex>0</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>0</TotalResult><SearchResults>";
			$strXml=$strStartXml.$this->strXmlMsn;

		}
		// Yahoo, Google, Msn
		elseif ($this->strYahoo=="yahoo" && $this->strGoogle=="google" && $this->strMsn=="msn" && $this->strFlickr=="")
		{
			$this->strXmlYahoo=$this->getYahooXml($pIntFirstIndex,$pIntNoOfResult);
			$intYahooResult=$this->intTotalResult+1;
			//$intYahooResult=$pIntNoOfResult;
			
			//$this->strXmlMsn=$this->getMsnXml($pIntFirstIndex,$pIntNoOfResult);
			//$intMsnResult=$this->getTotalResult($pIntFirstIndex,$pIntNoOfResult);
			
			//$this->strXmlGoogle=$this->getGoogleXml($pIntFirstIndex,$pIntNoOfResult);
			//$this->intGoogleResult=$this->getTotalResult($pIntFirstIndex,$pIntNoOfResult);
			
			$intTotalResultReturn=0+0+$intYahooResult;
			
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>$intTotalResultReturn</TotalResult><SearchResults>";
			$strXml=$strStartXml.$this->strXmlYahoo;
		}
		// Google, Msn, flickr
		elseif ($this->strYahoo=="" && $this->strGoogle=="google" && $this->strMsn=="msn" && $this->strFlickr=="flickr")
		{
			$strStartXml=$strStartXml."<EndIndex>0</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>0</TotalResult><SearchResults>";
			$strXml=$strStartXml;
		}
		// Yahoo, Google, Flickr
		elseif ($this->strYahoo=="yahoo" && $this->strGoogle=="google" && $this->strMsn=="" && $this->strFlickr=="flickr")
		{
			$this->strXmlYahoo=$this->getYahooXml($pIntFirstIndex,$pIntNoOfResult);
			$intYahooResult=$this->intTotalResult+1;
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>$intYahooResult</TotalResult><SearchResults>";
			$strXml=$strStartXml.$this->strXmlYahoo;
		}
		elseif ($this->strYahoo=="yahoo" && $this->strGoogle=="google" && $this->strMsn=="msn" && $this->strFlickr=="flickr")
		{
			$this->strXmlYahoo=$this->getYahooXml($pIntFirstIndex,$pIntNoOfResult);
			$intYahooResult=$this->intTotalResult+1;
			$strStartXml=$strStartXml."<EndIndex>$this->intResult</EndIndex>";
			$strStartXml=$strStartXml."<TotalResult>$intYahooResult</TotalResult><SearchResults>";
			$strXml=$strStartXml.$this->strXmlYahoo;
		}

		else 
		{
			return "</SearchResults></SearchResults>";
			
		}

		return $strXml=$strXml."</SearchResults></SearchResults>";
	}
}
?>