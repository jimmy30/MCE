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

class EditPlaceCastService
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

	function GetPlaceCastById($pPlaceCastId,$pIsActive)	 
	{
	try
	{
		/// set parameter in an object
		$objPlaceCastBO=new PlaceCastBO();
		$objPlaceCastBO->setPlaceCastId($pPlaceCastId);
		$objPlaceCastBO->setPlaceCastIsActive($pIsActive);		
		
		/// get results in an object
		$objPlaceCastDAO = new PlaceCastDAO();
		$objArrayBO=$objPlaceCastDAO->selectById($objPlaceCastBO);
		$objPlaceCastBO = $objArrayBO[0];
		
		/// Generate XML string 
		if ($objPlaceCastBO!=null)
		{
//			$objPlaceCastBO=(object)$objPlaceCastBO;
			$xmlPlaceCastList= "<PlaceCast>";
			$xmlPlaceCastList.="<PlaceCastProducerId>".$objPlaceCastBO->getProducerId()."</PlaceCastProducerId>";
			$xmlPlaceCastList.="<PlaceCastCountryId>".$objPlaceCastBO->getPlaceCastCountryId()."</PlaceCastCountryId>";
			$xmlPlaceCastList.="<PlaceCastStateId>".$objPlaceCastBO->getPlaceCastStateId()."</PlaceCastStateId>";
			$xmlPlaceCastList.="<PlaceCastName>".$objPlaceCastBO->getPlaceCastName()."</PlaceCastName>";
			$xmlPlaceCastList.="<PlaceCastAddress>".$objPlaceCastBO->getPlaceCastAddress()."</PlaceCastAddress>";
			$xmlPlaceCastList.="<PlaceCastCity>".$objPlaceCastBO->getPlaceCastCity()."</PlaceCastCity>";
			$xmlPlaceCastList.="<PlaceCastZipCode>".$objPlaceCastBO->getPlaceCastZipCode()."</PlaceCastZipCode>";
			$xmlPlaceCastList.="<PlaceCastLat1>".$objPlaceCastBO->getPlaceCastLat1()."</PlaceCastLat1>";			
			$xmlPlaceCastList.="<PlaceCastLong1>".$objPlaceCastBO->getPlaceCastLong1()."</PlaceCastLong1>";			
			$xmlPlaceCastList.="<PlaceCastLat2>".$objPlaceCastBO->getPlaceCastLat2()."</PlaceCastLat2>";			
			$xmlPlaceCastList.="<PlaceCastLong2>".$objPlaceCastBO->getPlaceCastLong2()."</PlaceCastLong2>";			
			$xmlPlaceCastList.="<PlaceCastLat3>".$objPlaceCastBO->getPlaceCastLat3()."</PlaceCastLat3>";			
			$xmlPlaceCastList.="<PlaceCastLong3>".$objPlaceCastBO->getPlaceCastLong3()."</PlaceCastLong3>";			
			$xmlPlaceCastList.="<PlaceCastLat4>".$objPlaceCastBO->getPlaceCastLat4()."</PlaceCastLat4>";			
			$xmlPlaceCastList.="<PlaceCastLong4>".$objPlaceCastBO->getPlaceCastLong4()."</PlaceCastLong4>";			
			$xmlPlaceCastList.="<PlaceCastDescription>".htmlentities($objPlaceCastBO->getPlaceCastDescription())."</PlaceCastDescription>";
			$xmlPlaceCastList.="</PlaceCast>";

		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
		return $xmlPlaceCastList;
		}
		catch (Exception  $e)
		{
			echo("Exception occured</br>");
			$e->displayMessage();
		}
	}


	/// UPDATE PLACECAST
	function UpdatePlaceCast($pIntPlaceCastId, $pIntCountryId, $pIntStateId, $pChrName, $pChrAddress, $pChrCity, $pChrZipCode, $pDecLat1, $pDecLong1, $pDecLat2, $pDecLong2, $pDecLat3, $pDecLong3, $pDecLat4, $pDecLong4, $pChrDescription)
	{
		/// Generating XML as response
		$this->strResponse="<Response>";	

		try
		{
			/// Set all parameters in an Object
			$objPlaceCastBO=new PlaceCastBO();
			$objPlaceCastBO->setPlaceCastId($pIntPlaceCastId);
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
		
			/// Call insert Producer function
			$objPlaceCastDAO = new PlaceCastDAO();
			$objPlaceCastDAO->update($objPlaceCastBO);

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
		NAJAX_Client::mapMethods($this, array('UpdatePlaceCast','FillCmbStateByCountryId','GetPlaceCastById'));
		NAJAX_Client::publicMethods($this, array('UpdatePlaceCast','FillCmbStateByCountryId','GetPlaceCastById'));
	}
	
	
}

?>

