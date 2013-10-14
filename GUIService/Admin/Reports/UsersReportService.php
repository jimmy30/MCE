<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Producer Registration.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Producer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Reports/UserDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/Reports/UserBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Utility.php");

class UsersReportService
{
	/// Declaring Response variable
	var $strResponse;
	
	/// RECORD COUNT BY ACCOUNT TYPE AND STATUS
	function GetUsersReport($pFromDate, $pToDate)
	{
		$objUserDAO = new UserDAO();
		$objUserBO = $objUserDAO->GetUsersReport($pFromDate, $pToDate);
	
		$xmlResponse="<Users>";
			$xmlResponse.="<Producer>";
				$xmlResponse.="<Free>";
					$xmlResponse.="<Active>".$objUserBO->getFreeActiveP()."</Active>";
					$xmlResponse.="<InActive>".$objUserBO->getFreeInActiveP()."</InActive>";
					$xmlResponse.="<SumFree>".$objUserBO->getSumFreeP()."</SumFree>";
				$xmlResponse.="</Free>";
				$xmlResponse.="<Premium>";
					$xmlResponse.="<Active>".$objUserBO->getPremiumActiveP()."</Active>";
					$xmlResponse.="<InActive>".$objUserBO->getPremiumInActiveP()."</InActive>";
					$xmlResponse.="<SumPremium>".$objUserBO->getSumPremiumP()."</SumPremium>";
				$xmlResponse.="</Premium>";
				$xmlResponse.="<Sum>".$objUserBO->getSumP()."</Sum>";
			$xmlResponse.="</Producer>";
			$xmlResponse.="<Consumer>";
				$xmlResponse.="<Free>";
					$xmlResponse.="<Active>".$objUserBO->getFreeActiveC()."</Active>";
					$xmlResponse.="<InActive>".$objUserBO->getFreeInActiveC()."</InActive>";
					$xmlResponse.="<SumFree>".$objUserBO->getSumFreeC()."</SumFree>";					
				$xmlResponse.="</Free>";
				$xmlResponse.="<Premium>";
					$xmlResponse.="<Active>".$objUserBO->getPremiumActiveC()."</Active>";
					$xmlResponse.="<InActive>".$objUserBO->getPremiumInActiveC()."</InActive>";
					$xmlResponse.="<SumPremium>".$objUserBO->getSumPremiumC()."</SumPremium>";
				$xmlResponse.="</Premium>";
				$xmlResponse.="<Sum>".$objUserBO->getSumC()."</Sum>";				
			$xmlResponse.="</Consumer>";
		$xmlResponse.="</Users>";
			
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

	/// Mapping Function for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('GetUsersReport'));

		NAJAX_Client::publicMethods($this, array('GetUsersReport'));
	}
	
}

?>

