<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add Waypoint.
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
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/WaypointDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/WaypointBO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/PlaceCastDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/PlaceCastBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utility.php");
/// Include PHPmailer Class for sending Email
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/phpmailer/class.phpmailer.php");


class AddWaypointService
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
	function InsertWaypoint($pIntPlaceCastId, $pChrName, $pChrAddress, $pChrCity, $pDecLat1, $pDecLong1, $pChrDescription, $pDteCreateDate, $pIntIsActive, $pIntPlaceCastCountryId,$pDecRadius)
	{

		/// Generating XML as response
		$this->strResponse="<Response>";	

		try
		{
			/// Set all parameters in an Object
			$objWaypointBO=new WaypointBO();
			$objWaypointBO->setPlaceCastId($pIntPlaceCastId);
			$objWaypointBO->setWaypointName($pChrName);
			$objWaypointBO->setWaypointAddress($pChrAddress);
			$objWaypointBO->setWaypointCity($pChrCity);
			$objWaypointBO->setWaypointLat1($pDecLat1);
			$objWaypointBO->setWaypointLong1($pDecLong1);
			$objWaypointBO->setWaypointDescription($pChrDescription);			
			$objWaypointBO->setWaypointCreateDate($pDteCreateDate);
			$objWaypointBO->setWaypointIsActive($pIntIsActive);
			$objWaypointBO->setWaypointRadius($pDecRadius);
			
			/// Call insert PLACECAST function
			$objWaypointDAO = new WaypointDAO();
			$this->strResponse.=$objWaypointDAO->insert($objWaypointBO,$pIntPlaceCastCountryId);

			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objWaypointDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}	 
	
	function GetPlaceCastById($pPlaceCastId,$pIsActive)	 
	{
		/// set parameter in an object
		$objPlaceCastBO=new PlaceCastBO();
		$objPlaceCastBO->setPlaceCastId($pPlaceCastId);
		$objPlaceCastBO->setPlaceCastIsActive($pIsActive);		
		
		/// get results in an object
		$objPlaceCastDAO = new PlaceCastDAO();
		$objArrayBO=$objPlaceCastDAO->selectById($objPlaceCastBO);
		$objPlaceCastBO = $objArrayBO[0];
		$objCountryBO = $objArrayBO[1];
		$objStateBO = $objArrayBO[2];		
		

		//// Generating Comobox items
		if ($objPlaceCastBO!=null)
		{

			$intCount = count($objPlaceCastBO);

			$strXML='<PlaceCasts>';
			$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><PlaceCastList>';
			
			$strXML.='<PlaceCast>';
			$strXML.='<PlaceCastId>'.$objPlaceCastBO->getPlaceCastId().'</PlaceCastId>';
			$strXML.='<PlaceCastName>'.$objPlaceCastBO->getPlaceCastName().'</PlaceCastName>';
			$strXML.='<PlaceCastAddress>'.$objPlaceCastBO->getPlaceCastAddress().'</PlaceCastAddress>';				
			$strXML.='<PlaceCastCity>'.$objPlaceCastBO->getPlaceCastCity().'</PlaceCastCity>';								
			$strXML.='<PlaceCastCountryName>'.$objCountryBO->getCountryName().'</PlaceCastCountryName>';
			$strXML.='<PlaceCastStateName>'.$objStateBO->getStateName().'</PlaceCastStateName>';																
			$strXML.='<PlaceCastStateZipCode>'.$objPlaceCastBO->getPlaceCastZipCode().'</PlaceCastStateZipCode>';				
			$strXML.='<PlaceCastCountryId>'.$objPlaceCastBO->getPlaceCastCountryId().'</PlaceCastCountryId>';				
			
			$strXML.='<PlaceCastLatOne>'.$objPlaceCastBO->getPlaceCastLat1().'</PlaceCastLatOne>';	
			$strXML.='<PlaceCastLongOne>'.$objPlaceCastBO->getPlaceCastLong1().'</PlaceCastLongOne>';				
			
			$strXML.='<PlaceCastLatTwo>'.$objPlaceCastBO->getPlaceCastLat2().'</PlaceCastLatTwo>';	
			$strXML.='<PlaceCastLongTwo>'.$objPlaceCastBO->getPlaceCastLong2().'</PlaceCastLongTwo>';				
			
			$strXML.='<PlaceCastLatThree>'.$objPlaceCastBO->getPlaceCastLat3().'</PlaceCastLatThree>';	
			$strXML.='<PlaceCastLongThree>'.$objPlaceCastBO->getPlaceCastLong3().'</PlaceCastLongThree>';				
			
			$strXML.='<PlaceCastLatFour>'.$objPlaceCastBO->getPlaceCastLat4().'</PlaceCastLatFour>';	
			$strXML.='<PlaceCastLongFour>'.$objPlaceCastBO->getPlaceCastLong4().'</PlaceCastLongFour>';				
			
			$strXML.='</PlaceCast>';
			$strXML.='</PlaceCastList></PlaceCasts>';

		}
		return $strXML;		

	}

	/// Mapping Function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('InsertWaypoint','FillCmbStateByCountryId','GetPlaceCastById'));
		NAJAX_Client::publicMethods($this, array('InsertWaypoint','FillCmbStateByCountryId','GetPlaceCastById'));
	}
	
	
}

?>

