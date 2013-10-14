<?php 
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Consumer Activation.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Consumer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ConsumerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ConsumerBO.php");

/// Include other classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class ConsumerActivationService
{
	/// Declaring Response variable	
	var $strResponse;
	
	/// Consumer ACTIVATION
	function ConsumerActivation($pStrEmail,$pStrActivationCode)
	{
		
		try
		{
			/// Set XML string
			$this->strResponse="<Response>";

			/// Set parameters in an object
			$objConsumerBO=new ConsumerBO();
			$objConsumerBO->setConsumerEmail($pStrEmail);
			$objConsumerBO->setConsumerActivationCode($pStrActivationCode);

			/// get results as status
			$objConsumerDAO = new ConsumerDAO();
			$intStatus=$objConsumerDAO->activation($objConsumerBO);
	
			if($intStatus==1) // if Registration activatation done
			{
				/// Set XML value
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";			
			}
			else if($intStatus==0) // if not done
			{
				/// Set XML value
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			}
		}
		catch(Exception $e)
		{
			/// Set XML values
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objConsumerDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$e->getMessage()."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$e->getLine()."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$e->getFile()."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$e->getTraceAsString()."</ExceptionDetail>";
			
		}
		/// set XML string
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;

	
	}
	
	/// Mapping function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('FillCmbStateByCountryId','ConsumerActivation'));

		NAJAX_Client::publicMethods($this, array('FillCmbStateByCountryId','ConsumerActivation'));
	}
	
	
}

?>

