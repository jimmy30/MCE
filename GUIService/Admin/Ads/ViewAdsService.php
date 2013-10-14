<?php
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for View Adds .
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Ads Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Ads/AdsDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/Ads/AdsBO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");




//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class ViewAdsService
{
	function GetListPageGroup()
	{
		$strFileName='grouppagelist.xml';
		
		if(!file_exists($strFileName))
		{
			$objAdsDAO = new AdsDAO();
			$objObjectArray=$objAdsDAO->GetListPageGroup();
			if ($objObjectArray!=null)
			{
				$intCount = count($objObjectArray[0]);
				$strXMLGroup='<Groups>';
				$intChkGroupId=0;
				$blnStatusOne=0;
				$intGroupCount=0;
				$intPageCounter=0;
				
				for($i=0; $i<$intCount; $i++)
				{
					 
					$objAdsBO=(object)$objObjectArray[0][$i];
					$intGroupId=$objAdsBO->getGroupId();
					if($intChkGroupId<>$intGroupId)
					{
						$intGroupCount++;
						$strXML=$strXML.'<Group>';
						$strXML=$strXML.'<GroupId>'.$objAdsBO->getGroupId().'</GroupId>';	
						$strXML=$strXML.'<GroupName>'.$objAdsBO->getGroupName().'</GroupName>';	
						$strXML=$strXML.'</Group>';
						$intChkGroupId=$intGroupId;
					}	
				}	
				$strXMLGroup=$strXMLGroup.'<NoOfGroups>'.$intGroupCount.'</NoOfGroups>';
				$strXMLGroup=$strXMLGroup.'<GroupList>';
				$strXMLGroup=$strXMLGroup.$strXML.'</GroupList></Groups>';
				
				// To do... for group pages
				/*
				for($i=0; $i<$intCount; $i++)
				{
					 
					$objAdsBO=(object)$objObjectArray[0][$i];
					$intGroupId=$objAdsBO->getGroupId();
					if($intGroupId==$intChkGroupId)
					{
						$blnStatusOne=1;
						$strXML=$strXML.'<Page>';
						$strXML=$strXML.'<PageId>'.$objAdsBO->getPageId().'</PageId>';
						$strXML=$strXML.'<PageName>'.$objAdsBO->getPageName().'</PageName>';
						$strXML=$strXML.'</Page>';
						$intPageCounter++;	
					}
					else
					{
						if($blnStatusOne==1)
						{
							
							$strXML=$strXML.'</Pages>';
							$strXML=$strXML.'<NoOfPages>'.$intPageCounter.'</NoOfPages>';
							$strXML=$strXML.'</Group>';
							$blnStatusOne=0;
							$intPageCounter=0;
						}
						$intGroupCount++;
						$strXML=$strXML.'<Group>';
						$intChkGroupId=$intGroupId;
						$strXML=$strXML.'<GroupId>'.$objAdsBO->getGroupId().'</GroupId>';	
						$strXML=$strXML.'<GroupName>'.$objAdsBO->getGroupName().'</GroupName>';	
						if($blnStatusOne==0)
						{

							$strXML=$strXML.'<Pages>';
							
						}
						$intPageCounter++;
						
						$strXML=$strXML.'<Page>';
						$strXML=$strXML.'<PageId>'.$objAdsBO->getPageId().'</PageId>';
						$strXML=$strXML.'<PageName>'.$objAdsBO->getPageName().'</PageName>';
						$strXML=$strXML.'</Page>';	
					}
				}	
				
				$strXML=$strXML.'</Pages>';
				$strXML=$strXML.'<NoOfPages>'.$intPageCounter.'</NoOfPages>';
				$strXML=$strXML.'</Group>';
				
				$strXMLGroup=$strXMLGroup.'<NoOfGroups>'.$intGroupCount.'</NoOfGroups>';
				$strXMLGroup=$strXMLGroup.'<GroupList>';
				$strXMLGroup=$strXMLGroup.$strXML.'</GroupList></Groups>';
				*/
				$objFile=fopen($strFileName,"w");
				fwrite($objFile,$strXMLGroup);
				fclose($objFile);
				return $strXMLGroup;
			}
			
		}
		else
		{
			$objFile=fopen($strFileName,"r");

			$strXMLGroup=fread($objFile,filesize($strFileName));
			fclose($objFile);
			return $strXMLGroup;
		}	

	}	
	
	function GetAddsList($start,$limit,$pIntSortListBy)
	{
		
		$objAdsDAO = new AdsDAO();
		$objXmlEncode=new xmlEncode();
		$objObjectArray=$objAdsDAO->GetAddsList($start,$limit,$pIntSortListBy);

		//// Generating Comobox items
		if ($objObjectArray!=null)
		{

			$intCount = count($objObjectArray[0]);
			
			$strXML='<Adds>';
			$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><AddsList>';
			
			for($i=0; $i<$intCount; $i++)
			{
				
				$objAdsBO=(object)$objObjectArray[0][$i];
				
				$strXML.='<Add>';
				$strXML.='<AddId>'.$objAdsBO->getAdsId().'</AddId>';
				$strXML.='<AddName>'.$objAdsBO->getAdsName().'</AddName>';				
				$strXML.='<AddImage>'.$objAdsBO->getImagePath().'</AddImage>';								
				$strXML.='<ExpiryDate>'.$objAdsBO->getExpiryDate().'</ExpiryDate>';
				$strXML.='<CreateDate>'.$objAdsBO->getCreateDate().'</CreateDate>';
				$strXML.='<IsActive>'.$objAdsBO->getActive().'</IsActive>';
				$strXML.='<AddSize>'.$objAdsBO->getAdSize().'</AddSize>';
				$strXML.='<AddSniffet>'.$objXmlEncode->xmlCdataEncode($objAdsBO->getSinffet()).'</AddSniffet>';
				
				$strXML.='</Add>';
			}
			$strXML.='</AddsList></Adds>';

		}
		return $strXML;		
	}
	/*=================================================================================
		Function Name 	: AddsRecords
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
	=================================================================================*/

	function AddsRecords()
	{
		/// Call procedure
		$objAdsDAO = new AdsDAO();
		$numRows=$objAdsDAO->AddsRecords();
		return $numRows;
	}	 
		/// POPULATE DAY COMOBOX OF DOB
	function FillCmbDay()
	{
		for($i=1;$i<=31;$i++)
		{
			if($i<10) $i="0".$i;		
			echo "<option value=".$i.">".$i."</option>";
		}
	}	 

	/// POPULATE MONTH COMOBOX OF DOB 
	function FillCmbMonth()
	{
		for($i=1;$i<=12;$i++)
		{
			$mkdate=mktime(0,0,0,$i,1,2006);
			echo "<option value='".date('m',$mkdate)."'>".date('F',$mkdate)."</option>";
		}
	}	 
	/*=================================================================================
		Function Name 	: getPagingLimit
		Created On    	: 22-Sept-2006 
		Synopsis	  	: set pagming limit values according page no
		Input Parameter : integer page No
		Returns		  	: integer start limit, integer no. of rows
	=================================================================================*/

	function getPagingLimit($pIntPageNo)
	{
		$objAdsDAO = new AdsDAO();
		
		$limit = $objAdsDAO->getPagingLimit();
		
		if($pIntPageNo == 1 || $pIntPageNo==null)
		{
			$startLimit = 0;
		}
		else
		{
			$startLimit = $pIntPageNo * $limit - ($limit); 		
		}
		
		$arrayPagingLimit[0]=$startLimit;
		$arrayPagingLimit[1]=$limit;
		return $arrayPagingLimit;
		
	}	 

	/*=================================================================================
			Function Name 	: paging
			Created On    	: 22-Sept-2006 
			Synopsis	  	: generate paging html
			Input Parameter : integer page No, integer total no. of rows
			Returns		  	: string HTML paging
	=================================================================================*/

	function paging($pIntPageNo,$intNumRows)
	{
		$objAdsDAO = new AdsDAO();
		$recordLimit = $objAdsDAO->getPagingLimit();
		$pagesLimit = $objAdsDAO->getPagesLimit();
		
		$intNumPages = ceil($intNumRows / $recordLimit);

		$intStartPage=1;
		$intEndPage=$intNumPages;

		if($intNumPages>$pagesLimit)
		{
			$intEndPage=$pagesLimit;
			$intMidPageValue=ceil($pagesLimit/2);
			
			if($pIntPageNo>$intMidPageValue)
			{
				$intStartPage=$pIntPageNo-$intMidPageValue+1;
				$intEndPage=$pIntPageNo+$intMidPageValue-1;
				if(($pIntPageNo-1)>($intNumPages-$intMidPageValue))
				{
					$intStartPage=$intNumPages-$pagesLimit+1;
					$intEndPage=$intNumPages;
				}
			}
		}
		
		if($intNumRows>=$recordLimit) 
		{
			$stringHtml="";
			if($pIntPageNo <= 1) 
			{
				$stringHtml.="<img border=0 align=middle src=/ImageFiles/common/paging/pre.gif>";
			}
			else
			{
				$pvs = $pIntPageNo -1;
				$stringHtml.="<a class=links href=# onclick=GoToPage(". $pvs .")><img border=0 align=middle src=/ImageFiles/common/paging/pre.gif></a>";
			}
				 
			for($_i = $intStartPage ; $_i <= $intEndPage ; $_i++)
			{
				if($_i == $pIntPageNo) 
				{
					$stringHtml.= "&nbsp;<font color=black>".$_i."</font>&nbsp;&nbsp;";
				}
				else 
				{
					$stringHtml.= "&nbsp;<a href=# onclick=GoToPage('".$_i."') class=LinkSmall>".$_i."</a>&nbsp;&nbsp;";
				}
			}
			
			if($pIntPageNo >= $intNumPages)
			{
				$stringHtml.= "<img border=0 align=middle src=/ImageFiles/common/paging/next.gif><br>(Total Pages:".$intNumPages.")";
			}
			else
			{
				$nxt = $pIntPageNo + 1;
				$stringHtml.= "<a class=links href=# onclick=GoToPage('". $nxt ."')><img border=0 align=middle src=/ImageFiles/common/paging/next.gif></a><br>(Total Pages:".$intNumPages.")";
			}
		}
		return $stringHtml;
	}	 
	function AddsDeleteById($pIntAddId)
	{
		/// Generating XML as response
		$this->strResponse="<Response>";	
		try
		{
			
			/// Call Delete palcecast 
			$objAdsDAO = new AdsDAO();
			
			$objAdsDAO->AddsDeleteById($pIntAddId);

			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objAdsDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
			
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}
	/// Mapping functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('GetListPageGroup','GetAddsList','getPagingLimit','paging','AddsRecords','AddsDeleteById'));
		NAJAX_Client::publicMethods($this, array('GetListPageGroup','GetAddsList','getPagingLimit','paging','AddsRecords','AddsDeleteById'));
	}
}

?>