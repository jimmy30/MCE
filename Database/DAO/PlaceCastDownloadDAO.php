<?php 

/*=================================================================================
		Class Name    : PlaceCastDownloadDAO
		Synopsis	  : This class is used for establishing DB connection 
						and calling stroed procedures realated with PlaceCastDownload Table
		Created On    : 26-Jun-2006 
=================================================================================*/

	class PlaceCastDownloadDAO
	{
		
		//// Declaring DB connection and objects and variables
		var $objDB;
				
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
		Input Parameter : object PlaceCastDownloadBO (All fields)
		Returns		  	: none
=================================================================================*/


		function insert($objPlaceCastDownloadBO) 
		{
			/// Calling Stored Procedure
			$strQuery = "CALL PLACECAST_DOWNLOAD_INSERT(?,?,?,?)";
			$objStatement=$this->objDB->executePrepare($strQuery);
			$objStatement->bind_param("iisi",$objPlaceCastDownloadBO->getConsumerId()
									 	,$objPlaceCastDownloadBO->getPlaceCastId()
										,$objPlaceCastDownloadBO->getPlaceCastDownloadCreateDate()
										,$objPlaceCastDownloadBO->getPlaceCastDownloadIsActive());

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