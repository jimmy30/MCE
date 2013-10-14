<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add Ads.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Ads Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Ads/AdsDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/Ads/AdsBO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Ads/AdsGroupDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/Ads/AdsGroupBO.php");


//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class AddAdsService
{
	function InsertAds($pStrAdName,$strAdDescription,$strAddImage,$dteExpiryDate,$dteCreatedDate,$pIntIsActive,$pArrGroup,$pStrSize,$pStrSniffet)
	{
		
		//return $pArrGroup[0];
		/// Generating XML as response
		$this->strResponse="<Response>";	
		try
		{
			/// Set all parameters in an Object
			$objAdsDAO = new AdsDAO();	
			$objAdsBO=new AdsBO();
			$objAdsDAO->GetMaxId($objAdsBO);
			$intAdsId=$objAdsBO->getAdsId();
			$intAdsId=$intAdsId+1;
			$objAdsBO->setAdsId($intAdsId);
			$objAdsBO->setAdsName($pStrAdName);
			$objAdsBO->setAdsDescription($strAdDescription);			
			$objAdsBO->setImagePath($strAddImage);
			$objAdsBO->setExpiryDate($dteExpiryDate);			
			$objAdsBO->setCreatedDate($dteCreatedDate);
			$objAdsBO->setActive($pIntIsActive);
			$objAdsBO->setAdSize($pStrSize);
			$objAdsBO->setSniffet($pStrSniffet);
			
			/// Call insert Adds function
			$objAdsDAOIns = new AdsDAO();	
			$intStatus.=$objAdsDAOIns->InsertAds($objAdsBO);
			$objAdsGroupBO=new AdsGroupBO();	
			for($i=0;$i<count($pArrGroup);$i++)
			{
				$objAdsGroupBO->setAdsId($intAdsId);
				$objAdsGroupBO->setGroupId($pArrGroup[$i]);
				$objAdsGroupDAO=new AdsGroupDAO();	
				$objAdsGroupDAO->InsertAdsGroup($objAdsGroupBO);
			}
			
			if($intStatus==1)
				$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_OK."</Status>";
			else
				$this->strResponse=$this->strResponse."<Status>".$intStatus."</Status>";
		}
		catch(Exception $e)
		{
			$objXmlEncode=new xmlEncode();
			$this->strResponse=$this->strResponse."<Status>".clsConstants::RESPONSE_STATUS_EXCEPTION."</Status>";
			$this->strResponse=$this->strResponse."<ExceptionName>".get_class($e)."</ExceptionName>";
			$this->strResponse=$this->strResponse."<ExceptionNo>".$objConsumerAlertDAO->intErrorNo."</ExceptionNo>";
			$this->strResponse=$this->strResponse."<ExceptionMessage>".$objXmlEncode->xmlCdataEncode($e->getMessage())."</ExceptionMessage>";
			$this->strResponse=$this->strResponse."<ExceptionLine>".$objXmlEncode->xmlCdataEncode($e->getLine())."</ExceptionLine>";
			$this->strResponse=$this->strResponse."<ExceptionFile>".$objXmlEncode->xmlCdataEncode($e->getFile())."</ExceptionFile>";
			$this->strResponse=$this->strResponse."<ExceptionDetail>".$objXmlEncode->xmlCdataEncode($e->getTraceAsString())."</ExceptionDetail>";
		}
		$this->strResponse=$this->strResponse."</Response>";
		return 	$this->strResponse;
	}

	
	/// Mapping functions for najax use
	function najaxGetMeta()
	{
		NAJAX_Client::mapMethods($this, array('InsertAds'));
		NAJAX_Client::publicMethods($this, array('InsertAds'));
	}
}
?>
