<?php 
/*=================================================================================
		Class Name    : AccountTypeDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with Country Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class CountryDAO
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

/*=================================================================================
		Function Name 	: getList
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get list of records from DB by IsActive status 
		Input Parameter : Integer IsActive
		Returns		  	: Returns Array of Objects
=================================================================================*/

		function getList($intIsActive)
		{
			/// Calling Stored Procedure			
			$stmt = $this->objDB->executePrepare("call COUNTRY_LIST_ACTIVE(?)");
			$stmt->bind_param("i", $intIsActive);
			$stmt->execute(); 

			/// Get results from Stored Procedurs
			$stmt->bind_result($pCountryId, $pCountryName, $pCountryCreateDate, $pCountryIsActive); 
			
			/// Set all record in Array of Objects
			while ($stmt->fetch()) 
				{ 
	        		$objCountryBO=new CountryBO(); 
					$objCountryBO->setCountryId($pCountryId);
					$objCountryBO->setCountryName($pCountryName);
					$objCountryBO->setCountryCreateDate($pCountryCreateDate);	
					$objCountryBO->setCountryIsActive($pCountryIsActive);
					
					$objObjectArray[]=$objCountryBO;
    			} 

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$stmt->close(); 
			return $objObjectArray;
		}

/*=================================================================================
		Function Name 	: SearchCountryById
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get list of records from DB by by country 
		Input Parameter : Integer Country Id , Integer IsActive
		Returns		  	: Returns Object CountryBO (All Fields)
=================================================================================*/

		function SearchCountryById($intCountryId, $intIsActive)
		{
			/// Calling Stored Procedure			
			$stmt = $this->objDB->executePrepare("call COUNTRY_GET_BY_ID(?,?)");
			$stmt->bind_param("ii", $intCountryId, $intIsActive);
			$stmt->execute();

			/// Get results from Stored Procedurs
			$stmt->bind_result($pCountryId, $pCountryName, $pCountryCreateDate, $pCountryIsActive); 
			$stmt->fetch();
			
			/// Set all fields in Objects
       		$objCountryBO=new CountryBO(); 
			$objCountryBO->setCountryId($pCountryId);
			$objCountryBO->setCountryName($pCountryName);
			$objCountryBO->setCountryCreateDate($pCountryCreateDate);	
			$objCountryBO->setCountryIsActive($pCountryIsActive);
			
			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
	
			$stmt->close(); 
			return $objCountryBO;
		}

	}	
?>