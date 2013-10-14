<?php 

/*=================================================================================
		Class Name    : StateDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with States Table
		Created On    : 01-Jun-2006 
=================================================================================*/

	class StateDAO
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
		Input Parameter : integer InActive
		Returns		  	: objects of Array (All fields)
=================================================================================*/

		/// GET ALL STATES LIST BY STATUS
		function getList($intIsActive)
		{
			/// Calling Stored Procedure			
			$stmt = $this->objDB->executePrepare("call STATE_LIST_ACTIVE(?)");
			$stmt->bind_param("i", $intIsActive);
			$stmt->execute();

			/// Get results from Stored Procedurs
			$stmt->bind_result($pStateId, $pStateCountryId, $pStateName, $pStateCreateDate, $pStateIsActive); 

			/// Set all record in Array of Objects
			while ($stmt->fetch()) 
				{ 
					$objStateBO=new StateBO(); 
					$objStateBO->setStateId($pStateId);
					$objStateBO->setCountryId($pStateCountryId);					
					$objStateBO->setStateName($pStateName);
					$objStateBO->setStateCreateDate($pStateCreateDate);	
					$objStateBO->setStateIsActive($pStateIsActive);
					
					$objObjectArray[]=$objStateBO;
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
		Function Name 	: SearchStateByCountryIdXML
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get all record against a specific Country
		Input Parameter : integer countryId, integer IsActive
		Returns		  	: XML string of all states (All fields)
=================================================================================*/

		
		function SearchStateByCountryIdXML($intCountryId, $intIsActive)
		{
			/// Calling Stored Procedure			
			$stmt = $this->objDB->executePrepare("call STATE_GET_BY_COUNTRY_ID(?,?)");
			$stmt->bind_param("ii", $intCountryId, $intIsActive);
			$stmt->execute();

			/// Declare counter
			$intRowCount=0;
			
			/// Get results from Stored Procedurs
			$stmt->bind_result($pStateId, $pStateCountryId, $pStateName, $pStateCreateDate, $pStateIsActive); 
			
			/// Generating XML String by results values
			$XMLSate="<States><NoOfRecords></NoOfRecords><StateList>";
			while ($stmt->fetch()) 
				{ 
					$intRowCount++;
					$XMLSate.="<State>";
					$XMLSate.="<StateId>$pStateId</StateId>";
					$XMLSate.="<StateCountryId>$pStateCountryId</StateCountryId>";
					$XMLSate.="<StateName>$pStateName</StateName>";					
					$XMLSate.="<StateCreateDate>$pStateCreateDate</StateCreateDate>";										
					$XMLSate.="<StateIsActive>$pStateIsActive</StateIsActive>";															
					$XMLSate.="</State>";					
    			}
			$XMLSate.="</StateList></States>";
			
			/// Set counter as No of Records
			$XMLSate=str_replace("<NoOfRecords></NoOfRecords>", "<NoOfRecords>$intRowCount</NoOfRecords>", $XMLSate);

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
	
			$stmt->close(); 
			return $XMLSate;
		}

/*=================================================================================
		Function Name 	: SearchStateById
		Created On    	: 01-Jun-2006 
		Synopsis	  	: Get a particular record 
		Input Parameter : integer Id, integer IsActive
		Returns		  	: Object StateBO (All fields)
=================================================================================*/

		function SearchStateById($intStateId, $intIsActive)
		{
			/// Calling Stored Procedure			
			$stmt = $this->objDB->executePrepare("call GET_STATE_BY_ID(?,?)");
			$stmt->bind_param("ii", $intStateId, $intIsActive);
			$stmt->execute();

			/// Declare counter
			$intRowCount=0;
			
			/// Get results from Stored Procedurs
			$stmt->bind_result($pStateId, $pStateCountryId, $pStateName, $pStateCreateDate, $pStateIsActive); 
			$stmt->fetch();
			
			$objStateBO= new StateBO();
			$objStateBO->setStateId($pStateId);
			$objStateBO->setCountryId($pStateCountryId);
			$objStateBO->setStateName($pStateName);						
			$objStateBO->setStateCreateDate($pStateCreateDate);
			
			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
	
			$stmt->close(); 
			return $objStateBO;
		}

	}	
?>