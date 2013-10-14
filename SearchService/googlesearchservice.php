<?php

require_once('nusoap.php');
//require_once('../Utilities/xmlEncode.php');
class GoogleSearchService
{

var $strKey;
var $strQuery;
var $strType;
var $strParram;
var $strSiteQuery;
var $intStart;
var $strErr;
var $ret;
var $soapClient;
var $soapOptions;
var $friendlyUrl;
var $intTotalRecord;
var $intFirstIndex;
var $intLastIndex;
var $strFormatXml;
var $intTotal;
var $intTest;
var $intReturnResult;
var $intTotalResultReturn;
var $strXml;
var $strUrl;
	function GoogleSearchService()
	{
		if (!$intStart) 
		{ 
		  $intStart = 0; 
		}
		else 
		{
			  $intStart = intval($intStart-1);
		}

//		include ('nusoap.php');
	}
	
	function getKey()
	{
		return $this->strKey;
	}
	
	function setKey($value)
	{
		$this->strKey=$value;
	}
	
	function getQuery()
	{
		return $this->strQuery;
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
	
	function getStart()
	{
		return $this->intStart;
	}
	
	function setStart()
	{
		if (!$this->intStart) 
			{ 
			  $this->intStart = 0; 
			}
		else 
			{
			  $this->intStart = intval($this->intStart-1);
			}
		//$this->intStart=$value;
	}
	
	function getTotalRecord()
	{
		return $this->intTotal;
	}
	
	function setTotalRecord()
	{
		$this->intTotal = $this->ret['estimatedTotalResultsCount'];	// total number of results
	}
	
	function getFirstIndex()
	{
			return $this-intFirstIndex;
	}
	
	function setFirstIndex()
	{
			$this->intFirstIndex=$this->ret['startIndex'];
	}
	
	function getLastIndex()
	{
			return $this->intLastIndex;
	}
	
	function setLastIndex()
	{
			$this->intLastIndex=$this->ret['endIndex'];						// last record returned
	}
	function getTotalResultReturn()
	{
		return $this->intTotalResultReturn;
	}

	function setTotalResultReturn($value)
	{
		$this->intTotalResultReturn=$value;
	}
	
	function setSoapClient()
	{

		//$this->soapClient = new soapclient('http://images.google.com/images');
		$this->soapClient = new soapclient('http://api.google.com/search/beta2');
		$this->soapOptions = 'urn:GoogleSearch';
	}

	function getSearch($strQuerya, $strTypea, $strKeya, $intStarta, $reta,$pIntNoOfResult)
	{
		if (!$intStarta) 
		{ 
		  $intStarta = 0; 
		}
		else 
		{
		  $intStarta = intval($intStarta-1);
		}
		
  		$this->strSiteQuery = "$strQuerya.$restrict";
  		//echo ("debug:::".$pIntNoOfResult . "::</br>");
  		
  		//if ($intStarta>$pIntNoOfResult)
  		//{
  		//	$pIntNoOfResult=$intStarta-$pIntNoOfResult;		
  		//}
  		//else 
  		//{
  		//	$pIntNoOfResult=$pIntNoOfResult-$intStarta;		
  		//}
	
		$this->strParram = array(
                'key' => $strKeya, 
                'q' => $this->strSiteQuery, 
				'start' => $intStarta, 
				'maxResults' =>$pIntNoOfResult,
                'filter' => false, 
                'restrict' => '',
                'safeSearch' => false,
                'lr' => '',
                'ie' => '',
                'oe' => ''
        );
	
	$this->ret = $this->soapClient->call('doGoogleSearch', $this->strParram, $this->soapOptions);
	
	if(!$this->ret)
	{
		//throw new GoogleSearchException("Enable to connect Google");
		
	}
    $this->strErr = $this->soapClient->getError();
	
		
    if ($this->strErr)
    {
        //throw new GoogleSearchException("Enable to connect Google");
        return false;
    }
    return true;
	}
	
	function displayXml($pIntFirstIndex,$pIntNoOfResult)
	{

		if( $this->strQuery != "" )
		{
				$this->strQuery = stripslashes($this->strQuery);
				    if( $this->getSearch( $this->strQuery, $this->strType, $this->strKey,$pIntFirstIndex, $this->ret,$pIntNoOfResult))
					{
							
						$this->intTotal = $this->ret['estimatedTotalResultsCount'];	// total number of results
						$secs = round($this->ret['searchTime'],2);			// time taken to search (in seconds)
						$this->intFirstIndex = $this->ret['startIndex'];	// first record returned
						$this->intLastIndex=$this->ret['endIndex'];

					       if ($this->intLastIndex) 
						   {
							  //echo ("<table cellspacing=0 cellpadding=0  border=1 bordercolor=#083a8f>");
							 // echo("<tr><td>");
							 
					          foreach($this->ret['resultElements'] as $result) 
		  					  {	
								
								 echo("<table cellspacing=0 cellpading=0 border=0");  
								  echo("<tr>");
            						$this->friendlyUrl = $result['URL'];
						            $this->friendlyUrl = str_replace("http://","",$this->friendlyUrl);
						            $this->friendlyUrl = str_replace("$q","<b>$q</b>",$this->friendlyUrl);
            			                            
						            if (!$title = $result['title']) 
									{
							              $title = $result['URL'];
							             echo ("<tr>");
										 echo("<td aligh=right><b>Url :</b></td><td><div align=justify width=600>{$this->friendlyUrl}</div></td>");
										  echo ("</tr>");
							        } 
									else 
									{
									echo ("<tr>");
									echo("<td aligh=right><b>Title :</b></td><td><div align=justify width=600><a href=\"{$result['URL']}\">{$title}</a></div></td>");
									echo ("</tr>");
							     
				 	                 	if ($result['snippet']) 
								   		{		
											$sin=$result['snippet'];

											
											echo ("<tr>");
											echo("<td aligh=right><b>snippet :</b></td><td><div align=justify width=600>{$result['snippet']}</div></td>");
											echo("</tr>");
					        		    }

										
										echo ("<tr>");
										echo("<td aligh=right><b>Url :</b></td><td><div align=justify width=600>{$this->friendlyUrl}</div></td>");
										echo ("</tr>");
							   		 
						            }

							echo ("<tr><td colspan=4 height=20></td></tr>");
							 echo("</tr>");
							 echo ("</table>");
							
				            }
							
							//echo("</td></tr>");
							//echo ("</table>");
				        } 
				else 
				{
					throw new GoogleSearchException("Sorry, no results were found on this site for <b>$q</b>");
     	 	         //print "<p>Sorry, no results were found on this site for <b>$q</b>. ";
			         //print "Occasionally no results will be returned when there are problems with the link between this site and Google. If you believe the information is on the site but it tells you that it's not, please try again.</p>";
        		}
		    }
		}
	}
	
	function getXml($pIntFirstIndex,$pIntNoOfResult)
	{
			$objXmlEncode=new xmlEncode();
		    if( $this->getSearch( $this->strQuery, $this->strType, $this->strKey, $pIntFirstIndex, $this->ret,$pIntNoOfResult)==true)
			{
						$this->intTotal = $this->ret['estimatedTotalResultsCount'];	// total number of results
						$secs = round($this->ret['searchTime'],2);			// time taken to search (in seconds)
						$this->intFirstIndex = $this->ret['startIndex'];	// first record returned
						$this->intLastIndex=$this->ret['endIndex'];
						$this->strFormatXml="<GoogleSearch>";
						$intNewEndIdex=$pIntFirstIndex+$pIntNoOfResult;
						$this->strFormatXml=$this->strFormatXml."<Query>$this->strQuery</Query>
									<SearchType>$this->strType</SearchType>
									<TotalResult>$pIntNoOfResult</TotalResult>
									<StartIndex>$pIntFirstIndex</StartIndex>
									<EndIndex>$intNewEndIdex</EndIndex>";
	
				   if ($this->intLastIndex) 
				   {
						  foreach($this->ret['resultElements'] as $result) 
						  {	
								$this->strFormatXml=$this->strFormatXml."<Result>";
								$this->friendlyUrl = $result['URL'];
								$this->friendlyUrl = str_replace("http://","",$this->friendlyUrl);
								$this->friendlyUrl = str_replace("$q","<b>$q</b>",$this->friendlyUrl);
		
								if (!$title = $result['title']) 
								{
									  $title = $result['URL'];
									  $this->strFormatXml=$this->strFormatXml."<Url>urlencode($this->friendlyUrl)</Url>";

								} 
								else 
								{
									$this->strFormatXml=$this->strFormatXml."<Title>".$objXmlEncode->xmlCdataEncode($title)."</Title>";
									if ($result['snippet']) 
									{		
										$sin=$result['snippet'];
										$this->strFormatXml=$this->strFormatXml."<Snippet>".$objXmlEncode->xmlCdataEncode($sin)."</Snippet>";
									}
									$this->strFormatXml=$this->strFormatXml."<Url>urlencode($this->friendlyUrl)</Url>";
								}
									$this->strFormatXml=$this->strFormatXml."</Result>";
							} 
					}
									
					$this->strFormatXml=$this->strFormatXml."</GoogleSearch>";

				} 
				else 
				{
					$this->strFormatXml=$this->strFormatXml."<Error>Sorry, no results were found on this site for $this->strQuery</Error>";
					throw  new GoogleSearchException("Sorry, no results were found on this site for $this->strQuery");					
        		}
				return $this->strFormatXml;

	}
	
	
	function buildQuery($pIntFirstIndex,$pIntNoOfResult)
	{
		
		$this->strUrl="http://video.google.com/videofeed?type=search&";
		$this->strUrl=$this->strUrl."q=".$this->strQuery."&num=".$pIntNoOfResult."&output=rss";
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
			 throw new GoogleSearchException("Enable to connect Google ");
		}

		
		if (!$this->strXml) 
		{
			throw new GoogleSearchException("Enable to connect Google");
		}

		return $this->strXml;
		
	}
	
