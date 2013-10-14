<?php
/*=================================================================================
		Class Name    : FeatureStatDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Producer and Consumer Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class FeatureStatDAO
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
		Function Name 	: GetFeatureStatReport
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Record Count
		Input Parameter : integer AccountType, integer IsActive
		Returns		  	: integer Count Records
=================================================================================*/
		function GetFeatureStatReport($pUserType)
		{
			$strQuery = "CALL FEATURE_STAT_HITS_REPORT(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param('i',$pUserType);
			$objStatement->execute();

 			$objStatement->bind_result($StatId, $UserType, $PageTitle, $PageUrl, $Hits, $CreateDate, $IsActive);
			$i=0;

			while($objStatement->fetch())
			{
				$arrayResult[$i][0]=$StatId;
				$arrayResult[$i][1]=$UserType;
				$arrayResult[$i][2]=$PageTitle;
				$arrayResult[$i][3]=$PageUrl;
				$arrayResult[$i][4]=$Hits;
				$arrayResult[$i][5]=$CreateDate;
				$arrayResult[$i][6]=$IsActive;
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