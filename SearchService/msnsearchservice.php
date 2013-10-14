
<?php
//require_once('nusoap.php');

define ('NUSOAP_PATH','nusoap');
define ('MSN_API_KEY', 'DEB8C9D66FB593A66F36B6D41E98983B49F94E64');
define ('MSN_API_ENDPOINT', 'http://soap.search.msn.com/webservices.asmx');
define ('MSN_API_NAMESPACE', 'http://schemas.microsoft.com/MSNSearch/2005/09/fex');



class MSNWebSearch
{
        var $strApiKey;
        var $blnFilterAdult;
        var $strLanguages;
        var $intPage;
        var $intPages;
        var $strQuery;
		var $strType;
        var $intRecords;
        var $intRecordsPerPage;
   		var $strFormatString;
		var $intStartIndex;
		var $result;
		var $strSearch;
		var $strNewQuery;
		var $intReturnResult;
        function & MSNWebSearch($strApiKey = null)
        {
                $this->strApiKey = isset($strApiKey) ? $streApiKey : MSN_API_KEY;
                $this->blfilterAdult = false;
                $this->strLanguages = 'en-US';
                $this->intRecordsPerPage = 10;
                $this->intPage = 1;
        }
        
        function getApiKey()
        {
                return $this->strApiKey;
        }
        
        function setApiKey($strApiKey)
        {
                $this->strApiKey = $strApiKey;
        }
        
        function getErrorMessage()
        {
                return $this->strErrorMessage;
        }
        
        function getFilterAdult()
        {
                return $this->blnFilterAdult;
        }
        
        function setFilterAdult($blnFilterAdult)
        {
                $this->blnFilterAdult = $blnFilterAdult;
        }
        
        function getLanguages()
        {
                return $this->strLanguages;
        }
        
        function setLanguages($pStrLanguages)
        {
                $this->strLanguages = $pStrLanguages;
        }
        
        function getPage()
        {
                return $this->intPage;
        }
        
        function setPage($pIntPage)
        {
                if ($intPage < 1)
                {
                        $intPage = 1;
                }
        
                $this->intPage = $pIntPage;
        }
        
        function getPages()
        {
                return $this->intPages;
        }
        
        function getQuery()
        {
                return $this->strQuery;
        }
        
        function setQuery($pStrQuery)
        {
                $this->strQuery = $pStrQuery;
        }
		
        function getType()
		{
				return $this->strType;
		}
		
		function setType($pStrType)
		{
				$this->strType=$pStrType;
		}
		
        function getRecords()
        {
                return $this->intRecords;
        }
        
		function getSearch()
		{
				return $this->strSearch;
		}
		
		function setSearch($pStrSearch)
		{
				$this->strSearch=$pStrSearch;
		}
		
        function getRecordsPerPage()
        {
                return $this->intRecordsPerPage;
        }
		
		function getNewQuery()
		{
			return $this->strNewQuery;
		}
		function setNewQuery($pStrNewQuery)
		{
			$this->strNewQuery=$pStrNewQuery;
		}
        
        /*function setRecordsPerPage($pIntRecordsPerPage)
        {
                $this->$intRecordsPerPage = is_int($pIntRecordsPerPage) && $pIntRecordsPerPage > 0 ? $pIntRecordsPerPage : 10;
        }*/
		
		 function setRecordsPerPage($recordsPerPage)
        {
                $this->intRecordsPerPage = is_int($recordsPerPage) && $recordsPerPage > 0 ? $recordsPerPage : 10;
        }
        
        function getRawXml($pIntStartIndex,$pIntNoOfResult)
        {
        		
                $startIndex = ($this->intPage - 1) * $this->intRecordsPerPage;
               // $pIntNoOfResult = $this->intRecordsPerPage;
                
                $parameters = array(
                        'AppID' => $this->strApiKey,
                        'Query' => $this->strQuery,
                        'CultureInfo' => $this->strLanguages,
                        'SafeSearch' => ($this->blnFilterAdult ? 'Strict' : 'Off'),
                        'Requests' => array (
                               				 'SourceRequest' => array (
                                        	 'Source' => 'Web',
                                        	 'Offset' => $pIntStartIndex,
                                        	 'Count' => $pIntNoOfResult,
                                        	 'ResultFields' => 'All'
                                										)
                        					)
                				  );
                
                if (isset($this->country))
                {
                        $parameters['Location'] = $this->country;
                }
                
                $soapClient =& new soapclient(MSN_API_ENDPOINT);
                
                $soapResult = $soapClient->call('Search', array ('Request' => $parameters), MSN_API_NAMESPACE );
                if (!$soapResult)
                {
                	
                	throw new MsnSearchException("Enable to connect Msn");
                }
                if ($soapClient->getError())
                {
                        $this->strErrorMessage = $soapClient->getError();
                        throw new MsnSearchException("Enable to connect Msn");
                        return false;
                }
                
                $this->intRecords = $soapResult['Responses']['SourceResponse']['Total'];
                $this->intPages = ceil($this->intRecords / $this->intRecordsPerPage);
                if (is_array($soapResult['Responses']['SourceResponse']['Results']['Result']))
 
                {
                        $this->result = array();
						 foreach ($soapResult['Responses']['SourceResponse']['Results']['Result'] as $item)
                  
                        {
                                $this->result[] = array (
                                        'url' => $item['Url'],
                                        'urlDisplay' => $item['DisplayUrl'],
                                        'urlCache' => $item['CacheUrl'],
                                        'title' => isset($item['Title']) && trim($item['Title']) != '' ? $item['Title'] : $item['DisplayUrl'],
                                        'snippet' => $item['Description']
                                );
                        }
                }
                else
                {
                        $this->result = array();
                }
                
                return $this->result;
        }
		
