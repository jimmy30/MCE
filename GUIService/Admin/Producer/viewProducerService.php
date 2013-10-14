<?php 
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for View Producers.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Admin Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ProducerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ProducerBO.php");

//// Include DO BO class for Admin Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/AdminDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/AdminBO.php");

/// Include other classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");

class viewProducerService
{
	/// Declaring Response variable	
	var $strResponse;

	/// Admin CHANGE PASSWORD
	function ProducerListByStatus($pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy)
	{
		
		/// get results as object
		$objProducerDAO = new ProducerDAO();
		$objArrayProducerBO=$objProducerDAO->ProducerListByStatus($pIntStart,$pIntNumRows,$pIntIsActive,$pIntSortListBy);
			
			
		if ($objArrayProducerBO!=null)
		{
			$intCount = count($objArrayProducerBO);

			$xmlProducerList='<Producers>';
			$xmlProducerList.='<NoOfRecords>'.$intCount.'</NoOfRecords><ProducerList>';

			for($i=0; $i<$intCount; $i++)
			{

				$objProducerBO=$objArrayProducerBO[$i];
				$objProducerBO=(object)$objProducerBO;

				$xmlProducerList.= "<Producer>";
				$xmlProducerList.="<ProducerId>".$objProducerBO->getProducerId()."</ProducerId>";
	
				$xmlProducerList.="<ProducerCountryId>".$objProducerBO->getProducerCountryId()."</ProducerCountryId>";
				$xmlProducerList.="<ProducerStateId>".$objProducerBO->getProducerStateId()."</ProducerStateId>";
				$xmlProducerList.="<ProducerAccountType>".$objProducerBO->getProducerAccountType()."</ProducerAccountType>";
				$xmlProducerList.="<ProducerSecretQuestion>".$objProducerBO->getProducerSecretQuestion()."</ProducerSecretQuestion>";
				$xmlProducerList.="<ProducerEmail>".$objProducerBO->getProducerEmail()."</ProducerEmail>";
				$xmlProducerList.="<ProducerPassword>".$objProducerBO->getProducerPassword()."</ProducerPassword>";
				$xmlProducerList.="<ProducerFristName>".$objProducerBO->getProducerFristName()."</ProducerFristName>";
				$xmlProducerList.="<ProducerLastName>".$objProducerBO->getProducerLastName()."</ProducerLastName>";
				$xmlProducerList.="<ProducerAddress>".$objProducerBO->getProducerAddress()."</ProducerAddress>";
				$xmlProducerList.="<ProducerCity>".$objProducerBO->getProducerCity()."</ProducerCity>";
				$xmlProducerList.="<ProducerZipCode>".$objProducerBO->getProducerZipCode()."</ProducerZipCode>";
				$xmlProducerList.="<ProducerTelephone1>".$objProducerBO->getProducerTelephone1()."</ProducerTelephone1>";
				$xmlProducerList.="<ProducerDateOfBirth>".$objProducerBO->getProducerDateOfBirth()."</ProducerDateOfBirth>";
				$xmlProducerList.="<ProducerAnswer>".$objProducerBO->getProducerAnswer()."</ProducerAnswer>";
				$xmlProducerList.="<ProducerActivationCode>".$objProducerBO->getProducerActivationCode()."</ProducerActivationCode>";
				$xmlProducerList.="<ProducerIsVerified>".$objProducerBO->getProducerIsVerified()."</ProducerIsVerified>";
				$xmlProducerList.="<ProducerCreateDate>".$objProducerBO->getProducerCreateDate()."</ProducerCreateDate>";
				$xmlProducerList.="<ProducerIsActive>".$objProducerBO->getProducerIsActive()."</ProducerIsActive>";
				$xmlProducerList.="</Producer>";
			}
			$xmlProducerList.="</ProducerList></Producers>";	
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
			
		return $xmlProducerList;


	}


	function ProducerDeleteById($pProducerId)
	{
		/// Generating XML as response
		$this->strResponse="<Response>";	
		try

		{
			/// Call Delete palcecast 
			$objProducerDAO = new ProducerDAO();

			$objProducerDAO->ProducerDeleteById($pProducerId);

			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objProducerDAO->intErrorNo."</ExceptionNo>";
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
		Function Name 	: ProducerRecordCountByStatus
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/

	function ProducerRecordCountByStatus($pIntIsActive)
	{
		/// Call procedure
		$objProducerDAO = new ProducerDAO();
		$numRows=$objProducerDAO->ProducerRecordCountByStatus($pIntIsActive);
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
		NAJAX_Client::mapMethods($this, array('ProducerListByStatus','getPagingLimit','ProducerRecordCountByStatus','paging','ProducerDeleteById'));

		NAJAX_Client::publicMethods($this, array('ProducerListByStatus','getPagingLimit','ProducerRecordCountByStatus','paging','ProducerDeleteById'));
	}
	
	
}

?>

