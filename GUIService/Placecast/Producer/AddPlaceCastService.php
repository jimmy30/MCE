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
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utility.php");

/// Include PHPmailer Class for sending Email
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/phpmailer/class.phpmailer.php");

class AddPlaceCastService
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

	/// POPULATE STATES COMOBOX BY COUNTRY AND STATUS
	function FillCmbStateByCountryId($intCountryId,$intIsActive)
	{

		/// Get XML response as results
		$objStateDAO = new StateDAO();
		$xmlState=$objStateDAO->SearchStateByCountryIdXML($intCountryId,$intIsActive);
		
		if ($xmlState!="")
		{
			return $xmlState;
		}
		else 
		{
			throw new NoRecordFoundExecption("");
		}
	}

	/// INSERT PLACECAST
	function InsertPlaceCast($pIntProducerId, $pIntCountryId, $pIntStateId, $pChrName, $pChrAddress, $pChrCity, $pChrZipCode, $pDecLat1, $pDecLong1, $pDecLat2, $pDecLong2, $pDecLat3, $pDecLong3, $pDecLat4, $pDecLong4, $pChrDescription, $pDteCreateDate, $pIntIsActive)
	{
//return addslashes(htmlentities($pChrDescription,ENT_QUOTES));
		/// Generating XML as response
		$this->strResponse="<Response>";	

		try
		{
			/// Set all parameters in an Object
			$objPlaceCastBO=new PlaceCastBO();
			$objPlaceCastBO->setProducerId($pIntProducerId);
			$objPlaceCastBO->setPlaceCastCountryId($pIntCountryId);
			$objPlaceCastBO->setPlaceCastStateId($pIntStateId);
			$objPlaceCastBO->setPlaceCastName($pChrName);
			$objPlaceCastBO->setPlaceCastAddress($pChrAddress);
			$objPlaceCastBO->setPlaceCastCity($pChrCity);
			$objPlaceCastBO->setPlaceCastZipCode($pChrZipCode);
			$objPlaceCastBO->setPlaceCastLat1($pDecLat1);
			$objPlaceCastBO->setPlaceCastLong1($pDecLong1);
			$objPlaceCastBO->setPlaceCastLat2($pDecLat2);
			$objPlaceCastBO->setPlaceCastLong2($pDecLong2);
			$objPlaceCastBO->setPlaceCastLat3($pDecLat3);
			$objPlaceCastBO->setPlaceCastLong3($pDecLong3);
			$objPlaceCastBO->setPlaceCastLat4($pDecLat4);
			$objPlaceCastBO->setPlaceCastLong4($pDecLong4);
			$objPlaceCastBO->setPlaceCastDescription($pChrDescription);			
			$objPlaceCastBO->setPlaceCastCreateDate($pDteCreateDate);
			$objPlaceCastBO->setPlaceCastIsActive($pIntIsActive);
			
			/// Call insert Producer function
			$objPlaceCastDAO = new PlaceCastDAO();
			$this->strResponse.=$objPlaceCastDAO->insert($objPlaceCastBO);
			//return $this->strResponse;

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
	/// Mapping Function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('InsertPlaceCast','FillCmbStateByCountryId'));
		NAJAX_Client::publicMethods($this, array('InsertPlaceCast','FillCmbStateByCountryId'));
	}
	
	
}

?>

