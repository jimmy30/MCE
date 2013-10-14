<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Consumer SignIn.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");


//// Include DO BO class for Consumer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ConsumerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ConsumerBO.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/ProducerDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/ProducerBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");

class SignInService
{
	/// Declaring Response variable
	var $strResponse;
	
	/// CONSUMER SIGN IN
	function ConsumerSignIn($pStrEmail,$pStrPassword,$pIntRemeberMe)
	{
		
		try
		{
		

			$this->strResponse="<Response>";

			/// Set parameters in an  object
			$objConsumerBO=new ConsumerBO();
			$objConsumerBO->setConsumerEmail($pStrEmail);
			$objConsumerBO->setConsumerPassword($pStrPassword);

			/// Get results
			$objConsumerDAO = new ConsumerDAO();
			$objConsumerBO=$objConsumerDAO->SignIn($objConsumerBO);
	
			if($objConsumerBO->getConsumerId()>0) // Authentication matched
			{
	
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
				
				/// generating session fields
				session_start();
				$_SESSION[sessionKeys::USER_ID]=$objConsumerBO->getConsumerId();
				$_SESSION[sessionKeys::USER_EMAIL]=$objConsumerBO->getConsumerEmail();
				$_SESSION[sessionKeys::USER_PASSWORD]=base64_encode($pStrPassword);
				$_SESSION[sessionKeys::USER_FIRST_NAME]=$objConsumerBO->getConsumerFristName();
				$_SESSION[sessionKeys::USER_LAST_NAME]=$objConsumerBO->getConsumerLastName();
				$_SESSION[sessionKeys::USER_TYPE]=1;
				
				setcookie('userno',$objConsumerBO->getConsumerId(),time()+31536000, "/");
				/// Set Cookie /////
				if($pIntRemeberMe==1)
				{
					setcookie('RemeberMeEmail', $pStrEmail,time()+31536000, "/");
					setcookie('RemeberMePassword', $pStrPassword,time()+31536000, "/");					
					setcookie('SignInAs', '1',time()+31536000, "/");					
				}
				else
				{
					setcookie('RemeberMeEmail', $pStrEmail,time()-31536000, "/");
					setcookie('RemeberMePassword', $pStrPassword,time()-31536000, "/");						
					setcookie('SignInAs', '1',time()-31536000, "/");					
				}
				////////////////////
	
			}
			else if($objConsumerBO->getConsumerId()==0) // Email not exists
			{
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EMAIL_NOT_EXISTS."</Status>";
			}
			else if($objConsumerBO->getConsumerId()==-1) // Password not correct
			{
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_PASSWORD_NOT_CORRECT."</Status>";			
			}
		}
		catch(Exception $e)
		{
			/// Set XML values
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objConsumerDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$e->getMessage()."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$e->getLine()."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$e->getFile()."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$e->getTraceAsString()."</ExceptionDetail>";
			
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}
	
	/// PRODUCER SIGN IN
	function ProducerSignIn($pStrEmail,$pStrPassword,$pIntRemeberMe)
	{
		
		try
		{
		
			$this->strResponse="<Response>";

			/// Set parameters in an  object
			$objProducerBO=new ProducerBO();
			$objProducerBO->setProducerEmail($pStrEmail);
			$objProducerBO->setProducerPassword($pStrPassword);

			/// Get results
			$objProducerDAO = new ProducerDAO();
			$objProducerBO=$objProducerDAO->SignIn($objProducerBO);
	
			if($objProducerBO->getProducerId()>0) // Authentication matched
			{
	
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
				
				/// generating session fields
				session_start();
				$_SESSION[sessionKeys::USER_ID]=$objProducerBO->getProducerId();
				$_SESSION[sessionKeys::USER_EMAIL]=$objProducerBO->getProducerEmail();
				$_SESSION[sessionKeys::USER_PASSWORD]=base64_encode($pStrPassword);
				$_SESSION[sessionKeys::USER_FIRST_NAME]=$objProducerBO->getProducerFristName();
				$_SESSION[sessionKeys::USER_LAST_NAME]=$objProducerBO->getProducerLastName();
				$_SESSION[sessionKeys::USER_TYPE]=2;
								
				setcookie('userno',$objProducerBO->getProducerId(),time()+31536000, "/");
				/// Set Cookie /////
				if($pIntRemeberMe==1)
				{
					setcookie('RemeberMeEmail', $pStrEmail,time()+31536000, "/");
					setcookie('RemeberMePassword', $pStrPassword,time()+31536000, "/");					
					setcookie('SignInAs', '2',time()+31536000, "/");										
				}
				else
				{
					setcookie('RemeberMeEmail', $pStrEmail,time()-31536000, "/");
					setcookie('RemeberMePassword', $pStrPassword,time()-31536000, "/");										
					setcookie('SignInAs', '2',time()-31536000, "/");					
				}
				////////////////////
	
			}
			else if($objProducerBO->getProducerId()==0) // Email not exists
			{
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EMAIL_NOT_EXISTS."</Status>";
			}
			else if($objProducerBO->getProducerId()==-1) // Password not correct
			{
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_PASSWORD_NOT_CORRECT."</Status>";			
			}
		}
		catch(Exception $e)
		{
			/// Set XML values
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objProducerDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$e->getMessage()."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$e->getLine()."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$e->getFile()."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$e->getTraceAsString()."</ExceptionDetail>";
			
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}
	
	function formData($formData)
	{


		$strEmailAddress=$formData['txtEmail'];
		$strPassword=$formData['txtPassword'];
		$cmbCustomerType=$formData['cmbCustomerType'];
		$chkRemeberMe=$formData['chkRemeberMe'];
		if ($cmbCustomerType==1)
		{
			return $this->ConsumerSignIn($strEmailAddress,$strPassword,$chkRemeberMe);
		}
		elseif ($cmbCustomerType==2)
		{
			return $this->ProducerSignIn($strEmailAddress,$strPassword,$chkRemeberMe);
		}

	}
	
	/// Mapping Functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('ConsumerSignIn','ProducerSignIn','formData'));

		NAJAX_Client::publicMethods($this, array('ConsumerSignIn','ProducerSignIn','formData'));
	}
	
	
}

?>