		 function getRawXmlb()
        {
                $startIndex = ($this->intPage - 1) * $this->intRecordsPerPage;
                $pIntNoOfResult = $this->intRecordsPerPage;
                
                $parameters = array(
                        'AppID' => $this->strApiKey,
                        'Query' => $this->strQuery,
                        'CultureInfo' => $this->strLanguages,
                        'SafeSearch' => ($this->blnFilterAdult ? 'Strict' : 'Off'),
                        'Requests' => array (
                               				 'SourceRequest' => array (
                                        	 'Source' => 'Web',
                                        	 'Offset' => $startIndex,
                                        	 'Count' => $pIntNoOfResult,
                                        	 'ResultFields' => 'All'
                                										)
                        					)
                				  );
                
                if (isset($this->country))
                {
                        $parameters['Location'] = $this->country;
                }
                
                $soapClient =& new soapclient(MSN_API_ENDPOINT);
                
                $soapResult = $soapClient->call('Search', array ('Request' => $parameters), MSN_API_NAMESPACE );
                
                if ($soapClient->getError())
                {
                        $this->strErrorMessage = $soapClient->getError();
                        return false;
                }
                
                $this->intRecords = $soapResult['Responses']['SourceResponse']['Total'];
                $this->intPages = ceil($this->intRecords / $this->intRecordsPerPage);
                if (is_array($soapResult['Responses']['SourceResponse']['Results']['Result']))
 
                {
                        $this->result = array();
						 foreach ($soapResult['Responses']['SourceResponse']['Results']['Result'] as $item)
                  
                        {
                                $this->result[] = array (
                                        'url' => $item['Url'],
                                        'urlDisplay' => $item['DisplayUrl'],
                                        'urlCache' => $item['CacheUrl'],
                                        'title' => isset($item['Title']) && trim($item['Title']) != '' ? $item['Title'] : $item['DisplayUrl'],
                                        'snippet' => $item['Description']
                                );
                        }
                }
                else
                {
                        $this->result = array();
                }
                
                return $this->result;
        }
		
		function displayResult()
		{
			$this->result=$this->getRawXmlb();
//			$intTotalResult=$pIntFirstIndex+$pIntNoOfResult;
			
			echo("<table cellspacing=0 cellpading=0 border=0>");
        	foreach ($this->result as $item)
        	{   
				echo("<tr>");
				
				echo("<tr>");
				
				echo "<td aligh=right><b>Title:</b></td><td><div align=justify width=600>{$item['title']}</td>";
				echo ("</tr>");
				

			    
				echo("<tr>");
				echo "<td aligh=right><b>Url:</b></td><td><div align=justify width=600><a href=\"{$item['url']}\">{$item['urlDisplay']}</a></td>";
				echo ("</tr>");
				
				
				
				echo("<tr>");
				echo "<td aligh=right><b>Snippet:</b></td><td><div align=justify width=600>{$item['snippet']}</td>";
				echo ("</tr>");
				
			
				echo("<tr>");
				echo "<td aligh=right><b>UrlCache:</b></td><td><div align=justify width=600><a href=\"{$item['urlCache']}\">{$item['urlCache']}</a></td>";
				echo ("</tr>");
				
				echo("</tr>");
				echo ("<tr><td colspan=4 height=20></td></tr>");
				
        	}
				echo("</table>");

		}
		
