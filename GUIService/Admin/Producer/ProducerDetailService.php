<?php 
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for View Producers.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Admin Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ProducerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ProducerBO.php");

//// Include DO BO class for Admin Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/AdminDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/AdminBO.php");

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

class ProducerDetailService
{
	/// Declaring Response variable	
	var $strResponse;

	/// Admin CHANGE PASSWORD
	function ProducerGetById($pIntProducerId)
	{
		/// get results as object
		$objProducerDAO = new ProducerDAO();
		$objArrayProducer=$objProducerDAO->ProducerGetById($pIntProducerId);

		if ($objArrayProducer!=null)
		{

			$objProducerBO=(object)$objArrayProducer[0];
			$objCountryBO=(object)$objArrayProducer[1];
			$objStateBO=(object)$objArrayProducer[2];
			$objSecretQuestionBO=(object)$objArrayProducer[3];
			$objAccountTypeBO=(object)$objArrayProducer[4];
			
			
			$xmlProducerList='<Producers>';
			$xmlProducerList.='<NoOfRecords>'.$intCount.'</NoOfRecords><ProducerList>';

			$xmlProducerList.= "<Producer>";
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
			$xmlProducerList.="<CountryName>".$objCountryBO->getCountryName()."</CountryName>";
			$xmlProducerList.="<StateName>".$objStateBO->getStateName()."</StateName>";			
			$xmlProducerList.="<QuestionName>".$objSecretQuestionBO->getSecretQuestionName()."</QuestionName>";						
			$xmlProducerList.="<AccountType>".$objAccountTypeBO->getAccountTypeName()."</AccountType>";									
			$xmlProducerList.="</Producer>";
			$xmlProducerList.="</ProducerList></Producers>";	
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
			
		return $xmlProducerList;


	}

	/// Mapping Functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('ProducerGetById'));

		NAJAX_Client::publicMethods($this, array('ProducerGetById'));
	}
	
	
}

?>