	function getVideoXml($pIntFirstIndex,$pIntNoOfResult)
	{

		$strXml=$this->getRawXml($pIntFirstIndex,$pIntNoOfResult);	
		$objXmlEncode=new xmlEncode();
		$this->intTotalResult=0;
		foreach ($strXml->channel->item as $items )					 
		{

			$newXml=$items->children('http://search.yahoo.com/mrss');
			
			$this->strFormatXml.="<Result>";
			$this->strFormatXml.="<Title>".htmlspecialchars($objXmlEncode->xmlCdataEncode($items->title))."</Title>";
			
			//$this->strFormatXml.="<Summary>".urlencode(htmlspecialchars($objXmlEncode->xmlCdataEncode($items->description)))."</Summary>";
			$this->strFormatXml.="<Summary></Summary>";
			
			/*foreach($items->enclosure[0]->attributes() as $url => $urlvalue) 
			{
				$this->strFormatXml.="<Url>".urlencode($urlvalue)."</Url>";
			}*/
			$urlvalue=$newXml->group->content[0]->attributes();
			$this->strFormatXml.="<Url>".urlencode($urlvalue)."</Url>";
			$this->strFormatXml.="<ClickUrl></ClickUrl>";
			$this->strFormatXml.="<RefererUrl></RefererUrl>";
			$this->strFormatXml.="<FileSize></FileSize>";
			$this->strFormatXml.="<FileFormat></FileFormat>";
			$this->strFormatXml.="<Height></Height>";
			$this->strFormatXml.="<Width></Width>";
			$this->strFormatXml.="<Duration></Duration>";
			$this->strFormatXml.="<Streaming></Streaming>";
			$this->strFormatXml.="<Channels></Channels>";
			
			$ImageUrl=$newXml->group->thumbnail[0]->attributes();
			$this->strFormatXml.="<Thumbnail>"."img src="."'".urlencode($ImageUrl)."'"." height='75' width='75'"."</Thumbnail>";
			$this->strFormatXml.="<ThumbnailUrl>".urlencode($ImageUrl)."</ThumbnailUrl>";
			$this->strFormatXml.="<SearchEngine></SearchEngine>";
			$this->strFormatXml.="</Result>";
			$this->intTotalResult++;
		}
		
		$this->setTotalResultReturn($this->intTotalResult);
		return $this->strFormatXml;
	}
	
