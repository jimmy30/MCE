<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add PlaceCast.
//////////////////////////////////////////////////////////////////////////////////////

//// Include all Exceptions Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/SQLException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/NoRecordFoundException.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/DBExceptions/DatabaseConnectivityException.php");

//// Include DO BO class for Country Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/CountryDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/CountryBO.php");

//// Include DO BO class for State Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/StateDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/StateBO.php");

//// Include DO BO class for Customer Table
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/PlaceCastDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/PlaceCastBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class PlaceCastDetailService
{
			
	function GetPlaceCastById($pPlaceCastId,$pIsActive)	 
	{
	try
	{
		/// set parameter in an object
		$objPlaceCastBO=new PlaceCastBO();
		$objPlaceCastBO->setPlaceCastId($pPlaceCastId);
		$objPlaceCastBO->setPlaceCastIsActive($pIsActive);		
		
		/// get results in an object
		$objPlaceCastDAO = new PlaceCastDAO();
		$objArrayBO=$objPlaceCastDAO->selectById($objPlaceCastBO);
		$objPlaceCastBO = $objArrayBO[0];
		$objCountryBO = $objArrayBO[1];
		$objStateBO = $objArrayBO[2];		
		
		/// Generate XML string 
		if ($objPlaceCastBO!=null)
		{
		echo '<table width="360" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
        <tr>
          <td class=RegistrationCellBg width="140" align="center"><div align="left" class="TabTopTextHightLight"><strong>PlaceCast Name:</strong></div></td>
          <td bgcolor="#EEEEEE" colspan="2" width="220" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastName().'</td>
        </tr>
        <tr>
          <td class=RegistrationCellBg align="center" valign="top"><div align="left" class="TabTopTextHightLight"><strong>Location:</strong></div></td>
          <td bgcolor="#EEEEEE"  colspan="2" align="center" class="RegistrationBodyText"><div align="left">'.$objPlaceCastBO->getPlaceCastCity().','.$objCountryBO->getCountryName().',<br>'.$objStateBO->getStateName().','.$objPlaceCastBO->getPlaceCastZipCode().'</div></td>
        </tr>
          <td class=RegistrationCellBg valign="top"><div align="left" class="TabTopTextHightLight"><strong>Description:</strong></div></td>
          <td bgcolor="#EEEEEE" colspan="2" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastDescription().'</td>
        </tr>
      </table>


	  <br>
	  	<table width="360" border="0" cellpadding="5" cellspacing="1">		  
		  <tr class=RegistrationCellBg>
          <td width="100" class="TabTopTextHightLight">&nbsp;</td>
          <td width="130" class="TabTopTextHightLight"><div align="left"><strong>Latitute</strong></div></td>
          <td width="130" class="TabTopTextHightLight"><div align="left"><strong>Longitute</strong></div></td>
        </tr>
        <tr class=SearchSettings>
          <td class=RegistrationBodyText><strong>Left-Top:</strong></td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastLat1().'</td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastLong1().'</td>
        </tr>
        <tr class=SearchSettings>
          <td class=RegistrationBodyText><strong>Right-Top:</strong></td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastLat2().'</td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastLong2().'</td>
        </tr>
        <tr class=SearchSettings>
          <td class=RegistrationBodyText><strong>Left-Bottom:</strong></td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastLat3().'</td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastLong3().'</td>
        </tr>
        <tr class=SearchSettings>
          <td class=RegistrationBodyText><strong>Right-Bottom:</strong></td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastLat4().'</td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objPlaceCastBO->getPlaceCastLong4().'</td>
        </tr></td></table>
			  <input name="txtLat1" type="hidden" id="txtLat1" size="20" value="'.$objPlaceCastBO->getPlaceCastLat1().'">
			  <input name="txtLong1" type="hidden" id="txtLong1" size="20" value="'.$objPlaceCastBO->getPlaceCastLong1().'">
			  <input name="txtLat2" type="hidden" id="txtLat2" size="20" value="'.$objPlaceCastBO->getPlaceCastLat2().'">
			  <input name="txtLong2" type="hidden" id="txtLong2" size="20" value="'.$objPlaceCastBO->getPlaceCastLong2().'">              
			  <input name="txtLat3" type="hidden" id="txtLat3" size="20" value="'.$objPlaceCastBO->getPlaceCastLat3().'">
			  <input name="txtLong3" type="hidden" id="txtLong3" size="20" value="'.$objPlaceCastBO->getPlaceCastLong3().'">
              <input name="txtLat4" type="hidden" id="txtLat4" size="20" value="'.$objPlaceCastBO->getPlaceCastLat4().'">
			  <input name="txtLong4" type="hidden" id="txtLong4" size="20" value="'.$objPlaceCastBO->getPlaceCastLong4().'">
';
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
		return $xmlPlaceCastList;
		}
		catch (Exception  $e)
		{
			echo("Exception occured</br>");
			$e->displayMessage();
		}
	}

}

?>

