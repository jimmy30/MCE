<?php
//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add Consumer Alerts.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Ads Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Ads/AdsDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/Ads/AdsBO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/Ads/AdsGroupBO.php");




//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/xmlEncode.php");

class EditAdsService
{
	function GetAddsById($pAddsId)
	{
		try
		{
			$objXmlEncode=new xmlEncode();
			/// get results in an object
			$objAddDAO = new AdsDAO();
			$objAdsBO=$objAddDAO->GetAddsById($pAddsId);

			$objAdsBO=(object)$objAdsBO;
			
			$strXML='<Adds>';
				$strXML.='<AddId>'.$objAdsBO->getAdsId().'</AddId>';
				$strXML.='<AddName>'.$objAdsBO->getAdsName().'</AddName>';				
				$strXML.='<AddDescription>'.$objAdsBO->getAdsDescription().'</AddDescription>';								
				$strXML.='<AddImage>'.$objAdsBO->getImagePath().'</AddImage>';
				$strXML.='<AddExpiryDate>'.$objAdsBO->getExpiryDate().'</AddExpiryDate>';
				$strXML.='<AddCreatedDate>'.$objAdsBO->getCreateDate().'</AddCreatedDate>';
				$strXML.='<AddStatus>'.$objAdsBO->getActive().'</AddStatus>';
				$strXML.='<AddSize>'.$objAdsBO->getAdSize().'</AddSize>';
				$strXML.='<AddSniffet>'.$objXmlEncode->xmlCdataEncode($objAdsBO->getSinffet()).'</AddSniffet>';
			$strXML.='</Adds>';
			return $strXML;
		}
		catch (Exception  $e)
		{
			echo("Exception occured</br>");
			$e->displayMessage();
		}

	}
	
	function GetGroupsByAddId($pIntAddId)
	{
		try
		{

			/// get results in an object

			$objAddDAO = new AdsDAO();
			$objObjectArray=$objAddDAO->GetGroupsByAddId($pIntAddId);

			//// Generating Comobox items
			if ($objObjectArray!=null)
			{
				$intCount = count($objObjectArray[0]);
				
				$strXML='<Groups>';
				$strXML.='<NoOfRecords>'.$intCount.'</NoOfRecords><GroupsList>';
				
				for($i=0; $i<$intCount; $i++)
				{
					
					$objAdsBO=(object)$objObjectArray[0][$i];
					$objAdsBO=(object)$objAdsBO;
					$strXML.='<Group>';
						$strXML.='<GroupId>'.$objAdsBO->getGroupId().'</GroupId>';
						$strXML.='<GroupName>'.$objAdsBO->getGroupName().'</GroupName>';				
					$strXML.='</Group>';
				}
				$strXML.='</GroupsList></Groups>';
				return $strXML;
			}	
		}
		catch (Exception  $e)
		{
			echo("Exception occured</br>");
			$e->displayMessage();
		}

	}
	
	/// UPDATE ADD
	function UpdateAdds($pIntAddsId, $pStrAddName, $pStrAddDescription, $pStrAddImage, $pDteExpiryDate, $pIntIsActive,$pIntStatus,$pStrSize,$pStrSniffet)
	{
		/// Generating XML as response
		$this->strResponse="<Response>";	

		try
		{
			/// Set all parameters in an Object
			$objAddsBO=new AdsBO();
			$objAddsBO->setAdsId($pIntAddsId);
			$objAddsBO->setAdsName($pStrAddName);			
			$objAddsBO->setAdsDescription($pStrAddDescription);			
			$objAddsBO->setImagePath($pStrAddImage);
			$objAddsBO->setExpiryDate($pDteExpiryDate);			
			$objAddsBO->setActive($pIntIsActive);
			$objAddsBO->setAdSize($pStrSize);
			$objAddsBO->setSniffet($pStrSniffet);


			/// Call insert Consumer alert function
			$objAddsDAO = new AdsDAO();
	
			$intStatus=$objAddsDAO->UpdateAdds($objAddsBO,$pIntStatus);

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
	
	function UpdateAddsGroup($pIntAddId,$pIntGroupId,$pIntGroupStatus)
	{
		
		/// Generating XML as response
		$this->strResponse="<Response>";	

		try
		{
			$objAddsGroupBO=new AdsGroupBO();
			$objAddsGroupBO->setAdsId($pIntAddId);
			$objAddsGroupBO->setGroupId($pIntGroupId);
	
			$objAddsDAO = new AdsDAO();

			$intStatus=$objAddsDAO->UpdateAddsGroup($objAddsGroupBO,$pIntGroupStatus);

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
		NAJAX_Client::mapMethods($this, array('GetAddsById','GetGroupsByAddId','UpdateAdds','UpdateAddsGroup'));
		NAJAX_Client::publicMethods($this, array('GetAddsById','GetGroupsByAddId','UpdateAdds','UpdateAddsGroup'));
	}
}
?>