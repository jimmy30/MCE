<?php 

//////////////////////////////////////////////////////////////////////////////////////
/// This is a service classs and Used for Add Waypoint.
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
require_once($_SERVER['DOCUMENT_ROOT']."/Database/DAO/WaypointDAO.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Database/BO/WaypointBO.php");

//// Include Other Classes
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Utilities/Constants.php");

class WaypointDetailService
{
			
	function GetWaypointById($pWaypointId,$pIsActive)	 
	{
	try
	{
		/// set parameter in an object
		$objWaypointBO=new WaypointBO();
		$objWaypointBO->setWaypointId($pWaypointId);
		$objWaypointBO->setWaypointIsActive($pIsActive);		
		
		/// get results in an object
		$objWaypointDAO = new WaypointDAO();
		$objWaypointBO=$objWaypointDAO->selectById($objWaypointBO);
		
		/// Generate XML string 
		if ($objWaypointBO!=null)
		{

		echo '<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
        <tr>
          <td class=RegistrationCellBg width="135" align="center"><div align="left" class="TabTopTextHightLight"><strong>Waypoint Name:</strong></div></td>
          <td bgcolor="#EEEEEE" colspan="2" width="515" class="RegistrationBodyText">'.$objWaypointBO->getWaypointName().'</td>
        </tr>
        <tr>
          <td class=RegistrationCellBg align="center" valign="top"><div align="left" class="TabTopTextHightLight"><strong>Location:</strong></div></td>
          <td bgcolor="#EEEEEE"  colspan="2" align="center" class="RegistrationBodyText"><div align="left">'.$objWaypointBO->getWaypointAddress().',<br />'.$objWaypointBO->getWaypointCity().'</div></td>
        </tr>
          <td class=RegistrationCellBg valign="top"><div align="left" class="TabTopTextHightLight"><strong>Description:</strong></div></td>
          <td bgcolor="#EEEEEE" colspan="2" class="RegistrationBodyText">'.$objWaypointBO->getWaypointDescription().'</td>
        </tr>
      </table>


	  <br>
	  	<table width="600" border="0" align="center" cellpadding="5" cellspacing="1">		  
		  <tr class=RegistrationCellBg>
          <td class="TabTopTextHightLight"><div align="left"><strong>Latitute</strong></div></td>
          <td class="TabTopTextHightLight"><div align="left"><strong>Longitute</strong></div></td>
          <td class="TabTopTextHightLight"><div align="left"><strong>Radius</strong></div></td>
        </tr>
        <tr class=SearchSettings>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objWaypointBO->getWaypointLat1().'</td>
          <td bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objWaypointBO->getWaypointLong1().'</td>
		<td colspan="2" bgcolor="#EEEEEE" class="RegistrationBodyText">'.$objWaypointBO->getWaypointRadius().' m</td>
</tr>
       
</table>';
		
		}
		else
		{
			throw new NoRecordFoundExecption("");
		}
		return $xmlWaypointList;
		}
		catch (Exception  $e)
		{
			echo("Exception occured</br>");
			$e->displayMessage();
		}
	}

}

?>

