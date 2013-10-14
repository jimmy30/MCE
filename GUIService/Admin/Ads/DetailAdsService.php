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

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");


class DetailAdsService
{
	function GetAddListById($pIntAddId)
	{
		$objProperties=new Properties();
		$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
		$this->strImageDirectory = $objProperties->getProperty('ads_upload_directory');
			
		
		
		$objAdsDAO=new AdsDAO();
		$objAdsBO=$objAdsDAO->GetAddsById($pIntAddId);
		$strSniffet=$objAdsBO->getSinffet();
		echo '<table width="800" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td class=RegistrationCellBg width="135" align="center"><div align="left" class="TabTopTextHightLight"><strong>Ad Name:</strong></div></td>
    <td bgcolor="#EEEEEE" colspan="2" width="515" class="RegistrationBodyText">'.$objAdsBO->getAdsName().'</td>
  </tr>
  <tr>
    <td class=RegistrationCellBg width="135" align="center"><div align="left" class="TabTopTextHightLight"><strong>Status:</strong></div></td>
    <td bgcolor="#EEEEEE" colspan="2" width="515" class="RegistrationBodyText">'.$objAdsBO->getActive().'</td>
  </tr>
  <tr>
    <td class=RegistrationCellBg width="135" align="center" valign="top"><div align="left" class="TabTopTextHightLight"><strong>Description:</strong></div></td>
    <td bgcolor="#EEEEEE" colspan="2" width="515" class="RegistrationBodyText">'.$objAdsBO->getAdsDescription().'</td>
  </tr>
</table>';
	$strImagePath=$objAdsBO->getImagePath();
			
	echo '<p><table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td align="left" valign="top" width="250">
	<table width="250" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
      <tr>
        <td class=RegistrationCellBg width="135" align="center" height="30">
			<div align="left" class="TabTopTextHightLight"><strong>Groups
		</td>
      </tr>';
	  
	    $objAdsDAOa=new AdsDAO();
		$objObjectArray=$objAdsDAOa->GetGroupsByAddId($pIntAddId);
		if ($objObjectArray!=null)
		{
			$intCount = count($objObjectArray[0]);
			for($i=0; $i<$intCount; $i++)
			{
			
				$objAdsBO=(object)$objObjectArray[0][$i];
				$strGroupName=$objAdsBO->getGroupName();
				echo'<tr>';
		
				echo ' <td bgcolor="#EEEEEE" colspan="2" width="515" class="RegistrationBodyText" >'.$strGroupName.'</td>
				      </tr>';	

			}	
		}
      

	 echo '
    </table></td>
	 <td width="250" colspan="3" align="left" valign="top">
	<table width="250" border="0" cellpadding="5" cellspacing="1">
      <tr>
        <td class=RegistrationCellBg colspan="2" width="135" align="center" height="30">
			<div align="left" class="TabTopTextHightLight"><strong>Sniffet
		</td>
		</tr>
		<tr>
		<td align="center">'.$strSniffet.'</td>
        </tr>
    </table>
	</td>
	<td width="300">&nbsp;</td
  </tr>
  
   
  
</table>
</p>';
	}
}

?>