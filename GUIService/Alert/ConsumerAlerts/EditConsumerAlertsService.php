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

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class EditConsumerAlertsService
{
			
	/// POPULATE COUNTRY COMOBOX BY STATUS
	function FillCmbCountry($intIsActive)
	{
		/// Get results
		$objCountryDAO = new CountryDAO();
		$objCountryBOAarray=$objCountryDAO->getList($intIsActive);

		//// Generating Comobox items
		if ($objCountryBOAarray!=null)
		{
			$intCount = count($objCountryBOAarray);
			for($i=0; $i<$intCount; $i++)
			{
				$objCountryBO=$objCountryBOAarray[$i];
				$objCountryBO=(object)$objCountryBO;
				echo("<option value=".$objCountryBO->getCountryId().">".$objCountryBO->getCountryName()."</option>");
			}	
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
	}	 

	// GET CONSUMER ALERT BY CONSUMER ALERT ID
	function GetConsumerAlertById($pConsumerAlertId)
	{
	try
	{

		/// get results in an object
		$objConsumerAlertDAO = new ConsumerAlertDAO();
		$objConsumerAlertBO=$objConsumerAlertDAO->GetConsumerAlertById($pConsumerAlertId);

		$objConsumerAlertBO=(object)$objConsumerAlertBO;
				
		$strXML='<ConsumerAlert>';
		$strXML.='<ConsumerAlertId>'.$objConsumerAlertBO->getConsumerAlertId().'</ConsumerAlertId>';
		$strXML.='<ConsumerId>'.$objConsumerAlertBO->getConsumerId().'</ConsumerId>';				
		$strXML.='<CountryId>'.$objConsumerAlertBO->getCountryId().'</CountryId>';								
		$strXML.='<Add>'.$objConsumerAlertBO->getAdd().'</Add>';
		$strXML.='<Modify>'.$objConsumerAlertBO->getModify().'</Modify>';
		$strXML.='<IsActive>'.$objConsumerAlertBO->getIsActive().'</IsActive>';				
		$strXML.='</ConsumerAlert>';
		
	return $strXML;
	}
	catch (Exception  $e)
	{
		echo("Exception occured</br>");
		$e->displayMessage();
	}


	}
	
	/// UPDATE ALERT
	function UpdateAlert($pIntConsumerAlertId, $pIntConsumerId, $pIntCountryId, $pIntAdd, $pIntModify, $pIntIsActive)
	{

		/// Generating XML as response
		$this->strResponse="<Response>";	

		try
		{
			/// Set all parameters in an Object
			$objConsumerAlertBO=new ConsumerAlertBO();
			$objConsumerAlertBO->setConsumerAlertId($pIntConsumerAlertId);
			$objConsumerAlertBO->setConsumerId($pIntConsumerId);			
			$objConsumerAlertBO->setCountryId($pIntCountryId);			
			$objConsumerAlertBO->setAdd($pIntAdd);
			$objConsumerAlertBO->setModify($pIntModify);			
			$objConsumerAlertBO->setIsActive($pIntIsActive);


			/// Call insert Consumer alert function
			$objConsumerAlertDAO = new ConsumerAlertDAO();
			$intStatus.=$objConsumerAlertDAO->UpdateAlert($objConsumerAlertBO);

			if($intStatus==1)
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
			else
				$this->strResponse=$this->strResponse."<Status>".$intStatus."</Status>";
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
	/// Mapping Function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('InsertAlert','GetConsumerAlertById','UpdateAlert'));
		NAJAX_Client::publicMethods($this, array('InsertAlert','GetConsumerAlertById','UpdateAlert'));
	}
	
	
}

?>

