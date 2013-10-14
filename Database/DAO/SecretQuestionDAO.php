<?php 

/*=================================================================================
		Class Name    : SecretQuestionDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with SecretQuestion Table
		Created On    : 01-Jun-2006 
=================================================================================*/


	class SecretQuestionDAO
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
		Synopsis	  	: Get all record by IsActive Status
		Input Parameter : integer IsActive
		Returns		  	: objects of Array (All fields)
=================================================================================*/

		/// GET ALL SECRET QUESTION LIST BY STATUS
		function getList($intIsActive)
		{
			/// Calling Stored Procedure						
			$stmt = $this->objDB->executePrepare("call SECERETQUESTION_LIST_ACTIVE(?)");
			$stmt->bind_param("i", $intIsActive);
			$stmt->execute(); 

			/// Get results from Stored Procedurs
			$stmt->bind_result($pSecretQuestionId, $pSecretQuestionName, $pSecretQuestionCreateDate, $pSecretQuestionIsActive); 
			
			/// Set all record in Array of Objects
			while ($stmt->fetch()) 
				{ 
	        		$objSecretQuestionBO=new SecretQuestionBO(); 
					$objSecretQuestionBO->setSecretQuestionId($pSecretQuestionId);
					$objSecretQuestionBO->setSecretQuestionName($pSecretQuestionName);
					$objSecretQuestionBO->setSecretQuestionCreateDate($pSecretQuestionCreateDate);	
					$objSecretQuestionBO->setSecretQuestionIsActive($pSecretQuestionIsActive);
					
					$objObjectArray[]=$objSecretQuestionBO;
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