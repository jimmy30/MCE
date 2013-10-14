<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add PlaceCast.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");

//// Include DO BO class for State Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/StateDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/StateBO.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/PlaceCastDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/PlaceCastBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

/// Include XML Encode class
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");	

class ViewPlaceCastService
{
			
	/// LIST PLACECAST BY PRODUCER ID
	function GetListByProducerId($pIntProducerId,$start,$limit,$pIntIsActive,$pIntSortListBy)
	{
		$objPlaceCastDAO = new PlaceCastDAO();
		$objPlaceCastBOAarray=$objPlaceCastDAO->GetListByProducerId($pIntProducerId,$start,$limit,$pIntIsActive,$pIntSortListBy);

		//// Generating Comobox items
		if ($objPlaceCastBOAarray[0][0]!=null)
		{

			$intCount = count($objPlaceCastBOAarray[0][0]);

			$strXML='<PlaceCasts>';
			$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><PlaceCastList>';
			
			for($i=0; $i<$intCount; $i++)
			{

				$objPlaceCastBO=$objPlaceCastBOAarray[0][0][$i];
				$objPlaceCastBO=(object)$objPlaceCastBO;
				
				$objCountryBO=$objPlaceCastBOAarray[0][1][$i];
				$objCountryBO=(object)$objCountryBO;
				
				$objStateBO=$objPlaceCastBOAarray[1][1][$i];
				$objStateBO=(object)$objStateBO;
				
				$strXML.='<PlaceCast>';
				$strXML.='<PlaceCastId>'.$objPlaceCastBO->getPlaceCastId().'</PlaceCastId>';
				$strXML.='<PlaceCastName>'.$objPlaceCastBO->getPlaceCastName().'</PlaceCastName>';
				$strXML.='<PlaceCastAddress>'.$objPlaceCastBO->getPlaceCastAddress().'</PlaceCastAddress>';				
				$strXML.='<PlaceCastCity>'.$objPlaceCastBO->getPlaceCastCity().'</PlaceCastCity>';								
				$strXML.='<PlaceCastCountryName>'.$objCountryBO->getCountryName().'</PlaceCastCountryName>';
				$strXML.='<PlaceCastStateName>'.$objStateBO->getStateName().'</PlaceCastStateName>';																
				$strXML.='<PlaceCastStateZipCode>'.$objPlaceCastBO->getPlaceCastZipCode().'</PlaceCastStateZipCode>';				
				$strXML.='</PlaceCast>';
			}
			$strXML.='</PlaceCastList></PlaceCasts>';

		}
		return $strXML;		
	}	 


	function PlaceCastDeleteById($pPlaceCastId)
	{

		/// Generating XML as response
		$this->strResponse="<Response>";	
		try
		{
			/// Call Delete palcecast 
			$objPlaceCastDAO = new PlaceCastDAO();
			$objPlaceCastDAO->PlaceCastDeleteById($pPlaceCastId);
 
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objPlaceCastDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
			
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}	 

/*=================================================================================
		Function Name 	: PlaceCastRecordCountByCutomer
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/

	function PlaceCastRecordCountByProducer($pIntProducerId,$pIntIsActive)
	{
		/// Call procedure
		$objPlaceCastDAO = new PlaceCastDAO();
		$numRows=$objPlaceCastDAO->PlaceCastRecordCountByProducer($pIntProducerId,$pIntIsActive);
		return $numRows;
	}	 


/*=================================================================================
		Function Name 	: getPagingLimit
		Created On    	: 01-Aug-2006 
		Synopsis	  	: set pagming limit values according page no
		Input Parameter : integer page No
		Returns		  	: integer start limit, integer no. of rows
=================================================================================*/

	function getPagingLimit($pIntPageNo)
	{
		$objPlaceCastDAO = new PlaceCastDAO();
		$limit = $objPlaceCastDAO->getPagingLimit();
		
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
		Created On    	: 01-Aug-2006 
		Synopsis	  	: generate paging html
		Input Parameter : integer page No, integer total no. of rows
		Returns		  	: string HTML paging
=================================================================================*/

	function paging($pIntPageNo,$intNumRows)
	{
		$objPlaceCastDAO = new PlaceCastDAO();
		$recordLimit = $objPlaceCastDAO->getPagingLimit();
		$pagesLimit = $objPlaceCastDAO->getPagesLimit();
		
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


	/// Mapping functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('GetListByProducerId','GetListActive','PlaceCastDeleteById','PlaceCastRecordCount','PlaceCastRecordCountByProducer','getPagingLimit','paging'));

		NAJAX_Client::publicMethods($this, array('GetListByProducerId','GetListActive','PlaceCastDeleteById','PlaceCastRecordCount','PlaceCastRecordCountByProducer','getPagingLimit','paging'));
	}

	
}

?>
