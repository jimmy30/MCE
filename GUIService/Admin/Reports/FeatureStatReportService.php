<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Feature State.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO class for FeatureStat Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Reports/FeatureStatDAO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utility.php");

class FeatureStatReportService
{
	/// Declaring Response variable
	var $strResponse;
	
	/// RECORD COUNT BY ACCOUNT TYPE AND STATUS
	function GetFeatureStatReport($pUserType)
	{
		$objFeatureStatDAO = new FeatureStatDAO();
		$arrayResult = $objFeatureStatDAO->GetFeatureStatReport($pUserType);

		$xmlResponse="";
		if($arrayResult!=null)
		{

			$xmlResponse.="<FeatureStats>";
				$xmlResponse.="<NoOfRecord>".sizeof($arrayResult)."</NoOfRecord>";
				$xmlResponse.="<FeatureStatList>";

			for($i=0;$i<sizeof($arrayResult);$i++)
			{
		
				$xmlResponse.="<FeatureStat>";
					$xmlResponse.="<StatId>".$arrayResult[$i][0]."</StatId>";
					$xmlResponse.="<UserType>".$arrayResult[$i][1]."</UserType>";
					$xmlResponse.="<PageTitle>".$arrayResult[$i][2]."</PageTitle>";
					$xmlResponse.="<PageUrl>".$arrayResult[$i][3]."</PageUrl>";
					$xmlResponse.="<Hits>".$arrayResult[$i][4]."</Hits>";
					$xmlResponse.="<CreateDate>".$arrayResult[$i][5]."</CreateDate>";
					$xmlResponse.="<IsActive>".$arrayResult[$i][6]."</IsActive>";
				$xmlResponse.="</FeatureStat>";
			}
			$xmlResponse.="</FeatureStatList>";
		$xmlResponse.="</FeatureStats>";

		}	
		return $xmlResponse;
	}

	/// Mapping Function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('GetFeatureStatReport'));

		NAJAX_Client::publicMethods($this, array('GetFeatureStatReport'));
	}
	
}

?>