        function getXml($pIntFirstIndex,$pIntNoOfResult)
        {
			$objXmlEncode=new xmlEncode();
			$result=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
			$intTotalResult=$pIntFirstIndex+$pIntNoOfResult;
        	$this->strFormatString="<MsnSearch>
			<Query>$this->strQuery</Query>
			<SearchType>$this->strType</SearchType>
			
			 <TotalResult>$pIntNoOfResult</TotalResult>
			<FirstIndex>$pIntFirstIndex</FirstIndex>
			<EndIndex>$intTotalResult</EndIndex>";
        	
        	foreach ($this->result as $item)
        	{   
				
				$this->strFormatString=$this->strFormatString."<Result>";
				
	       	  	$this->strFormatString=$this->strFormatString."<Title>".$objXmlEncode->xmlCdataEncode($item['title'])."</Title>";
				

				$this->strFormatString=$this->strFormatString."<Url>".urlencode($item['url'])."</Url>";
				$this->strFormatString=$this->strFormatString."<Snippet>".$objXmlEncode->xmlCdataEncode($item['snippet'])."</Snippet>";
				
				$this->strFormatString=$this->strFormatString."<UrlCache>".urlencode($item['urlCache'])."</UrlCache>";
				$this->strFormatString=$this->strFormatString."</Result>";
        	}
			$this->strFormatString=$this->strFormatString."</MsnSearch>";
			return $this->strFormatString;
        }	
		
		function getImageXml($pIntFirstIndex,$pIntNoOfResult)
        {
			$objXmlEncode=new xmlEncode();
			$result=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
			$intTotalResult=$pIntFirstIndex+$pIntNoOfResult;

        	$this->intReturnResult=0;
        	/*foreach ($this->result as $item)
        	{   
				
				$this->strFormatString=$this->strFormatString."<Result>";
				$this->strFormatString=$this->strFormatString."<Title>".$objXmlEncode->xmlCdataEncode($item['title'])."</Title>";
				$this->strFormatString=$this->strFormatString."<Summary>".$objXmlEncode->xmlCdataEncode($item['snippet'])."</Summary>";
				$this->strFormatString=$this->strFormatString."<Url>".urlencode($item['url'])."</Url>";
				$this->strFormatString=$this->strFormatString."<ClickUrl>".urlencode($item['urlCache'])."</ClickUrl>";
				$this->strFormatString=$this->strFormatString."<RefererUrl></RefererUrl>";
				$this->strFormatString=$this->strFormatString."<FileSize></FileSize>";
				$this->strFormatString=$this->strFormatString."<FileFormat></FileFormat>";
				$this->strFormatString=$this->strFormatString."<Height></Height>";
				$this->strFormatString=$this->strFormatString."<Width></Width>";
				$this->strFormatString=$this->strFormatString."<Thumbnail></Thumbnail>";
				$this->strFormatString=$this->strFormatString."<SearchEngine>Msn</SearchEngine>";
				$this->strFormatString=$this->strFormatString."</Result>";
				$this->intReturnResult=$this->intReturnResult+1;
        	}
			*/
			return $this->strFormatString;
        }	
		
		function getVideoXml($pIntFirstIndex,$pIntNoOfResult)
        {
			$objXmlEncode=new xmlEncode();
			$result=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
			$intTotalResult=$pIntFirstIndex+$pIntNoOfResult;

        	$this->intReturnResult=0;
        	/*
			foreach ($this->result as $item)
        	{   
				
				$this->strFormatString=$this->strFormatString."<Result>";
				
	       	  	$this->strFormatString=$this->strFormatString."<Title>".$objXmlEncode->xmlCdataEncode($item['title'])."</Title>";
				$this->strFormatString=$this->strFormatString."<Summary>".$objXmlEncode->xmlCdataEncode($item['snippet'])."</Summary>";
				$this->strFormatString=$this->strFormatString."<Url>".urlencode($item['url'])."</Url>";
				$this->strFormatString=$this->strFormatString."<ClickUrl>".urlencode($item['urlCache'])."</ClickUrl>";
				$this->strFormatString=$this->strFormatString."<RefererUrl></RefererUrl>";
				$this->strFormatString=$this->strFormatString."<FileSize></FileSize>";
				$this->strFormatString=$this->strFormatString."<FileFormat></FileFormat>";
				$this->strFormatString=$this->strFormatString."<Height></Height>";
				$this->strFormatString=$this->strFormatString."<Width></Width>";
				$this->strFormatString=$this->strFormatString."<Duration></Duration>";
				$this->strFormatString=$this->strFormatString."<Streaming></Streaming>";
				$this->strFormatString=$this->strFormatString."<Channels></Channels>";
				$this->strFormatString=$this->strFormatString."<Thumbnail></Thumbnail>";
				$this->strFormatString=$this->strFormatString."<ThumbnailUrl></ThumbnailUrl>";
				$this->strFormatString=$this->strFormatString."<SearchEngine>Msn</SearchEngine>";
				$this->strFormatString=$this->strFormatString."</Result>";
				$this->intReturnResult=$this->intReturnResult+1;
        	}
			*/
			return $this->strFormatString;
        }	
		
