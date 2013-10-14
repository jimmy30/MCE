<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Waypoint Downlaod Registration.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO class for Waypoint Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Reports/WaypointDownloadDAO.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");


//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utility.php");

class WaypointDownloadReportService
{
	/// Declaring Response variable
	var $strResponse;
	
	/// RECORD COUNT BY ACCOUNT TYPE AND STATUS
	function GetWaypointDownloadReport($pFromDate, $pToDate, $pCountryId)
	{
		$objWaypointDownloadDAO = new WaypointDownloadDAO();
		$arrayResult = $objWaypointDownloadDAO->GetWaypointDownloadReport($pFromDate, $pToDate, $pCountryId);

		$xmlResponse="";
		if($arrayResult!=null)
		{

			$xmlResponse.="<WaypointDownload>";
				$xmlResponse.="<NoOfRecord>".sizeof($arrayResult)."</NoOfRecord>";
				$xmlResponse.="<WaypointList>";

			for($i=0;$i<sizeof($arrayResult);$i++)
			{
		
				$xmlResponse.="<Waypoint>";
					$xmlResponse.="<WaypointCount>".$arrayResult[$i][0]."</WaypointCount>";
					$xmlResponse.="<WaypointId>".$arrayResult[$i][1]."</WaypointId>";
					$xmlResponse.="<WaypointName>".$arrayResult[$i][2]."</WaypointName>";
				$xmlResponse.="</Waypoint>";
			}
			$xmlResponse.="</WaypointList>";
		$xmlResponse.="</WaypointDownload>";

		}	
		return $xmlResponse;
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

	/// Mapping Function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('GetWaypointDownloadReport'));

		NAJAX_Client::publicMethods($this, array('GetWaypointDownloadReport'));
	}
	
}

?>

