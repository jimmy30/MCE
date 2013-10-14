<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Website Hits Registration.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO class for WebsiteHits Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Reports/WebsiteHitsDAO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utility.php");

class WebsiteHitsReportService
{
	/// Declaring Response variable
	var $strResponse;
	
	/// RECORD COUNT BY ACCOUNT TYPE AND STATUS
	function GetWebsiteHitsReport($pFromDate, $pToDate)
	{
		$objWebsiteHitsDAO = new WebsiteHitsDAO();
		$arrayResult = $objWebsiteHitsDAO->GetWebsiteHitsReport($pFromDate, $pToDate);

		$xmlResponse="";
		if($arrayResult!=null)
		{

			$xmlResponse.="<WebsiteHits>";
				$xmlResponse.="<NoOfRecord>".sizeof($arrayResult)."</NoOfRecord>";
				$xmlResponse.="<WebsiteHitsList>";

			for($i=0;$i<sizeof($arrayResult);$i++)
			{
		
				$xmlResponse.="<WebsiteHit>";
					$xmlResponse.="<WebsiteHitCount>".$arrayResult[$i][0]."</WebsiteHitCount>";
					$xmlResponse.="<CleintIP>".$arrayResult[$i][1]."</CleintIP>";
				$xmlResponse.="</WebsiteHit>";
			}
			$xmlResponse.="</WebsiteHitsList>";
		$xmlResponse.="</WebsiteHits>";

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
		NAJAX_Client::mapMethods($this, array('GetWebsiteHitsReport'));

		NAJAX_Client::publicMethods($this, array('GetWebsiteHitsReport'));
	}
	
}

?>

