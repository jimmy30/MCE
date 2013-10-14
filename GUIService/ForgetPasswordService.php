<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Forget Password.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/EmailException.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ProducerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ProducerBO.php");

//// Include DO BO class for Producer Table
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

class ForgetPasswordService
{
	/// Declaring Response variable
	var $strResponse;

	//// Declaring common variables
	var $siteUrl;
	
	/// Declaring Email variables for Producer Forget password email
	var $strProducerhelpEmail;
	var $strProducerForgetPasswordFromEmail;
	var $strProducerForgetPasswordEmailSubject;
	var $strProducerForgetPasswordEmailBody;

	/// Declaring Email variables for Consumer Forget password email
	var $strConsumerhelpEmail;	
	var $strConsumerForgetPasswordFromEmail;
	var $strConsumerForgetPasswordEmailSubject;
	var $strConsumerForgetPasswordEmailBody;
	
		function __construct()
		{
			/// Loading property file
			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));

			/// Get common variables from property file
			$this->siteUrl=$objProperties->getProperty('site_url');

			/// Get Producer forget password variables from property file
			$this->strProducerhelpEmail=$objProperties->getProperty('registration_producer_help_email');			
			$this->strProducerForgetPasswordFromEmail=$objProperties->getProperty('registration_producer_from_email');						
			$this->strProducerForgetPasswordEmailSubject=$objProperties->getProperty('forget_password_producer_email_subject');	
			$this->strProducerForgetPasswordEmailBody=$objProperties->getProperty('forget_password_producer_email_body');				

			/// Get Consumer forget password variables from property file
			$this->strConsumerhelpEmail=$objProperties->getProperty('registration_consumer_help_email');			
			$this->strConsumerForgetPasswordFromEmail=$objProperties->getProperty('registration_consumer_from_email');						
			$this->strConsumerForgetPasswordEmailSubject=$objProperties->getProperty('forget_password_consumer_email_subject');	
			$this->strConsumerForgetPasswordEmailBody=$objProperties->getProperty('forget_password_consumer_email_body');				

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

	/// PRODUCER FORGET PASSWORD
	function ProducerForgetPassword($pStrEmail,$pIntQuestionId,$pStrAnswer)
	{
		
		try
		{
			/// Generate XML string as Response
			$this->strResponse="<Response>";

			/// Set parameter in a object
			$objProducerBO=new ProducerBO();
			$objProducerBO->setProducerEmail($pStrEmail);
			$objProducerBO->setProducerSecretQuestion($pIntQuestionId);
			$objProducerBO->setProducerAnswer($pStrAnswer);

			/// Get result array
			$objProducerDAO = new ProducerDAO();
			$arrValue=$objProducerDAO->ForgetPassword($objProducerBO);
	
			/// Check email address is not empty
			if($arrValue[2]!="")
			{
				/// Generate Email body
				$this->strProducerForgetPasswordEmailBody=str_replace("[EMAIL]",$arrValue[2],$this->strProducerForgetPasswordEmailBody);				
				$this->strProducerForgetPasswordEmailBody=str_replace("[PASSWORD]",$arrValue[3],$this->strProducerForgetPasswordEmailBody);								
				$this->strProducerForgetPasswordEmailBody=str_replace("[FIRST_NAME]",$arrValue[0],$this->strProducerForgetPasswordEmailBody);
				$this->strProducerForgetPasswordEmailBody=str_replace("[LAST_NAME]",$arrValue[1],$this->strProducerForgetPasswordEmailBody);				
				$this->strProducerForgetPasswordEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strProducerForgetPasswordEmailBody);				
				$this->strProducerForgetPasswordEmailBody=str_replace("[PRODUCER_REGISTRATION_HELP_EMAIL]",$this->strProducerhelpEmail,$this->strProducerForgetPasswordEmailBody);								

				/// Send forget password email to Producer
				$objUtitlity=new utility();
				$objUtitlity->sendEmail($this->strProducerForgetPasswordFromEmail,$arrValue[2],$this->strProducerForgetPasswordEmailSubject,$this->strProducerForgetPasswordEmailBody);
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";				

				
			}
			else if($arrValue[2]=="")
			{
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_FORGET_SECRET_ANSWER_NOT_CORRENCT."</Status>";
			}
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
	
	/// CONSUMER FORGET PASSWORD
	function ConsumerForgetPassword($pStrEmail,$pIntQuestionId,$pStrAnswer)
	{
		
		try
		{
			/// Generate XML string as Response
			$this->strResponse="<Response>";

			/// Set parameter in a object
			$objConsumerBO=new ConsumerBO();
			$objConsumerBO->setConsumerEmail($pStrEmail);
			$objConsumerBO->setConsumerSecretQuestion($pIntQuestionId);
			$objConsumerBO->setConsumerAnswer($pStrAnswer);

			/// Get result array
			$objConsumerDAO = new ConsumerDAO();
			$arrValue=$objConsumerDAO->ForgetPassword($objConsumerBO);
	
			/// Check email address is not empty
			if($arrValue[2]!="")
			{
				/// Generate Email body
				$this->strConsumerForgetPasswordEmailBody=str_replace("[EMAIL]",$arrValue[2],$this->strConsumerForgetPasswordEmailBody);				
				$this->strConsumerForgetPasswordEmailBody=str_replace("[PASSWORD]",$arrValue[3],$this->strConsumerForgetPasswordEmailBody);								
				$this->strConsumerForgetPasswordEmailBody=str_replace("[FIRST_NAME]",$arrValue[0],$this->strConsumerForgetPasswordEmailBody);
				$this->strConsumerForgetPasswordEmailBody=str_replace("[LAST_NAME]",$arrValue[1],$this->strConsumerForgetPasswordEmailBody);				
				$this->strConsumerForgetPasswordEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strConsumerForgetPasswordEmailBody);				
				$this->strConsumerForgetPasswordEmailBody=str_replace("[CONSUMER_REGISTRATION_HELP_EMAIL]",$this->strConsumerhelpEmail,$this->strConsumerForgetPasswordEmailBody);								

				/// Send forget password email to Consumer
				$objUtitlity=new utility();
				$objUtitlity->sendEmail($this->strConsumerForgetPasswordFromEmail,$arrValue[2],$this->strConsumerForgetPasswordEmailSubject,$this->strConsumerForgetPasswordEmailBody);
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";				

				
			}
			else if($arrValue[2]=="")
			{
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_FORGET_SECRET_ANSWER_NOT_CORRENCT."</Status>";
			}
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objConsumerDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
			
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;

	}

	/// Mapping Functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('FillCmbStateByCountryId','ProducerForgetPassword','ConsumerForgetPassword'));

		NAJAX_Client::publicMethods($this, array('FillCmbStateByCountryId','ProducerForgetPassword','ConsumerForgetPassword'));
	}
	
	
}

?>

