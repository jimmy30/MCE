<?php

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for View Adds .
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");

require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Ads Table

require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/Admin/Ads/AdsDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/Admin/Ads/AdsBO.php");
//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");


class RightMenuService
{
	function GetImageList($pStrPageName,$pStrType)
	{

		// Loading property file
		$objProperties=new Properties(); 
		$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
		$strImageDirectory = $objProperties->getProperty('ads_upload_directory');			
		$intNoOfAdds= $objProperties->getProperty('no_of_adds_display');			
		
		
		$objAddDAO = new AdsDAO();
		if($pStrType=="image")
		{

			$objObjectArray=$objAddDAO->GetImageList($pStrPageName);
			$strHtml='<table cellspacing="0" cellpadding="0" border="0">
			      <tr>
			        <td height="27" class="HeadingText">&nbsp;</td>
			      </tr>
			      <tr class="RegistrationCellBg">
			        <td align="center" class="RegistrationTitleText" height="27" width="175" class="HeadingText">Advertisement</td>
			      </tr>
			      <tr>
			        <td height="4"></td>
			      </tr>
			      <tr>
			        <td><table cellspacing="0" cellpadding="0"  border="0">
				          <tr>
        				    <td height="10"></td>
				          </tr>';
			$strImageHtml="";
			if ($objObjectArray!=null)
			{
				$intCount = count($objObjectArray[0]);
				if($intCount>$intNoOfAdds)
				{
					$intCount=$intNoOfAdds;
				}
				for($i=0; $i<$intCount; $i++)
				{
					$objAdsBO=(object)$objObjectArray[0][$i];
					$objAdsBO=(object)$objAdsBO;
					$strImageHtml=$strImageHtml.'<tr>
								<td width="10" colspan="4"> <img src="/'.$strImageDirectory.'/'.$objAdsBO->getImagePath().'" width="174" height="105"> </td>
							  </tr>  ' ;
					
				}	
				
			}
		
			$strHtml=$strHtml.$strImageHtml.'</table>
											</td>
											  </tr>
											</table>';
		}
		else if ($pStrType=="sniffet")
		{

			$objObjectArray=$objAddDAO->GetSniffetList($pStrPageName,'sniffet');

			$strHtml='<table cellspacing="0" cellpadding="0" border="0">
			      <tr>
			        <td height="27" class="HeadingText">&nbsp;</td>
			      </tr>
			      <tr class="RegistrationCellBg">
			        <td align="center" class="RegistrationTitleText" height="27" width="175" class="HeadingText">Advertisement</td>
			      </tr>
			      <tr>
			        <td height="4"></td>
			      </tr>
			      <tr>
			        <td><table cellspacing="0" cellpadding="0"  border="0">
				          <tr>
        				    <td height="10"></td>
				          </tr>';
			$strImageHtml="";
			if ($objObjectArray!=null)
			{
				$intCount = count($objObjectArray[0]);
				if($intCount>$intNoOfAdds)
				{
					$intCount=$intNoOfAdds;
				}
				for($i=0; $i<$intCount; $i++)
				{
					$objAdsBO=(object)$objObjectArray[0][$i];
					$objAdsBO=(object)$objAdsBO;
					$strImageHtml=$strImageHtml.'<tr>
								<td colspan="4"><div style="overflow:hidden; width=175px; height=200px">'.$objAdsBO->getSinffet().'</div></td>
							  </tr>  ' ;
					
				}	
				
			}
		
			$strHtml=$strHtml.$strImageHtml.'</table>
											</td>
											  </tr>
											</table>';
		}	
		
		
										
		
		/*$strHtml='<table cellspacing="0" cellpadding="0" border="0">
			      <tr>
			        <td height="27" class="HeadingText">&nbsp;</td>
			      </tr>
			      <tr>
			        <td align="center" bgcolor='.$strColor .'height="27" width="175" class="HeadingText">Advertisement</td>
			      </tr>
			      <tr>
			        <td height="4"></td>
			      </tr>
			      <tr>
			        <td><table cellspacing="0" cellpadding="0"  border="0">
				          <tr>
        				    <td height="10"></td>
				          </tr>
				          <tr>
				            <td width="10" colspan="4"> <img src="/ImageFiles/Add.jpg" width="174" height="105"> </td>
				          </tr>
				          <tr>
				            <td height="10"></td>
				          </tr>
				          <tr>
				            <td colspan="4"> <img src="/ImageFiles/Add.jpg" width="174" height="105"> </td>
				          </tr>
			        </table>
				</td>
		      </tr>
		    </table>';*/
echo($strHtml);
	}
}