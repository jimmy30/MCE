<?php 
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Consumer SignIn.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/WebsiteHitsDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/WebsiteHitsBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/SessionKeys.php");

	session_start();
	if(!isset($_SESSION[sessionKeys::WEBSITE_SESSION_ID]))
	{
		$_SESSION[sessionKeys::WEBSITE_SESSION_ID]=session_id();
		
		/// Set parameters in an  object
		$objWebsiteHitsBO=new WebsiteHitsBO();
		$objWebsiteHitsBO->setSessionId($_SESSION[sessionKeys::WEBSITE_SESSION_ID]);
		$objWebsiteHitsBO->setCleintIP($_SERVER['REMOTE_ADDR']);
		$objWebsiteHitsBO->setWebsiteHitsCreateDate(date('Y-m-d'));
		$objWebsiteHitsBO->setWebsiteHitsIsActive(1);

		$objWebsiteHitsDAO=new WebsiteHitsDAO();
		$objWebsiteHitsDAO->insert($objWebsiteHitsBO);

	}
?>

