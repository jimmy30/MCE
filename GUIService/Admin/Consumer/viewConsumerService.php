<?php 
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for View Consumers.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Admin Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ConsumerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ConsumerBO.php");

//// Include DO BO class for Admin Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/AdminDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/AdminBO.php");

/// Include other classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");

class viewConsumerService
{
	/// Declaring Response variable	
	var $strResponse;

	/// Admin CHANGE PASSWORD
	function ConsumerListByStatus($pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy)
	{
		
		/// get results as object
		$objConsumerDAO = new ConsumerDAO();
		$objArrayConsumerBO=$objConsumerDAO->ConsumerListByStatus($pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy);
			
			
		if ($objArrayConsumerBO!=null)
		{
			$intCount = count($objArrayConsumerBO);

			$xmlConsumerList='<Consumers>';
			$xmlConsumerList.='<NoOfRecords>'.$intCount.'</NoOfRecords><ConsumerList>';

			for($i=0; $i<$intCount; $i++)
			{

				$objConsumerBO=$objArrayConsumerBO[$i];
				$objConsumerBO=(object)$objConsumerBO;

				$xmlConsumerList.= "<Consumer>";
				$xmlConsumerList.="<ConsumerId>".$objConsumerBO->getConsumerId()."</ConsumerId>";
	
				$xmlConsumerList.="<ConsumerCountryId>".$objConsumerBO->getConsumerCountryId()."</ConsumerCountryId>";
				$xmlConsumerList.="<ConsumerStateId>".$objConsumerBO->getConsumerStateId()."</ConsumerStateId>";
				$xmlConsumerList.="<ConsumerAccountType>".$objConsumerBO->getConsumerAccountType()."</ConsumerAccountType>";
				$xmlConsumerList.="<ConsumerSecretQuestion>".$objConsumerBO->getConsumerSecretQuestion()."</ConsumerSecretQuestion>";
				$xmlConsumerList.="<ConsumerEmail>".$objConsumerBO->getConsumerEmail()."</ConsumerEmail>";
				$xmlConsumerList.="<ConsumerPassword>".$objConsumerBO->getConsumerPassword()."</ConsumerPassword>";
				$xmlConsumerList.="<ConsumerFristName>".$objConsumerBO->getConsumerFristName()."</ConsumerFristName>";
				$xmlConsumerList.="<ConsumerLastName>".$objConsumerBO->getConsumerLastName()."</ConsumerLastName>";
				$xmlConsumerList.="<ConsumerAddress>".$objConsumerBO->getConsumerAddress()."</ConsumerAddress>";
				$xmlConsumerList.="<ConsumerCity>".$objConsumerBO->getConsumerCity()."</ConsumerCity>";
				$xmlConsumerList.="<ConsumerZipCode>".$objConsumerBO->getConsumerZipCode()."</ConsumerZipCode>";
				$xmlConsumerList.="<ConsumerTelephone1>".$objConsumerBO->getConsumerTelephone1()."</ConsumerTelephone1>";
				$xmlConsumerList.="<ConsumerDateOfBirth>".$objConsumerBO->getConsumerDateOfBirth()."</ConsumerDateOfBirth>";
				$xmlConsumerList.="<ConsumerAnswer>".$objConsumerBO->getConsumerAnswer()."</ConsumerAnswer>";
				$xmlConsumerList.="<ConsumerActivationCode>".$objConsumerBO->getConsumerActivationCode()."</ConsumerActivationCode>";
				$xmlConsumerList.="<ConsumerIsVerified>".$objConsumerBO->getConsumerIsVerified()."</ConsumerIsVerified>";
				$xmlConsumerList.="<ConsumerCreateDate>".$objConsumerBO->getConsumerCreateDate()."</ConsumerCreateDate>";
				$xmlConsumerList.="<ConsumerIsActive>".$objConsumerBO->getConsumerIsActive()."</ConsumerIsActive>";
				$xmlConsumerList.="</Consumer>";
			}
			$xmlConsumerList.="</ConsumerList></Consumers>";	
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
			
		return $xmlConsumerList;


	}


	function ConsumerDeleteById($pConsumerId)
	{
		/// Generating XML as response
		$this->strResponse="<Response>";	
		try

		{
			/// Call Delete palcecast 
			$objConsumerDAO = new ConsumerDAO();

			$objConsumerDAO->ConsumerDeleteById($pConsumerId);

			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objConsumerDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
			
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
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
		$objAdminDAO = new AdminDAO();
		$limit = $objAdminDAO->getPagingLimit();
		
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
		Function Name 	: ConsumerRecordCountByStatus
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/

	function ConsumerRecordCountByStatus($pIntIsActive)
	{
		/// Call procedure
		$objConsumerDAO = new ConsumerDAO();
		$numRows=$objConsumerDAO->ConsumerRecordCountByStatus($pIntIsActive);
		return $numRows;
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
		$objAdminDAO = new AdminDAO();
		$recordLimit = $objAdminDAO->getPagingLimit();;
		$pagesLimit = $objAdminDAO->getPagesLimit();
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

	
	/// Mapping Functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('ConsumerListByStatus','getPagingLimit','ConsumerRecordCountByStatus','paging','ConsumerDeleteById'));

		NAJAX_Client::publicMethods($this, array('ConsumerListByStatus','getPagingLimit','ConsumerRecordCountByStatus','paging','ConsumerDeleteById'));
	}
	
	
}

?>

