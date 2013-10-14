<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Consumer SignIn.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");


//// Include DO BO class for Consumer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/AdminDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/AdminBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");

class SignInService
{
	/// Declaring Response variable
	var $strResponse;
	
	/// Admin SIGN IN
	function AdminSignIn($pStrEmail,$pStrPassword)
	{
		
		try
		{
		

			$this->strResponse="<Response>";

			/// Set parameters in an  object
			$objAdminBO=new AdminBO();
			$objAdminBO->setEmail($pStrEmail);
			$objAdminBO->setPassword($pStrPassword);

			/// Get results
			$objAdminDAO = new AdminDAO();
			$strEmail=$objAdminDAO->SignIn($objAdminBO);

			if($strEmail=="0") // Email not exists
			{
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EMAIL_NOT_EXISTS."</Status>";
			}
			else if($strEmail==-1) // Password not correct
			{
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_PASSWORD_NOT_CORRECT."</Status>";			
			}
			else  // Authentication matched
			{
	
				/// Set XML values
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
				
				/// generating session fields
				session_start();
				$_SESSION[sessionKeys::ADMIN_EMAIL]=$strEmail;
				$_SESSION[sessionKeys::ADMIN_TYPE]=3;				
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

	/// Mapping Functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('AdminSignIn'));

		NAJAX_Client::publicMethods($this, array('AdminSignIn'));
	}
	
	
}

?>

