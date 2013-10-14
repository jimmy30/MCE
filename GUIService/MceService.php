<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Mce.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes

require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/WaypointDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/PlaceCastDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/WaypointBO.php");

/// Include Utilities Files Class
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utilities.php");

/// Include PHPmailer Class for sending Email
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/phpmailer/class.phpmailer.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/utility.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class MceService
{
	function SendEmailAlert($pIntCountryId,$pWaypointId)
	{
			/// Call SendEmailAlert
			$objWaypointDAO = new WaypointDAO();
			$objWaypointDAO->SendEmailAlert($pIntCountryId,$pWaypointId,'Waypoint');
			return $pIntCountryId;
	}

	function SendSmsAlert($pIntCountryId,$pWaypointId)
	{
			/// Call SendEmailAlert
			$objWaypointDAO = new WaypointDAO();
			$objWaypointDAO->SendEmailAlert($pIntCountryId,$pWaypointId,'Waypoint');
			return $pIntCountryId;
	}
	function EnablePlaceCastStatus($pIntPlaceCastId,$pIntStatus)
	{
		$objPlaceCastDAO = new PlaceCastDAO();
		$intStatusId=$objPlaceCastDAO->ToggleIsActive($pIntPlaceCastId,$pIntStatus);
		return $intStatusId;
	}
	function EnableWaypointStatus($pIntWaypointId,$pIntStatus)
	{
		$objWaypointDAO = new WaypointDAO();
		$intStatusId=$objWaypointDAO->ToggleIsActive($pIntWaypointId,$pIntStatus);
		return $intStatusId;
	}
	function GetWaypointById($pWaypointId,$pIsActive)	 
	{
			
			/// set parameter in an object
			$objWaypointBO=new WaypointBO();
			$objWaypointBO->setWaypointId($pWaypointId);
			$objWaypointBO->setWaypointIsActive($pIsActive);		
		
			/// get results in an object
			$objWaypointDAO = new WaypointDAO();
			$objWaypointBO=$objWaypointDAO->selectById($objWaypointBO);

			/// Generate XML string 
			if ($objWaypointBO!=null)
			{
				$intCount = count($objWaypointBO);
				$strXML='<Waypoints>';
				$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><WaypointList>';
				for($i=0; $i<$intCount; $i++)
				{
					
					$strXML.='<Waypoint>';
					$strXML.='<WaypointId>'.$objWaypointBO->getWaypointId().'</WaypointId>';
					$strXML.='<WaypointName>'.$objWaypointBO->getWaypointName().'</WaypointName>';
					$strXML.='<WaypointAddress>'.$objWaypointBO->getWaypointAddress().'</WaypointAddress>';				
					$strXML.='<WaypointCity>'.$objWaypointBO->getWaypointCity().'</WaypointCity>';								
					$strXML.='<WaypointLongitute>'.$objWaypointBO->getWaypointLong1().'</WaypointLongitute>';
					$strXML.='<WaypointLatitute>'.$objWaypointBO->getWaypointLat1().'</WaypointLatitute>';																
					$strXML.='<WaypointDescription>'.$objWaypointBO->getWaypointDescription().'</WaypointDescription>';
					$strXML.='</Waypoint>';
				}
				$strXML.='</WaypointList></Waypoints>';
			}
			return $strXML;
			
	}	

	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('SendEmailAlert','SendSmsAlert','EnablePlaceCastStatus','EnableWaypointStatus','GetWaypointById'));

		NAJAX_Client::publicMethods($this, array('SendEmailAlert','SendSmsAlert','EnablePlaceCastStatus','EnableWaypointStatus','GetWaypointById'));
	}

}