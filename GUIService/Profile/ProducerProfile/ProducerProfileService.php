<?php 
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Edit Producer profile.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for AccountType Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/AccountTypesDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/AccountTypeBO.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");

//// Include DO BO class for State Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/StateDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/StateBO.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ProducerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ProducerBO.php");

//// Include DO BO class for SecretQuestion Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/SecretQuestionDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/SecretQuestionBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");	

class ProducerProfileService
{
	/// Declaring Response variable	
	var $strResponse;
	

	/// POPULATE ACCOUNT TYPE COMOBOX BY STATUS
	function FillCmbAccountType($intIsActive)
	{
		/// Get results
		$objAccountTypeDAO = new AccountTypeDAO();
		$objAccountTypeBOAarray=$objAccountTypeDAO->getList($intIsActive);
		
		//// Generating Comobox items
		if ($objAccountTypeBOAarray!=null)
		{
			$intCount = count($objAccountTypeBOAarray);
			for($i=0; $i<$intCount; $i++)
			{
				$objAccountTypeBO=$objAccountTypeBOAarray[$i];
				$objAccountTypeBO=(object)$objAccountTypeBO;
				echo("<option value=".$objAccountTypeBO->getAccountTypeId().">".$objAccountTypeBO->getAccountTypeName()."</option>");
			}	
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
	}	 
			
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

	/// UPDATE PRODUCER PROFILE
	function UpdateProducer($pStrEmail, $pIntCountryId, $pIntStateId, $pIntAccountType, $pChrFirstName, $pChrLastName, $pChrAddress, $pChrCity, $pChrZipCode, $pChrTelephone1, $pDteDateOfBirth, $pIntSecretQuestion, $pChrAnswer)
	{
		/// Set Value in xml String
		$this->strResponse="<Response>";
		
		try
		{
			/// set parameters in an object
			$objProducerBO=new ProducerBO();
			$objProducerBO->setProducerEmail($pStrEmail);
			$objProducerBO->setProducerCountryId($pIntCountryId);
			$objProducerBO->setProducerStateId($pIntStateId);
			$objProducerBO->setProducerAccountType($pIntAccountType);
			$objProducerBO->setProducerSecretQuestion($pIntSecretQuestion);
			$objProducerBO->setProducerFristName($pChrFirstName);
			$objProducerBO->setProducerLastName($pChrLastName);
			$objProducerBO->setProducerAddress($pChrAddress);
			$objProducerBO->setProducerCity($pChrCity);
			$objProducerBO->setProducerZipCode($pChrZipCode);
			$objProducerBO->setProducerTelephone1($pChrTelephone1);
			$objProducerBO->setProducerDateOfBirth($pDteDateOfBirth);
			$objProducerBO->setProducerAnswer($pChrAnswer);
			
			/// Call update Producer profile
			$objProducerDAO = new ProducerDAO();
			$objProducerDAO->update($objProducerBO);

			/// Set Value in xml String
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();

			/// Set Values in xml String
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objProducerDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
			
		}

		/// Set Values in xml String
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}	 

	/// POPULATE SECRET QUESTION COMOBOX OF DOB 
	function FillCmbSecretQuestion($intIsActive)
	{
		/// Get results
		$objSecretQuestionDAO = new SecretQuestionDAO();
		$objSecretQuestionBOAarray=$objSecretQuestionDAO->getList($intIsActive);

		//// Generating Comobox items
		if ($objSecretQuestionBOAarray!=null)
		{
			$intCount = count($objSecretQuestionBOAarray);
			for($i=0; $i<$intCount; $i++)
			{
				$objSecretQuestionBO=$objSecretQuestionBOAarray[$i];
				$objSecretQuestionBO=(object)$objSecretQuestionBO;
				echo("<option value=".$objSecretQuestionBO->getSecretQuestionId().">".$objSecretQuestionBO->getSecretQuestionName()."</option>");
			}	
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
	}	 
	

	/// POPULATE DAY COMOBOX OF DOB
	function FillCmbDay()
	{
		for($i=1;$i<=31;$i++)
		{
			if($i<10) $i="0".$i;
			echo "<option value=".$i.">".$i."</option>";
		}
	}

	/// POPULATE MONTH COMOBOX OF DOB 
	function FillCmbMonth()
	{
		for($i=1;$i<=12;$i++)
		{
			$mkdate=mktime(0,0,0,$i,1,2006);
			echo "<option value='".date('m',$mkdate)."'>".date('F',$mkdate)."</option>";
		}
	}	 
	
	/// GET PRODUCER LIST BY EMAIL
	function GetProducerListByEmail($pProducerEmail)	 
	{
		/// set parameter in an object
		$objProducerBO=new ProducerBO();
		$objProducerBO->setProducerEmail($pProducerEmail);
		
		/// get results in an object
		$objProducerDAO = new ProducerDAO();
		$objProducerBO=$objProducerDAO->select($objProducerBO);
		
		/// Generate XML string 
		if ($objProducerBO!=null)
		{
			$objProducerBO=(object)$objProducerBO;
			$xmlProducerList= "<ProducerList>";
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
			$xmlProducerList.="</ProducerList>";

		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
		
		return $xmlProducerList;

	}
	
	/// Mapping functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('FillCmbStateByCountryId','UpdateProducer','GetProducerListByEmail'));

		NAJAX_Client::publicMethods($this, array('FillCmbStateByCountryId','UpdateProducer','GetProducerListByEmail'));
	}
	
}

?>

