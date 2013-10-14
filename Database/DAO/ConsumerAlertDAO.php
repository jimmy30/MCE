<?php 

/*=================================================================================
		Class Name    : ConsumerAlertDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with ConsumerAlert Table
		Created On    : 26-Jun-2006 
=================================================================================*/

	class ConsumerAlertDAO
	{
		
		//// Declaring DB connection and objects and variables
		var $objDB;
		
		var $strDbName;	
		
		/// Declaring paging variables
		var $recordLimit;
		var $pagesLimit;

		/// Declaring Error handling variables
		var $strErrorMessage;
		var $intErrorNo;
		
/*=================================================================================
		Function Name : Custoructor
		Synopsis	  : Loading and get values from property file 
						and establishing DB connection 
		Created On    : 26-Jun-2006 
=================================================================================*/

		function __construct()
		{
			/// Loading property file
			$objProperties=new Properties();
			$objProperties->load(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/Properties/default.properties'));
			
			
			/// GEt Paging variables from property file
			$this->recordLimit = $objProperties->getProperty('paging_record_limit');
			$this->pagesLimit = $objProperties->getProperty('paging_pages_limit');
			
			/// Connect With Database
			$this->objDB=Database::singleton();
			
			/// Exception thrown incase of error connecting with DB
			if (mysqli_connect_errno())
			{ 
   				throw new DatabaseConnectivityException();
			}	 
		}
		
/*=================================================================================
		Function Name 	: insert
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Insert record 
		Input Parameter : object ConsumerAlertBO (All fields)
		Returns		  	: none
=================================================================================*/


		function insert($pConsumerAlertBO) 
		{
			/// Calling Stored Procedure
			$strQuery = "CALL CONSUMER_ALERT_INSERT(?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiiisi",$pConsumerAlertBO->getConsumerId()
											   ,$pConsumerAlertBO->getCountryId()
											   ,$pConsumerAlertBO->getAdd()
											   ,$pConsumerAlertBO->getModify()											   
											   ,$pConsumerAlertBO->getCreateDate()
											   ,$pConsumerAlertBO->getIsActive());

			
			$objStatement->execute();
			$objStatement->bind_result($intStatus);
			$objStatement->fetch();			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if ($this->intErrorNo!=0) // Error exists
			{
				
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}
			$objStatement->close(); 
			return $intStatus;

	   }
		
/*=================================================================================
		Function Name 	: GetListByConsumerId
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Get all list against a particular Producer
		Input Parameter : object PlaceCastBO (string ProducerId, integer IsActive)
		Returns		  	: Three dimenssions Array of Objects (All fields)
=================================================================================*/

	   function GetListByConsumerId($pIntConsumerId,$pIntStart,$pIntNumRows,$pIntSortListBy)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL CONSUMER_ALERT_LIST_BY_CONSUMER_ID(".$pIntConsumerId.",".$pIntStart.",".$pIntNumRows.",".$pIntSortListBy.")";
			$objStatement=$this->objDB->executeQuery($strQuery);
		
			/// set results in a object

			while ($row=$objStatement->fetch_array()) 
				{ 
				$objConsumerAlertBO=new ConsumerAlertBO();
				$objConsumerAlertBO->setConsumerAlertId($row[1]);
				$objConsumerAlertBO->setConsumerId($row[2]);
				$objConsumerAlertBO->setCountryId($row[3]);
				$objConsumerAlertBO->setAdd($row[4]);
				$objConsumerAlertBO->setModify($row[5]);																
				$objConsumerAlertBO->setCreateDate($row[6]);
				$objConsumerAlertBO->setIsActive($row[7]);				

				/// set country name 
				$objCountryBO = new CountryBO();
				$objCountryBO->setCountryName($row[0]);

				$objObjectArray[0][]=$objConsumerAlertBO;
				$objObjectArray[1][]=$objCountryBO;

    			} 

			if ($this->objDB->geterrornumber()!=0) // Error exists
			{
				$this->errorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->errorMessage);
			}
			
			$objStatement->close(); 
			return $objObjectArray;
	   }