	function getTextXml($pIntFirstIndex,$pIntNoOfResult)
	{
	
			$objXmlEncode=new xmlEncode();
		    if( $this->getSearch( $this->strQuery, $this->strType, $this->strKey, $pIntFirstIndex, $this->ret,$pIntNoOfResult)==true)
			{
						$this->intTotal = $this->ret['estimatedTotalResultsCount'];	// total number of results
						$secs = round($this->ret['searchTime'],2);			// time taken to search (in seconds)
						$this->intFirstIndex = $this->ret['startIndex'];	// first record returned
						$this->intLastIndex=$this->ret['endIndex'];
						//echo($this->intLastIndex);
						$intNewEndIdex=$pIntFirstIndex+$pIntNoOfResult;
							
				   if ($this->intLastIndex) 
				   {
						  foreach($this->ret['resultElements'] as $result) 
						  {	
								$this->strFormatXml=$this->strFormatXml."<Result>";
								$this->friendlyUrl = $result['URL'];
								$this->friendlyUrl = str_replace("http://","",$this->friendlyUrl);
								$this->friendlyUrl = str_replace("$q","<b>$q</b>",$this->friendlyUrl);
		
								if (!$title = $result['title']) 
								{
									  $title = $result['URL'];
									  $this->strFormatXml=$this->strFormatXml."<Url>urlencode($this->friendlyUrl)</Url>";

								} 
								else 
								{
									$this->strFormatXml=$this->strFormatXml."<Title>".htmlspecialchars($objXmlEncode->xmlCdataEncode($title))."</Title>";
									if ($result['snippet']) 
									{		
										$sin=$result['snippet'];
										$this->strFormatXml=$this->strFormatXml."<Summary>".htmlspecialchars($objXmlEncode->xmlCdataEncode($sin))."</Summary>";
									}
									$this->strFormatXml=$this->strFormatXml."<Url>".urlencode($this->friendlyUrl)."</Url>";
									$this->strFormatXml=$this->strFormatXml."<ClickUrl></ClickUrl>";
									$this->strFormatXml=$this->strFormatXml."<ModificationDate></ModificationDate>";
									$this->strFormatXml=$this->strFormatXml."<MimeType></MimeType>";
									$this->strFormatXml=$this->strFormatXml."<Cache></Cache>";
								}
									$this->strFormatXml=$this->strFormatXml."<SearchEngine>Google</SearchEngine>";
									$this->strFormatXml=$this->strFormatXml."</Result>";
							} 
					}
									
					

				} 
				else 
				{
					$this->strFormatXml=$this->strFormatXml."<Error>Sorry, no results were found on this site for $this->strQuery</Error>";
					$this->intReturnResult=0;
					//throw  new GoogleSearchException("Sorry, no results were found on this site for $this->strQuery");
        		}
				return $this->strFormatXml;

	}
	
