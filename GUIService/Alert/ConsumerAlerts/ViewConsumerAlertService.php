<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add Consumer Alerts.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");

//// Include DO BO class for ConsumerAlert Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ConsumerAlertDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ConsumerAlertBO.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");


//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class ViewConsumerAlertService
{
			
	/// LIST PLACECAST BY PRODUCER ID
	function GetListByConsumerId($pIntConsumerId,$start,$limit,$pIntIsActive,$pIntSortListBy)
	{
		$objConsumerAlertDAO = new ConsumerAlertDAO();

		$objObjectArray=$objConsumerAlertDAO->GetListByConsumerId($pIntConsumerId,$start,$limit,$pIntSortListBy);

		//// Generating Comobox items
		if ($objObjectArray!=null)
		{

			$intCount = count($objObjectArray[0]);

			$strXML='<ConsumerAlerts>';
			$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><ConsumerAlertList>';
			
			for($i=0; $i<$intCount; $i++)
			{
				
				$objConsumerAlertBO=(object)$objObjectArray[0][$i];
				$objCountryBO=(object)$objObjectArray[1][$i];
				
				if(($objConsumerAlertBO->getCountryId())==-1)
					$CountryName = "All Countries";
				else
				{
					$CountryName = $objCountryBO->getCountryName();
				}
				
				$strXML.='<ConsumerAlert>';
				$strXML.='<ConsumerAlertId>'.$objConsumerAlertBO->getConsumerAlertId().'</ConsumerAlertId>';
				$strXML.='<ConsumerId>'.$objConsumerAlertBO->getConsumerId().'</ConsumerId>';				
				$strXML.='<CountryName>'.$CountryName.'</CountryName>';								
				$strXML.='<Add>'.$objConsumerAlertBO->getAdd().'</Add>';
				$strXML.='<Modify>'.$objConsumerAlertBO->getModify().'</Modify>';
				$strXML.='<IsActive>'.$objConsumerAlertBO->getIsActive().'</IsActive>';				
				$strXML.='</ConsumerAlert>';
			}
			$strXML.='</ConsumerAlertList></ConsumerAlerts>';

		}
		return $strXML;		
	}


	function ConsumerAlertDeleteById($pConsumerAlertId)
	{

		/// Generating XML as response
		$this->strResponse="<Response>";	
		try
		{
			/// Call Delete palcecast 
			$objConsumerAlertDAO = new ConsumerAlertDAO();
			$objConsumerAlertDAO->ConsumerAlertDeleteById($pConsumerAlertId);

			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objConsumerAlertDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
			
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}	 

/*=================================================================================
		Function Name 	: AlertRecordCountByConsumer
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/

	function AlertRecordCountByConsumer($pIntConsumerId)
	{
		/// Call procedure
		$objConsumerAlertDAO = new ConsumerAlertDAO();
		$numRows=$objConsumerAlertDAO->AlertRecordCountByConsumer($pIntConsumerId);
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
		$objConsumerAlertDAO = new ConsumerAlertDAO();
		$limit = $objConsumerAlertDAO->getPagingLimit();
		
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
		$objConsumerAlertDAO = new ConsumerAlertDAO();
		$recordLimit = $objConsumerAlertDAO->getPagingLimit();
		$pagesLimit = $objConsumerAlertDAO->getPagesLimit();
		
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
		NAJAX_Client::mapMethods($this, array('GetListByConsumerId','ConsumerAlertDeleteById','PlaceCastRecordCount','AlertRecordCountByConsumer','getPagingLimit','paging'));

		NAJAX_Client::publicMethods($this, array('GetListByConsumerId','ConsumerAlertDeleteById','PlaceCastRecordCount','AlertRecordCountByConsumer','getPagingLimit','paging'));
	}

	
}

?>