/*=================================================================================
		Function Name 	: GetConsumerAlertById
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Get a record for particular ID
		Input Parameter : object PlaceCastBO (integer  ID)
		Returns		  	: Array of objects (All fields)
=================================================================================*/

	   /// GET CONSUMER ALERT RECORD BY ID
	   function GetConsumerAlertById($pConsumerAlertId)
	   {
			/// Calling Stored Procedure	
	   		$strQuery = "CALL CONSUMER_ALERT_GET_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pConsumerAlertId);
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pIntConsumerAlertId, 
										$pIntConsumerId, 
										$pIntCountryId, 
										$pIntAdd,
										$pIntModify,
										$pCreateDate,
										$pIntIsActive
										); 

			$objStatement->fetch();
			
			/// Set results in object	
			$objConsumerAlertBO=new ConsumerAlertBO();
			$objConsumerAlertBO->setConsumerAlertId($pIntConsumerAlertId);
			$objConsumerAlertBO->setConsumerId($pIntConsumerId);
			$objConsumerAlertBO->setCountryId($pIntCountryId);
			$objConsumerAlertBO->setAdd($pIntAdd);
			$objConsumerAlertBO->setModify($pIntModify);																
			$objConsumerAlertBO->setCreateDate($pCreateDate);
			$objConsumerAlertBO->setIsActive($pIntIsActive);		
 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
	
			return $objConsumerAlertBO;
	   }

/*=================================================================================
		Function Name 	: UpdateAlert
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Update particular record against ID
		Input Parameter : object ConsumerAlertBO (All fields)
		Returns		  	: none
=================================================================================*/

		function UpdateAlert($pConsumerAlertBO)
		{
			/// Calling Stored Procedure	
			$strQuery = "CALL CONSUMER_ALERT_UPDATE(?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiiiii",$pConsumerAlertBO->getConsumerAlertId()
											   ,$pConsumerAlertBO->getConsumerId()
											   ,$pConsumerAlertBO->getCountryId()
											   ,$pConsumerAlertBO->getAdd()
											   ,$pConsumerAlertBO->getModify()											   											   ,$pConsumerAlertBO->getIsActive());

			$objStatement->execute();
			$objStatement->bind_result($intStatus);
			$objStatement->fetch();			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
			
			if ($this->intErrorNo!=0) // Error exists
			{
				
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
				
			}
			$objStatement->close(); 
			return $intStatus;
	   }

/*=================================================================================
		Function Name 	: ConsumerAlertDeleteById
		Created On    	: 26-Jun-2006 
		Synopsis	  	: Delete particular record against ID
		Input Parameter : integer ID
		Returns		  	: none
=================================================================================*/
		function ConsumerAlertDeleteById($pConsumerAlertId)
		{
			$strQuery = "CALL CONSUMER_ALERT_DELETE_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pConsumerAlertId);
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


/*=================================================================================
		Function Name 	: AlertRecordCountByConsumer
		Created On    	: 01-Aug-2006 
		Synopsis	  	: count total no. of records against a particular ConsumerAlert
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/
		function AlertRecordCountByConsumer($pIntConsumerId)
		{
			$strQuery = "CALL CONSUMER_ALERT_RECORD_COUNT_BY_CONSUMER(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pIntConsumerId);
			$objStatement->execute();
			
			$objStatement->bind_result($numRows);
			$objStatement->fetch();			
			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0) // Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}

			$objStatement->close();
			return $numRows;
		
		}

/*=================================================================================
		Function Name 	: getPagingLimit
		Created On    	: 01-Aug-2006 
		Synopsis	  	: get paging limit value form property file
		Input Parameter : none
		Returns		  	: integer record limit
=================================================================================*/
		function getPagingLimit()
		{
			return $this->recordLimit;
		}

/*=================================================================================
		Function Name 	: getPagesLimit
		Created On    	: 01-Aug-2006 
		Synopsis	  	: get pages limit value form property file
		Input Parameter : none
		Returns		  	: integer pages limt
=================================================================================*/
		function getPagesLimit()
		{
			return $this->pagesLimit;
		}

	}	
?>