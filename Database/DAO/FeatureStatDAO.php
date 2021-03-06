<?php 

/*=================================================================================
		Class Name    : FeatureStatDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with FeatureStat Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class FeatureStatDAO
	{
		//// Declaring DB connection and objects and variables	
		var $objDB;		
	
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

		function HitsUpdate($objFeatureStatBO)
		{
			
			/// Calling Stored Procedure
			$strQuery = "CALL FEATURE_STAT_UPDATE_HITS(?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("si",	$objFeatureStatBO->getPageUrl()
											,$objFeatureStatBO->getUserType());
			
			$objStatement->execute();
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if ($this->intErrorNo!=0) // Error exists
			{
				
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}
			$objStatement->close(); 
			
		}
	
	}	
?>