	function writeToFile($strFileName,$pIntFirstIndex,$pIntNoOfResult)
	{
			if (file_exists($strFileName)) 
			{ 

			$Handle=fopen($strFileName,'w');
			$strFormatXml=$this->getXml($pIntFirstIndex,$pIntNoOfResult);
			fwrite($Handle,$strFormatXml);
			 fclose($Handle);
			} 
			else
			{
				$Handle=fopen($strFileName,'w');
				$strFormatXml=$this->getXml($pIntFirstIndex,$pIntNoOfResult);
				fwrite($Handle,$strFormatXml);
				 fclose($Handle);
			}
			
			 			
	}
	    
	function nextPrevious()
	{
		if ($this->intTotal)
		{
		  print "<div class=\"search_bottom\">";
		  if ($this->intFirstIndex>1) 
		  {
		    	if ($this->intFirstIndex >10)
		    	{
		   			 $prevpage = $this->intFirstIndex-10;
	      		}
		  		else 
		  		{
		      		$prevpage = 1;
    	  		}
				print " <b><a href=".$_SERVER['PHP_SELF']."?query=".$strNewQuery."&type=".$this->strType."&search=".$this->strSearch."&start=".$prevpage.">Previous Page</a></b> | ";
	      }
		else 
		{
		   print " Previous Page | ";
	    }
	   	if ($this->intTotal > $this->intLastIndex)
	    {
		    $nextpage = $this->intLastIndex+1;
		    print " <b><a href=".$_SERVER['PHP_SELF']."?query=".$strNewQuery."&type=".$this->strType."&search=".$this->strSearch."&start=".$nextpage.">Next Page</a></b> ";
	    } 
	    else
	    {
	        print " Next Page ";
	    }
		    print "</div>";
			//$objGoogleSearch->displayResult();
		}
	}
	
}

?>