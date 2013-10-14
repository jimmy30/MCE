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

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");

//// Include DO BO class for State Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/StateBO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/StateDAO.php");

//// Include DO BO class for Cellular Provider Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CellularProviderDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CellularProviderBO.php");

//// Include DO BO class for SecretQuestion Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/SecretQuestionBO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/SecretQuestionDAO.php");

//// Include DO BO class for AccountType Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/AccountTypeBO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/AccountTypesDAO.php");


/// Include other classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");

class EditConsumerService
{
	/// Declaring Response variable	
	var $strResponse;

	/// Admin CHANGE PASSWORD
	function ConsumerGetById($pIntConsumerId)
	{
		/// get results as object
		$objConsumerDAO = new ConsumerDAO();
		$objArrayConsumer=$objConsumerDAO->ConsumerGetById($pIntConsumerId);

		if ($objArrayConsumer!=null)
		{

			$objConsumerBO=(object)$objArrayConsumer[0];
			$objCountryBO=(object)$objArrayConsumer[1];
			$objStateBO=(object)$objArrayConsumer[2];
			$objSecretQuestionBO=(object)$objArrayConsumer[3];
			$objAccountTypeBO=(object)$objArrayConsumer[4];
			
			
			$xmlConsumerList='<Consumers>';
			$xmlConsumerList.='<NoOfRecords>'.$intCount.'</NoOfRecords><ConsumerList>';

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
			$xmlConsumerList.="<CountryName>".$objCountryBO->getCountryName()."</CountryName>";
			$xmlConsumerList.="<StateName>".$objStateBO->getStateName()."</StateName>";			
			$xmlConsumerList.="<QuestionName>".$objSecretQuestionBO->getSecretQuestionName()."</QuestionName>";						
			$xmlConsumerList.="<AccountType>".$objAccountTypeBO->getAccountTypeName()."</AccountType>";									
			$xmlConsumerList.="<ConsumerMobile>".$objConsumerBO->getMobileNumber()."</ConsumerMobile>";
			$xmlConsumerList.="<ConsumerCellularProvider>".$objConsumerBO->getCellularId()."</ConsumerCellularProvider>";

			$xmlConsumerList.="</Consumer>";
			$xmlConsumerList.="</ConsumerList></Consumers>";	
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
			
		return $xmlConsumerList;


	}


	/// UPDATE CONSUMER PROFILE
	function UpdateConsumer($pIntConsumerId, $pIntCountryId, $pIntStateId, $pIntAccountType, $pIntSecretQuestion, $pStrEmail, $pStrPassword, $pChrFirstName, $pChrLastName, $pChrAddress, $pChrCity, $pChrZipCode, $pChrTelephone1, $pDteDateOfBirth, $pChrAnswer, $pStrActivationCode, $pIntIsVarify, $dtCreateDate,$pIsActive,$pMobileNo,$pCellularId)
	{
		/// Set Value in xml String
		$this->strResponse="<Response>";

		try
		{
			/// set parameters in an object
			$objConsumerBO=new ConsumerBO();
			$objConsumerBO->setConsumerId($pIntConsumerId);
			$objConsumerBO->setConsumerCountryId($pIntCountryId);
			$objConsumerBO->setConsumerStateId($pIntStateId);
			$objConsumerBO->setConsumerAccountType($pIntAccountType);
			$objConsumerBO->setConsumerSecretQuestion($pIntSecretQuestion);
			$objConsumerBO->setConsumerEmail($pStrEmail);
			$objConsumerBO->setConsumerPassword($pStrPassword);						
			$objConsumerBO->setConsumerFristName($pChrFirstName);
			$objConsumerBO->setConsumerLastName($pChrLastName);
			$objConsumerBO->setConsumerAddress($pChrAddress);
			$objConsumerBO->setConsumerCity($pChrCity);
			$objConsumerBO->setConsumerZipCode($pChrZipCode);
			$objConsumerBO->setConsumerTelephone1($pChrTelephone1);
			$objConsumerBO->setConsumerDateOfBirth($pDteDateOfBirth);
			$objConsumerBO->setConsumerAnswer($pChrAnswer);
			$objConsumerBO->setConsumerActivationCode($pStrActivationCode);		
			$objConsumerBO->setConsumerIsVerified($pIntIsVarify);					
			$objConsumerBO->setConsumerCreateDate($dtCreateDate);								
			$objConsumerBO->setConsumerIsActive($pIsActive);	
			$objConsumerBO->setMobileNumber($pMobileNo);
			$objConsumerBO->setCellularId($pCellularId);					
			/// Call update Consumer profile
			$objConsumerDAO = new ConsumerDAO();
			$objConsumerDAO->UpdateConsumer($objConsumerBO);

			/// Set Value in xml String
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
		}
		catch(Exception $e)
		{

			$objXmlEncode=new xmlEncode();

			/// Set Values in xml String
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objConsumerDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
			
		}

		/// Set Values in xml String
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}	 
	
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

	/// Mapping Functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('ConsumerGetById','FillCmbStateByCountryId','UpdateConsumer','FillCmbCellularByCountryId'));

		NAJAX_Client::publicMethods($this, array('ConsumerGetById','FillCmbStateByCountryId','UpdateConsumer','FillCmbCellularByCountryId'));
	}
	
	
}

?>

