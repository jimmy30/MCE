<?php
/*=================================================================================
		Class Name    : WaypointDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Producer and Consumer Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class WaypointDAO
	{
		
		//// Declaring DB connection and objects and variables
		var $objDB;
				
		/// Declaring Error handling variables
		var $strErrorMessage;
		var $strEmailErrorMessage;
		var $intErrorNo;
		
/*=================================================================================
		Function Name : Custoructor
		Synopsis	  : Loading and get values from property file 
						and establishing DB connection 
		Created On    : 01-Jun-2006 
=================================================================================*/

		function __construct()
		{
			/// Loading property file
			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
			
			/// Connect With Database
			$this->objDB=Database::singleton();
			
			/// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}	 
		}


/*=================================================================================
		Function Name 	: RecordCountByTypeAndStatus
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Record Count
		Input Parameter : integer AccountType, integer IsActive
		Returns		  	: integer Count Records
=================================================================================*/
		function GetWaypointReport($pFromDate, $pToDate, $pCountryId)
		{
			$strQuery = "CALL WAYPOINT_RECORD_COUNT_REPORT(?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param('ssi',$pFromDate, $pToDate, $pCountryId);
			$objStatement->execute();

 			$objStatement->bind_result($numRows, $countryName, $isActive);
			$i=0;
			while($objStatement->fetch())
			{
				$arrayResult[$i][0]=$numRows;
				$arrayResult[$i][1]=$countryName;
				$arrayResult[$i][2]=$isActive;				
				$i++;
			}
			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}

			$objStatement->close(); 
			return $arrayResult;		
		}

	}
?>