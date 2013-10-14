<?php 

/*=================================================================================
		Class Name    : AccountTypeDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with AccountType Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class AccountTypeDAO
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
		Returns		  	: Returns Array of Objects of AccountTypeBO (All fields)
=================================================================================*/

		function getList($intIsActive)
		{
			/// Calling Stored Procedure
			$stmt = $this->objDB->executePrepare("call ACCOUNTTYPE_LIST_ACTIVE(?)");
			$stmt->bind_param("i", $intIsActive);
			$stmt->execute(); 

			/// Get results from Stored Procedurs
			$stmt->bind_result($pAccountTypeId, $pAccountTypeName, $pAccountTypeCreateDate, $pAccountTypeIsActive); 
			
			/// Set all record in Array of Objects
			while ($stmt->fetch()) 
				{ 
	        		$objAccountTypeBO=new AccountTypeBO(); 
					$objAccountTypeBO->setAccountTypeId($pAccountTypeId);
					$objAccountTypeBO->setAccountTypeName($pAccountTypeName);
					$objAccountTypeBO->setAccountTypeCreateDate($pAccountTypeCreateDate);	
					$objAccountTypeBO->setAccountTypeIsActive($pAccountTypeIsActive);
					
					$objObjectArray[]=$objAccountTypeBO;
    			} 
			
			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}

			$stmt->close(); 
			return $objObjectArray;
		}
	}	
?>