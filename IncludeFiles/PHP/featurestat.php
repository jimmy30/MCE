<?php 
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Consumer SignIn.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/FeatureStatDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/FeatureStatBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");

	session_start();
	$intUserType=0;

$arrUrl=explode('/',$_SERVER['PHP_SELF']);
$strPage='/'.$arrUrl[sizeof($arrUrl)-1];
$strRegistraion=$arrUrl[sizeof($arrUrl)-2];

	if(isset($_SESSION[sessionKeys::USER_EMAIL]) && $_SESSION[sessionKeys::USER_EMAIL]!="" && isset($_SESSION[sessionKeys::USER_TYPE]))
	{
		$intUserType=$_SESSION[sessionKeys::USER_TYPE];
	}
	else if($strRegistraion=="ProducerRegistration")
		$intUserType=2;
	else if($strRegistraion=="ConsumerRegistration")
		$intUserType=1;
	
		/// Set parameters in an  object
		$objFeatureStatBO=new FeatureStatBO();
		$objFeatureStatBO->setPageUrl($strPage);
		$objFeatureStatBO->setUserType($intUserType);

		$objFeatureStatDAO=new FeatureStatDAO();
		$objFeatureStatDAO->HitsUpdate($objFeatureStatBO);

?>

