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

//// Include DO BO class for Cellular Provider Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CellularProviderDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CellularProviderBO.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");
//// Include DO BO class for State Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/StateBO.php");
//// Include DO BO class for SecretQuestion Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/SecretQuestionBO.php");
//// Include DO BO class for AccountType Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/AccountTypeBO.php");


/// Include other classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");

class ConsumerDetailService
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
			
			$objCellularProviderDAO = new CellularProviderDAO();
			$objCellularProviderBO=$objCellularProviderDAO->GetById($objConsumerBO->getCellularId());

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
			$xmlConsumerList.="<ConsumerCellularProvider>".$objCellularProviderBO->getCellularProvider()."</ConsumerCellularProvider>";

			$xmlConsumerList.="</Consumer>";
			$xmlConsumerList.="</ConsumerList></Consumers>";	
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
			
		return $xmlConsumerList;


	}

	/// Mapping Functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('ConsumerGetById'));

		NAJAX_Client::publicMethods($this, array('ConsumerGetById'));
	}
	
	
}

?>

