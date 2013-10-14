<?php 
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Producer Activation.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ProducerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ProducerBO.php");

/// Include other classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class ProducerActivationService
{
	/// Declaring Response variable	
	var $strResponse;
	
	/// Producer ACTIVATION
	function ProducerActivation($pStrEmail,$pStrActivationCode)
	{
		
		try
		{
			/// Set XML string
			$this->strResponse="<Response>";

			/// Set parameters in an object
			$objProducerBO=new ProducerBO();
			$objProducerBO->setProducerEmail($pStrEmail);
			$objProducerBO->setProducerActivationCode($pStrActivationCode);

			/// get results as status
			$objProducerDAO = new ProducerDAO();
			$intStatus=$objProducerDAO->activation($objProducerBO);
	
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
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objProducerDAO->intErrorNo."</ExceptionNo>";
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
		NAJAX_Client::mapMethods($this, array('FillCmbStateByCountryId','ProducerActivation'));

		NAJAX_Client::publicMethods($this, array('FillCmbStateByCountryId','ProducerActivation'));
	}
	
	
}

?>

