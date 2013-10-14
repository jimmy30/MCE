<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Producer Registration.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO class for Waypoint Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Reports/WaypointDAO.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");


//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utility.php");

class WaypointReportService
{
	/// Declaring Response variable
	var $strResponse;
	
	/// RECORD COUNT BY ACCOUNT TYPE AND STATUS
	function GetWaypointReport($pFromDate, $pToDate, $pCountryId)
	{
		$objWaypointDAO = new WaypointDAO();
		$arrayResult = $objWaypointDAO->GetWaypointReport($pFromDate, $pToDate, $pCountryId);

		$xmlResponse="";

		if($arrayResult!=null)
		{

			//// set array according to right results format
//		$handle=fopen("c:/abc.html",'w');
//		fwrite($handle,"start\n");
//		fclose($handle);

//		$handle=fopen("c:/abc.html",'a');
		$arrayActive = array();
		$arrayInActive = array();		
		
			for($p=0;$p<sizeof($arrayResult);$p++)
			{
	
	//			fwrite($handle,"loop ite: ".$p."<br>");

				if($arrayResult[$p][2]==1)
				{
		//			fwrite($handle,"if case 1: ".$arrayResult[$p][2]."<br>");
					if($arrayResult[$p][1]==$arrayActive[sizeof($arrayActive)-1][1])
					{
						$arrayActive[sizeof($arrayActive)-1][0]=$arrayResult[$p][0];
			//			fwrite($handle,"inner if case 1: ".$arrayResult[$p][0]."<br>");
					}
					else
					{						
				//		fwrite($handle,"inner else case 1:<br>");
						$arrayActive[sizeof($arrayActive)][0]=$arrayResult[$p][0];
						$arrayActive[sizeof($arrayActive)-1][1]=$arrayResult[$p][1];
						
						$arrayInActive[sizeof($arrayInActive)][0]=0;
						$arrayInActive[sizeof($arrayInActive)-1][1]=$arrayResult[$p][1];
					}					
				}
				else
				{
//					fwrite($handle,"else case 0: ".$arrayResult[$p][2]."<br>");
					if($arrayResult[$p][1]==$arrayInActive[sizeof($arrayInActive)-1][1])
					{
						$arrayInActive[sizeof($arrayInActive)-1][0]=$arrayResult[$p][0];
	//					fwrite($handle,"inner if case 0:<br>");
					}
					else
					{
						$arrayInActive[sizeof($arrayInActive)][0]=$arrayResult[$p][0];
						$arrayInActive[sizeof($arrayInActive)-1][1]=$arrayResult[$p][1];
		//				fwrite($handle,"inner else case 0:<br>");						
						
						$arrayActive[sizeof($arrayActive)][0]=0;
						$arrayActive[sizeof($arrayActive)-1][1]=$arrayResult[$p][1];
					}
				}
			}
			///////////////////////////////////////////////


			$xmlResponse.="<Waypoint>";
				$xmlResponse.="<NoOfRecord>".sizeof($arrayActive)."</NoOfRecord>";
				$xmlResponse.="<CountryList>";

			for($i=0;$i<sizeof($arrayInActive);$i++)
			{
		
				$xmlResponse.="<Country>";

					$xmlResponse.="<Active>";
						$xmlResponse.="<RecordCountActive>".$arrayActive[$i][0]."</RecordCountActive>";
						$xmlResponse.="<CountryNameActive>".$arrayActive[$i][1]."</CountryNameActive>";
					$xmlResponse.="</Active>";

					$xmlResponse.="<InActive>";
						$xmlResponse.="<RecordCountInActive>".$arrayInActive[$i][0]."</RecordCountInActive>";
						$xmlResponse.="<CountryNameInActive>".$arrayInActive[$i][1]."</CountryNameInActive>";
					$xmlResponse.="</InActive>";

				$xmlResponse.="</Country>";
			}
			$xmlResponse.="</CountryList>";
		$xmlResponse.="</Waypoint>";

		}	
//	$handle=fopen("c:/abc.xml",'w');
//	fwrite($handle,$xmlResponse);
//	fclose($handle);

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
		NAJAX_Client::mapMethods($this, array('GetWaypointReport'));

		NAJAX_Client::publicMethods($this, array('GetWaypointReport'));
	}
	
}

?>

