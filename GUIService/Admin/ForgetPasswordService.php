<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Forget Password.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/EmailException.php");

//// Include DO BO class for Admin Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/AdminDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/AdminBO.php");

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
	
	/// Declaring Email variables for Admin Forget password email
	var $strAdminhelpEmail;	
	var $strAdminForgetPasswordFromEmail;
	var $strAdminForgetPasswordEmailSubject;
	var $strAdminForgetPasswordEmailBody;
	
		function __construct()
		{
			/// Loading property file
			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));

			/// Get common variables from property file
			$this->siteUrl=$objProperties->getProperty('site_url');

			/// Get Admin forget password variables from property file
			$this->strAdminhelpEmail=$objProperties->getProperty('admin_help_email');			
			$this->strAdminForgetPasswordFromEmail=$objProperties->getProperty('forget_password_admin_from_email');						
			$this->strAdminForgetPasswordEmailSubject=$objProperties->getProperty('forget_password_admin_email_subject');	
			$this->strAdminForgetPasswordEmailBody=$objProperties->getProperty('forget_password_admin_email_body');				

		}

	
	
	/// ADMIN FORGET PASSWORD
	function AdminForgetPassword($pStrEmail)
	{
		
		try
		{
			/// Generate XML string as Response
			$this->strResponse="<Response>";

			/// Get result array
			$objAdminDAO = new AdminDAO();
			$objAdminBO=$objAdminDAO->ForgetPassword($pStrEmail);
			/// Check email address is not empty
			if($objAdminBO->getEmail()!="")
			{
				/// Generate Email body
				$this->strAdminForgetPasswordEmailBody=str_replace("[EMAIL]",$objAdminBO->getEmail(),$this->strAdminForgetPasswordEmailBody);				
				$this->strAdminForgetPasswordEmailBody=str_replace("[PASSWORD]",$objAdminBO->getPassword($pPassword),$this->strAdminForgetPasswordEmailBody);								
				$this->strAdminForgetPasswordEmailBody=str_replace("[SITE_URL]",$this->siteUrl,$this->strAdminForgetPasswordEmailBody);				
				$this->strAdminForgetPasswordEmailBody=str_replace("[ADMIN_HELP_EMAIL]",$this->strAdminhelpEmail,$this->strAdminForgetPasswordEmailBody);								

				/// Send forget password email to Consumer
				$objUtitlity=new utility();
				$objUtitlity->sendEmail($this->strAdminForgetPasswordFromEmail,$objAdminBO->getEmail($pEmail),$this->strAdminForgetPasswordEmailSubject,$this->strAdminForgetPasswordEmailBody);
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";				

				
			}
			else if($objAdminBO->getEmail()=="")
			{
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_ADMIN_FORGET_PASSWORD_EMAIL_NOT_CORRECT."</Status>";
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
		NAJAX_Client::mapMethods($this, array('AdminForgetPassword'));

		NAJAX_Client::publicMethods($this, array('AdminForgetPassword'));
	}
	
	
}

?>

