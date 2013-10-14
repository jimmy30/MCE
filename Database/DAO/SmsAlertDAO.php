<?php 

/*=================================================================================
		Class Name    : SmsAlertDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with ConsumerAlert Table
		Created On    : 17-Oct-2006 
=================================================================================*/

	class SmsAlertDAO
	{
		
		//// Declaring DB connection and objects and variables
		var $objDB;
				
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
		Created On    : 17-Oct-2006 
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
		Created On    	: 18-Oct-2006 
		Synopsis	  	: Insert record 
		Input Parameter : object ConsumerAlertBO (All fields)
		Returns		  	: none
=================================================================================*/


		function insert($pSmsAlertBO) 
		{
			
			
			/// Calling Stored Procedure
			$strQuery = "CALL SMS_ALERT_INSERT(?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiiisi",$pSmsAlertBO->getConsumerId()
											   ,$pSmsAlertBO->getCountryId()
											   ,$pSmsAlertBO->getAdd()
											   ,$pSmsAlertBO->getModify()											   
											   ,$pSmsAlertBO->getCreateDate()
											   ,$pSmsAlertBO->getIsActive());

			
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
		Created On    	: 18-Oct-2006  
		Synopsis	  	: Get all list against a particular Consumer
		Input Parameter : object PlaceCastBO (string ProducerId, integer IsActive)
		Returns		  	: Three dimenssions Array of Objects (All fields)
=================================================================================*/

	   function GetListByConsumerId($pIntConsumerId,$pIntStart,$pIntNumRows,$pIntSortListBy)
	   {
			
				

			/// Calling Stored Procedure	
	   		$strQuery = "CALL SMS_ALERT_LIST_BY_CONSUMER_ID(".$pIntConsumerId.",".$pIntStart.",".$pIntNumRows.",".$pIntSortListBy.")";
			
			$objStatement=$this->objDB->executeQuery($strQuery);

			/// set results in a object

			while ($row=$objStatement->fetch_array()) 
				{ 

					$objSmsAlertBO=new SmsAlertBO();
					$objSmsAlertBO->setSmsAlertId($row[1]);
					$objSmsAlertBO->setConsumerId($row[2]);
					$objSmsAlertBO->setCountryId($row[3]);
					$objSmsAlertBO->setAdd($row[4]);
					$objSmsAlertBO->setModify($row[5]);																
					$objSmsAlertBO->setCreateDate($row[6]);
					$objSmsAlertBO->setIsActive($row[7]);				
		
					/// set country name 
					$objCountryBO = new CountryBO();
					$objCountryBO->setCountryName($row[0]);
		
					$objObjectArray[0][]=$objSmsAlertBO;
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
		Created On    	:18-Oct-2006
		Synopsis	  	: Get a record for particular ID
		Input Parameter : object PlaceCastBO (integer  ID)
		Returns		  	: Array of objects (All fields)
=================================================================================*/

	   /// GET CONSUMER ALERT RECORD BY ID
	   function GetConsumerAlertById($pSmsAlertId)
	   {
			
			/// Calling Stored Procedure	
	   		$strQuery = "CALL SMS_ALERT_GET_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pSmsAlertId);
			$objStatement->execute();
			
			/// Get results from Stored Procedurs
			$objStatement->bind_result(
										$pSmsAlertId, 
										$pIntConsumerId, 
										$pIntCountryId, 
										$pIntAdd,
										$pIntModify,
										$pCreateDate,
										$pIntIsActive
										); 

			$objStatement->fetch();
			
			/// Set results in object	
			$objSmsAlertBO=new SmsAlertBO();
			$objSmsAlertBO->setSmsAlertId($pSmsAlertId);
			$objSmsAlertBO->setConsumerId($pIntConsumerId);
			$objSmsAlertBO->setCountryId($pIntCountryId);
			$objSmsAlertBO->setAdd($pIntAdd);
			$objSmsAlertBO->setModify($pIntModify);																
			$objSmsAlertBO->setCreateDate($pCreateDate);
			$objSmsAlertBO->setIsActive($pIntIsActive);		
 			
			/// Get error no from stored procedure
			$this->intErrorNo=$this->objDB->geterrornumber();
		
			if ($this->intErrorNo!=0)// Error exists
			{
				$this->strErrorMessage=$this->objDB->geterrormessage();
				throw new SQLException($this->strErrorMessage);
			}
		
			$objStatement->close(); 
	
			return $objSmsAlertBO;
			
	   }

/*=================================================================================
		Function Name 	: UpdateAlert
		Created On    	: 18-Oct-2006 
		Synopsis	  	: Update particular record against ID
		Input Parameter : object SmsAlertBO (All fields)
		Returns		  	: none
=================================================================================*/

		function UpdateAlert($pSmsAlertBO)
		{
			
			/// Calling Stored Procedure	

			$strQuery = "CALL SMS_ALERT_UPDATE(?,?,?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iiiiii",$pSmsAlertBO->getSmsAlertId()
											   ,$pSmsAlertBO->getConsumerId()
											   ,$pSmsAlertBO->getCountryId()
											   ,$pSmsAlertBO->getAdd()
											   ,$pSmsAlertBO->getModify()
							   				   ,$pSmsAlertBO->getIsActive());
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
		Created On    	: 18-Aug-2006 
		Synopsis	  	: Delete particular record against ID
		Input Parameter : integer ID
		Returns		  	: none
=================================================================================*/
		function ConsumerAlertDeleteById($pSmsAlertId)
		{
			
			$strQuery = "CALL SMS_ALERT_DELETE_BY_ID(?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("i",$pSmsAlertId);
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
		Created On    	: 17-Oct-2006 
		Synopsis	  	: count total no. of records against a particular SmsAlert
		Input Parameter : integer IsActive
		Returns		  	: integer count
=================================================================================*/
		function AlertRecordCountByConsumer($pIntConsumerId)
		{
			
			$strQuery = "CALL CONSUMER_SMS_ALERT_RECORD_COUNT_BY_CONSUMER(?)";
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
		Created On    	: 17-Ocy-2006 
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
		Created On    	: 17-Oct-2006 
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