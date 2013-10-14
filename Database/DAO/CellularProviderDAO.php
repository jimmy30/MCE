<?php 
/*=================================================================================
		Class Name    : CellularProviderDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with CellularProvider Table
		Created On    : 19-Oct-2006 
=================================================================================*/

	class CellularProviderDAO
	{
		//// Declaring DB connection and objects and variables			
		var $objDB;		
		
	
/*=================================================================================
		Function Name : Custoructor
		Synopsis	  : Loading and get values from property file 
						and establishing DB connection
		Created On    : 19-Oct-2006 
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
		Created On    	: 19-Oct-2006 
		Synopsis	  	: Get list of records from DB by IsActive status 
		Input Parameter : Integer IsActive
		Returns		  	: Returns Array of Objects
=================================================================================*/

		function getList($intIsActive)
		{
			/// Calling Stored Procedure			
			$stmt = $this->objDB->executePrepare("call CELLULARPROVIDER_LIST_ACTIVE(?)");
			$stmt->bind_param("i", $intIsActive);
			$stmt->execute(); 

			/// Get results from Stored Procedurs
			$stmt->bind_result($pCellularProviderId, $pIntCellularCode, $pStrCellularProvider, $pStrEmail,$pDteCreatedDate,$pIntIsActive); 
			
			/// Set all record in Array of Objects
			while ($stmt->fetch()) 
				{ 
	        		$objCellularProviderBO=new CellularProviderBO(); 
					$objCellularProviderBO->setCellularId($pCellularProviderId);
					$objCellularProviderBO->setCellularCode($pIntCellularCode);
					$objCellularProviderBO->setCellularProvider($pStrCellularProvider);	
					$objCellularProviderBO->setEmail($pStrEmail);
					$objCellularProviderBO->setCreatedDate($pDteCreatedDate);
					$objCellularProviderBO->setIsActive($pIntIsActive);
					$objObjectArray[]=$objCellularProviderBO;
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
		Function Name 	: SearchCellularProviderByCountryIdXML
		Created On    	: 01-Nov-2006 
		Synopsis	  	: Get all record against a specific Country
		Input Parameter : integer countryId, integer IsActive
		Returns		  	: XML string of all states (All fields)
	=================================================================================*/

		
		function SearchCellularProviderByCountryIdXML($intCountryId, $intIsActive)
		{
			/// Calling Stored Procedure			
			$stmt = $this->objDB->executePrepare("call CELLULAR_PROVIDER_GET_BY_COUNTRY_ID(?,?)");
			$stmt->bind_param("ii", $intCountryId, $intIsActive);
			$stmt->execute();

			/// Declare counter
			$intRowCount=0;
			
			/// Get results from Stored Procedurs
			$stmt->bind_result($pCellularId, $pCellularCode, $pCellularProvider,$pEmail ,$pCreateDate, $pIsActive,$pCountryId); 
			
			/// Generating XML String by results values
			$XMLCellular="<CellularProviders><NoOfRecords></NoOfRecords><CellularList>";
			while ($stmt->fetch()) 
			{ 
				$intRowCount++;
				$XMLCellular.="<CellularProvider>";
				$XMLCellular.="<CellularId>$pCellularId</CellularId>";
				$XMLCellular.="<CellularCode>$pCellularCode</CellularCode>";
				$XMLCellular.="<CellularProviderName>$pCellularProvider</CellularProviderName>";					
				$XMLCellular.="<Email>$pEmail</Email>";
				$XMLCellular.="<CreatedDate>$pCreateDate</CreatedDate>";										
				$XMLCellular.="<IsActive>$pIsActive</IsActive>";
				$XMLCellular.="<CountryId>$pCountryId</CountryId>";															
				$XMLCellular.="</CellularProvider>";					
			}
			$XMLCellular.="</CellularList></CellularProviders>";
			
			/// Set counter as No of Records
			$XMLCellular=str_replace("<NoOfRecords></NoOfRecords>", "<NoOfRecords>$intRowCount</NoOfRecords>", $XMLCellular);

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
	
			$stmt->close(); 
			return $XMLCellular;
		}


/*=================================================================================
		Function Name 	: GetById
		Created On    	: 12-Dec-2006 
		Synopsis	  	: Get record from DB by ID 
		Input Parameter : Integer ID
		Returns		  	: Returns Objects
=================================================================================*/

		function GetById($intCellularId)
		{
			/// Calling Stored Procedure			
			$stmt = $this->objDB->executePrepare("call CELLULAR_PROVIDER_GET_BY_ID(?)");
			$stmt->bind_param("i", $intCellularId);
			$stmt->execute(); 

			/// Get results from Stored Procedurs
			$stmt->bind_result($pCellularProviderId, $pIntCellularCode, $pStrCellularProvider, $pStrEmail,$pDteCreatedDate,$pIntIsActive,$pCountryID); 
			
			$stmt->fetch();

			$objCellularProviderBO=new CellularProviderBO(); 
			$objCellularProviderBO->setCellularId($pCellularProviderId);
			$objCellularProviderBO->setCellularCode($pIntCellularCode);
			$objCellularProviderBO->setCellularProvider($pStrCellularProvider);	
			$objCellularProviderBO->setEmail($pStrEmail);
			$objCellularProviderBO->setCreatedDate($pDteCreatedDate);
			$objCellularProviderBO->setIsActive($pIntIsActive);

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$stmt->close(); 
			return $objCellularProviderBO;
		}

	}	
?>