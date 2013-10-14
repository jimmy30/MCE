<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Producer Registration.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/EmailException.php");

//// Include DO BO class for AccountType Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/AccountTypesDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/AccountTypeBO.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");

//// Include DO BO class for State Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/StateDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/StateBO.php");

//// Include DO BO class for Cellular Provider Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CellularProviderDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CellularProviderBO.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ProducerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ProducerBO.php");

//// Include DO BO class for Consumer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ConsumerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ConsumerBO.php");

//// Include DO BO class for SecretQuestion Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/SecretQuestionDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/SecretQuestionBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utility.php");

/// Include XML Encode class
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");	

/// Include PHPmailer Class for sending Email
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/phpmailer/class.phpmailer.php");

class RegistrationService
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

	function FillCmbCellularByCountryId($intCountryId,$intIsActive)
	{

		/// Get XML response as results
		$objCellularProviderDAO = new CellularProviderDAO();
		$xmlCellular=$objCellularProviderDAO->SearchCellularProviderByCountryIdXML($intCountryId,$intIsActive);
		
		if ($xmlCellular!="")
		{
//			$handle=fopen('c:/test.xml',w);
//			fwrite($handle,$xmlCellular);
//			fclose($handle);
			return $xmlCellular;
			
		}
		else 
		{
			throw new NoRecordFoundExecption("");
		}
	}

	/// INSERT PRODUCER
	function InsertProducer($pIntCountryId, $pIntStateId, $pIntAccountType, $pChrEmail, $pChrPassword, $pChrFirstName, $pChrLastName, $pChrAddress, $pChrCity, $pChrZipCode, $pChrTelephone1, $pDteDateOfBirth, $pIntSecretQuestion, $pChrAnswer, $pStrActivationCode, $pIntIsVerified, $pDteCreateDate, $pIntIsActive,$strMobileNumber,$intCellularId)
	{

		/// Generating XML as response
		$this->strResponse="<Response>";	

		/// Get Registration Activation Code
		$objUtility = new Utility();
		$pStrActivationCode=$objUtility->GetActivationCode();

		try
		{
			/// Set all parameters in an Object
			$objProducerBO=new ProducerBO();
			$objProducerBO->setProducerCountryId($pIntCountryId);
			$objProducerBO->setProducerStateId($pIntStateId);
			$objProducerBO->setProducerAccountType($pIntAccountType);
			$objProducerBO->setProducerSecretQuestion($pIntSecretQuestion);
			$objProducerBO->setProducerEmail($pChrEmail);
			$objProducerBO->setProducerPassword($pChrPassword);
			$objProducerBO->setProducerFristName($pChrFirstName);
			$objProducerBO->setProducerLastName($pChrLastName);
			$objProducerBO->setProducerAddress($pChrAddress);
			$objProducerBO->setProducerCity($pChrCity);
			$objProducerBO->setProducerZipCode($pChrZipCode);
			$objProducerBO->setProducerTelephone1($pChrTelephone1);
			$objProducerBO->setProducerTelephone2($pChrTelephone2);
			$objProducerBO->setProducerTelephone3($pChrTelephone3);
			$objProducerBO->setProducerExtension($pChrExtension);
			$objProducerBO->setProducerDateOfBirth($pDteDateOfBirth);
			$objProducerBO->setProducerAnswer($pChrAnswer);
			$objProducerBO->setProducerActivationCode($pStrActivationCode);
			$objProducerBO->setProducerIsVerified($pIntIsVerified);
			$objProducerBO->setProducerCreateDate($pDteCreateDate);
			$objProducerBO->setProducerIsActive($pIntIsActive);
			
			/// Call insert producer function
			$objProducerDAO = new ProducerDAO();
			$objProducerDAO->insert($objProducerBO);

			/// Set all parameters in an Object
			$objConsumerBO=new ConsumerBO();
			$objConsumerBO->setConsumerCountryId($pIntCountryId);
			$objConsumerBO->setConsumerStateId($pIntStateId);
			$objConsumerBO->setConsumerAccountType($pIntAccountType);
			$objConsumerBO->setConsumerSecretQuestion($pIntSecretQuestion);
			$objConsumerBO->setConsumerEmail($pChrEmail);
			$objConsumerBO->setConsumerPassword($pChrPassword);
			$objConsumerBO->setConsumerFristName($pChrFirstName);
			$objConsumerBO->setConsumerLastName($pChrLastName);
			$objConsumerBO->setConsumerAddress($pChrAddress);
			$objConsumerBO->setConsumerCity($pChrCity);
			$objConsumerBO->setConsumerZipCode($pChrZipCode);
			$objConsumerBO->setConsumerTelephone1($pChrTelephone1);
			$objConsumerBO->setConsumerTelephone2($pChrTelephone2);
			$objConsumerBO->setConsumerTelephone3($pChrTelephone3);
			$objConsumerBO->setConsumerExtension($pChrExtension);
			$objConsumerBO->setConsumerDateOfBirth($pDteDateOfBirth);
			$objConsumerBO->setConsumerAnswer($pChrAnswer);
			$objConsumerBO->setConsumerActivationCode($pStrActivationCode);
			$objConsumerBO->setConsumerIsVerified($pIntIsVerified);
			$objConsumerBO->setConsumerCreateDate($pDteCreateDate);
			$objConsumerBO->setConsumerIsActive($pIntIsActive);
			$objConsumerBO->setMobileNumber($strMobileNumber);
			$objConsumerBO->setCellularId($intCellularId);

			/// Call insert Consumer function
			$objConsumerDAO = new ConsumerDAO();
			$objConsumerDAO->insert($objConsumerBO,1);

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

	function IsConsumerProducer($pEmail)
	{
		/// Call insert producer function
		$objProducerDAO = new ProducerDAO();
		$intStatus=$objProducerDAO->IsConsumerProducer($pEmail);
		return $intStatus;
	}
	
	/// Mapping Function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('FillCmbStateByCountryId','InsertProducer','FillCmbCellularByCountryId','IsConsumerProducer'));

		NAJAX_Client::publicMethods($this, array('FillCmbStateByCountryId','InsertProducer','FillCmbCellularByCountryId','IsConsumerProducer'));
	}
	
}

?>