		function getAudioXml($pIntFirstIndex,$pIntNoOfResult)
        {
			$objXmlEncode=new xmlEncode();
			$result=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
			$intTotalResult=$pIntFirstIndex+$pIntNoOfResult;

        	$this->intReturnResult=0;
        	/*foreach ($this->result as $item)
        	{   
				
				$this->strFormatString=$this->strFormatString."<Result>";
				
	       	  	$this->strFormatString=$this->strFormatString."<Title>".$objXmlEncode->xmlCdataEncode($item['title'])."</Title>";
				$this->strFormatString=$this->strFormatString."<Summary>".$objXmlEncode->xmlCdataEncode($item['snippet'])."</Summary>";
				$this->strFormatString=$this->strFormatString."<Url>".urlencode($item['url'])."</Url>";
				$this->strFormatString=$this->strFormatString."<ClickUrl>".urlencode($item['urlCache'])."</ClickUrl>";
				$this->strFormatString=$this->strFormatString."<RefererUrl></RefererUrl>";
				$this->strFormatString=$this->strFormatString."<FileSize></FileSize>";
				$this->strFormatString=$this->strFormatString."<FileFormat></FileFormat>";
				$this->strFormatString=$this->strFormatString."<Duration></Duration>";
				$this->strFormatString=$this->strFormatString."<Streaming></Streaming>";
				$this->strFormatString=$this->strFormatString."<Copyrights></Copyrights>";
				$this->strFormatString=$this->strFormatString."<SearchEngine>Msn</SearchEngine>";
				$this->strFormatString=$this->strFormatString."</Result>";
				$this->intReturnResult=$this->intReturnResult+1;
        	}*/
			
			return $this->strFormatString;
        }	
		
		function getTextXml($pIntFirstIndex,$pIntNoOfResult)
        {
			$objXmlEncode=new xmlEncode();
			$result=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);
			$intTotalResult=$pIntFirstIndex+$pIntNoOfResult;

        	$this->intReturnResult=0;
        	foreach ($this->result as $item)
        	{   
				
				$this->strFormatString=$this->strFormatString."<Result>";
	       	  	$this->strFormatString=$this->strFormatString."<Title>".$objXmlEncode->xmlCdataEncode($item['title'])."</Title>";
				$this->strFormatString=$this->strFormatString."<Summary>".$objXmlEncode->xmlCdataEncode($item['snippet'])."</Summary>";
				$this->strFormatString=$this->strFormatString."<Url>".urlencode($item['url'])."</Url>";
				$this->strFormatString=$this->strFormatString."<ClickUrl>".urlencode($item['urlCache'])."</ClickUrl>";
				$this->strFormatString=$this->strFormatString."<ModificationDate></ModificationDate>";
				$this->strFormatString=$this->strFormatString."<MimeType></MimeType>";
				$this->strFormatString=$this->strFormatString."<Cache></Cache>";
				$this->strFormatString=$this->strFormatString."<SearchEngine>Msn</SearchEngine>";
				$this->strFormatString=$this->strFormatString."</Result>";
				$this->intReturnResult=$this->intReturnResult+1;
        	}
			
			return $this->strFormatString;
        }	
		
		function nextPrevious()
		{
			if ($this->result !== false)
			{
					
					if ($this->getPages() > 1)
					{
							$navigation = array();
					
							$navigation['pages'] = $this->getPages();
							
							if ($this->getPage() > 1)
							{
									
									$navigation['back'] = $PHP_SELF . '?page=' . ($this->getPage() - 1) . '&query=' . urlencode($this->getNewQuery()).'&type='.$this->getType()."&search=".$this->getSearch()."&submit=submit";
							}
							
							if ($this->getPage() < $this->getPages())
							{
									$navigation['next'] = $PHP_SELF . '?page=' . ($this->getPage() + 1) . '&query=' . urlencode($this->getNewQuery()).'&type='.$this->getType()."&search=".$this->getSearch()."&submit=submit";
							}
					}
			}
			if (isset($navigation))
            {
				if ($this->result !== false)
            	{
           			 //echo $this->getPage();
	            }
				if (isset($navigation['back']))
            	{
		//	echo ("<a href=\"{$item['urlCache']}\">{$item['urlCache']}</a></td>");
              		echo ("<a href=\"{$navigation['back']}\">Previous</a>");
				}
				else
				{

				}
				if (isset($navigation['back']) && isset($navigation['next']))
            	{
           			 echo ("&nbsp;|&nbsp;");
            	}
				if (isset($navigation['next']))
            	{
                    echo ("<a href=\"{$navigation['next']}\">Next</a>");
           		 }
			}
		}
		function writeToFile($strFileName,$pIntFirstIndex,$pIntNoOfResult)
		{
			$strFormatString=$this->getXml($pIntFirstIndex,$pIntNoOfResult);
			$Handle = fopen($strFileName, 'w');
			fwrite($Handle,$strFormatString);
    	    fclose($Handle);
		}
}
?>
